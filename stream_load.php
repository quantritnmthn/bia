<?php
// BƯỚC 1: Vô hiệu hóa giới hạn thời gian chạy và bỏ qua ngắt kết nối
set_time_limit(0); 
ignore_user_abort(true); 

// BƯỚC 2: Vô hiệu hóa Zlib Compression và Output Buffering của PHP
if (ini_get('zlib.output_compression')) {
    ini_set('zlib.output_compression', 'off');
}
if (ini_get('output_buffering')) {
    ini_set('output_buffering', 'off');
}

// BƯỚC 3: Xóa và tắt mọi bộ đệm đầu ra hiện có (để đảm bảo dữ liệu đẩy ra ngay lập tức)
while (ob_get_level()) {
    ob_end_clean();
}

$ban=1;
if ( isset( $_GET["b"] ) ) $ban=$_GET["b"];

// BƯỚC 4: Thiết lập headers cho Server-Sent Events
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
header('Connection: keep-alive');

// BƯỚC 5: Include và Khởi tạo DB
include 'config.php'; 

// Biến lưu trữ hash của kết quả lần cuối cùng để so sánh 
$lastDataHash = '';
$lastPing = time(); // Thêm biến theo dõi thời gian ping

/**
 * Hàm gửi dữ liệu SSE
 */
function send_message($data) {
    echo "data: $data\n\n";
    flush(); 
}

// --- LOGIC TÍNH TOÁN VÀ LẤY DỮ LIỆU BILLIARDS_DATA ---

function parseScore($score_str) {
    $score_str = trim(strtolower($score_str));
    $numeric_score = intval(preg_replace('/[^0-9]/', '', $score_str)); 
    $is_u = (strpos($score_str, 'u') !== false); 
    return ['score' => $numeric_score, 'is_u' => $is_u];
}

function ThuTuChoi($pdo) {
    global $ban;
    try {
        $stmt = $pdo->query("SELECT data_json FROM billiards_data where id=".$ban);
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

    $playOrder = [];
    $playersToSort = $gameData; 

    if ($playerWhoU) {
        $playOrder[] = $playerWhoU . ' phá bi';
        unset($playersToSort[$playerWhoU]);
    }

    usort($playersToSort, function($a, $b) use ($breakGameIndex) {
        
        if ($a['score'] !== $b['score']) {
            return $a['score'] <=> $b['score']; 
        }

        for ($i = $breakGameIndex - 1; $i >= 0; $i--) { 
            
            $scoreA_str = $a['player_obj']['scores'][$i] ?? '';
            $scoreB_str = $b['player_obj']['scores'][$i] ?? '';
            
            $parsedA = parseScore($scoreA_str);
            $parsedB = parseScore($scoreB_str);
            
            if ($parsedA['is_u'] !== $parsedB['is_u']) {
                if ($parsedA['is_u']) return -1;
                if ($parsedB['is_u']) return 1;
            }
            
            if ($parsedA['score'] !== $parsedB['score']) {
                return $parsedA['score'] <=> $parsedB['score']; 
            }
        }
        
        return 0;
    });

    foreach ($playersToSort as $player) {
        $playOrder[] = $player['name'];
    }

    return implode(' > ', $playOrder);
}


function get_data_json($pdo) {
	global $ban;
    $id = $ban; 
    try {
        $stmt = $pdo->prepare("SELECT data_json FROM billiards_data WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $data = $stmt->fetchColumn();
        return $data ? $data : '{}';
    } catch (PDOException $e) {
        return '{}';
    }
}

// --- LOGIC MỚI LẤY DỮ LIỆU BÀI/BÀN TỪ load_desk.php ---

function get_desk_data($pdo) {
	global $ban;
    $stmt = $pdo->query("SELECT player_name, cards FROM billiards_deals where ban=".$ban);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $hands = [];
    $ans = [];
    $thoi = [];
    $noc = [];
    $baiTrenNoc = '';

    foreach ($rows as $row) {
        if (strpos($row['player_name'], 'AN_') === 0) {
            $ans[] = $row['player_name'] . ':' . $row['cards'];
        } elseif (strpos($row['player_name'], 'NOC_') === 0) {
            $noc[] = $row['player_name'] . ':' . $row['cards'];
        } elseif (strpos($row['player_name'], 'THOI_') === 0) {
            $thoi[] = $row['player_name'] . ':' . $row['cards'];
        } elseif ($row['player_name'] === 'BaiTrenNoc') {
            $baiTrenNoc = $row['cards'];
        } else {
            $hands[] = $row['player_name'] . ':' . $row['cards'];
        }
    }
    
    return ['hands' => $hands, 'ans' => $ans, 'thoi' => $thoi, 'bocnoc' => $noc, 'baiTrenNoc' => $baiTrenNoc];
}


// --- VÒNG LẶP CHÍNH ---

try {
    // Kết nối DB 
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("SET NAMES 'utf8'");
} catch (PDOException $e) {
    send_message(json_encode(['error' => 'Lỗi kết nối CSDL. Vui lòng kiểm tra config.php']));
    exit();
}


// Vòng lặp chính của SSE
while (true) {
    // Lấy dữ liệu mới nhất
    $gameDataJson = get_data_json($pdo);
    $thutuchoi = ThuTuChoi($pdo); 
    $deskData = get_desk_data($pdo); // <<-- LẤY DỮ LIỆU BÀI/BÀN
    
    // Đóng gói tất cả dữ liệu vào một JSON object
    $combinedData = json_encode([
        'game_data' => $gameDataJson,
        'thutuchoi' => $thutuchoi,
        'desk_data' => $deskData // <<-- GỬI CẢ DỮ LIỆU BÀN/BÀI
    ]);
    
    $currentHash = md5($combinedData);

// Chỉ gửi dữ liệu nếu có thay đổi
    if ($currentHash !== $lastDataHash) {
        send_message($combinedData);
        $lastDataHash = $currentHash;
        $lastPing = time(); // Đặt lại ping khi dữ liệu thật được gửi
    } else {
        // --- LOGIC HEARTBEAT/PING MỚI ---
        // Gửi dữ liệu rỗng (ping) sau 30 giây để giữ kết nối qua Proxy/Tường lửa
        if (time() - $lastPing > 30) {
            echo ": keep-alive\n\n"; // Gửi một comment SSE rỗng
            flush();
            $lastPing = time();
        }
    }
    //sleep(1); 
    usleep(100000);

    if (connection_aborted()) {
        exit();
    }
}
?>