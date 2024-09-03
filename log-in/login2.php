<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $servername = "localhost:3306";
    $username = "centradraudze";
    $password = "LcDmirT8!";
    $dbname = "maceklis_DB";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $inputUsername = $_POST['username'];
    $inputPassword = $_POST['password'];

    // Fetch hashed password and user ID from the database
    $sql = "SELECT id, username, password FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $inputUsername);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $hashedPassword = $row['password'];

        // Verify the input password against the hashed password
        if (password_verify($inputPassword, $hashedPassword)) {
            // Valid login
            $_SESSION['username'] = $row['username'];
            $_SESSION['user_id'] = $row['id']; // Store user ID in session
            header("Location: ../../maceklis_test_page"); // Redirect to logged-in page
            exit();
        } else {
            // Invalid password
            $_SESSION['error'] = "Nepareizs lietotājvārds vai parole.";
        }
    } else {
        // User not found
        $_SESSION['error'] = "Šāds lietotājs nav reģistrēts.";
    }

    $stmt->close();
    $conn->close();
    header("Location: login.php"); // Redirect back to login.html
    exit();
}
?>
