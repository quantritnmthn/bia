<?php
// get_results.php - AJAX endpoint to calculate and retrieve player results

include 'config.php';

// --- PHẦN 1: KẾT NỐI VÀ HÀM HỖ TRỢ ---

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("SET NAMES 'utf8'");
} catch (PDOException $e) {
    die(json_encode(['error' => "Database connection failed: " . $e->getMessage()]));
}

$ban=1;
if ( isset( $_GET["b"] ) ) $ban=$_GET["b"];

/**
 * Hàm vệ sinh tên người chơi (loại bỏ khoảng trắng đặc biệt và trim)
 */
function cleanPlayerName($name) {
    $name = preg_replace('/[\p{C}\p{Z}]/u', ' ', $name);
    return trim(preg_replace('/\s+/', ' ', $name));
}

/**
 * Hàm tạo giá trị so sánh (loại bỏ dấu và khoảng trắng để đảm bảo so sánh chính xác).
 */
function compareName($name) {
    $clean = cleanPlayerName($name);
    $clean = mb_strtolower($clean, 'UTF-8'); 
    
    $search = array(
        'à', 'á', 'ạ', 'ả', 'ã', 'â', 'ầ', 'ấ', 'ậ', 'ẩ', 'ẫ', 'ă', 'ằ', 'ắ', 'ặ', 'ẳ', 'ẵ',
        'è', 'é', 'ẹ', 'ẻ', 'ẽ', 'ê', 'ề', 'ế', 'ệ', 'ể', 'ễ',
        'ì', 'í', 'ị', 'ỉ', 'ĩ',
        'ò', 'ó', 'ọ', 'ỏ', 'õ', 'ô', 'ồ', 'ố', 'ộ', 'ổ', 'ỗ', 'ơ', 'ờ', 'ớ', 'ợ', 'ở', 'ỡ',
        'ù', 'ú', 'ụ', 'ủ', 'ũ', 'ư', 'ừ', 'ứ', 'ự', 'ử', 'ữ',
        'ỳ', 'ý', 'ỵ', 'ỷ', 'ỹ',
        'đ', ' ' 
    );
    $replace = array(
        'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a',
        'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e',
        'i', 'i', 'i', 'i', 'i',
        'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o',
        'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u',
        'y', 'y', 'y', 'y', 'y',
        'd', ''
    );
    
    return str_replace($search, $replace, $clean);
}

/**
 * Kiểm tra điều kiện tiềm năng Ù.
 */
function isPotentialU($playerCompare, $playerResults) {
    if (!isset($playerResults[$playerCompare])) {
        return false;
    }
    // Logic: HAND_ phải rỗng (0) VÀ ANBI_ phải có ít nhất 1 lá (>= 1)
    return $playerResults[$playerCompare]['hand_cards'] === 0 && $playerResults[$playerCompare]['anbi_cards'] >= 1;
}

// --- PHẦN 2: TRUY VẤN VÀ XỬ LÝ DỮ LIỆU ---

try {
    // 1. Lấy dữ liệu JSON chính từ billiards_data
    $stmtData = $pdo->query("SELECT data_json FROM billiards_data WHERE id = ".$ban." LIMIT 1");
    $gameDataJson = $stmtData->fetchColumn();
    $gameData = json_decode($gameDataJson, true);

    // 2. Lấy dữ liệu tất cả các lá bài (deals)
    $stmt = $pdo->query("SELECT player_name, cards FROM billiards_deals where ban=".$ban);
    $deals = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 3. Xây dựng cấu trúc dữ liệu thẻ bài (HAND, AN, THOI, ANBI)
    $playerResults = [];
    $nameMap = []; 
    $playerListFromDeals = []; 
    
    foreach ($deals as $deal) {
        $player_name = $deal['player_name'];
        $cards = $deal['cards'];

        if (strpos($player_name, '_') !== false) {
            list($prefix, $playerOriginal) = explode('_', $player_name, 2);
            
            $playerCompare = compareName($playerOriginal); 
            $playerOriginalClean = cleanPlayerName($playerOriginal); 
            $playerListFromDeals[$playerCompare] = $playerOriginalClean; 

            $nameMap[$playerCompare] = $playerOriginalClean;
            
            if (!isset($playerResults[$playerCompare])) {
                $playerResults[$playerCompare] = [
                    'hand_cards' => 0,
                    'an_cards' => 0,
                    'thoi_cards' => 0,
                    'anbi_cards' => 0 
                ];
            }

            $num_cards = 0;
            $clean_cards = trim($cards);
            if (!empty($clean_cards)) {
                $num_cards = (substr_count($clean_cards, ',') + 1);
            }

            switch($prefix) {
                case 'HAND':
                    $playerResults[$playerCompare]['hand_cards'] = $num_cards;
                    break;
                case 'AN':
                    $playerResults[$playerCompare]['an_cards'] = $num_cards;
                    break;
                case 'THOI':
                    $playerResults[$playerCompare]['thoi_cards'] = $num_cards;
                    break;
                case 'ANBI':
                    $playerResults[$playerCompare]['anbi_cards'] = $num_cards;
                    break;
            }
        }
    }

    // 4. Lấy dữ liệu ThuTuChoi và NguoiVuaHaBai
    $handsData = $gameData['hands'] ?? [];
    $thuTuChoiStr = '';
    $nguoiVuaHaBaiKey = '';

    foreach ($handsData as $line) {
        $trimmedLine = trim($line); 
        if (strpos($trimmedLine, 'ThuTuChoi:') === 0) {
            $thuTuChoiStr = cleanPlayerName(substr($trimmedLine, strlen('ThuTuChoi:')));
        } elseif (strpos($trimmedLine, 'NguoiVuaHaBai:') === 0) {
            $nguoiVuaHaBaiKey = cleanPlayerName(substr($trimmedLine, strlen('NguoiVuaHaBai:'))); 
        }
    }
    
    // Fallback NguoiVuaHaBai: 
    if (empty($nguoiVuaHaBaiKey)) {
        $stmtNguoiHaBai = $pdo->prepare("SELECT cards FROM billiards_deals WHERE player_name = 'NguoiVuaHaBai' and ban=".$ban);
        $stmtNguoiHaBai->execute();
        $fallbackName = $stmtNguoiHaBai->fetchColumn();
        if ($fallbackName) {
            $nguoiVuaHaBaiKey = cleanPlayerName($fallbackName);
        }
    }

    // Fallback ThuTuChoi (từ deals table): 
    if (empty($thuTuChoiStr)) {
        $stmtThuTuChoi = $pdo->prepare("SELECT cards FROM billiards_deals WHERE player_name = 'ThuTuChoi' and ban=".$ban);
        $stmtThuTuChoi->execute();
        $fallbackOrder = $stmtThuTuChoi->fetchColumn();
        if ($fallbackOrder !== false && $fallbackOrder !== null) { 
            $thuTuChoiStr = cleanPlayerName($fallbackOrder);
        }
    }

    // Xác định rõ ràng ThuTuChoi có rỗng không
    $isOrderEmptyExplicit = empty($thuTuChoiStr); 

    // Fallback cuối cùng cho ThuTuChoi (tạo danh sách nếu rỗng, chỉ dùng để đảm bảo biến mảng không rỗng)
    if (empty($thuTuChoiStr)) {
        $thuTuChoiStr = implode(' > ', $playerListFromDeals);
    }
    
    // 5. Xử lý logic Ù/Móm
    
    $nguoiVuaHaBaiCompare = compareName($nguoiVuaHaBaiKey);
    $playerOrderStr = str_replace([' phá bi > ', ' > '], ',', $thuTuChoiStr);
    $playerOrderClean = array_map('cleanPlayerName', explode(',', $playerOrderStr));
    $playerOrderCompare = array_map('compareName', $playerOrderClean);
    $playerOrderCompare = array_filter($playerOrderCompare);
    
    $haBaiIndex = array_search($nguoiVuaHaBaiCompare, $playerOrderCompare);
    $totalPlayers = count($playerOrderCompare);
    $playerWithHighestPriorityU = null;
    
    // --- TÌM NGƯỜI CÓ ƯU TIÊN Ù CAO NHẤT (Nếu ThuTuChoi KHÔNG rỗng) ---
    $nguoiHaBaiU = isPotentialU($nguoiVuaHaBaiCompare, $playerResults);

    if (!$isOrderEmptyExplicit && !$nguoiHaBaiU) { 
        // Nếu người vừa hạ bài KHÔNG Ù tiềm năng VÀ CÓ thứ tự chơi (Ù vòng)
        if ($haBaiIndex !== false && $totalPlayers > 0) {
            for ($i = 0; $i < $totalPlayers; $i++) {
                $checkIndex = ($haBaiIndex + 1 + $i) % $totalPlayers;
                $pNameCompare = $playerOrderCompare[$checkIndex];
                
                if (isPotentialU($pNameCompare, $playerResults)) {
                    $playerWithHighestPriorityU = $pNameCompare;
                    break;
                }
            }
        }
    }

    $finalResults = [];

    foreach($playerResults as $playerCompare => $data) {
        
        $score = $data['hand_cards'] + $data['thoi_cards'];
        $scoreStr = (string)$score;
        
        $isMom = ($data['an_cards'] === 0);
        $isPotential = isPotentialU($playerCompare, $playerResults);
        $isU = false;

        if ($isMom) {
            $scoreStr .= 'm';
        } elseif ($isPotential) {
            
            // A. Ưu tiên tuyệt đối: NguoiVuaHaBai Ù
            if ($playerCompare === $nguoiVuaHaBaiCompare) { 
                $isU = true; 
            } 
            // B. Khối Chặn: Nếu NguoiVuaHaBai Ù, người khác KHÔNG được Ù
            elseif ($nguoiHaBaiU) { 
                $isU = false; 
            }
            // C. Logic Ù Vòng/Ù Đa
            elseif (!$isOrderEmptyExplicit) { 
                // Có thứ tự chơi: chỉ người có ưu tiên cao nhất được Ù
                if ($playerCompare === $playerWithHighestPriorityU) {
                    $isU = true;
                }
            } else { 
                // ThuTuChoi rỗng: cho phép tất cả tiềm năng Ù
                $isU = true; 
            }
            
            if ($isU) {
                $scoreStr = (string)$score . 'u'; 
            }
        }
        
        $originalName = $nameMap[$playerCompare] ?? $playerCompare;
        $finalResults[$originalName] = $scoreStr;
    }
    
    echo json_encode($finalResults);
} catch (Exception $e) {
    echo json_encode(['error' => 'Query failed: ' . $e->getMessage()]);
}

?>