<?php
// CalorieScanner.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>AI Calorie Scanner</title>
  
  <link rel="stylesheet" href="Memberstyle.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <script src="https://cdn.tailwindcss.com"></script> 
  
  <style>
   
    body {
      margin: 0;
      padding: 0;
      background-color: #1a1a1a;
      color: #e0e0e0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      display: flex;
      min-height: 100vh; 
      overflow-x: hidden;
    }

    /* ---------------------------------------------------------------- */
    /* SIDEBAR STYLES */
    /* ---------------------------------------------------------------- */
    .sidebar {
      width: 250px;
      background-color: #242424;
      padding-top: 20px;
      box-shadow: 3px 0 10px rgba(0, 0, 0, 0.6);
      flex-shrink: 0;
      transition: width 0.3s ease;
    }

    .sidebar ul {
      list-style: none;
      padding: 0;
      margin: 0;
    }

    .sidebar li a {
      display: flex;
      align-items: center;
      padding: 15px 20px;
      color: #e0e0e0; /* Default text color */
      text-decoration: none;
      transition: background-color 0.3s, color 0.3s;
    }

    .sidebar li a:hover {
      background-color: #3a3a3a;
      color: #e0e0e0;
    }

    .sidebar li a:hover i {
    color: #e0e0e0; /* KEEP ICON COLOR WHITE/GRAY */
}
    
    
    .sidebar li i {
        margin-right: 12px;
        font-size: 22px;
        color: #e0e0e0; /* ICONS: Changed from yellow to default light color */
        transition: color 0.3s;
    }
    
    /* Change icon color on hover */
    .sidebar li a:hover i {
        color: #ffcc00; /* Icon turns yellow on hover */
    }
    
    .submenu {
        list-style: none;
        padding: 0;
        margin: 0;
        background-color: #2e2e2e;
        overflow: hidden;
        max-height: 0; 
        transition: max-height 0.0s ease-out;
    }

    .submenu li a {
        padding-left: 50px;
        font-size: 0.95em;
    }
    
    .toggle-icon {
        margin-left: auto;
        transition: transform 0.3s ease;
    }

    /* Highlight for current page */
    .sidebar .more-menu .submenu li .active-link {
        color: #ffcc00; 
        font-weight: bold;
        background-color: #3a3a3a;
    }

    /* ---------------------------------------------------------------- */
    /* MAIN CONTENT AREA STYLES */
    /* ---------------------------------------------------------------- */
    .content-area {
      flex-grow: 1;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 30px;
      overflow-y: auto;
      text-align: center;
    }
    
    .content-area h2 {
        font-size: 2.2em;
        color: #ffffffff;
        margin-bottom: 30px;
        letter-spacing: 1px;
    }

    /* ---------------------------------------------------------------- */
    /* CALORIE SCANNER ELEMENTS UI DESIGN */
    /* ---------------------------------------------------------------- */
    video {
      width: 95%;
      max-width: 600px;
      height: auto;
      min-height: 300px;
      border-radius: 20px;
      border: 3px solid #ffcc00;
      box-shadow: 0 0 25px rgba(255, 204, 0, 0.4);
      background-color: #000;
      object-fit: cover;
    }

    button#scanBtn {
      margin-top: 40px;
      padding: 18px 40px; /* Large button size */
      font-size: 20px;
      border: none;
      border-radius: 12px;
      background-color: #ffcc00;
      color: #1a1a1a;
      font-weight: bold;
      cursor: pointer;
      transition: all 0.3s ease;
      box-shadow: 0 5px 15px rgba(255, 204, 0, 0.4);
      letter-spacing: 0.5px;
    }

    button#scanBtn:hover {
      background-color: #ffd633;
      transform: translateY(-3px);
      box-shadow: 0 8px 20px rgba(255, 204, 0, 0.6);
    }

    #resultBox {
      margin-top: 40px;
      background: rgba(255, 255, 255, 0.08);
      border-radius: 16px;
      padding: 25px;
      width: 90%;
      max-width: 600px;
      text-align: left;
      font-size: 16px;
      line-height: 1.6;
      border: 1px solid rgba(255, 204, 0, 0.3);
      box-shadow: 0 0 10px rgba(255, 204, 0, 0.1);
      display: none;
      animation: fadeIn 0.5s ease-out forwards;
    }

    #resultBox b {
        color: #ffcc00;
    }

    /* Animation for result box */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .sidebar {
            width: 80px;
        }
        .sidebar li a {
            justify-content: center;
            padding: 15px 0;
        }
        .sidebar li a span {
            display: none;
        }
        .sidebar li i {
            margin-right: 0;
        }
        .more-toggle .toggle-icon {
            display: none;
        }
        .submenu {
            position: absolute;
            left: 80px;
            width: 180px;
            background-color: #2e2e2e;
            z-index: 10;
            box-shadow: 3px 3px 10px rgba(0,0,0,0.5);
            border-radius: 8px;
            max-height: 0 !important;
            transition: max-height 0.3s ease-out;
        }
        .more-menu:hover .submenu {
            max-height: 200px !important;
        }
        .submenu li a {
            padding-left: 20px;
            justify-content: flex-start;
        }
    }

  </style>
</head>
<body>

<div class="sidebar">
  <ul>
    <li><a href="Membership.php">
        <i class='bx bx-user'></i> 
        <span>User Details</span>
    </a></li>
    <li><a href="WorkoutJournal.php">
        <i class='bx bx-notepad'></i> 
        <span>Workout Journal</span>
    </a></li>
    <li><a href="Progress.php">
        <i class='bx bx-line-chart'></i>
        <span>Progress</span>
    </a></li>
    <li><a href="TrainerBooking.php">
        <i class='bx bxs-user-pin'></i> 
        <span>Trainers</span>
    </a></li>
    
    <li class="more-menu">
      <a href="#" class="more-toggle">
        <span>More</span> 
        <i class='bx bx-chevron-down toggle-icon'></i>
      </a>
      <ul class="submenu">
        <li><a href="#" class="active-link">
            <i class='bx bx-scan'></i> 
            <span>Calorie Scanner</span>
        </a></li>
        <li><a href="ScanEquipment.php">
            <i class='bx bx-qr-scan'></i> 
            <span>Scan Equipment</span>
        </a></li>
      </ul>
    </li>
    <li><a href="Loginpage.php">
        <i class='bx bx-log-out'></i> 
        <span>Logout</span>
    </a></li>
  </ul>
</div>


<div class="content-area">
  <h2>AI Calorie Scanner</h2>
  <video id="videoFeed" autoplay playsinline></video>
  <button id="scanBtn">📸 Scan Food</button>

  <div id="resultBox"></div>
</div>


<script type="module">
  // --- Sidebar Toggle Logic ---
  const moreToggle = document.querySelector('.more-toggle');
  const submenu = document.querySelector('.more-menu .submenu');
  const toggleIcon = document.querySelector('.more-menu .toggle-icon');

  if (moreToggle && submenu && toggleIcon) {
      submenu.style.maxHeight = '0px'; 

      moreToggle.addEventListener('click', function(e) {
          e.preventDefault(); 
          
          if (submenu.style.maxHeight === '0px') {
              submenu.style.maxHeight = '200px'; 
              toggleIcon.style.transform = 'rotate(180deg)';
          } else {
              submenu.style.maxHeight = '0px';
              toggleIcon.style.transform = 'rotate(0deg)';
          }
      });
  }

  // --- Calorie Scanner Logic ---
  const video = document.getElementById('videoFeed');
  const scanBtn = document.getElementById('scanBtn');
  const resultBox = document.getElementById('resultBox');

  // Start camera
  async function startCamera() {
    try {
      const stream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: "environment" } });
      video.srcObject = stream;
    } catch (err) {
      alert("⚠️ Unable to access camera. Please allow camera permission.");
      console.error(err);
    }
  }

  // On click — capture image and send to Gemini
  scanBtn.addEventListener('click', async () => {
    resultBox.style.display = "block";
    resultBox.innerHTML = "⏳ Scanning food... please wait.";

    const canvas = document.createElement('canvas');
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    const ctx = canvas.getContext('2d');
    ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

    const imageBase64 = canvas.toDataURL('image/jpeg');

    try {
      const response = await fetch('gemini_calorie_estimator.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ image: imageBase64 })
      });

      if (!response.ok) {
        const errorDetails = await response.json().catch(() => ({ error: `Server responded with status ${response.status}` }));
        throw new Error(errorDetails.error || `HTTP Error ${response.status}: ${JSON.stringify(errorDetails.details)}`);
      }

      const result = await response.json();
      console.log(result);

      if (result.candidates && result.candidates[0].content) {
        const text = result.candidates[0].content.parts[0].text;
        const formattedText = text.replace(/\n/g, '<br>');
        resultBox.innerHTML = `<b>Result:</b><br>${formattedText}`;
      } else if (result.error) {
        resultBox.innerHTML = `<b>❌ Error:</b> ${result.error}`;
      } else {
        resultBox.innerHTML = `<b>⚠️ Unexpected response:</b> ${JSON.stringify(result)}`;
      }
    } catch (error) {
      console.error(error);
      resultBox.innerHTML = "❌ Error scanning, please try again.";
    }
  });

  // Start camera
  startCamera();
</script>

</body>
</html>