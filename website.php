<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" 
    xintegrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="websitedesign.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />

</head>

<body>

<nav class="navbar sticky-top navbar navbar-expand-lg navbar-dark bg-dark"> <!-- NAVBAR -->
  <div class="container-fluid shadow-lg">

    <nav class="navbar navbar-light bg-dark"> <!-- NAVBAR LOGO-->
  <div class="container">
    <a class="navbar-ecglogo" href="#">
      <img src="images/Ecg_logo.jpg" alt="" width="70" height="70">
    </a>
  </div>
</nav>


    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation"> <!-- NAVBAR CONTENTS -->
      <span class="navbar-toggler-icon"></span>
    </button>
    
      <div class="collapse navbar-collapse nav justify-content-center" id="navbarNav"> 
      <ul class="navbar-nav">
        <li class="home">
          <a class="nav-link"  aria-current="page" data-scroll-target="home" href="#">Home</a>
        </li>
        <li class="membership">
          <a class="nav-link" data-scroll-target="membership" href="#">Membership</a>
        </li>
        <li class="trainer">
          <a class="nav-link" data-scroll-target="instructors" href="#">Personal Trainings</a>
        </li>
        <li class="blog">
          <a class="nav-link" data-scroll-target="blog" href="#">About</a>
        </li>
      </ul>
    </div> 


    <div class="loginbutton"> <!-- LOGIN BUTTON-->
      <nav class="navbar navbar-light bg-dark justify-content-right">
        <form class="container-fluid justify-content-start">
          <button class="btn btn-sm custom-black-btn" type="button" onclick="window.location.href='Loginpage.php'"> Login </button>
        </form>
      </nav>
    </div>

  </div>
</nav>



<main>


<section class="homepagepic scroll-reveal">
    <div class="banner-card" id="home" tabindex="-1"> 
        
        <video class="background-media" autoplay muted loop playsinline>
            <source src="Images/Video_Gif.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>

        <div class="content-overlay">
            
            <h1 class="main-headline">
                TRAIN LIKE A <br>
                <span class="highlight">FIGHTER</span>,
                CONQUER <br> 
                LIKE A <span class="highlight">CHAMPION</span>.
            </h1>

            <p class="subtext">
                Strength, skill, and discipline—built one punch at a time.
            </p>

            <a href="#join-form" class="join-button" onclick="window.location.href='Loginpage.php'">JOIN NOW!</a>
        </div>
        
    </div>
</section>



<section class="membership scroll-reveal" id="membership" tabindex="-1" aria-label="Membership section"> <!-- MEMBERSHIP SECTION-->
      <h2 class="page-title" tabindex="0" aria-label="Gym Membership plans and prices">Gym Membership Plans</h2>
      <div class="cards-grid">

    <!-- STUDENT MEMBERSHIP CARD -->
    <article class="card" tabindex="0" aria-labelledby="student-title" role="region">
      <img src="images/Student_Membership.jpg" alt="Student Gym Membership card image with gym equipment design" class="card-image" />
      <div class="card-content">
        <h2 class="card-title" id="student-title">Student Membership</h2>
        <p><span class="material-icons md-18" aria-hidden="true">school</span>Special rates for students</p>
        <div class="summary">
          <p><span class="currency">₱</span><span class="price">499</span> / 1 year</p>
          <p><span class="currency">₱</span><span class="price">1,999</span> Lifetime</p>
        </div>
        <h3 class="section-heading">Monthly Rates</h3>
        <ul class="price-list" aria-label="Student Monthly Rates">
          <li><span>1 Month</span><span><span class="currency">₱</span>1,099</span></li>
          <li><span>3 Months + 1 Month</span><span><span class="currency">₱</span>3,799</span></li>
          <li><span>6 Months</span><span><span class="currency">₱</span>5,499</span></li>
          <li><span>12 Months</span><span><span class="currency">₱</span>9,999</span></li>
        </ul>
        <h3 class="section-heading">Daily Rates</h3>
        <div class="daily-rates" aria-label="Student Daily Rates">
          <div class="daily-rate">
            <p>Member</p>
            <p><span class="currency">₱</span>80</p>
          </div>
          <div class="daily-rate">
            <p>Non-Member</p>
            <p><span class="currency">₱</span>130</p>
          </div>
        </div>
      </div>
    </article>
  

    <!-- NON STUDENT MEMBERSHIP CARD -->
    <article class="card" tabindex="0" aria-labelledby="nonstudent-title" role="region">
      <img src="images/Non-student_Membership.jpg" alt="Non-Student Gym Membership card image with modern gym interior" class="card-image" />
      <div class="card-content">
        <h2 class="card-title" id="nonstudent-title">Non-Student Membership</h2>
        <p><span class="material-icons md-18" aria-hidden="true">work</span>Standard rates for all non-students</p>
        <div class="summary">
          <p><span class="currency">₱</span><span class="price">799</span> / 1 year</p>
          <p><span class="currency">₱</span><span class="price">3,999</span> Lifetime</p>
        </div>
        <h3 class="section-heading">Monthly Rates</h3>
        <ul class="price-list" aria-label="Non Student Monthly Rates">
          <li><span>1 Month</span><span><span class="currency">₱</span>1,399</span></li>
          <li><span>3 Months + 1 Month</span><span><span class="currency">₱</span>4,899</span></li>
          <li><span>6 Months</span><span><span class="currency">₱</span>6,999</span></li>
          <li><span>12 Months</span><span><span class="currency">₱</span>12,999</span></li>
        </ul>
        <h3 class="section-heading">Daily Rates</h3>
        <div class="daily-rates" aria-label="Non-Student Daily Rates">
          <div class="daily-rate">
            <p>Member</p>
            <p><span class="currency">₱</span>120</p>
          </div>
          <div class="daily-rate">
            <p>Non-Member</p>
            <p><span class="currency">₱</span>170</p>
          </div>
        </div>
      </div>
    </article>


    <!-- GENERAL INFO CARD -->
    <article class="card" tabindex="0" aria-labelledby="general-info-title" role="region">
      <img src="images/General_Membership.jpg" alt="Photo showing gym rules and general membership information" class="card-image" />
      <div class="card-content">
        <h2 class="card-title" id="general-info-title">General Membership Info</h2>
        <p><span class="material-icons md-18" aria-hidden="true">info</span>Additional membership details and policies</p>
        <div class="summary" style="margin-top: 1rem; font-size: 1rem; color: #ffeb3b;">
          <ul class="price-list" aria-label="General membership details">
            <li>Student 1 Year - <span class="currency"> ₱</span>499</li>
            <li>Student Lifetime - <span class="currency"> ₱</span>1,999</li>
            <li>Non-Student 1 Year - <span class="currency"> ₱</span>799</li>
            <li>Non-Student Lifetime - <span class="currency">₱</span>3,999</li>
          </ul>
        </div>
      </div>
    </article>
    </div>
    </section>

  <br>
  <br>



    <section class="instructors scroll-reveal" id="instructors" tabindex="-1" aria-label="Instructors section"> <!-- TRAININGS SECTIONS-->
      <div class="container">
    <h2>PERSONAL TRAININGS</h2>
    <p>Need a personal trainer? We got you covered!</p>
    <div class="tr-cards">
      <div class="training-card">
        <img src="images/Boxing.jpg" alt="BOXING" />
        <div class="info">
          <h3>BOXING</h3>
          <p>Build endurance, improve coordination, and boost your strength with <strong>high-intensity </strong> boxing workouts tailored for all levels.</p>
        </div>
      </div>
      <div class="training-card">
        <img src="images/Muay.png" alt="MUAY THAI" />
        <div class="info">
          <h3>MUAY THAI</h3>
          <p>Master <strong>powerful striking techniques </strong> while enhancing balance, flexibility, and overall conditioning.</p>
        </div>
      </div>
      <div class="training-card">
        <img src="images/Circuit_Training.jpg" alt="CIRCUIT TRAINING" />
        <div class="info">
          <h3>CIRCUIT TRAINING</h3>
          <p>Engage in a <strong> full-body workout </strong> combining cardio and strength exercises to burn fat and increase functional fitness.</p>
        </div>
      </div>
      <div class="training-card">
        <img src="images/Weightlifting.jpg" alt="WEIGHT LIFTING" />
        <div class="info">
          <h3>WEIGHT LIFTING TRAINING</h3>
          <p>Gain muscle, enhance core strength, and learn proper <strong> lifting techniques </strong> with personalized resistance training programs.</p>
        </div>
      </div>
    </div>
  </div>
    </section>
  <br>
  <br>


<!-- ADDED class="scroll-reveal" -->
    <section class="blog scroll-reveal" id="blog" tabindex="-1" aria-label="Blog section"> <!-- BLOG SECTION-->
      <h2 id="about-heading">About Our Gym</h2>
    <p class="intro">Dedicated to empowering our community through fitness, health, and wellness, we combine expert guidance with high end facilities for your best workout experience.</p>
    <div class="content-wrapper">
      <div class="aboutimage-container">
        <img src="images/Ecg_About.jpg" alt="Ecg Picture" />
      </div>
      <article class="text-content">
        <p>Founded on January 8, 2024, ECG Fitness is dedicated to providing a clean, safe, and welcoming environment for everyone—whether you're a beginner or a regular. With spacious two-story facilities, members can enjoy their workouts without feeling crowded.</p>
        <p>We prioritize <strong>high-quality</strong>, <strong>well-maintained equipment </strong> to ensure a safe and comfortable experience. Our branches are designed to promote a positive atmosphere where teens and adults can feel motivated, confident, and at ease.</p>
        <p>Join us to experience a fitness community that values your progress, encourages consistency, and celebrates your achievements every step of the way.</p>
      </article>
    </div>
    </section>

</main> <!-- MAIN END -->




<footer class="footer"> <!-- FOOTER -->
  <div class="footer-section">
    <h3>CONTACT</h3>
    <i class="bi bi-telephone-fill"></i>
    <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-telephone-fill" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877z"/>
</svg>  0905-527-2512</p>

    <i class="bi bi-envelope-fill"></i>
    <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope-fill" viewBox="0 0 16 16">
  <path d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414zM0 4.697v7.104l5.803-3.558zM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586zm3.436-.586L16 11.801V4.697z"/>
</svg> <a href="https://mail.google.com/mail/?view=cm&fs=1&to=ecgprofitnessgym@gmail.com">ecgprofitnessgym@gmail.com</a></p>

      <div class="social-icons">
      <a href="https://www.instagram.com/ecgfitnessgym?igsh=MTRlb3Jtcm5uZjNqdg==" target="_blank" aria-label="Instagram">
        <i class="bi bi-instagram"></i>
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-instagram" viewBox="0 0 16 16">
  <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.9 3.9 0 0 0-1.417.923A3.9 3.9 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.9 3.9 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.9 3.9 0 0 0-.923-1.417A3.9 3.9 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599s.453.546.598.92c.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.5 2.5 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.5 2.5 0 0 1-.92-.598 2.5 2.5 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233s.008-2.388.046-3.231c.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92s.546-.453.92-.598c.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92m-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217m0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334"/> </svg>
      </a>

      <a href="https://www.tiktok.com/@ecgfitnessgym?_t=ZS-8xG0nZhTQjB&_r=1" target="_blank" aria-label="TikTok">
        <i class="bi bi-tiktok"></i>
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-tiktok" viewBox="0 0 16 16">
  <path d="M9 0h1.98c.144.715.54 1.617 1.235 2.512C12.895 3.389 13.797 4 15 4v2c-1.753 0-3.07-.814-4-1.829V11a5 5 0 1 1-5-5v2a3 3 0 1 0 3 3z"/> </svg>
      </a>

      <a href="https://www.facebook.com/ecgprofitnessgym" target="_blank" aria-label="Facebook">
        <i class="bi bi-facebook"></i>
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
  <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951"/> </svg>
  </a>

    </div> 
  </div>

  <div class="footer-section"> <!-- FOOTER CONTENTS -->
    <h3>OPEN HOURS</h3>
    <i class="bi bi-calendar"></i>
    <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar" viewBox="0 0 16 16">
  <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z"/>
</svg> <em>Monday — Sunday</em><br>7:00 AM – 11:00 PM</p>
  </div>

  <div class="footer-section">
    <h3>LOCATION</h3>
  <p> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
  <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6"/> </svg>
    Phase 1 lot 1 Block 16, <br>
    Grand riverside subd, Subdivision, PASCAM 1, <br>
    General Trias, 4107 Cavite</p>

  <p> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
  <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6"/> </svg>
    Phase 1 lot 14 block 46, <br>
    PASCAM 2, General Trias, 4107 Cavite</p>

  </div>
</footer>





<!-- JAVASCRIPT -->
<script> 

  document.querySelectorAll('.nav-link').forEach(link => {
    link.addEventListener('click', e => {
      e.preventDefault();
      const targetClass = link.getAttribute('data-scroll-target');
      const targetSection = document.getElementById(targetClass);
      if (targetSection) {
        targetSection.focus({preventScroll:true});
        targetSection.scrollIntoView({behavior: 'smooth', block: 'start'});
      }
    });
  });


  document.addEventListener('DOMContentLoaded', () => {
    const sectionsToReveal = document.querySelectorAll('.scroll-reveal');
    const observerOptions = {
      root: null, 
      rootMargin: '0px',
      threshold: 0.2
    };

   
    const observerCallback = (entries, observer) => {
      entries.forEach(entry => {
       
        if (entry.isIntersecting) {
         
          entry.target.classList.add('is-visible');
        
          observer.unobserve(entry.target);
        }
      });
    };


    const observer = new IntersectionObserver(observerCallback, observerOptions);

   
    sectionsToReveal.forEach(section => {
      observer.observe(section);
    });
  });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" 
integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>
</html>
