<?php
// CRITICAL: Must be the very first line
session_start(); 
include 'connection.php'; 

header('Content-Type: application/json');

// --- 1. Authentication and User ID Retrieval ---

if (!isset($_SESSION['email'])) {
    echo json_encode(["success" => false, "message" => "User not logged in."]);
    exit();
}

$user_email = $_SESSION['email'];
$current_user_id = null;

try {
    // 1a. Retrieve user_id from the database
    $sql_user = "SELECT id FROM users WHERE email = ?";
    $stmt_user = $conn->prepare($sql_user);
    $stmt_user->bind_param("s", $user_email);
    $stmt_user->execute();
    $result_user = $stmt_user->get_result();

    if ($row_user = $result_user->fetch_assoc()) {
        $current_user_id = $row_user['id'];
    } else {
        echo json_encode(["success" => false, "message" => "User ID not found, invalid session data."]);
        exit();
    }
    $stmt_user->close();

    // 2. Get the day to load from the GET request
    if (!isset($_GET['day'])) {
        echo json_encode(["success" => false, "message" => "Day not specified."]);
        exit();
    }
    $day_of_week = $_GET['day'];

    // 3. Retrieve exercises for that user and day
    $sql_select = "SELECT exercise_name, sets, reps_time FROM workout_journal WHERE user_id = ? AND day_of_week = ?";
    $stmt_select = $conn->prepare($sql_select);
    $stmt_select->bind_param("is", $current_user_id, $day_of_week);
    $stmt_select->execute();
    $result_select = $stmt_select->get_result();

    $exercises = [];
    while ($row = $result_select->fetch_assoc()) {
        $exercises[] = [
            // Use a temporary unique ID for JS to manipulate the element
            'id' => uniqid('db-'), 
            'name' => $row['exercise_name'],
            'sets' => $row['sets'],
            'reps' => $row['reps_time'],
            'img' => '<svg width="48" height="48"><circle cx="24" cy="24" r="20" fill="darkgray" /></svg>' 
        ];
    }

    $stmt_select->close();
    $conn->close();

    // Success response: returns the array (even if empty)
    echo json_encode(["success" => true, "exercises" => $exercises]);

} catch (Exception $e) {
    // Catch any unexpected database or connection errors
    echo json_encode(["success" => false, "message" => "Server Error: " . $e->getMessage()]);
}
?>