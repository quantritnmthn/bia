<?php
// get_users.php - Fetch danh sách users từ DB
include 'config.php';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("SET NAMES 'utf8'");
    $stmt = $pdo->query("SELECT DISTINCT Ten 
FROM billiards_users 
WHERE 
    Ten <> '' 
    AND Ten NOT IN (
        SELECT DISTINCT 
            SUBSTRING_INDEX(player_name, '_', -1) COLLATE utf8mb4_general_ci  -- THÊM DÒNG NÀY
        FROM 
            billiards_deals 
        WHERE 
            player_name LIKE 'HAND_%'
    ) 
ORDER BY Ten;
	");
    
    
    $users = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo json_encode($users);
} catch (PDOException $e) {
    echo json_encode([]);
}
?>