<?php
session_start();
include "connection.php"; 

// Clear any previous error message
unset($_SESSION['error_message']);

$conn = new mysqli("localhost", "root", "", "ecg_fitness");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    //Admin Account
    $admin_email = "admin@ecg.com";
    $admin_password = "admin123";

    // Admin login
    if ($email === $admin_email && $password === $admin_password) {
        header("Location: Admindashboard.php");
        exit();
    }

    // Regular user login
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        // ✅ store email in session
        if (password_verify($password, $row['password'])) {
            $_SESSION['email'] = $email; 
            header("Location: membership.php");
            exit();
        } else {
            $_SESSION['error_message'] = 'Incorrect password';
        }
    } else {
        // 👤 Trainer login (check trainers table)
        $stmt_trainer = $conn->prepare("SELECT * FROM trainers WHERE email = ? AND password = ?");
        $stmt_trainer->bind_param("ss", $email, $password); // Assumes trainer passwords are stored in plaintext (not recommended—consider hashing)
        $stmt_trainer->execute();
        $trainer_result = $stmt_trainer->get_result();

        if ($trainer_result->num_rows === 1) {
            $trainer = $trainer_result->fetch_assoc();
            $_SESSION['trainer_id'] = $trainer['trainer_id'];
            $_SESSION['trainer_name'] = $trainer['name'];
            $_SESSION['role'] = 'trainer';
            header("Location: Trainerdashboard.php");
            exit();
        } else {
            $_SESSION['error_message'] = 'Email not found';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LoginPage</title>
    <link rel="stylesheet" href="Loginstyle.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    
   
</head>
<body>

<!-- Toast Alert HTML -->
<div id="toast-alert" class="toast-alert" role="alert" aria-live="polite" style="display: none;">
    <span id="toast-message"></span>
    <button id="toast-close" class="toast-close" aria-label="Close alert">&times;</button>
</div>

<main>
<section>
<div class="wrapper"> 
    <form method="POST">
        <h1>Login</h1>

        <div class="input-box">
            <input type="text" placeholder="Email" name="email" required>
            <i class='bx bxs-user'></i>
        </div>

        <div class="input-box">
            <input type="password" id="password" placeholder="Password" name="password" required>
            <i class='bx bx-show' id="togglePassword" style="cursor: pointer;"></i>
        </div>

        <div class="remember-forgot">
            <a href="Forgotpass.php">Forgot password?</a>
        </div>

        <a href="website.php" class="back-icon"><i class='bx bx-arrow-back'></i></a>

        <button type="submit" class="btn">Login</button>

        <div class="nonMember-link">
            <p>Not a member? <a href="Nonmember.php">Click Here</a> </p>
        </div>

    </form>
</div>
</section>
</main>

<script>
    // Password Toggle
    const passwordInput = document.getElementById("password");
    const togglePassword = document.getElementById("togglePassword");

    togglePassword.addEventListener("click", function () {
        const type = passwordInput.getAttribute("type") === "password" ? "text" : "password";
        passwordInput.setAttribute("type", type);

        
        this.classList.toggle("bx-show");
        this.classList.toggle("bx-hide");
    });

    // Toast Alert
    document.addEventListener('DOMContentLoaded', function() {
        const toast = document.getElementById('toast-alert');
        const messageEl = document.getElementById('toast-message');
        const closeBtn = document.getElementById('toast-close');

        function showToast(message, type = 'error') {
            if (!toast || !messageEl || !message) return;

            
            messageEl.textContent = message;
            toast.className = `toast-alert ${type}`;
            toast.style.display = 'flex';

           
            setTimeout(() => {
                toast.classList.add('show');
                toast.focus(); 
            }, 10);

         
            const autoHideTimer = setTimeout(() => {
                hideToast();
            }, 3000);

           
            function hideToast() {
                toast.classList.remove('show');
                setTimeout(() => {
                    toast.style.display = 'none';
                    clearTimeout(autoHideTimer);
                }, 300);
            }

            closeBtn.onclick = hideToast;
            toast.onclick = (e) => {
                if (e.target === toast) hideToast(); 
            };
        }

       
        <?php if (isset($_SESSION['error_message'])): ?>
            showToast('<?php echo $_SESSION['error_message']; ?>');
            <?php unset($_SESSION['error_message']); ?>
        <?php endif; ?>
    });
</script>

</body>
</html>
