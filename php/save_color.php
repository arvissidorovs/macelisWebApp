<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id'])) {
    $verse_id = $_POST['verse_id'];
    $color = $_POST['color'];
    $user_id = $_SESSION['user_id'];

    // Database connection
    $servername = "localhost:3306";
    $username = "centradraudze";
    $password = "LcDmirT8!";
    $dbname = "maceklis_DB";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare SQL statement to check if the verse color entry exists for the user
    $stmt = $conn->prepare("SELECT id FROM verse_colors WHERE verse_id=? AND user_id=?");
    $stmt->bind_param('si', $verse_id, $user_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Update existing entry
        $stmt->close();
        $stmt = $conn->prepare("UPDATE verse_colors SET color=? WHERE verse_id=? AND user_id=?");
        $stmt->bind_param('ssi', $color, $verse_id, $user_id);
    } else {
        // Insert new entry
        $stmt->close();
        $stmt = $conn->prepare("INSERT INTO verse_colors (verse_id, user_id, color) VALUES (?, ?, ?)");
        $stmt->bind_param('sis', $verse_id, $user_id, $color);
    }

    if ($stmt->execute()) {
        echo "Color saved successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request";
}
?>
