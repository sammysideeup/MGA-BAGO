<?php
session_start();
// Include your database connection file
include 'connection.php'; 

// Query to fetch all trainer profiles
$query = "SELECT * FROM trainer_profiles";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Book Training Session</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        /* Global Styles (from your provided CSS) */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        /* Body and Layout Fix: Ensures the sidebar and content are side-by-side */
        body {
            display: flex; /* Key to placing sidebar and main content side-by-side */
            min-height: 100vh;
            background: #f1f1f1;
        }

        /* Sidebar Styles (from your provided CSS) */
        .sidebar {
            width: 250px;
            background-color: #161515;
            color: #fff;
            padding: 20px;
            /* Consider adding position: sticky; if you want the sidebar to remain visible on scroll */
        }

        .sidebar h2 {
            /* Fix for 'Membership Panel' font weight */
            text-align: center;
            margin-bottom: 30px;
        }
        
        .sidebar ul {
            list-style: none;
        }

        .sidebar ul li {
            padding: 15px 10px;
            margin-bottom: 15px;
        }

        .sidebar ul li a {
            color: #e6e6e6;
            text-decoration: none;
            font-size: 18px;
            display: flex;
            align-items: center;
        }

        .sidebar ul li a i {
            margin-right: 10px;
            font-size: 22px;
        }

        .sidebar ul li:hover {
            background: #333;
            border-radius: 5px;
        }

        .sidebar .more-menu {
    padding: 0; 
    margin-bottom: 15px; 
}


.sidebar .more-toggle {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 15px 10px 15px 45px;
}

/* Submenu container (starts hidden) */
.sidebar .submenu {
    list-style: none;
    padding: 0;
    margin: 0;
    max-height: 0; 
    overflow: hidden;
    transition: max-height 0.3s ease-out; 
    background-color: rgba(0, 0, 0, 0.05);
}

/* Submenu individual links (Calorie Scanner, Scan Equipment) */
.sidebar .submenu li a {
    padding: 10px 10px 10px 45px; 
    font-size: 0.9em; 
    opacity: 0.8;
    display: flex; 
    align-items: center;
}

/* Submenu link icons */
.sidebar .submenu li a i {
    margin-right: 10px; 
}

/* Toggle arrow icon */
.sidebar .toggle-icon {
    transition: transform 0.3s ease-out;
}
        
    
        /* Main Content Styling */
        main {
            flex-grow: 1; /* Allows the main content to take up the remaining space */
            padding: 20px;
            background-color: #f1f1f1; /* Matches body background */
        }

        /* Trainer Card Styles (from your provided CSS) */
        h1 {
            /* This targets the 'Available Trainers' header */
            text-align: left; /* Removed center alignment to fit the main content flow */
            margin-bottom: 30px;
            font-size: 24px;
        }

        .trainer-list {
            /* Removed text-align: center; which affects inline-block positioning */
            display: flex; /* Use flexbox for cleaner card layout */
            flex-wrap: wrap; /* Allows cards to wrap to the next line */
            gap: 20px; /* Space between cards */
        }

        .trainer-card {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 300px;
            padding: 20px;
            text-align: left;
        }
        
        /* ... (rest of the card styles are fine) ... */
        .trainer-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 15px;
        }

        .trainer-card h2 {
            font-size: 18px;
            margin: 10px 0;
        }

        .trainer-card p {
            margin: 6px 0;
            color: #555;
            font-size: 14px;
        }

        .trainer-card ul {
            padding-left: 18px;
            margin: 10px 0;
        }

        .trainer-card button {
            background-color: #6c63ff;
            color: white;
            border: none;
            padding: 10px 16px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s;
            float: right;
        }

        .trainer-card button:hover {
            background-color: #574fd6;
        }

        

        
    </style>
</head>
<body>

    <div class="sidebar">
        <ul>
            <li><a href="Membership.php"><i class='bx bx-user'></i> User Details</a></li>
            <li><a href="WorkoutJournal.php"><i class='bx bx-notepad'></i> Workout Journal</a></li>
            <li><a href="Progress.php"><i class='bx bx-line-chart'></i> Progress</a></li>
            <li class="active"><a href="#"><i class='bx bxs-user-pin'></i> Trainers</a></li>
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
            <h1 class="text-2xl font-bold leading-tight mb-6">Available Trainers</h1>
            
            <div class="trainer-list">
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="trainer-card">
                        <?php if (!empty($row['profile_pic'])): ?>
                            <img src="<?= htmlspecialchars($row['profile_pic']) ?>" alt="Trainer Profile Picture">
                        <?php endif; ?>
                        
                        <h2><?= htmlspecialchars($row['about_me']) ?></h2>
                        <p><strong>Specialization:</strong> <?= htmlspecialchars($row['specialization']) ?></p>
                        <p><strong>Location:</strong> <?= htmlspecialchars($row['location']) ?></p>
                        <p><strong>Weekly Availability:</strong></p>
                        <ul>
                            <?php
                                // Decode the JSON schedule data
                                $schedule = json_decode($row['schedule'], true);
                                if ($schedule) {
                                    foreach ($schedule as $day => $available) {
                                        if ($available) echo "<li>" . htmlspecialchars($day) . "</li>";
                                    }
                                }
                            ?>
                        </ul>
                        <form action="TrainerBookingForm.php" method="GET">
                            <input type="hidden" name="trainer_id" value="<?= htmlspecialchars($row['trainer_id']) ?>">
                            <button type="submit">Book</button>
                        </form>
                    </div>
                <?php endwhile; ?>
            </div>
            
        </section>
    </main>

    <script>
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