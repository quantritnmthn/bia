<?php
// chiabai.php - File xử lý chia bài và lưu vào DB

include 'config.php';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// SỬA LỖI FONT: Thiết lập charset cho phiên kết nối MySQL
    $pdo->exec("SET NAMES 'utf8'");
} catch (PDOException $e) {
    die(json_encode(['error' => "Database connection failed: " . $e->getMessage()]));
}

// Lấy dữ liệu từ POST
$playersJson = $_POST['players'] ?? '';
$soCay = intval($_POST['soCay'] ?? 10);
// THÊM: Lấy biến bàn chơi, mặc định là '1'
$ban = $_POST['b'] ?? '1'; 

$players = json_decode($playersJson, true);
if (!is_array($players) || empty($players)) {
    die(json_encode(['error' => 'Invalid players data']));
}

// Tạo bảng mới nếu chưa tồn tại
// CHÚ Ý: Bảng phải có cột 'ban' và khóa chính hợp lý
$pdo->exec("CREATE TABLE IF NOT EXISTS billiards_deals (
    id INT AUTO_INCREMENT,
    player_name VARCHAR(255) NOT NULL,
    cards TEXT NOT NULL,
    ban INT NOT NULL,
    PRIMARY KEY (id)
    
)");

// Xóa dữ liệu cũ của BÀN CHƠI HIỆN TẠI để chỉ lưu ván hiện tại của bàn đó
// Dùng DELETE thay vì TRUNCATE TABLE để giữ lại dữ liệu của các bàn khác
$stmt_delete = $pdo->prepare("DELETE FROM billiards_deals WHERE ban = ?");
$stmt_delete->execute([$ban]);

$numPlayers = count($players);
$totalCardsNeeded = $numPlayers * $soCay;

if ($totalCardsNeeded > 52) {
    die(json_encode(['error' => 'Không đủ bài để chia']));
}

// Tạo bộ bài
$suits = ['R', 'C', 'B', 'T']; // Rô, Cơ, Bích, Tép
$values = ['A', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K'];
$deck = [];
foreach ($suits as $suit) {
    foreach ($values as $value) {
        $deck[] = $value . $suit;
    }
}

// Xáo trộn ngẫu nhiên
shuffle($deck);shuffle($deck);shuffle($deck);

// Chia bài cho từng người chơi
$hands = [];
$ans = [];
$thois = [];
$rankMap = ['A' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6, '7' => 7, '8' => 8, '9' => 9, '10' => 10, 'J' => 11, 'Q' => 12, 'K' => 13];
$suitMap = ['R' => 3, 'C' => 2, 'B' => 1, 'T' => 0]; // Thứ tự R > C > B > T (descending)

for ($i = 0; $i < $numPlayers; $i++) {
    $hand = array_slice($deck, $i * $soCay, $soCay);
    
    // Sắp xếp tay bài: rank asc, suit desc (R first, then C, B, T)
    usort($hand, function ($a, $b) use ($rankMap, $suitMap) {
        $rankA = $rankMap[substr($a, 0, -1)];
        $rankB = $rankMap[substr($b, 0, -1)];
        if ($rankA != $rankB) {
            return $rankA - $rankB;
        }
        $suitA = $suitMap[substr($a, -1)];
        $suitB = $suitMap[substr($b, -1)];
        return $suitB - $suitA; // desc suit
    });
    
    $hands[] = $players[$i] . ':' . implode(',', $hand);
    $ans[] = 'AN_' . $players[$i] . ':';
    $thois[] = 'THOI_' . $players[$i] . ':';
    $bocbai[] = 'NOC_' . $players[$i] . ':';
    $anbi[] = 'ANBI_' . $players[$i] . ':';
}
// Bài trên nọc (còn lại, không sắp xếp)
$noc = implode(',', array_slice($deck, $numPlayers * $soCay));

// CẬP NHẬT: Thêm cột 'ban' vào câu lệnh INSERT
$stmt = $pdo->prepare("INSERT INTO billiards_deals (player_name, cards, ban) VALUES (?, ?, ?)");

// Lưu cho từng người chơi (cards là chuỗi đã sắp xếp)
foreach ($hands as $hand) {
    [$name, $cards] = explode(':', $hand, 2);
    // THÊM: Truyền biến $ban
    $stmt->execute(["HAND_".$name, $cards, $ban]);
}

// Lưu nọc
// THÊM: Truyền biến $ban
$stmt->execute(['BaiTrenNoc', $noc, $ban]);
// Thời gian
// THÊM: Truyền biến $ban
$stmt->execute(['ThoiGian','0', $ban]);
// Người vừa hạ bài
// THÊM: Truyền biến $ban
$stmt->execute(['NguoiVuaHaBai','', $ban]);
// Người vừa hạ bài
// THÊM: Truyền biến $ban
$stmt->execute(['ThuTuChoi','', $ban]);
// Lưu danh sách AN_
foreach ($ans as $an) {
    [$name, $cards] = explode(':', $an, 2);
    // THÊM: Truyền biến $ban
    $stmt->execute([$name, $cards, $ban]);
}

// Lưu danh sách THOI_
foreach ($thois as $thoi) {
    [$name, $cards] = explode(':', $thoi, 2);
    // THÊM: Truyền biến $ban
    $stmt->execute([$name, $cards, $ban]);
}

// Lưu danh sách BOCBAI_
foreach ($bocbai as $boc) {
    [$name, $cards] = explode(':', $boc, 2);
    // THÊM: Truyền biến $ban
    $stmt->execute([$name, $cards, $ban]);
}

// Lưu danh sách ANBI_
foreach ($anbi as $an) {
    [$name, $cards] = explode(':', $an, 2);
    // THÊM: Truyền biến $ban
    $stmt->execute([$name, $cards, $ban]);
}

echo json_encode(['status' => 'success']);
?>