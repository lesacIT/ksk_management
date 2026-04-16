<?php
// config.php - dành cho dự án ksk_management
$host = 'localhost';
$dbname = 'ksk_management';   // Đặt tên database mới cho dự án này
$username = 'root';            // Giữ nguyên user root
$password = '';                // XAMPP mặc định không mật khẩu

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Kết nối CSDL thất bại: " . $e->getMessage());
}
?>