<?php
session_start();
include 'connection.php'; 

header('Content-Type: application/json');

// --- 1. Authentication and User ID Retrieval ---

// Check if user is logged in using 'email'
if (!isset($_SESSION['email'])) {
    echo json_encode(["success" => false, "message" => "User not logged in."]);
    exit();
}

// Retrieve user_id from the database using the email
$user_email = $_SESSION['email'];
$current_user_id = null;

$sql = "SELECT id FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user_email);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $current_user_id = $row['id'];
} else {
    // Should not happen if login is correct, but handles corrupted session data
    echo json_encode(["success" => false, "message" => "User ID not found, please log in again."]);
    exit();
}
$stmt->close();
$user_id = $current_user_id; 


// --- 2. Data Processing and Transaction ---

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents('php://input'), true);

    if (empty($data['day']) || !isset($data['exercises'])) {
        echo json_encode(["success" => false, "message" => "Invalid data received."]);
        exit();
    }

    $day_of_week = $data['day'];
    $exercises = $data['exercises'];

    // Start transaction for atomic operations
    $conn->begin_transaction();
    
    try {
        // 3. Delete existing data for the current day for this user (to prevent duplicates)
        $sql_delete = "DELETE FROM workout_journal WHERE user_id = ? AND day_of_week = ?";
        $stmt_delete = $conn->prepare($sql_delete);
        $stmt_delete->bind_param("is", $user_id, $day_of_week);
        $stmt_delete->execute();
        $stmt_delete->close();
        
        // 4. Insert new data
        if (!empty($exercises)) {
            $sql_insert = "INSERT INTO workout_journal (user_id, day_of_week, exercise_name, sets, reps_time) VALUES (?, ?, ?, ?, ?)";
            $stmt_insert = $conn->prepare($sql_insert);
            
            foreach ($exercises as $exercise) {
                // Cast sets to integer (i) since it's INT in DB, and others to string (s)
                $sets = is_numeric($exercise['sets']) ? (int)$exercise['sets'] : null;

                $stmt_insert->bind_param("issis", 
                    $user_id, 
                    $day_of_week, 
                    $exercise['name'], 
                    $sets, 
                    $exercise['reps'] // Reps can be '10x' or '30secs', so treat as string
                );
                $stmt_insert->execute();
            }
            $stmt_insert->close();
        }
        
        // Commit the transaction
        $conn->commit();
        echo json_encode(["success" => true, "message" => "Workout journal saved successfully!"]);

    } catch (mysqli_sql_exception $e) {
        // Rollback on database error
        $conn->rollback();
        echo json_encode(["success" => false, "message" => "Database error: " . $e->getMessage()]);
    }
    
    $conn->close();

} else {
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
}
?>