<?php
// reset.php - AJAX endpoint to reset data

include 'config.php';

// THÊM: Lấy biến bàn chơi từ POST (b), mặc định là '1'
$ban = $_POST['b'] ?? '1';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// SỬA LỖI FONT: Thiết lập charset cho phiên kết nối MySQL
    $pdo->exec("SET NAMES 'utf8'");
} catch (PDOException $e) {
    die("Error");
}

try {
    // 1. Reset dữ liệu bảng điểm trong billiards_data cho bàn chơi hiện tại (id = ban)
    $stmt_data = $pdo->prepare("UPDATE billiards_data SET data_json = '{}' WHERE id = ?");
    $stmt_data->execute([$ban]);

    // 2. Xóa dữ liệu bài đã chia trong billiards_deals cho bàn chơi hiện tại
    $stmt_deals = $pdo->prepare("DELETE FROM billiards_deals WHERE ban = ?");
    $stmt_deals->execute([$ban]);

    echo "Reset success";

} catch (PDOException $e) {
    // Nếu có lỗi, trả về thông báo lỗi thay vì 'Error' chung chung
    error_log("Database error during reset: " . $e->getMessage());
    // Trả về Error cho client để client biết lỗi xảy ra
    http_response_code(500);
    die("Error during reset process");
}
?>