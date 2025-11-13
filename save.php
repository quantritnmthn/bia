<?php
// save.php - AJAX endpoint để lưu dữ liệu

include 'config.php';

// Thiết lập header để luôn trả về JSON, giúp client-side dễ dàng kiểm tra lỗi
header('Content-Type: application/json');

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("SET NAMES 'utf8'");
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Lỗi kết nối CSDL: ' . $e->getMessage()]);
    exit();
}

if (isset($_POST['data'])) {
    $dataJsonNew = $_POST['data']; // Dữ liệu mới (có scores mới nhất)
    
    // THÊM: Lấy biến bàn chơi, mặc định là '1'
    $ban = $_POST['b'] ?? '1'; 
    $id = $ban; // CẬP NHẬT: ID của bảng điểm LÀ BÀN CHƠI

    try {
        // 1. Giải mã JSON MỚI (chứa scores mới)
        $parsedDataNew = json_decode($dataJsonNew, true);

        if ($parsedDataNew === null) {
            throw new Exception("Dữ liệu JSON không hợp lệ.");
        }

        // 2. TẢI DỮ LIỆU CŨ TỪ CSDL để lấy mảng 'bi' đã lưu trước đó (Phòng thủ chống mất dữ liệu cũ)
        // CẬP NHẬT: Điều kiện WHERE id = :id (id = $ban)
        $stmtFetchOld = $pdo->prepare("SELECT data_json FROM billiards_data WHERE id = :id");
        $stmtFetchOld->bindParam(':id', $id);
        $stmtFetchOld->execute();
        $oldDataJson = $stmtFetchOld->fetchColumn();
        $stmtFetchOld->closeCursor();

        $parsedDataOld = json_decode($oldDataJson, true);
        
        // 3. HỢP NHẤT: Sao chép mảng 'bi' cũ vào dữ liệu mới
        $parsedData = $parsedDataNew; 

        if ($parsedDataOld && isset($parsedDataOld['players']) && isset($parsedData['players'])) {
            // Lặp qua dữ liệu MỚI ($parsedData)
            foreach ($parsedData['players'] as $newPlayerIndex => &$newPlayer) {
                $playerName = $newPlayer['name'];
                
                // Tìm người chơi tương ứng trong dữ liệu CŨ
                $oldPlayer = null;
                foreach ($parsedDataOld['players'] as $p) {
                    if ($p['name'] === $playerName) {
                        $oldPlayer = $p;
                        break;
                    }
                }

                // Nếu tìm thấy người chơi cũ và họ có mảng 'bi', sao chép sang dữ liệu mới
                if ($oldPlayer && isset($oldPlayer['bi'])) {
                    $newPlayer['bi'] = $oldPlayer['bi']; // Giữ lại toàn bộ dữ liệu 'bi' cũ
                }
            }
            unset($newPlayer);
        }
        // --------------------------------------------------------------------------
        // Bắt đầu Logic Xử lý Đồng bộ hóa và Cập nhật BI
        // --------------------------------------------------------------------------

        $maxGames = $parsedData['maxGames'] ?? 30;

        foreach ($parsedData['players'] as &$player) {
            $playerName = trim($player['name']); 
            $scores = $player['scores'] ?? [];
            $dbPlayerName = "ANBI_" . $playerName;

            // Đảm bảo mảng 'bi' tồn tại và có kích thước đúng
            if (!isset($player['bi']) || count($player['bi']) != $maxGames) {
                $player['bi'] = array_fill(0, $maxGames, '');
            }
            
            // TÌM INDEX CỦA SCORE MỚI NHẤT VÀ KIỂM TRA ĐỒNG BỘ HÓA
            $lastScoredGameIndex = -1;
            
            // Lặp qua tất cả các ván đấu
            for ($i = 0; $i < $maxGames; $i++) {
                $scoreValue = trim($scores[$i] ?? '');
                $biValue = trim($player['bi'][$i] ?? '');
                
                // *** LOGIC SỬA LỖI ĐỒNG BỘ (TRƯỜNG HỢP XÓA SCORE) ***
                // Nếu Score rỗng và Bi KHÔNG rỗng => XÓA Bi (Đồng bộ hóa)
                if ($scoreValue === '' && $biValue !== '') {
                    $player['bi'][$i] = ''; 
                    continue; // Chuyển sang ván tiếp theo
                }
                
                // Cập nhật Index có Score gần nhất
                if ($scoreValue !== '') {
                    $lastScoredGameIndex = $i;
                }
            }

            // ----------------------------------------------------
            // CẬP NHẬT BI VÀO INDEX CÓ SCORE GẦN NHẤT
            // ----------------------------------------------------
            if ($lastScoredGameIndex !== -1) {
                
                // *** ĐIỀU KIỆN MỚI: CHỈ CẬP NHẬT NẾU BI RỖNG TẠI INDEX NÀY ***
                // Và Score phải tồn tại (điều kiện này đã được kiểm tra khi tìm lastScoredGameIndex)
                if (empty(trim($player['bi'][$lastScoredGameIndex]))) {
                    
                    // *** Khắc phục lỗi Dữ liệu Rỗng: Khởi tạo PREPARE trong vòng lặp ***
                    // CẬP NHẬT: THÊM ĐIỀU KIỆN 'AND ban = :ban'
                    $stmtDeals = $pdo->prepare("
                        SELECT cards 
                        FROM billiards_deals 
                        WHERE player_name = :player_name AND ban = :ban
                        ORDER BY id DESC 
                        LIMIT 1
                    ");

                    // Thực thi truy vấn để lấy dữ liệu bài
                    // CẬP NHẬT: Thêm tham số ':ban'
                    $stmtDeals->execute([':player_name' => $dbPlayerName, ':ban' => $ban]);
                    
                    $latestDeal = $stmtDeals->fetch(PDO::FETCH_ASSOC);
                    $stmtDeals->closeCursor(); 

                    $cardsString = ''; 
                    
                    // Lấy chuỗi bài
                    if ($latestDeal && isset($latestDeal['cards'])) {
                        $cardsString = (string)trim($latestDeal['cards']); 
                    } 
                    
                    // Cập nhật chuỗi bài vào ĐÚNG vị trí index vừa tìm thấy
                    $player['bi'][$lastScoredGameIndex] = $cardsString;
                }
            }
        }
        
        // Gỡ bỏ tham chiếu
        unset($player);

        // 4. MÃ HÓA VÀ LƯU DỮ LIỆU JSON CUỐI CÙNG (có scores mới và bi đã cập nhật/đồng bộ)
        $updatedDataJson = json_encode($parsedData, JSON_UNESCAPED_UNICODE);
        
        // CẬP NHẬT: Điều kiện WHERE id = :id (id = $ban)
        $stmt = $pdo->prepare("UPDATE billiards_data SET data_json = :data WHERE id = :id");
        $stmt->bindParam(':data', $updatedDataJson);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        // Báo cáo thành công
        echo json_encode(['status' => 'success', 'message' => 'Lưu dữ liệu và cập nhật chuỗi mã bài ván gần nhất thành công']);

    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => 'Lỗi xử lý dữ liệu: ' . $e->getMessage()]);
    }

} else {
    echo json_encode(['status' => 'error', 'message' => 'Không nhận được dữ liệu POST (data)']);
}
?>