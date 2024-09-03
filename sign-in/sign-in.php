<?php
$servername = "localhost:3306";
$dbUsername = "centradraudze";
$dbPassword = "LcDmirT8!";
$dbname = "maceklis_DB";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $repassword = isset($_POST['repassword']) ? $_POST['repassword'] : '';

    if (empty($username) || empty($email) || empty($password) || empty($repassword)) {
        die("All fields are required.");
    }

    if ($password !== $repassword) {
        die("Passwords do not match.");
    }

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    $conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $hashedPassword);

    if ($stmt->execute() === TRUE) {
        header("Location: ../log-in/login.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>