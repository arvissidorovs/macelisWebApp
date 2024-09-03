<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Get parameters from GET request
    $verse_id = isset($_GET['verse_id']) ? trim($_GET['verse_id']) : '';

    // Check if the user is logged in (optional based on your requirements)
    if (!isset($_SESSION['user_id'])) {
        http_response_code(403);
        echo json_encode(['error' => 'User not logged in']);
        exit();
    }

    // Database connection
    $servername = "localhost:3306";
    $username = "centradraudze";
    $password = "LcDmirT8!";
    $dbname = "maceklis_DB";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        http_response_code(500);
        echo json_encode(['error' => 'Database connection failed']);
        exit();
    }

    // Prepare the SQL query to get the comment
    $stmt = $conn->prepare("SELECT comment FROM verse_comments WHERE verse_id = ? LIMIT 1");

    if (!$stmt) {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to prepare statement']);
        exit();
    }

    $stmt->bind_param('s', $verse_id);
    $stmt->execute();
    $stmt->bind_result($comment);
    $stmt->fetch();

    $response = [];
    if ($comment) {
        $response['comment'] = $comment;
    } else {
        $response['comment'] = ''; // No comment found
    }

    $stmt->close();
    $conn->close();

    echo json_encode($response);
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid request method']);
}
?>
