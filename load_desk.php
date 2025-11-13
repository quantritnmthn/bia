<?php
include 'config.php';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// SỬA LỖI FONT: Thiết lập charset cho phiên kết nối MySQL
    $pdo->exec("SET NAMES 'utf8'");
} catch (PDOException $e) {
    die(json_encode(['error' => "Database connection failed: " . $e->getMessage()]));
}

$stmt = $pdo->query("SELECT player_name, cards FROM billiards_deals");
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

echo json_encode(['hands' => $hands, 'ans' => $ans, 'thoi' => $thoi,'bocnoc' => $noc, 'baiTrenNoc' => $baiTrenNoc]);
?>