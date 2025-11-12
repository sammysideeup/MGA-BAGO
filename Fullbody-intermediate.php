<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fullbody Intermediate</title>
    <link rel="stylesheet" href="Suggestiondesign.css">
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

<style>
  .back-icon {
    font-size: 24px;
    color: black;
    text-decoration: none;
    z-index: 10;
}
</style>

<main class="bg-white rounded-2xl  w-full drop-shadow-lg select-none"
    role="main"
    aria-label="Abs Beginner workout description and exercises list"
  >
    <section class="p-6">
      <a href="Fullbody.php" class="back-icon"><i class='bx bx-arrow-back'></i></a>
      <h1 class="text-2xl font-bold leading-tight mb-6">Full Body Intermediate</h1>
      <div class="flex gap-4 mb-8">
        <div
          class="flex-1 bg-gray-100 rounded-xl p-4 text-center shadow-inner"
          aria-label="Duration"
        >
          <p class="text-lg font-semibold text-gray-900">60 mins</p>
          <p class="text-sm text-gray-400">Duration</p>
        </div>
        <div
          class="flex-1 bg-gray-100 rounded-xl p-4 text-center shadow-inner"
          aria-label="Exercises count"
        >
          <p class="text-lg font-semibold text-gray-900">7</p>
          <p class="text-sm text-gray-400">Exercises</p>
        </div>
      </div>

      <button id="start-button" class="mt-4 p-2 bg-blue-500 text-white rounded">Start Workout</button> 


      <h2 class="text-lg font-semibold mb-3">Exercises</h2>
      <ul
        id="exercises-list"
        class="divide-y divide-gray-200"
        role="list"
        aria-describedby="instructions"
        tabindex="0"
      >
        <!-- Draggable exercise items inserted by JS -->
      </ul>
    </section>
  </main>

  
<script>
    
    document.getElementById('start-button').addEventListener('click', () => {
  const reordered = [];
  const items = document.querySelectorAll("#exercises-list li");

  items.forEach(li => {
    const id = li.id;
    const found = exercises.find(e => e.id === id);
    if (found) {
      reordered.push({
        name: found.name,
        sets: found.sets,
        reps: found.reps,
        gif: found.gif 
      });
    }
  });

      localStorage.setItem('selectedExercises', JSON.stringify(reordered));
      window.location.href = "Recommended-workout-viewer.php";
    });

    const exercises = [
      {
        id: "barbell-back-squat",
        name: "Barbell Back Squat",
        sets: 4,
        reps: "10x",
        gif: "WorkoutGifs/.gif",
        img: 
          `<svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
            
          </svg>`
      },

      {
        id: "bench-press",
        name: "Bench Press",
        sets: 3,
        reps: "10x",
        gif: "WorkoutGifs/.gif",
        img: 
          `<svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
            
          </svg>`
      },

      {
        id: "lat-pulldown",
        name: "Lat Pulldown",
        sets: 3,
        reps: "12x",
        gif: "WorkoutGifs/.gif",
        img: 
          `<svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
            
          </svg>`
      },

      {
        id: "seated-shoulder-press",
        name: "Seated Shoulder Press",
        sets: 3,
        reps: "12x",
        gif: "WorkoutGifs/.gif",
        img: 
          `<svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
            
          </svg>`
      },

      {
        id: "cable-bicep-curl",
        name: "Cable Bicep Curl",
        sets: 3,
        reps: "12x",
        gif: "WorkoutGifs/.gif",
        img: 
          `<svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
            
          </svg>`
      },

      {
        id: "dumbbell-tricep-overload-press",
        name: "Dunbbell Tricep Overload Press",
        sets: 3,
        reps: "12x",
        gif: "WorkoutGifs/.gif",
        img: 
          `<svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
            
          </svg>`
      },

      {
        id: "hanging-leg-raise",
        name: "Hanging Leg Raise",
        sets: 3,
        reps: "15x",
        gif: "WorkoutGifs/.gif",
        img: 
          `<svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
            
          </svg>`
      },

     
      

    ];

    const listContainer = document.getElementById("exercises-list");

    // Create draggable list items
    function createExerciseItem(exercise) {
      const li = document.createElement("li");
      li.className = "flex items-center p-3 cursor-grab";
      li.setAttribute("draggable", "true");
      li.id = exercise.id;
      li.setAttribute("role", "listitem");
      li.setAttribute("aria-grabbed", "false");

      // Drag handle with three stacked lines
      const handle = document.createElement("div");
      handle.className = "draggable-handle";
      handle.setAttribute("aria-label", "Drag to reorder");
      handle.tabIndex = 0;
      for (let i = 0; i < 3; i++) {
        const span = document.createElement("span");
        handle.appendChild(span);
      }

      // Thumbnail container
      const thumb = document.createElement("div");
      thumb.className = "w-12 h-12 flex-shrink-0 mr-4";
      thumb.innerHTML = exercise.img;
      thumb.querySelector("svg").setAttribute("class", "rounded-md bg-gray-50");

      // Text container
      const textContainer = document.createElement("div");
      textContainer.className = "flex-grow";

      const title = document.createElement("p");
      title.className = "font-semibold text-gray-900 mb-0.5";
      title.textContent = exercise.name;

      const info = document.createElement("p");
      info.className = "text-gray-500 text-sm flex justify-between";

      // Sets span
      const setsSpan = document.createElement("span");
      setsSpan.textContent = "Sets: " + (exercise.sets !== undefined ? exercise.sets : "-");

      // Reps/Time span
      const repsSpan = document.createElement("span");
      repsSpan.textContent = "Reps / Time: " + (exercise.reps ? exercise.reps : "-");

      

      // Append both spans to info
      info.appendChild(setsSpan);
      info.appendChild(repsSpan);

      textContainer.appendChild(title);
      textContainer.appendChild(info);


      // Arrow icon on right side (rotated 90deg) — Unicode character
      const arrow = document.createElement("div");
      arrow.className = "exercise-arrow";
      arrow.setAttribute("aria-hidden", "true");
      arrow.textContent = "↕";

      li.appendChild(handle);
      li.appendChild(thumb);
      li.appendChild(textContainer);
      li.appendChild(arrow);

      return li;
    }

    // Render all exercises
    exercises.forEach((ex) => {
      listContainer.appendChild(createExerciseItem(ex));
    });

    // Drag and Drop reorder logic
    let draggedItem = null;
    let draggedIndex = -1;

    function swapNodes(nodeA, nodeB) {
      const parent = nodeA.parentNode;
      const siblingA = nodeA.nextSibling === nodeB ? nodeA : nodeA.nextSibling;
      parent.insertBefore(nodeA, nodeB);
      parent.insertBefore(nodeB, siblingA);
    }

    listContainer.addEventListener("dragstart", (e) => {
      if (e.target && e.target.tagName === "LI") {
        draggedItem = e.target;
        draggedIndex = [...listContainer.children].indexOf(draggedItem);
        e.dataTransfer.effectAllowed = "move";
        e.dataTransfer.setData("text/plain", "");
        setTimeout(() => {
          draggedItem.classList.add("opacity-50");
          draggedItem.setAttribute("aria-grabbed", "true");
        }, 0);
      }
    });

    listContainer.addEventListener("dragend", (e) => {
      if (draggedItem) {
        draggedItem.classList.remove("opacity-50");
        draggedItem.setAttribute("aria-grabbed", "false");
        draggedItem = null;
        draggedIndex = -1;
      }
    });

    listContainer.addEventListener("dragover", (e) => {
      e.preventDefault();
      const target = e.target.closest("li");
      if (!target || target === draggedItem) return;

      const bounding = target.getBoundingClientRect();
      const offset = bounding.y + bounding.height / 2;
      if (e.clientY - offset > 0) {
        target.after(draggedItem);
      } else {
        target.before(draggedItem);
      }
    });

    // Keyboard accessibility for drag handles (allows moving items with keyboard arrows)
    listContainer.querySelectorAll(".draggable-handle").forEach((handle) => {
      handle.addEventListener("keydown", (e) => {
        if (!draggedItem) draggedItem = e.target.closest("li");
        if (!draggedItem) return;

        const currentIndex = [...listContainer.children].indexOf(draggedItem);
        if (e.key === "ArrowUp" && currentIndex > 0) {
          listContainer.insertBefore(draggedItem, listContainer.children[currentIndex - 1]);
          e.preventDefault();
          draggedItem.querySelector(".draggable-handle").focus();
        } else if (e.key === "ArrowDown" && currentIndex < listContainer.children.length - 1) {
          listContainer.insertBefore(draggedItem, listContainer.children[currentIndex + 2] || null);
          e.preventDefault();
          draggedItem.querySelector(".draggable-handle").focus();
        }
      });
    });



    
  </script>




</body>
</html>