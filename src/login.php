<?php
$servername = "mysql";
$username_db = "user";
$password_db = "user_password";
$dbname = "database";

$conn = new mysqli($servername, $username_db, $password_db, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Lấy data từ post request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ yêu cầu POST
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Sử dụng prepared statement để ngăn chặn tấn công SQL injection
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("ss", $username, $password);

    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        echo "success";
    } else {
        echo "Invalid username or password";
    }

    $stmt->close();
}

$conn->close();
?>  
