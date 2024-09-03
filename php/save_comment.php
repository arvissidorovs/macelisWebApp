<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get parameters from POST request
    $verse_id = isset($_POST['verse_id']) ? trim($_POST['verse_id']) : '';
    $comment = isset($_POST['comment']) ? trim($_POST['comment']) : '';

    // Check if the user is logged in
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

    // Prepare the SQL query to insert or update the comment
    $user_id = $_SESSION['user_id']; // Assuming user_id is stored in session

    // Check if a comment already exists for this verse_id by this user
    $stmt = $conn->prepare("SELECT comment FROM verse_comments WHERE verse_id = ? AND user_id = ?");

    if (!$stmt) {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to prepare statement']);
        exit();
    }

    $stmt->bind_param('si', $verse_id, $user_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Comment exists, perform an update
        $stmt->close();
        $stmt = $conn->prepare("UPDATE verse_comments SET comment = ? WHERE verse_id = ? AND user_id = ?");
        if (!$stmt) {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to prepare update statement']);
            exit();
        }
        $stmt->bind_param('ssi', $comment, $verse_id, $user_id);
    } else {
        // No comment exists, perform an insert
        $stmt->close();
        $stmt = $conn->prepare("INSERT INTO verse_comments (verse_id, user_id, comment) VALUES (?, ?, ?)");
        if (!$stmt) {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to prepare insert statement']);
            exit();
        }
        $stmt->bind_param('sis', $verse_id, $user_id, $comment);
    }

    $stmt->execute();
    
    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => 'Comment saved successfully']);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to save comment']);
    }

    $stmt->close();
    $conn->close();
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid request method']);
}
