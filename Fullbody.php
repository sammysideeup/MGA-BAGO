<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Fullbody</title>
    <link rel="stylesheet" href="Nonmemberstyle.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>

<div class="sidebar">
    <h2>Non Member Panel</h2>
    <ul>
        <li><a href="#"><i class='bx bx-dumbbell'></i> Workouts</a></li>
        <li><a href="Register.php"><i class='bx bxs-user-badge'></i> Membership</a></li>
        <li><a href="Loginpage.php"><i class='bx bx-log-out'></i> Logout</a></li>
    </ul>

</div>


<div class="main content w-full bg-white rounded-lg shadow-md p-6">
    <!-- Header -->
    <h2 class="text-2xl font-bold mb-5 select-none">Body Focus</h2>

    <!-- Body Target Tabs -->
    <div class="mb-6 flex space-x-3 overflow-x-auto scrollbar-thin no-scrollbar-safari">

      <button class="flex-shrink-0 px-4 py-1.5 font-medium rounded-full bg-gray-200 text-gray-600 hover:bg-gray-300 focus:outline-none" type="button" onclick="window.location.href= 'Nonmember.php'">Abs</button>

      <button class="flex-shrink-0 px-4 py-1.5 font-medium rounded-full bg-gray-200 text-gray-600 hover:bg-gray-300 focus:outline-none" type="button" onclick="window.location.href='Chest.php'">Arm</button>

      <button class="flex-shrink-0 px-4 py-1.5 font-medium rounded-full bg-gray-200 text-gray-600 hover:bg-gray-300 focus:outline-none" type="button" onclick="window.location.href='Chest.php'">Chest</button>

      <button class="flex-shrink-0 px-4 py-1.5 font-medium rounded-full bg-gray-200 text-gray-600 hover:bg-gray-300 focus:outline-none" type="button" onclick="window.location.href='Leg.php'">Leg</button>

      <button class="flex-shrink-0 px-4 py-1.5 font-semibold rounded-full border border-blue-500 text-blue-600 bg-blue-100 focus:outline-none" aria-current="true">Full body</button>

    </div>

    <!-- Exercises list scroll container -->
    <div
      class="flex space-x-6 overflow-x-auto scrollbar-thin snap-x snap-mandatory"
      style="scroll-padding-left: 1.5rem; scroll-padding-right: 1.5rem;"
    >


      <a href="Fullbody-beginner.php" class="no-underline">
  <!-- Abs Beginner -->
  <div class="snap-start min-w-[300px] flex-shrink-0 flex items-center space-x-4 bg-gray-50 rounded-xl p-4 shadow-sm hover:shadow-md transition-shadow cursor-pointer select-none">
    <img
      src="https://cdn.mos.cms.futurecdn.net/s5iSWauEK6itgNzTyBeo9o-650-80.jpg.webp"
      alt="Abs Beginner"
      class="w-20 h-20 rounded-lg object-cover flex-shrink-0"
      loading="lazy"
    />
    <div>
      <h3 class="font-bold text-lg text-gray-900">Full Body Beginner</h3>
      <p class="text-gray-500 mt-1 text-sm">45 - 50 mins · 7 Exercises</p>
      <div class="mt-2 flex space-x-1">
        <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
          <path d="M11.3 1.046a1 1 0 00-1.67.742v3.034H6a1 1 0 00-.832 1.555l3.33 5.19-3.33 5.193A1 1 0 006 18h3.63v3.034a1 1 0 001.67.742l6.985-7.956a1 1 0 000-1.484L11.3 1.046z"/>
        </svg>
        <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
          <path d="M11.3 1.046a1 1 0 00-1.67.742v3.034H6a1 1 0 00-.832 1.555l3.33 5.19-3.33 5.193A1 1 0 006 18h3.63v3.034a1 1 0 001.67.742l6.985-7.956a1 1 0 000-1.484L11.3 1.046z"/>
        </svg>
        <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
          <path d="M11.3 1.046a1 1 0 00-1.67.742v3.034H6a1 1 0 00-.832 1.555l3.33 5.19-3.33 5.193A1 1 0 006 18h3.63v3.034a1 1 0 001.67.742l6.985-7.956a1 1 0 000-1.484L11.3 1.046z"/>
        </svg>
      </div>
    </div>
  </div>
</a>


      <a href="Fullbody-intermediate.php" class="no-underline">
  <!-- Abs Intermediate -->
  <div
    class="snap-start min-w-[300px] flex-shrink-0 flex items-center space-x-4 bg-gray-50 rounded-xl p-4 shadow-sm hover:shadow-md transition-shadow cursor-pointer select-none"
  >
    <img
      src="https://cdn.muscleandstrength.com/sites/default/files/field/feature-wide-image/workout/4-day-muscle-building-program-wide.jpg"
      alt="Abs Intermediate"
      class="w-20 h-20 rounded-lg object-cover flex-shrink-0"
      loading="lazy"
    />
    <div>
      <h3 class="font-bold text-lg text-gray-900">Full Body Intermediate</h3>
      <p class="text-gray-500 mt-1 text-sm">60 mins · 7 Exercises</p>
      <div class="mt-2 flex space-x-1">
        <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
          <path d="M11.3 1.046a1 1 0 00-1.67.742v3.034H6a1 1 0 00-.832 1.555l3.33 5.19-3.33 5.193A1 1 0 006 18h3.63v3.034a1 1 0 001.67.742l6.985-7.956a1 1 0 000-1.484L11.3 1.046z"/>
        </svg>
        <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
          <path d="M11.3 1.046a1 1 0 00-1.67.742v3.034H6a1 1 0 00-.832 1.555l3.33 5.19-3.33 5.193A1 1 0 006 18h3.63v3.034a1 1 0 001.67.742l6.985-7.956a1 1 0 000-1.484L11.3 1.046z"/>
        </svg>
        <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
          <path d="M11.3 1.046a1 1 0 00-1.67.742v3.034H6a1 1 0 00-.832 1.555l3.33 5.19-3.33 5.193A1 1 0 006 18h3.63v3.034a1 1 0 001.67.742l6.985-7.956a1 1 0 000-1.484L11.3 1.046z"/>
        </svg>
      </div>
    </div>
  </div>
</a>


      <a href="Fullbody-advanced.php" class="no-underline">
  <!-- Abs Advanced -->
  <div
    class="snap-start min-w-[300px] flex-shrink-0 flex items-center space-x-4 bg-gray-50 rounded-xl p-4 shadow-sm hover:shadow-md transition-shadow cursor-pointer select-none"
  >
    <img
      src="https://caliathletics.com/wp-content/uploads/2017/04/diamond-push-up-1024x999.jpg"
      alt="Abs Advanced"
      class="w-20 h-20 rounded-lg object-cover flex-shrink-0"
      loading="lazy"
    />
    <div>
      <h3 class="font-bold text-lg text-gray-900">Full Body Advanced</h3>
      <p class="text-gray-500 mt-1 text-sm">75 - 90 mins · 7 Exercises</p>
      <div class="mt-2 flex space-x-1">
        <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
          <path d="M11.3 1.046a1 1 0 00-1.67.742v3.034H6a1 1 0 00-.832 1.555l3.33 5.19-3.33 5.193A1 1 0 006 18h3.63v3.034a1 1 0 001.67.742l6.985-7.956a1 1 0 000-1.484L11.3 1.046z"/>
        </svg>
        <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
          <path d="M11.3 1.046a1 1 0 00-1.67.742v3.034H6a1 1 0 00-.832 1.555l3.33 5.19-3.33 5.193A1 1 0 006 18h3.63v3.034a1 1 0 001.67.742l6.985-7.956a1 1 0 000-1.484L11.3 1.046z"/>
        </svg>
        <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
          <path d="M11.3 1.046a1 1 0 00-1.67.742v3.034H6a1 1 0 00-.832 1.555l3.33 5.19-3.33 5.193A1 1 0 006 18h3.63v3.034a1 1 0 001.67.742l6.985-7.956a1 1 0 000-1.484L11.3 1.046z"/>
        </svg>
      </div>
    </div>
  </div>
</a>


</body>
</html>