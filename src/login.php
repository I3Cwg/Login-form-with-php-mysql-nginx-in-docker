<?php
$servername = "mysql";
$username_db = "user";
$password_db = "user_password";
$dbname = "database";

// Tạo kết nối đến cơ sở dữ liệu
$conn = new mysqli($servername, $username_db, $password_db, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Kiểm tra xem yêu cầu gửi đến có phải là phương thức POST hay không
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ yêu cầu POST
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Sử dụng prepared statement để ngăn chặn tấn công SQL injection
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    // Bind parameters
    $stmt->bind_param("ss", $username, $password);

    // Thực thi truy vấn
    $stmt->execute();

    // Lấy kết quả
    $result = $stmt->get_result();

    // Kiểm tra xem có bản ghi phù hợp hay không
    if ($result->num_rows == 1) {
        // Đăng nhập thành công
        echo "Đăng nhập thành công!";
    } else {
        // Đăng nhập thất bại
        echo "Đăng nhập thất bại!";
    }

    // Đóng kết nối và giải phóng tài nguyên
    $stmt->close();
}

$conn->close();
?>  
