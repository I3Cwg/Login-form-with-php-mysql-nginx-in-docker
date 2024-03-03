<?php
$servername = "mysql";
$username_db = "user";
$password_db = "user_password";
$dbname = "database";

try {
    // Tạo kết nối đến cơ sở dữ liệu
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username_db, $password_db);
    // Thiết lập chế độ lỗi
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Tạo bảng users (nếu chưa tồn tại)
    $stmt = $conn->query("CREATE TABLE IF NOT EXISTS users (
        username VARCHAR(30) NOT NULL,
        password VARCHAR(30) NOT NULL
    )");

    // Chèn dữ liệu vào bảng users
    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);

    $username = 'admin-nhom10';
    $password = 'admin-nhom10';
    $stmt->execute();


    echo "Data inserted successfully\n";
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
