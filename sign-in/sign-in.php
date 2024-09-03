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

   // Check if any field is empty
   if (empty($username) || empty($email) || empty($password) || empty($repassword)) {
       die("All fields are required.");
   }

   // Check if passwords match
   if ($password !== $repassword) {
       die("Passwords do not match.");
   }

   // Hash the password
   $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

   // Create connection
   $conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

   // Check connection
   if ($conn->connect_error) {
       die("Connection failed: " . $conn->connect_error);
   }

   // Prepare and bind
   $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
   $stmt->bind_param("sss", $username, $email, $hashedPassword);

   // Execute the statement
   if ($stmt->execute() === TRUE) {
       // Registration successful, redirect to login page
       header("Location: ../log-in/login.html");
       exit(); // Ensure script termination after redirection
   } else {
       echo "Error: " . $stmt->error;
   }

   // Close the statement and connection
   $stmt->close();
   $conn->close();
}
?>
