<?php
// load.php - modified to accept ?id=

include 'config.php';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo->exec("SET NAMES 'utf8'");
} catch (PDOException $e) {
    die(json_encode([]));
}

$id = isset($_GET['b']) ? intval($_GET['b']) : 1;

$stmt = $pdo->prepare("SELECT data_json FROM billiards_data WHERE id = :id");
$stmt->bindParam(':id', $id);
$stmt->execute();
$data = $stmt->fetchColumn();

if ($data) {
    echo $data;
} else {
    echo '{}';
}
?>