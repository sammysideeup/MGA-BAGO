<?php 
// At the top of WorkoutViewerMember.php, check user status and get ID
// ... (Your existing PHP code) ...
$current_user_id = $row['id'] ?? 'null';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Workout Viewer</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex justify-center items-center p-4">

  <div class="max-w-sm w-full bg-white rounded-2xl shadow-xl p-6 text-center relative">

    <!-- Back Button -->
    <button onclick="history.back()" class="absolute top-4 left-4 text-blue-500 font-bold">&larr; Back</button>

    <!-- Progress Bar -->
    <div class="w-full bg-gray-200 h-3 rounded mb-4 mt-6 overflow-hidden">
      <div id="progress-bar" class="bg-blue-500 h-full transition-all duration-300" style="width: 0%;"></div>
    </div>

    <!-- Workout Info -->
    <img id="workout-gif" src="" alt="Workout Image" class="mx-auto mb-4 w-48 h-48 object-contain rounded-lg"/>

    <h2 id="workout-name" class="text-2xl font-bold mb-2">Workout Name:</h2>
    <p id="workout-info" class="text-gray-600 mb-2">Sets: 3 | Reps: 10</p>
    <p id="exercise-time" class="text-sm text-gray-500 mb-1">Total Time: 0s</p>

    <!-- Rest Timer (after exercise) -->
    <p id="rest-timer-display" class="text-lg text-green-600 font-semibold hidden mb-2">Rest: 60s</p>

    <button id="skip-rest-btn" onclick="skipRest()" class="hidden bg-orange-500 text-white px-4 py-2 rounded mb-2"> Skip Rest </button>


    <!-- Workout Timer -->
    <p id="timer-display" class="text-2xl text-red-600 font-bold mb-2 hidden"></p>
    <button id="start-timer-btn" onclick="startTimer()" class="mb-4 bg-yellow-400 text-black px-4 py-2 rounded hidden">
      Start Timer
    </button>

    <!-- Controls -->
    <div class="flex justify-between mt-4" id="button-group">
      <button onclick="prevExercise()" class="bg-gray-300 text-gray-700 px-4 py-2 rounded">Previous</button>
      <button onclick="skipExercise()" class="bg-red-500 text-white px-4 py-2 rounded">Skip</button>
      <button onclick="nextExercise()" class="bg-blue-500 text-white px-4 py-2 rounded">Next</button>
    </div>

    <!-- Back to Page -->
    <button id="finish-button" onclick="finishWorkout()" class="hidden mt-4 bg-green-500 text-white px-6 py-2 rounded">
    Finish
  </button>

    <!-- Alarm Sound -->
    <audio id="alarm-sound" src="https://www.soundjay.com/button/beep-07.wav" preload="auto"></audio>
  </div>

  <script>
    const exercises = JSON.parse(localStorage.getItem('selectedExercises')) || [];
    let currentIndex = 0;
    let timerInterval;
    let timerSeconds = 0;
    let totalTime = 0;
    let trackingTime = null; // Used for the global workout duration
    let isResting = false;

    const timerDisplay = document.getElementById("timer-display");
    const startButton = document.getElementById("start-timer-btn");
    const alarm = document.getElementById("alarm-sound");
    const restDisplay = document.getElementById("rest-timer-display");
    const progressBar = document.getElementById("progress-bar");

    // Helper to format total duration display (seconds to M:S)
    function updateExerciseTime(seconds) {
        const m = Math.floor(seconds / 60);
        const s = seconds % 60;
        document.getElementById("exercise-time").textContent = `Total Time: ${m}m ${s}s`;
    }

    // --- GLOBAL TIME TRACKING (Total Workout Duration) ---
    function trackTimeStart() {
        if (trackingTime !== null) return; // Prevent multiple intervals
        
        trackingTime = setInterval(() => {
            totalTime++;
            updateExerciseTime(totalTime);
        }, 1000);
    }

    function trackTimeStop() {
        clearInterval(trackingTime);
        trackingTime = null;
    }
    // ----------------------------------------------------

    function parseTimeToSeconds(text) {
        if (text.includes("secs")) return parseInt(text);
        if (text.includes("mins")) return parseInt(text) * 60;
        return null;
    }

    function updateProgressBar() {
        const percent = ((currentIndex + 1) / exercises.length) * 100;
        progressBar.style.width = percent + "%";
    }

    function startTimer() {
        startButton.disabled = true;
        timerDisplay.classList.remove("hidden");
        updateTimerDisplay(timerSeconds);

        timerInterval = setInterval(() => {
            timerSeconds--;
            updateTimerDisplay(timerSeconds);
            if (timerSeconds <= 0) {
                clearInterval(timerInterval);
                timerDisplay.textContent = "Done!";
                alarm.play();
                if (isResting) {
                    isResting = false;
                    nextExercise(true); 
                }
            }
        }, 1000);
    }

    function updateTimerDisplay(sec) {
        const m = Math.floor(sec / 60);
        const s = sec % 60;
        timerDisplay.textContent = `${m > 0 ? m + 'm ' : ''}${s}s`;
    }

    function clearTimer() {
        clearInterval(timerInterval);
        timerDisplay.classList.add("hidden");
        timerDisplay.textContent = "";
        startButton.classList.add("hidden");
        startButton.disabled = false;
        restDisplay.classList.add("hidden");
    }

    function loadExercise(index) {
        clearTimer();
        // 🛑 CRITICAL FIX: DO NOT reset totalTime or stop/start the global tracker here
        
        updateExerciseTime(totalTime); // Update display with accumulated total
        updateProgressBar();

        // Clean up rest UI
        restDisplay.classList.add("hidden");
        document.getElementById('skip-rest-btn').classList.add("hidden");
        startButton.classList.add("hidden");
        startButton.disabled = false;

        const ex = exercises[index];
        if (!ex) return;

        document.getElementById("workout-name").textContent = ex.name;
        document.getElementById("workout-info").textContent = `Sets: ${ex.sets} | Reps/Time: ${ex.reps}`;
        document.getElementById("workout-gif").src = ex.gif || 'https://via.placeholder.com/150';

        const timeInSeconds = parseTimeToSeconds(ex.reps);
        if (timeInSeconds) {
            timerSeconds = timeInSeconds;
            startButton.classList.remove("hidden");
        }

        if (index === exercises.length - 1) {
            document.getElementById('button-group').classList.add("hidden");
            document.getElementById('finish-button').classList.remove("hidden");
        } else {
            document.getElementById('button-group').classList.remove("hidden");
            document.getElementById('finish-button').classList.add("hidden");
        }
    }

    function nextExercise(skipRest = false) {
        if (!skipRest && !isResting && currentIndex < exercises.length - 1) {
            isResting = true;
            restDisplay.classList.remove("hidden");
            document.getElementById('skip-rest-btn').classList.remove("hidden");

            // Hide controls during rest
            document.getElementById('button-group').classList.add("hidden");
            startButton.classList.add("hidden"); 

            let restTime = 60; // 60 seconds default rest
            restDisplay.textContent = `Rest: ${restTime}s`;

            const restInterval = setInterval(() => {
                restTime--;
                restDisplay.textContent = `Rest: ${restTime}s`;

                if (restTime <= 0 || !isResting) {
                    clearInterval(restInterval);
                    isResting = false;
                    currentIndex++;
                    loadExercise(currentIndex);
                }
            }, 1000);

            return;
        }

        // Already resting or skipping manually
        if (currentIndex < exercises.length - 1) {
            currentIndex++;
            loadExercise(currentIndex);
        } else if (currentIndex === exercises.length - 1) {
            // End of workout flow
            document.getElementById('finish-button').click(); // Auto-click finish if 'Next' pressed on last exercise
        }
    }

    function skipRest() {
        isResting = false; // flag will tell restInterval to stop
    }


    function prevExercise() {
        if (currentIndex > 0) {
            currentIndex--;
            loadExercise(currentIndex);
        }
    }

    function skipExercise() {
        nextExercise(true); // Skip rest
    }

    // --- NEW PROGRESS LOGGING FUNCTION ---
    function finishWorkout() {
        trackTimeStop(); // Stop the global timer
        clearTimer(); // Clear any exercise timer

        // 2. Prepare data to send
        const workoutData = {
            // NOTE: user_id logic must be handled by PHP session in the PHP block before this script runs.
            total_duration_seconds: totalTime, 
            session_date: new Date().toISOString().slice(0, 10), 
            workout_day: new Date().toLocaleDateString('en-US', { weekday: 'long' }), 
            total_exercises: exercises.length
        };

        // 3. Send data to server
        fetch('log_progress.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(workoutData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Alert removed for cleaner user experience
            } else {
                console.error("Error logging workout:", data.message);
            }
        })
        .catch(error => {
            console.error('Network error during progress log:', error);
        })
        .finally(() => {
            window.location.href = "WorkoutJournal.php"; 
        });
    }

    // --- INITIALIZATION ---
    document.addEventListener('DOMContentLoaded', () => {
        if (exercises.length > 0) {
            loadExercise(currentIndex); // Load UI for first exercise
            trackTimeStart(); // 🔑 START THE ACCUMULATOR ONCE HERE
        } else {
             // Handle case with no exercises selected
             document.getElementById("workout-name").textContent = "No Exercises Selected";
             document.getElementById("workout-info").textContent = "Go back and select a routine to begin.";
             document.getElementById('button-group').classList.add("hidden");
             document.getElementById('finish-button').classList.remove("hidden");
             document.getElementById('finish-button').textContent = "Go Back";
             document.getElementById('finish-button').onclick = () => history.back();
        }
    });

</script>
</body>
</html>