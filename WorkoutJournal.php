<?php 
// 🔑 PHP Session and Authentication
session_start();

include 'connection.php'; // Ensure this path is correct

// Check if user is logged in using the 'email' session variable
if (!isset($_SESSION['email'])) {
    header("Location: Loginpage.php");
    exit();
}

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
    session_destroy();
    header("Location: Loginpage.php");
    exit();
}
$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Workout Journal</title>
    <link rel="stylesheet" href="Memberstyle.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        /* CSS for highlighting the active day tab */
        .day-tab.active-day {
            background-color: #3b82f6; /* Tailwind blue-500 */
            color: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .toast-wrapper{
            position: fixed;
            top: 20px;
            right: 20px;
            width: 380px;
            z-index: 1000;
            opacity: 0;
            transform: translateX(100%);
            transition: opacity 0.5s, transform 0.5s;
        }

        .toast-wrapper.show{
            opacity: 1;
            transform: translateX(0);
        }

        .toast{
            width: 100%;
            height: 80px;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 7px;
            display: grid;
            grid-template-columns: 1.3fr 6fr 0.5fr;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.08)
        }

        .success{
            border-left: 8px solid #47D764;
        }

        .success i{
            color:#47D764;
        }

        .error {
            border-left: 8px solid #FF5050;
        }

        .error i {
            color: #FF5050;
        }

        .container-1, .container-2{
            align-self: center;
        }

        .container-1 i{
            font-size: 35px;
        }

        .container-2 p:first-child {
            color: #101020;
            font-weight: 600;
            font-size: 16px;
        }

        .container-2 p:last-child {
            font-size: 12px;
            font-weight: 400;
            color: #656565;
        }

        .toast button {
            align-self: flex-start;
            background-color: transparent;
            font-size: 25px;
            color: #656565;
            line-height: 0;
            cursor: pointer;
        }

        
    </style>

    
</head>
<body>

<div id="toast-notification" class="toast-wrapper">
    <div class="toast success">
        <div class="container-1">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="container-2">
            <p>Success</p>
            <p>Workout Journal updated!</p>
        </div>
        <button onclick="document.getElementById('toast-notification').classList.remove('show')">&times;</button>
    </div>
</div>

<div class="sidebar">
    <ul>
        <li><a href="Membership.php"><i class='bx bx-user'></i> User Details</a></li>
        <li><a href="#"><i class='bx bx-notepad'></i> Workout Journal</a></li>
        <li><a href="Progress.php"><i class='bx bx-line-chart'></i>Progress</a></li>
        <li><a href="TrainerBooking.php"><i class='bx bxs-user-pin'></i> Trainers</a></li>
        <li class="more-menu">
            <a href="#" class="more-toggle">
                 More 
                <i class='bx bx-chevron-down toggle-icon'></i>
            </a>
            <ul class="submenu">
                <li><a href="CalorieScanner.php"><i class='bx bx-scan'></i> Calorie Scanner</a></li>
                <li><a href="ScanEquipment.php"><i class='bx bx-qr-scan'></i> Scan Equipment</a></li>
            </ul>
        </li>
        <li><a href="Loginpage.php"><i class='bx bx-log-out'></i> Logout</a></li>
    </ul>
</div>



<main class="bg-white rounded-2xl w-full drop-shadow-lg select-none" role="main">
    <section class="p-6">
        <h1 class="text-2xl font-bold leading-tight mb-6">Workout Journal</h1>
        <p>Customize your own personalized workout</p>

        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-3 mt-6 mb-8">
            <div onclick="showDay('Monday')" class="day-tab bg-gray-100 rounded-xl p-4 text-center shadow-inner font-semibold cursor-pointer">Monday</div>
            <div onclick="showDay('Tuesday')" class="day-tab bg-gray-100 rounded-xl p-4 text-center shadow-inner font-semibold cursor-pointer">Tuesday</div>
            <div onclick="showDay('Wednesday')" class="day-tab bg-gray-100 rounded-xl p-4 text-center shadow-inner font-semibold cursor-pointer">Wednesday</div>
            <div onclick="showDay('Thursday')" class="day-tab bg-gray-100 rounded-xl p-4 text-center shadow-inner font-semibold cursor-pointer">Thursday</div>
            <div onclick="showDay('Friday')" class="day-tab bg-gray-100 rounded-xl p-4 text-center shadow-inner font-semibold cursor-pointer">Friday</div>
            <div onclick="showDay('Saturday')" class="day-tab bg-gray-100 rounded-xl p-4 text-center shadow-inner font-semibold cursor-pointer">Saturday</div>
            <div onclick="showDay('Sunday')" class="day-tab bg-gray-100 rounded-xl p-4 text-center shadow-inner font-semibold cursor-pointer">Sunday</div>
        </div>

        <div class="flex gap-4 mb-6">
            <button class="bg-indigo-500 hover:bg-indigo-600 text-white font-medium py-2 px-4 rounded" onclick="browseWorkout()">Browse Workout</button>
            <button class="bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded" onclick="document.getElementById('addExerciseModal').showModal()">Add Exercise</button>
            <button id="saveRoutineButton" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded" onclick="saveWorkoutRoutine()">Save Routine</button>
        </div>

        <button id="start-button" class="mt-4 p-2 bg-blue-500 text-white rounded">Start Workout</button>

        <div id="day-views">
            <div id="Monday" class="day-view"><h2 class="text-lg font-semibold mb-3">Exercises for Monday</h2><ul class="exercise-list divide-y divide-gray-200" role="list"></ul></div>
            <div id="Tuesday" class="day-view hidden"><h2 class="text-lg font-semibold mb-3">Exercises for Tuesday</h2><ul class="exercise-list divide-y divide-gray-200"></ul></div>
            <div id="Wednesday" class="day-view hidden"><h2 class="text-lg font-semibold mb-3">Exercises for Wednesday</h2><ul class="exercise-list divide-y divide-gray-200"></ul></div>
            <div id="Thursday" class="day-view hidden"><h2 class="text-lg font-semibold mb-3">Exercises for Thursday</h2><ul class="exercise-list divide-y divide-gray-250"></ul></div>
            <div id="Friday" class="day-view hidden"><h2 class="text-lg font-semibold mb-3">Exercises for Friday</h2><ul class="exercise-list divide-y divide-gray-200"></ul></div>
            <div id="Saturday" class="day-view hidden"><h2 class="text-lg font-semibold mb-3">Exercises for Saturday</h2><ul class="exercise-list divide-y divide-gray-200"></ul></div>
            <div id="Sunday" class="day-view hidden"><h2 class="text-lg font-semibold mb-3">Exercises for Sunday</h2><ul class="exercise-list divide-y divide-gray-200"></ul></div>
        </div>
    </section>
</main>

<dialog id="addExerciseModal" class="rounded-lg p-6 w-full max-w-md border border-gray-300 shadow-xl">
    <form method="dialog" class="space-y-4">
        <h3 class="text-xl font-semibold">Add New Exercise</h3>
        <div>
            <label class="block text-sm font-medium mb-1">Routine Name</label>
            <input type="text" id="routineName" class="w-full border rounded px-3 py-2" required />
        </div>
        <div class="flex gap-2">
            <div class="flex-1">
                <label class="block text-sm font-medium mb-1">Sets</label>
                <input type="number" id="exerciseSets" class="w-full border rounded px-3 py-2" />
            </div>
            <div class="flex-1">
                <label class="block text-sm font-medium mb-1">Reps / Time (e.g., '12x' or '30secs')</label>
                <input type="text" id="exerciseReps" class="w-full border rounded px-3 py-2" />
            </div>
        </div>
        <div class="flex justify-end gap-2 pt-4">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Add</button>
            <button type="button" class="bg-gray-300 px-4 py-2 rounded" onclick="document.getElementById('addExerciseModal').close()">Cancel</button>
        </div>
    </form>
</dialog>

<dialog id="browseWorkoutModal" class="rounded-lg p-6 w-full max-w-md border border-gray-300 shadow-xl">
    <form method="dialog" class="space-y-4" id="browseWorkoutForm">
        <h3 class="text-xl font-semibold">Browse Exercises</h3>
        <div id="browseExerciseList"></div>
        <div class="flex justify-end gap-2 pt-4">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Add Selected</button>
            <button type="button" class="bg-gray-300 px-4 py-2 rounded" onclick="document.getElementById('browseWorkoutModal').close()">Cancel</button>
        </div>
    </form>
</dialog>

<dialog id="editExerciseModal" class="rounded-lg p-6 w-full max-w-md border border-gray-300 shadow-xl">
    <form method="dialog" class="space-y-4" id="editExerciseForm">
        <h3 class="text-xl font-semibold">Edit Exercise</h3>
        <input type="hidden" id="editExerciseId">
        <div>
            <label class="block text-sm font-medium mb-1">Name</label>
            <input type="text" id="editExerciseName" class="w-full border rounded px-3 py-2" required>
        </div>
        <div class="flex gap-2">
            <div class="flex-1">
                <label class="block text-sm font-medium mb-1">Sets</label>
                <input type="number" id="editExerciseSets" class="w-full border rounded px-3 py-2">
            </div>
            <div class="flex-1">
                <label class="block text-sm font-medium mb-1">Reps / Time</label>
                <input type="text" id="editExerciseReps" class="w-full border rounded px-3 py-2">
            </div>
        </div>
        <div class="flex justify-end gap-2 pt-4">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Save</button>
            <button type="button" class="bg-gray-300 px-4 py-2 rounded" onclick="document.getElementById('editExerciseModal').close()">Cancel</button>
        </div>
    </form>
</dialog>


<script>
let currentDay = 'Monday';

// Holds the currently visible exercises for each day
const dayExercises = {
    Monday: [], Tuesday: [], Wednesday: [], Thursday: [], Friday: [], Saturday: [], Sunday: []
};


const sampleExercises = [
    { id: "dumbbell-bicep-curl", name: "Dumbbell Bicep Curl", group: "Arms", sets: 3, reps: "12x", img: `<svg width="48" height="48"><circle cx="24" cy="24" r="20" fill="gray"/></svg>` },
    { id: "tricep-pushdown", name: "Tricep Pushdown", group: "Arms", sets: 3, reps: "12x", img: `<svg width="48" height="48"><circle cx="24" cy="24" r="20" fill="gray"/></svg>` },
    { id: "crunches", name: "Crunches", group: "Abs", sets: 3, reps: "20x", img: `<svg width="48" height="48"><rect width="48" height="48" fill="lightgray"/></svg>` },
    { id: "leg-press", name: "Leg Press", group: "Legs", sets: 4, reps: "10x", img: `<svg width="48" height="48"><rect width="48" height="48" fill="gray"/></svg>` },
    { id: "bench-press", name: "Bench Press", group: "Chest", sets: 4, reps: "8x", img: `<svg width="48" height="48"><rect width="48" height="48" fill="darkgray"/></svg>` },
    
    { id: "treadmill", name: "Treadmill", group: "Cardio", sets: 1, reps: "5 mins", img: `<svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"></svg>` },
    { id: "cable-crunch", name: "Cable Crunch", group: "Abs", sets: 3, reps: "12-15x", img: `<svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"></svg>` },
    { id: "roman-chair-knee-raises", name: "Roman Chair Knee Raises", group: "Abs", sets: 3, reps: "10-12x", img: `<svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"></svg>` },
    { id: "decline-sit-ups", name: "Decline Sit-Ups", group: "Abs", sets: 3, reps: "10-12x", img: `<svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"></svg>` },
    { id: "plank-hold", name: "Plank Hold", group: "Abs", sets: 3, reps: "30 secs", img: `<svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"></svg>` },
    { id: "dead-bug", name: "Dead Bug", group: "Abs", sets: 3, reps: "10x", img: `<svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"></svg>` },
    { id: "lying-leg-raises", name: "Lying Leg Raises", group: "Abs", sets: 3, reps: "10x", img: `<svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"></svg>` },
    { id: "hanging-knee", name: "Hanging Knee", group: "Abs", sets: 3, reps: "12x", img: `<svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"></svg>` },
    { id: "weighted-cable-crunch", name: "Weighted Cable Crunch", group: "Abs", sets: 3, reps: "12x", img: `<svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"></svg>` },
    { id: "russian-twist", name: "Russian Twist", group: "Abs", sets: 3, reps: "15x each side", img: `<svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"></svg>` },
    { id: "v-ups", name: "V-Ups", group: "Abs", sets: 3, reps: "12x", img: `<svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"></svg>` },
    { id: "plank-shoulder-taps", name: "Plank Shoulder Taps", group: "Abs", sets: 3, reps: "20x taps", img: `<svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"></svg>` },
    { id: "barbell-rollout", name: "Barbell Rollout", group: "Abs", sets: 3, reps: "8x", img: `<svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"></svg>` },
    { id: "cable-woodchoppers", name: "Cable Woodchoppers", group: "Abs", sets: 3, reps: "10x each side", img: `<svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"></svg>` },
    { id: "hanging-straight-leg-raises", name: "Hanging Straight Leg Raises", group: "Abs", sets: 4, reps: "15x", img: `<svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"></svg>` },
    { id: "weighted-decline-sit-up-with-twist", name: "Weighted Decline Sit-Up With Twist", group: "Abs", sets: 4, reps: "10x each side", img: `<svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"></svg>` },
    { id: "dragon-flags", name: "Dragon Flags", group: "Abs", sets: 3, reps: "12x", img: `<svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"></svg>` },
    { id: "plank-to-push-up", name: "Plank To Push-Up", group: "Abs", sets: 3, reps: "10-12", img: `<svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"></svg>` },
    { id: "ad-cable-crunch-heavy-pause", name: "Ad Cable Crunch (Heavy) + Pause", group: "Abs", sets: 4, reps: "10x", img: `<svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"></svg>` },
    { id: "cable-oblique-twists", name: "Cable Oblique Twists", group: "Abs", sets: 3, reps: "12x each side", img: `<svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"></svg>` },
    { id: "toe-touches-pulse-crunch", name: "Toe Touches + Pulse Crunch", group: "Abs", sets: 3, reps: "15x", img: `<svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"></svg>` },
    { id: "weighted-plank", name: "Weighted Plank", group: "Abs", sets: 3, reps: "60 secs", img: `<svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"></svg>` },

    { id: "ez-bar-curl", name: "EZ Bar Curl", group: "Arms", sets: 3, reps: "10x", img: `<svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"></svg>` },
    { id: "overhead-dumbbell-tricep-extension", name: "Overhead Dumbbell Tricep Extension", group: "Arms", sets: 3, reps: "10x", img: `<svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"></svg>` },
    { id: "cable-hammer-curl", name: "Cable Hammer Curl", group: "Arms", sets: 3, reps: "12x", img: `<svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"></svg>` },
    { id: "wrist-curl", name: "Wrist Curl", group: "Forearms", sets: 3, reps: "15x", img: `<svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"></svg>` },
    { id: "barbell-curl", name: "Barbell Curl", group: "Arms", sets: 4, reps: "10x", img: `<svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"></svg>` },
    { id: "skull-crushers", name: "Skull Crushers", group: "Arms", sets: 4, reps: "12x", img: `<svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"></svg>` },
    { id: "preacher-curl", name: "Preacher Curl", group: "Arms", sets: 3, reps: "10x", img: `<svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"></svg>` },
    { id: "dips", name: "Dips", group: "Arms", sets: 3, reps: "12x each arm", img: `<svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"></svg>` },
    { id: "cable-concentration-curl", name: "Cable Concentration Curl", group: "Arms", sets: 3, reps: "15x", img: `<svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"></svg>` },
    { id: "tricep-kickbacks", name: "Tricep Kickbacks", group: "Arms", sets: 3, reps: "15x", img: `<svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"></svg>` },
    { id: "reverse-curl", name: "Reverse Curl", group: "Forearms", sets: 3, reps: "12x", img: `<svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"></svg>` },
    { id: "barbell-curl-drop-set", name: "Barbell Curl (Drop Set)", group: "Arms", sets: 3, reps: "10x", img: `<svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"></svg>` },
    { id: "close-grip-bench-press", name: "Close Grip Bench Press", group: "Arms", sets: 4, reps: "10x", img: `<svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"></svg>` },
    { id: "incline-dumbbell-curl", name: "Incline Dumbbell Curl", group: "Arms", sets: 4, reps: "10x", img: `<svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"></svg>` },
    { id: "tricep-rope-pushdown-overhead-superset", name: "Tricep Rope Pushdown + Overhead Superset", group: "Arms", sets: 3, reps: "12x", img: `<svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"></svg>` },
    { id: "zottman-curl", name: "Zottman Curl", group: "Arms", sets: 3, reps: "12x", img: `<svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"></svg>` },
    { id: "one-arm-cable-tricep-extension", name: "One-Arm Cable Tricep Extension", group: "Arms", sets: 3, reps: "12x each", img: `<svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"></svg>` },
    { id: "farmers-carry", name: "Farmers Carry", group: "Forearms", sets: 3, reps: "30 secs", img: `<svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"></svg>` },

    { id: "machine-chest-press-basic", name: "Machine Chest Press", group: "Chest", sets: 3, reps: "12x", img: `<svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"></svg>` },
    { id: "dumbbell-bench-press", name: "Dumbbell Bench Press", group: "Chest", sets: 3, reps: "10x", img: `<svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"></svg>` },
    { id: "pec-deck", name: "Pec Deck", group: "Chest", sets: 3, reps: "12x", img: `<svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"></svg>` },
    { id: "push-ups", name: "Push-Ups", group: "Chest", sets: 3, reps: "8x", img: `<svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"></svg>` },
    { id: "incline-machine-press", name: "Incline Machine Press", group: "Chest", sets: 3, reps: "12x", img: `<svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"></svg>` },
    { id: "barbell-flat-bench-press", name: "Barbell Bench Press", group: "Chest", sets: 4, reps: "10x", img: `<svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"></svg>` },
    { id: "incline-dumbbell-press-basic", name: "Incline Dumbbell Press", group: "Chest", sets: 4, reps: "12x", img: `<svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"></svg>` },
    { id: "cable-chest-fly", name: "Cable Chest Fly", group: "Chest", sets: 3, reps: "12x", img: `<svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"></svg>` },
    { id: "chest-dips", name: "Chest Dips", group: "Chest", sets: 3, reps: "10x", img: `<svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"></svg>` },
    { id: "dumbbell-pullover", name: "Dumbbell Pullover", group: "Chest", sets: 3, reps: "12x", img: `<svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"></svg>` },
    { id: "incline-push-ups-burnout", name: "Incline Push-Ups (Burnout)", group: "Chest", sets: 2, reps: "15x", img: `<svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"></svg>` },
    { id: "barbell-bench-press-pyramid", name: "Barbell Bench Press (Pyramid Set)", group: "Chest", sets: 4, reps: "15x", img: `<svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"></svg>` },
    { id: "cable-fly-push-ups", name: "Cable Fly + Push-Ups", group: "Chest", sets: 3, reps: "15x", img: `<svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"></svg>` },
    { id: "decline-bench-press", name: "Decline Bench Press", group: "Chest", sets: 4, reps: "10x", img: `<svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"></svg>` },
    { id: "dumbbell-squeeze-press", name: "Dumbbell Squeeze Press", group: "Chest", sets: 3, reps: "12x", img: `<svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"></svg>` },
    { id: "isometric-push-up-hold", name: "Isometric Push-Up Hold (Burnout)", group: "Chest", sets: 2, reps: "Hold 20-30 secs", img: `<svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"></svg>` },

    { id: "bodyweight-squats", name: "Bodyweight Squats", group: "Legs", sets: 3, reps: "15x", img: `<svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"></svg>` },
    { id: "leg-curl-machine", name: "Leg Curl Machine", group: "Legs", sets: 3, reps: "12x", img: `<svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"></svg>` },
    { id: "leg-extension-machine", name: "Leg Extension Machine", group: "Legs", sets: 3, reps: "12x", img: `<svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"></svg>` },
    { id: "standing-calf-raise", name: "Standing Calf Raise", group: "Calves", sets: 3, reps: "15x", img: `<svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"></svg>` },
    { id: "barbell-back-squat-10x", name: "Barbell Back Squat", group: "Legs", sets: 4, reps: "10x", img: `<svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"></svg>` },
    { id: "romanian-deadlift-12x", name: "Romanian Deadlift", group: "Legs", sets: 3, reps: "12x", img: `<svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"></svg>` },
    { id: "walking-lunges", name: "Walking Lunges", group: "Legs", sets: 3, reps: "12x steps each leg", img: `<svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"></svg>` },
    { id: "seated-leg-curl", name: "Seated Leg Curl", group: "Legs", sets: 3, reps: "12x", img: `<svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"></svg>` },
    { id: "seated-calf-raise-15x", name: "Seated Calf Raise", group: "Calves", sets: 3, reps: "15x", img: `<svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"></svg>` },
    { id: "barbell-back-squat-15x", name: "Barbell Back Squat", group: "Legs", sets: 4, reps: "15x", img: `<svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"></svg>` },
    { id: "bulgarian-split-squat", name: "Bulgarian Split Squat", group: "Legs", sets: 3, reps: "12x each leg", img: `<svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"></svg>` },
    { id: "romanian-deadlift-10x", name: "Romanian Deadlift", group: "Legs", sets: 4, reps: "10x", img: `<svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"></svg>` },
    { id: "hack-squat", name: "Hack Squat", group: "Legs", sets: 3, reps: "12x", img: `<svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"></svg>` },
    { id: "leg-curl", name: "Leg Curl", group: "Legs", sets: 3, reps: "15x", img: `<svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"></svg>` },
    { id: "walking-lunge-calf-raises", name: "Walking Lunge + Calf Raises", group: "Legs", sets: 3, reps: "12x steps", img: `<svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"></svg>` },
    { id: "seated-calf-raise-20x", name: "Seated Calf Raise", group: "Calves", sets: 3, reps: "20x", img: `<svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"></svg>` },

    { id: "lat-pulldown", name: "Lat Pulldown", group: "Back", sets: 3, reps: "12x", img: `<svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"></svg>` },
    { id: "dumbbell-shoulder-press", name: "Dumbbell Shoulder Press", group: "Shoulders", sets: 3, reps: "12x", img: `<svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"></svg>` },
    { id: "seated-ab-crunch-machine", name: "Seated Ab Crunch Machine", group: "Abs", sets: 2, reps: "15x", img: `<svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"></svg>` },
    { id: "seated-shoulder-press", name: "Seated Shoulder Press", group: "Shoulders", sets: 3, reps: "12x", img: `<svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"></svg>` },
    { id: "cable-bicep-curl", name: "Cable Bicep Curl", group: "Arms", sets: 3, reps: "12x", img: `<svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"></svg>` },
    { id: "dumbbell-tricep-overload-press", name: "Dumbbell Tricep Overload Press", group: "Arms", sets: 3, reps: "12x", img: `<svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"></svg>` },
    { id: "hanging-leg-raise-15x", name: "Hanging Leg Raise", group: "Abs", sets: 3, reps: "15x", img: `<svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"></svg>` },
    { id: "deadlift", name: "Deadlift", group: "Back", sets: 4, reps: "5x", img: `<svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"></svg>` },
    { id: "squat-to-overhead-press", name: "Squat To Overhead Press", group: "Legs", sets: 3, reps: "10x", img: `<svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"></svg>` },    
    { id: "pull-ups", name: "Pull-Ups", group: "Back", sets: 3, reps: "12x", img: `<svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"></svg>` },
    { id: "arnold-press", name: "Arnold Press", group: "Shoulders", sets: 3, reps: "10x", img: `<svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"></svg>` },
    { id: "barbell-curl-tricep-rope-pushdown-superset", name: "Barbell Curl Tricep Rope Pushdown", group: "Arms", sets: 3, reps: "12x", img: `<svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"></svg>` },
];


function markRoutineAsModified() {
    const saveButton = document.getElementById('saveRoutineButton');
    // Remove default styles
    saveButton.classList.remove('bg-blue-600', 'hover:bg-blue-700');
    // Add warning/modification styles
    saveButton.classList.add('bg-yellow-600', 'hover:bg-yellow-700', 'animate-pulse');
}

function resetSaveButton() {
    const saveButton = document.getElementById('saveRoutineButton');
    // Reset to default styles
    saveButton.classList.remove('bg-yellow-600', 'hover:bg-yellow-700', 'animate-pulse');
    saveButton.classList.add('bg-blue-600', 'hover:bg-blue-700');
}

function showDay(day) {
    // 1. Visually switch the day tab
    document.querySelectorAll(".day-tab").forEach(tab => tab.classList.remove('active-day'));
    document.querySelector(`.day-tab[onclick*='${day}']`).classList.add('active-day');
    
    // 2. Visually switch the day view
    document.querySelectorAll(".day-view").forEach(view => view.classList.add("hidden"));
    document.getElementById(day).classList.remove("hidden");
    currentDay = day;
    
    // 3. Trigger loading of data for the newly selected day
    loadExercisesForDay(day);
}

function loadExercisesForDay(day) {
    const exerciseList = document.querySelector(`#${day} .exercise-list`);
    
    // Reset and show loading message
    resetSaveButton();
    exerciseList.innerHTML = '<li class="p-3 text-gray-400">Loading routine...</li>';
    dayExercises[day] = []; // Clear the JS array

    fetch(`load_workout.php?day=${day}`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            exerciseList.innerHTML = ''; // Clear loading message

            if (data.success) {
                if (data.exercises.length > 0) {
                    dayExercises[day] = data.exercises; 
                    
                    data.exercises.forEach(ex => {
                        exerciseList.appendChild(createExerciseItem(ex));
                    });
                } else {
                    // *** IMPORTANT: Unique class for easy removal (used below) ***
                    exerciseList.innerHTML = '<li class="empty-list-placeholder p-3 text-gray-500">No exercises saved for this day. Click "Browse Workout" or "Add Exercise" to begin.</li>';
                }
            } else {
                exerciseList.innerHTML = `<li class="p-3 text-red-500">Error loading data: ${data.message}</li>`;
                console.error('Server reported error:', data.message);
            }
        })
        .catch(error => {
            console.error('Error fetching workout:', error);
            exerciseList.innerHTML = `<li class="p-3 text-red-500">Connection Error.</li>`;
        });
}


// TOAST
function showToast(type, message) {
    const toastWrapper = document.getElementById('toast-notification');
    const toastElement = toastWrapper.querySelector('.toast');
    const iconElement = toastWrapper.querySelector('.container-1 i');
    const titleElement = toastWrapper.querySelector('.container-2 p:first-child');
    const messageElement = toastWrapper.querySelector('.container-2 p:last-child');

    toastElement.classList.remove('success', 'error');
    if (type === 'success') {
        toastElement.classList.add('success');
        iconElement.className = 'fas fa-check-circle'; 
        titleElement.textContent = 'Success';
    } else if (type === 'error') {
        toastElement.classList.add('error');
        iconElement.className = 'fas fa-times-circle'; 
        titleElement.textContent = 'Error';
    }

    messageElement.textContent = message;
    toastWrapper.classList.add('show');
    
    setTimeout(() => {
        toastWrapper.classList.remove('show');
    }, 4000); 
}

function saveWorkoutRoutine() {
    const dataToSave = {
        day: currentDay, 
        exercises: (dayExercises[currentDay] || []).map(ex => ({
            name: ex.name,
            sets: ex.sets,
            reps: ex.reps
        }))
    };

    fetch('save_workout.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(dataToSave)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast('success', 'Workout Journal updated!');
            resetSaveButton(); 
            loadExercisesForDay(currentDay); 
        } else {
            showToast('error', 'Error has occured while saving changes.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('error', 'A network error occurred while communicating with the server.');
    });
}


function createExerciseItem(ex) {
    const li = document.createElement("li");
    li.className = "flex items-center p-3 cursor-grab justify-between gap-4";
    li.id = ex.id;

    const imgHtml = ex.img || `<svg width="48" height="48"><circle cx="24" cy="24" r="20" fill="darkgray" /></svg>`;

    li.innerHTML = `
        <div class="w-12 h-12 flex-shrink-0">${imgHtml}</div>
        <div class="flex-grow">
            <p class="font-semibold text-gray-900 mb-0.5">${ex.name}</p>
            <p class="text-gray-500 text-sm flex justify-between">
                <span>Sets: ${ex.sets ?? '-'}</span>
                <span>Reps: ${ex.reps ?? '-'}</span>
            </p>
        </div>
        <div class="flex items-center gap-2">
            <button class="text-blue-500 hover:text-blue-700" onclick="openEditModal('${ex.id}')">
            <i class='bx bx-edit text-xl'></i>
            </button>
            <button class="text-red-500 hover:text-red-700" onclick="deleteExercise('${ex.id}')">
            <i class='bx bx-trash text-xl'></i>
            </button>
        </div>`;
    return li;
}

function deleteExercise(id) {
    dayExercises[currentDay] = dayExercises[currentDay].filter(e => e.id !== id);
    document.getElementById(id)?.remove();
    markRoutineAsModified();
}

// --- MODAL & FORM HANDLERS ---

function browseWorkout() {
    const container = document.getElementById("browseExerciseList");
    container.innerHTML = `
        <input type="text" id="searchInput" placeholder="Search by name or group..." class="w-full mb-4 px-3 py-2 border rounded" oninput="filterExercises()">
        <div id="filteredExerciseList" class="space-y-2 max-h-60 overflow-y-auto"></div>
    `;
    renderExerciseList(sampleExercises);
    document.getElementById("browseWorkoutModal").showModal();
}

function openEditModal(id) {
    const ex = dayExercises[currentDay].find(e => e.id === id);
    if (!ex) return;
    document.getElementById("editExerciseId").value = id;
    document.getElementById("editExerciseName").value = ex.name;
    document.getElementById("editExerciseSets").value = ex.sets;
    document.getElementById("editExerciseReps").value = ex.reps;
    document.getElementById("editExerciseModal").showModal();
}

// Event Listeners for CRUD operations
document.getElementById("editExerciseForm").addEventListener("submit", function(e) {
    e.preventDefault();
    const id = document.getElementById("editExerciseId").value;
    const name = document.getElementById("editExerciseName").value;
    const sets = document.getElementById("editExerciseSets").value;
    const reps = document.getElementById("editExerciseReps").value;
    const index = dayExercises[currentDay].findIndex(e => e.id === id);
    
    if (index !== -1) {
        const updated = { ...dayExercises[currentDay][index], name, sets, reps }; 
        dayExercises[currentDay][index] = updated;
        document.getElementById(id)?.replaceWith(createExerciseItem(updated)); 
        markRoutineAsModified(); // Mark as modified after edit
    }
    document.getElementById("editExerciseModal").close();
});

document.querySelector("#addExerciseModal form").addEventListener("submit", function (e) {
    e.preventDefault();
    const name = document.getElementById("routineName").value.trim();
    const sets = document.getElementById("exerciseSets").value.trim();
    const reps = document.getElementById("exerciseReps").value.trim();
    if (!name) return alert("Routine name is required.");

    const newExercise = {
        id: "custom-" + Date.now(),
        name,
        sets,
        reps,
        img: `<svg width="48" height="48"><circle cx="24" cy="24" r="20" fill="lightgray" /></svg>`
    };

    const exerciseList = document.querySelector(`#${currentDay} .exercise-list`);
    
    // *** FIX: Remove placeholder instantly when an exercise is added ***
    const placeholder = exerciseList.querySelector('.empty-list-placeholder');
    if (placeholder) {
        placeholder.remove();
    }

    dayExercises[currentDay].push(newExercise);
    exerciseList.appendChild(createExerciseItem(newExercise));
    document.getElementById('addExerciseModal').close();
    
    // Clear form fields
    this.reset();
    markRoutineAsModified(); // Mark as modified after add
});

document.getElementById("browseWorkoutForm").addEventListener("submit", function(e) {
    e.preventDefault();
    const selected = [...document.querySelectorAll("#filteredExerciseList input:checked")];
    const exerciseList = document.querySelector(`#${currentDay} .exercise-list`);

    if(selected.length > 0) {
        
        // *** FIX: Remove placeholder instantly when an exercise is added from browse ***
        const placeholder = exerciseList.querySelector('.empty-list-placeholder');
        if (placeholder) {
            placeholder.remove();
        }

        selected.forEach(cb => {
            const ex = sampleExercises.find(s => s.id === cb.value);
            if (ex) {
                // Ensure a unique ID for exercises added from browse
                const newItem = { ...ex, id: "browse-" + Date.now() + Math.random().toFixed(4) }; 
                dayExercises[currentDay].push(newItem);
                exerciseList.appendChild(createExerciseItem(newItem));
            }
        });
        markRoutineAsModified(); // Mark as modified after adding from browse
    }
    document.getElementById("browseWorkoutModal").close();
});

// Helper functions for Browse Modal (unchanged)
function renderExerciseList(exercises) {
    const container = document.getElementById("filteredExerciseList");
    container.innerHTML = "";
    const groups = [...new Set(exercises.map(ex => ex.group))];
    groups.forEach(group => {
        const groupLabel = document.createElement("h4");
        groupLabel.className = "font-semibold text-gray-700 mt-3";
        groupLabel.textContent = group;
        container.appendChild(groupLabel);
        exercises.filter(ex => ex.group === group).forEach(ex => {
            const div = document.createElement("div");
            div.className = "flex items-center gap-2";
            div.innerHTML = `
                <input type="checkbox" id="browse-${ex.id}" value="${ex.id}">
                <label for="browse-${ex.id}" class="flex-grow cursor-pointer">
                    <strong>${ex.name}</strong><br>
                    <small>Sets: ${ex.sets}, Reps: ${ex.reps}</small>
                </label>`;
            container.appendChild(div);
        });
    });
}

function filterExercises() {
    const query = document.getElementById("searchInput").value.toLowerCase();
    const filtered = sampleExercises.filter(ex =>
        ex.name.toLowerCase().includes(query) || ex.group.toLowerCase().includes(query)
    );
    renderExerciseList(filtered);
}


document.getElementById('start-button').addEventListener('click', () => {
    const exercisesToSend = dayExercises[currentDay] || [];
    localStorage.setItem('selectedExercises', JSON.stringify(exercisesToSend));
    window.location.href = "WorkoutViewerMember.php";
});


document.addEventListener('DOMContentLoaded', () => {
    showDay('Monday'); 
});

document.addEventListener('DOMContentLoaded', () => {
            // ... (Your toggleEditMode function logic remains unchanged)
            
            // --- Sidebar Toggle Logic (No 'active' class) ---
            const moreToggle = document.querySelector('.more-toggle');
            const submenu = document.querySelector('.more-menu .submenu');
            const toggleIcon = document.querySelector('.more-menu .toggle-icon');

            if (moreToggle && submenu && toggleIcon) {
                moreToggle.addEventListener('click', function(e) {
                    e.preventDefault(); 
                    

                    if (submenu.style.maxHeight === '0px' || submenu.style.maxHeight === '') {
                        submenu.style.maxHeight = '200px'; 
                        toggleIcon.style.transform = 'rotate(180deg)';
                    } else {
                        submenu.style.maxHeight = '0px';
                        toggleIcon.style.transform = 'rotate(0deg)';
                    }
                });
            }
        });
</script>


</body>
</html>