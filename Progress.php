<?php
// Progress.php
session_start();
include 'connection.php'; // Your database connection

// Authentication block
if (!isset($_SESSION['email'])) {
    header("Location: Loginpage.php");
    exit();
}

$user_email = $_SESSION['email'];
$current_user_id = null;

// Retrieve user_id
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

// --- 🎯 CORE PROGRESS ANALYTICS ---

// Function to fetch and process data
function getWorkoutAnalytics($conn, $user_id) {
    $analytics = [];
    
    // --- TODAY'S WORKOUTS AND DURATION (Resets at 12 AM) ---
    $sql_today = "SELECT COUNT(id) AS today_workouts, SUM(total_duration_seconds) AS today_duration 
                  FROM workout_sessions 
                  WHERE user_id = ? AND session_date = CURDATE()";
    $stmt_today = $conn->prepare($sql_today);
    $stmt_today->bind_param("i", $user_id);
    $stmt_today->execute();
    $result_today = $stmt_today->get_result()->fetch_assoc();
    $stmt_today->close();
    
    // Store Today's data
    $analytics['today_workouts'] = $result_today['today_workouts'] ?? 0;
    $analytics['today_duration_min'] = round(($result_today['today_duration'] ?? 0) / 60);

    // --- Total Workouts & Duration (All Time) ---
    $sql_total = "SELECT COUNT(id) AS total_workouts, SUM(total_duration_seconds) AS total_duration FROM workout_sessions WHERE user_id = ?";
    $stmt_total = $conn->prepare($sql_total);
    $stmt_total->bind_param("i", $user_id);
    $stmt_total->execute();
    $result_total = $stmt_total->get_result()->fetch_assoc();
    $stmt_total->close();
    
    $analytics['total_workouts'] = $result_total['total_workouts'] ?? 0; // Total (All Time)
    $analytics['total_duration_min'] = round(($result_total['total_duration'] ?? 0) / 60); // Total (All Time)

    // DAILY: Workouts per Day (Last 7 days)
    $sql_daily = "SELECT session_date, COUNT(id) AS count, SUM(total_duration_seconds) AS duration FROM workout_sessions WHERE user_id = ? AND session_date >= DATE(NOW() - INTERVAL 7 DAY) GROUP BY session_date ORDER BY session_date ASC";
    $stmt_daily = $conn->prepare($sql_daily);
    $stmt_daily->bind_param("i", $user_id);
    $stmt_daily->execute();
    $result_daily = $stmt_daily->get_result();
    $daily_data = [];
    while ($row = $result_daily->fetch_assoc()) {
        $daily_data[$row['session_date']] = [
            'workouts' => $row['count'],
            'duration_min' => round($row['duration'] / 60)
        ];
    }
    $analytics['daily'] = $daily_data;
    $stmt_daily->close();

    // MONTHLY: Workouts per Month (Last 6 months)
    $sql_monthly = "SELECT DATE_FORMAT(session_date, '%Y-%m') AS month, COUNT(id) AS count, SUM(total_duration_seconds) AS duration FROM workout_sessions WHERE user_id = ? AND session_date >= DATE(NOW() - INTERVAL 6 MONTH) GROUP BY month ORDER BY month ASC";
    $stmt_monthly = $conn->prepare($sql_monthly);
    $stmt_monthly->bind_param("i", $user_id);
    $stmt_monthly->execute();
    $result_monthly = $stmt_monthly->get_result();
    $monthly_data = [];
    while ($row = $result_monthly->fetch_assoc()) {
        $monthly_data[$row['month']] = [
            'workouts' => $row['count'],
            'duration_min' => round($row['duration'] / 60)
        ];
    }
    $analytics['monthly'] = $monthly_data;
    $stmt_monthly->close();

    return $analytics;
}

$workout_analytics = getWorkoutAnalytics($conn, $current_user_id);
$conn->close(); // Close connection after fetching all data

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Progress Dashboard</title>
    <link rel="stylesheet" href="Memberstyle.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
</head>
<body>

<div class="sidebar">
    <ul>
        <li><a href="Membership.php"><i class='bx bx-user'></i> User Details</a></li>
        <li><a href="WorkoutJournal.php"><i class='bx bx-notepad'></i> Workout Journal</a></li>
        <li><a href="#"><i class='bx bx-line-chart'></i> Progress</a></li>
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

<main class="bg-white rounded-2xl w-full drop-shadow-lg select-none p-6" role="main">
    <h1 class="text-2xl font-bold leading-tight mb-6 text-black">📊 Fitness Progress</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-indigo-50 p-6 rounded-lg shadow-md border-l-4 border-indigo-500">
            <p class="text-sm font-medium text-gray-500">Total Workouts Completed Today</p>
            <p class="text-3xl font-bold text-indigo-900 mt-1"><?php echo $workout_analytics['today_workouts']; ?></p>
        </div>
        <div class="bg-green-50 p-6 rounded-lg shadow-md border-l-4 border-green-500">
            <p class="text-sm font-medium text-gray-500">Total Workout Duration</p>
            <p class="text-3xl font-bold text-green-900 mt-1"><?php echo $workout_analytics['today_duration_min']; ?> minutes</p>
        </div>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <section>
            <h2 class="text-xl font-semibold mb-4 text-gray-700">🗓️ Weekly Workout Volume</h2>
            <div class="bg-gray-100 p-4 rounded-lg shadow">
                <canvas id="dailyWorkoutChart" class="h-80"></canvas>
            </div>
        </section>

        <section>
            <h2 class="text-xl font-semibold mb-4 text-gray-700">📅 Monthly Progress (Last 6 Months)</h2>
            <div class="bg-gray-100 p-4 rounded-lg shadow">
                <canvas id="monthlyWorkoutChart" class="h-80"></canvas>
            </div>
        </section>
        
    </div>
    
    <section class="mt-10">
        <h2 class="text-xl font-semibold mb-4 text-gray-700">💡 Fitness Insights</h2>
        <div id="insights-container" class="space-y-4">
            </div>
    </section>

</main>

<script>
    // PHP data passed to JavaScript
    const analyticsData = <?php echo json_encode($workout_analytics); ?>;

    // Helper function to convert duration (optional, if needed elsewhere)
    function secondsToMinutes(seconds) {
        return Math.round(seconds / 60);
    }
    
    // --- CHARTING FUNCTIONS (Using Chart.js) ---

    function createDailyChart() {
        const dailyData = analyticsData.daily;
        const labels = Object.keys(dailyData);
        const workoutCounts = labels.map(date => dailyData[date].workouts);
        const durationMins = labels.map(date => dailyData[date].duration_min);
        
        const ctx = document.getElementById('dailyWorkoutChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels.map(l => l.slice(5)), // Show only Month-Day
                datasets: [
                    {
                        label: 'Workouts Completed',
                        data: workoutCounts,
                        backgroundColor: 'rgba(59, 130, 246, 0.6)', // Blue
                        borderColor: 'rgba(59, 130, 246, 1)',
                        borderWidth: 1,
                        yAxisID: 'y'
                    },
                    {
                        label: 'Duration (min)',
                        data: durationMins,
                        type: 'line',
                        fill: false,
                        borderColor: 'rgba(22, 163, 74, 1)', // Green
                        yAxisID: 'y1'
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        title: { display: true, text: 'Workouts' }
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        grid: { drawOnChartArea: false },
                        title: { display: true, text: 'Duration (min)' }
                    }
                },
                plugins: {
                    legend: { position: 'top' },
                    title: { display: false }
                }
            }
        });
    }

    function createMonthlyChart() {
        const monthlyData = analyticsData.monthly;
        const labels = Object.keys(monthlyData);
        const workoutCounts = labels.map(month => monthlyData[month].workouts);
        
        const ctx = document.getElementById('monthlyWorkoutChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels, // YYYY-MM
                datasets: [{
                    label: 'Workouts per Month',
                    data: workoutCounts,
                    backgroundColor: 'rgba(79, 70, 229, 0.4)', // Violet
                    borderColor: 'rgba(79, 70, 229, 1)',
                    tension: 0.3,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: { display: true, text: 'Workouts' }
                    }
                },
                plugins: {
                    legend: { position: 'top' },
                    title: { display: false }
                }
            }
        });
    }

    // --- INSIGHTS GENERATION (Structured Card Layout) ---
    
    function generateInsights() {
        const container = document.getElementById('insights-container');
        container.innerHTML = '';
        
        const totalWorkouts = analyticsData.total_workouts; 
        const totalDuration = analyticsData.total_duration_min;
        const dailyData = analyticsData.daily; 
        
        // --- Card Content Builders ---
        let card1Content = []; // All-Time Performance & Metrics
        let card2Content = []; // Weekly Activity & Habits
        let card3Content = []; // Monthly & Long-Term Trends
        
        if (totalWorkouts === 0) {
            container.innerHTML = '<p class="text-gray-700 p-6 bg-yellow-50 rounded-lg shadow border-l-4 border-yellow-500">**Welcome!** Start your first workout to see your progress here.</p>';
            return; 
        }
        
        // --- CARD 1: All-Time & Averages ---
        
        // Total Workouts (All-Time)
        card1Content.push(`<li>You have completed a total of ${totalWorkouts} workouts.</li>`);
        
        // Average Workout Duration
        const avgDuration = totalWorkouts > 0 ? Math.round(totalDuration / totalWorkouts) : 0;
        if (avgDuration > 0) {
            card1Content.push(`<li>Your average workout session lasts ${avgDuration} minutes.</li>`);
        }

        // Duration Insight (Long-Term Commitment)
        if (totalDuration > 300) { 
            card1Content.push(`<li>You've dedicated over ${Math.floor(totalDuration / 60)} hours to your fitness. That's a huge commitment!</li>`);
        }

        // --- CARD 2: Weekly Activity & Habits ---
        
        // Weekly Insight (Last 7 Days)
        const dailyCounts = Object.values(dailyData).map(d => d.workouts);
        const weeklyTotal = dailyCounts.reduce((a, b) => a + b, 0);
        
        if (weeklyTotal > 3) {
            card2Content.push(`<li>You were very active this past week, completing ${weeklyTotal} workouts! Keep up the intensity.</li>`);
        } else if (weeklyTotal > 0) {
            card2Content.push(`<li>You completed ${weeklyTotal} workouts in the last 7 days. Aim for a little more consistency to hit your goals.</li>`);
        } else {
             card2Content.push(`<li>No workouts logged in the last 7 days. Time to get moving!</li>`);
        }

        // Best Workout Day (Volume)
        const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        const dayTotals = {};
        
        Object.keys(dailyData).forEach(date => {
            const dayOfWeekIndex = new Date(date).getDay();
            const dayName = days[dayOfWeekIndex];
            dayTotals[dayName] = (dayTotals[dayName] || 0) + dailyData[date].workouts;
        });
        
        if (Object.keys(dayTotals).length > 0) {
            const bestDay = Object.keys(dayTotals).reduce((a, b) => dayTotals[a] > dayTotals[b] ? a : b);
            if (dayTotals[bestDay] > 0) {
                card2Content.push(`<li>Your most active day is ${bestDay}, with ${dayTotals[bestDay]} total workouts logged.</li>`);
            }
        }

        // --- CARD 3: Monthly Trends ---

        // Monthly comparison insight
        const months = Object.keys(analyticsData.monthly);
        if (months.length >= 2) {
            const lastMonthCount = analyticsData.monthly[months[months.length - 1]].workouts;
            const prevMonthCount = analyticsData.monthly[months[months.length - 2]].workouts;
            
            if (lastMonthCount > prevMonthCount) {
                card3Content.push(`<li>Momentum! You completed ${lastMonthCount - prevMonthCount} more workouts this past month than the month before. Excellent progress!</li>`);
            } else if (lastMonthCount < prevMonthCount) {
                card3Content.push('<li>Your workout volume slightly decreased last month. Focus on scheduling a consistent routine this month.</li>');
            }
        }

        // --- 2. RENDER CARDS ---

        const cardsHtml = `
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-white p-5 rounded-lg shadow-lg border-t-4 border-indigo-500">
                    <h3 class="text-lg font-semibold mb-3 text-indigo-700">All-Time Performance</h3>
                    <ul class="list-disc list-inside space-y-2 text-gray-700">
                        ${card1Content.join('')}
                    </ul>
                </div>

                <div class="bg-white p-5 rounded-lg shadow-lg border-t-4 border-green-500">
                    <h3 class="text-lg font-semibold mb-3 text-green-700">Recent Activity & Habits</h3>
                    <ul class="list-disc list-inside space-y-2 text-gray-700">
                        ${card2Content.join('')}
                    </ul>
                </div>
            </div>
            
            ${card3Content.length > 0 ? `
                <div class="mt-4 bg-white p-5 rounded-lg shadow-lg border-t-4 border-yellow-500">
                    <h3 class="text-lg font-semibold mb-3 text-yellow-700">Long-Term Trends</h3>
                    <ul class="list-disc list-inside space-y-2 text-gray-700">
                        ${card3Content.join('')}
                    </ul>
                </div>
            ` : ''}
        `;

        container.innerHTML = cardsHtml;
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', () => {
        if (analyticsData.total_workouts > 0) {
            createDailyChart();
            createMonthlyChart();
        } else {
            document.getElementById('dailyWorkoutChart').parentElement.innerHTML = '<p class="text-center text-gray-500 py-10">Start logging workouts to see your charts!</p>';
            document.getElementById('monthlyWorkoutChart').parentElement.innerHTML = '<p class="text-center text-gray-500 py-10">Start logging workouts to see your charts!</p>';
        }
        generateInsights();
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