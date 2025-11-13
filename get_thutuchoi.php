<?php


include 'config.php';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// SỬA LỖI FONT: Thiết lập charset cho phiên kết nối MySQL
    $pdo->exec("SET NAMES 'utf8'");
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}


/**
 * PHÂN TÍCH ĐIỂM SỐ
 * (Hàm này giữ nguyên)
 * @param string $score_str Chuỗi điểm số (ví dụ: "3", "10m", "2u", "0u").
 * @return array Mảng chứa 'score' (điểm số numeric) và 'is_u' (có ù không).
 */
function parseScore($score_str) {
    $score_str = trim(strtolower($score_str));
    $numeric_score = intval(preg_replace('/[^0-9]/', '', $score_str)); 
    
    // Chỉ xét ù nếu có ký tự 'u'
    $is_u = (strpos($score_str, 'u') !== false); 

    return [
        'score' => $numeric_score,
        'is_u' => $is_u
    ];
}

/**
 * TÍNH TOÁN THỨ TỰ CHƠI (PHÁ BI) CHO VÁN TIẾP THEO.
 * Áp dụng quy tắc ưu tiên ù khi phá vỡ thế hòa.
 * @global PDO $pdo Đối tượng kết nối PDO đã được khai báo.
 * @return string Chuỗi thứ tự chơi (ví dụ: "Ninh phá bi > Hoàng > Dương").
 */
function ThuTuChoi() {
    global $pdo;

    // ... [Phần 1 & 2: Lấy dữ liệu từ DB và tìm $breakGameIndex (giữ nguyên)] ...
    try {
        $stmt = $pdo->query("SELECT data_json FROM billiards_data ORDER BY id DESC LIMIT 1");
        $latestData = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$latestData || empty($latestData['data_json'])) {
            return "";
        }
        
        $data = json_decode($latestData['data_json'], true);
        $players = $data['players'] ?? [];

        if (empty($players) || empty($players[0]['scores'])) {
            return "";
        }
        
    } catch (PDOException $e) {
        return "";
    }
    
    $maxGames = count($players[0]['scores']); 
    $breakGameIndex = -1;

    for ($i = $maxGames - 1; $i >= 0; $i--) {
        $isCompleted = true;
        foreach ($players as $p) {
            if (empty(trim($p['scores'][$i] ?? ''))) {
                $isCompleted = false;
                break;
            }
        }
        if ($isCompleted) {
            $breakGameIndex = $i;
            break; 
        }
    }
    
    if ($breakGameIndex === -1) {
        return "";
    }

    // 3. Lấy dữ liệu ván phá bi và tìm người ù
    $gameData = [];
    $playerWhoU = null;
    
    foreach ($players as $p) {
        $name = $p['name'];
        $score_str = $p['scores'][$breakGameIndex] ?? ''; 
        $parsed = parseScore($score_str);

        $gameData[$name] = [
            'name' => $name,
            'score' => $parsed['score'],
            'player_obj' => $p 
        ];
        
        if ($parsed['is_u']) {
            $playerWhoU = $name;
        }
    }

    // 4. Xử lý người phá bi
    $playOrder = [];
    $playersToSort = $gameData; 

    if ($playerWhoU) {
        $playOrder[] = $playerWhoU . ' phá bi';
        unset($playersToSort[$playerWhoU]);
    }

    // 5. Sắp xếp những người còn lại (LOGIC SỬA LỖI NẰM Ở ĐÂY)
    usort($playersToSort, function($a, $b) use ($breakGameIndex) {
        
        // --- So sánh 1: Ván Phá Bi ($breakGameIndex) ---
        // Nếu điểm ván phá bi bằng nhau, chuyển sang tie-breaker
        if ($a['score'] !== $b['score']) {
            return $a['score'] <=> $b['score']; // Ít cây hơn đứng trước
        }

        // --- So sánh 2: Xét các ván cũ hơn (tie-breaker) ---
        // Bắt đầu từ index $breakGameIndex - 1 (ván liền trước) ngược về index 0
        for ($i = $breakGameIndex - 1; $i >= 0; $i--) { 
            
            $scoreA_str = $a['player_obj']['scores'][$i] ?? '';
            $scoreB_str = $b['player_obj']['scores'][$i] ?? '';
            
            $parsedA = parseScore($scoreA_str);
            $parsedB = parseScore($scoreB_str);
            
            // QUY TẮC MỚI: Ưu tiên người ù trong ván tie-breaker
            if ($parsedA['is_u'] !== $parsedB['is_u']) {
                // Nếu A ù mà B không ù, A ưu tiên hơn (trả về -1)
                if ($parsedA['is_u']) return -1;
                // Nếu B ù mà A không ù, B ưu tiên hơn (trả về 1)
                if ($parsedB['is_u']) return 1;
            }
            
            // Nếu cả hai đều ù hoặc đều không ù, xét điểm số
            if ($parsedA['score'] !== $parsedB['score']) {
                return $parsedA['score'] <=> $parsedB['score']; // Ít cây hơn đứng trước
            }
        }
        
        // Nếu vẫn trùng đến ván đầu tiên
        return 0;
    });

    // 6. Kết hợp thứ tự chơi
    foreach ($playersToSort as $player) {
        $playOrder[] = $player['name'];
    }

    return implode(' > ', $playOrder);
}
echo(ThuTuChoi());
?>