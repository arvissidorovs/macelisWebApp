<?php
session_start();

header('Content-Type: application/json');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    exit();
}

$user_id = $_SESSION['user_id'];

// Database connection details
$servername = "localhost:3306";
$username = "centradraudze";
$password = "LcDmirT8!";
$dbname = "maceklis_DB";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['error' => 'Database connection failed']);
    exit();
}

// Prepare the SQL statement to fetch verses with user comments
$sql = "SELECT DISTINCT verse_id FROM verse_comments WHERE user_id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to prepare SQL statement']);
    exit();
}

// Bind parameters and execute
$stmt->bind_param('i', $user_id);

if (!$stmt->execute()) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to execute SQL statement']);
    exit();
}

// Fetch results
$result = $stmt->get_result();
$verses_with_comments = [];

while ($row = $result->fetch_assoc()) {
    $verses_with_comments[] = $row['verse_id'];
}

// Output the results
echo json_encode(['verses_with_comments' => $verses_with_comments]);

// Close the statement and connection
$stmt->close();
$conn->close();
?>
