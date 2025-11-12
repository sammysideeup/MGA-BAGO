<?php
// log_progress.php
session_start();
include 'connection.php'; // Your database connection

header('Content-Type: application/json');
$response = ['success' => false, 'message' => ''];

// 1. Authentication and Data Retrieval
if (!isset($_SESSION['email'])) {
    $response['message'] = 'User not logged in.';
    echo json_encode($response);
    exit;
}

// Retrieve user_id from the database using the email
$user_email = $_SESSION['email'];
$sql_user = "SELECT id FROM users WHERE email = ?";
$stmt_user = $conn->prepare($sql_user);
$stmt_user->bind_param("s", $user_email);
$stmt_user->execute();
$result_user = $stmt_user->get_result();
$user_row = $result_user->fetch_assoc();
$current_user_id = $user_row['id'] ?? null;
$stmt_user->close();

if (!$current_user_id) {
    $response['message'] = 'User ID not found.';
    echo json_encode($response);
    exit;
}

// Get the JSON data from the request body
$data = json_decode(file_get_contents("php://input"), true);

$total_duration = $data['total_duration_seconds'] ?? 0;
$session_date = $data['session_date'] ?? date('Y-m-d');
$workout_day = $data['workout_day'] ?? date('l'); 
$exercises_completed = json_encode($data['completed_exercises'] ?? []); // Store as JSON string

if ($total_duration <= 0) {
    $response['message'] = 'Invalid workout duration.';
    echo json_encode($response);
    exit;
}

// 2. Insert into workout_sessions table
$sql_insert = "INSERT INTO workout_sessions (user_id, session_date, total_duration_seconds, workout_day, exercises_completed) VALUES (?, ?, ?, ?, ?)";
$stmt_insert = $conn->prepare($sql_insert);

if (!$stmt_insert) {
    $response['message'] = 'Prepare failed: ' . $conn->error;
    echo json_encode($response);
    exit;
}

$stmt_insert->bind_param("isiss", $current_user_id, $session_date, $total_duration, $workout_day, $exercises_completed);

if ($stmt_insert->execute()) {
    $response['success'] = true;
    $response['message'] = 'Workout progress logged successfully.';
} else {
    $response['message'] = 'Error logging progress: ' . $stmt_insert->error;
}

$stmt_insert->close();
$conn->close();

echo json_encode($response);
?>