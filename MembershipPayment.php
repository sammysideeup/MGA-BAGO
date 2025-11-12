<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Membership Plan</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://www.paypal.com/sdk/js?client-id=YOUR_LIVE_CLIENT_ID&vault=true&intent=subscription&currency=PHP"></script>

    <div id="paypal-button-container"></div>

    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        'primary-blue': '#000000ff',
                        'primary-yellow': '#f7f200', 
                        'light-bg': '#f9f6f1', 
                        'card-bg': '#ffffff',
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        /* Custom styles for the selected state and smooth transitions */
        .card-container {
            transition: transform 0.2s, box-shadow 0.2s, border 0.2s;
            cursor: pointer;
            border: 2px solid transparent; /* Base border for spacing */
        }
        .card-container:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        .space-y-6 h2{
            text-align: center;
        }
        
        .card-container.selected {
            border-color: #3b82f6; /* Tailwind blue-500 */
            box-shadow: 0 10px 20px rgba(59, 130, 246, 0.5);
            transform: translateY(-4px); /* A small lift on selection */
        }
        /* Hide default radio button */
        .card-container input[type="radio"] {
            display: none;
        }

        /* Ensure smooth sizing for better mobile experience */
        .grid-container {
            max-width: 1200px;
        }

        .back-icon i {
            font-size: 180%; 
        }

        
    </style>
   
</head>
<body class="bg-light-bg min-h-screen flex flex-col items-center p-4 sm:p-8 font-sans text-gray-800">

    <div class="w-full max-w-7xl mx-auto">
        <!-- Main Header -->
         <a href="Register.php" class="back-icon"><i class='bx bx-arrow-back'></i></a>
        <header class="text-center mb-10">
            <h1 class="text-3xl sm:text-4xl font-extrabold text-primary-blue mb-2">
                Choose Your Membership Plan
            </h1>
            <p class="text-lg text-gray-600 font-medium">
                Select the option that best suits your needs.
            </p>
        </header>

        <form id="membershipForm" action="ProcessPayment.php" method="post" class="space-y-12">

            <!-- Student Membership Section -->
            <section class="space-y-6">
                <h2 class="text-2xl font-bold text-gray-700 border-b pb-2">Student Membership</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Student Card 1: 1 Year -->
                    <label for="student_1year" class="card-container rounded-xl shadow-lg bg-card-bg hover:shadow-xl p-6 flex flex-col justify-between">
                        <input type="radio" id="student_1year" name="membership" value="student_1year" required>
                        <div class="text-center">
                            <p class="text-sm font-medium uppercase text-primary-blue">Best Value</p>
                            <h3 class="text-4xl font-extrabold text-gray-900 my-2">
                                ₱499
                            </h3>
                            <p class="text-xl font-semibold text-gray-600 mb-4">/ 1 Year</p>
                            <p class="text-sm text-gray-500 min-h-10">
                                Perfect for academic cycles. Full access for one whole year.
                            </p>
                        </div>
                    </label>

                    <!-- Student Card 2: Lifetime -->
                    <label for="student_lifetime" class="card-container rounded-xl shadow-lg bg-card-bg hover:shadow-xl p-6 flex flex-col justify-between">
                        <input type="radio" id="student_lifetime" name="membership" value="student_lifetime">
                        <div class="text-center">
                            <p class="text-sm font-medium uppercase text-yellow-600">Premium Choice</p>
                            <h3 class="text-4xl font-extrabold text-gray-900 my-2">
                                ₱1,999
                            </h3>
                            <p class="text-xl font-semibold text-gray-600 mb-4">Lifetime</p>
                            <p class="text-sm text-gray-500 min-h-10">
                                Pay once, enjoy forever. Never worry about renewal.
                            </p>
                        </div>
                    </label>

                    <!-- Student Card 3: 1 Month -->
                    <label for="student_1month" class="card-container rounded-xl shadow-lg bg-card-bg hover:shadow-xl p-6 flex flex-col justify-between">
                        <input type="radio" id="student_1month" name="membership" value="student_1month">
                        <div class="text-center">
                            <p class="text-sm font-medium uppercase text-gray-400">Monthly</p>
                            <h3 class="text-4xl font-extrabold text-gray-900 my-2">
                                ₱1,099
                            </h3>
                            <p class="text-xl font-semibold text-gray-600 mb-4">/ 1 Month</p>
                            <p class="text-sm text-gray-500 min-h-10">
                                Short-term access for focused projects or trials.
                            </p>
                        </div>
                    </label>
                    
                    <!-- Student Card 4: 3 Months + 1 Month -->
                    <label for="student_3plus1" class="card-container rounded-xl shadow-lg bg-card-bg hover:shadow-xl p-6 flex flex-col justify-between">
                        <input type="radio" id="student_3plus1" name="membership" value="student_3plus1">
                        <div class="text-center">
                            <p class="text-sm font-medium uppercase text-green-600">Bonus Month!</p>
                            <h3 class="text-4xl font-extrabold text-gray-900 my-2">
                                ₱3,799
                            </h3>
                            <p class="text-xl font-semibold text-gray-600 mb-4">/ 4 Months</p>
                            <p class="text-sm text-gray-500 min-h-10">
                                Get 3 months, plus 1 month free. A great package deal.
                            </p>
                        </div>
                    </label>

                    <!-- Student Card 5: 6 Months -->
                    <label for="student_6months" class="card-container rounded-xl shadow-lg bg-card-bg hover:shadow-xl p-6 flex flex-col justify-between">
                        <input type="radio" id="student_6months" name="membership" value="student_6months">
                        <div class="text-center">
                            <p class="text-sm font-medium uppercase text-purple-600">Semester Term</p>
                            <h3 class="text-4xl font-extrabold text-gray-900 my-2">
                                ₱5,499
                            </h3>
                            <p class="text-xl font-semibold text-gray-600 mb-4">/ 6 Months</p>
                            <p class="text-sm text-gray-500 min-h-10">
                                Ideal for full-semester or long course needs.
                            </p>
                        </div>
                    </label>

                    <!-- Student Card 6: 12 Months -->
                    <label for="student_12months" class="card-container rounded-xl shadow-lg bg-card-bg hover:shadow-xl p-6 flex flex-col justify-between">
                        <input type="radio" id="student_12months" name="membership" value="student_12months">
                        <div class="text-center">
                            <p class="text-sm font-medium uppercase text-primary-blue">Annual Savings</p>
                            <h3 class="text-4xl font-extrabold text-gray-900 my-2">
                                ₱9,999
                            </h3>
                            <p class="text-xl font-semibold text-gray-600 mb-4">/ 12 Months</p>
                            <p class="text-sm text-gray-500 min-h-10">
                                Locked-in price for the entire academic year.
                            </p>
                        </div>
                    </label>

                </div>
            </section>

            <!-- Non-Student Membership Section -->
            <section class="space-y-6">
                <h2 class="text-2xl font-bold text-gray-700 border-b pb-2">Non-Student Membership</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    
                    <!-- Non-Student Card 1: 1 Year -->
                    <label for="nonstudent_1year" class="card-container rounded-xl shadow-lg bg-card-bg hover:shadow-xl p-6 flex flex-col justify-between">
                        <input type="radio" id="nonstudent_1year" name="membership" value="nonstudent_1year">
                        <div class="text-center">
                            <p class="text-sm font-medium uppercase text-primary-blue">Annual Access</p>
                            <h3 class="text-4xl font-extrabold text-gray-900 my-2">
                                ₱799
                            </h3>
                            <p class="text-xl font-semibold text-gray-600 mb-4">/ 1 Year</p>
                            <p class="text-sm text-gray-500 min-h-10">
                                Standard yearly plan for professionals.
                            </p>
                        </div>
                    </label>

                    <!-- Non-Student Card 2: Lifetime -->
                    <label for="nonstudent_lifetime" class="card-container rounded-xl shadow-lg bg-card-bg hover:shadow-xl p-6 flex flex-col justify-between">
                        <input type="radio" id="nonstudent_lifetime" name="membership" value="nonstudent_lifetime">
                        <div class="text-center">
                            <p class="text-sm font-medium uppercase text-yellow-600">The Ultimate Plan</p>
                            <h3 class="text-4xl font-extrabold text-gray-900 my-2">
                                ₱3,999
                            </h3>
                            <p class="text-xl font-semibold text-gray-600 mb-4">Lifetime</p>
                            <p class="text-sm text-gray-500 min-h-10">
                                Unlimited, permanent access to all features.
                            </p>
                        </div>
                    </label>

                    <!-- Non-Student Card 3: 1 Month -->
                    <label for="nonstudent_1month" class="card-container rounded-xl shadow-lg bg-card-bg hover:shadow-xl p-6 flex flex-col justify-between">
                        <input type="radio" id="nonstudent_1month" name="membership" value="nonstudent_1month">
                        <div class="text-center">
                            <p class="text-sm font-medium uppercase text-gray-400">Monthly</p>
                            <h3 class="text-4xl font-extrabold text-gray-900 my-2">
                                ₱1,399
                            </h3>
                            <p class="text-xl font-semibold text-gray-600 mb-4">/ 1 Month</p>
                            <p class="text-sm text-gray-500 min-h-10">
                                Flexible access, cancel anytime.
                            </p>
                        </div>
                    </label>
                    
                    <!-- Non-Student Card 4: 3 Months + 1 Month -->
                    <label for="nonstudent_3plus1" class="card-container rounded-xl shadow-lg bg-card-bg hover:shadow-xl p-6 flex flex-col justify-between">
                        <input type="radio" id="nonstudent_3plus1" name="membership" value="nonstudent_3plus1">
                        <div class="text-center">
                            <p class="text-sm font-medium uppercase text-green-600">Bonus Month!</p>
                            <h3 class="text-4xl font-extrabold text-gray-900 my-2">
                                ₱4,899
                            </h3>
                            <p class="text-xl font-semibold text-gray-600 mb-4">/ 4 Months</p>
                            <p class="text-sm text-gray-500 min-h-10">
                                3 months plus one month complimentary access.
                            </p>
                        </div>
                    </label>

                    <!-- Non-Student Card 5: 6 Months -->
                    <label for="nonstudent_6months" class="card-container rounded-xl shadow-lg bg-card-bg hover:shadow-xl p-6 flex flex-col justify-between">
                        <input type="radio" id="nonstudent_6months" name="membership" value="nonstudent_6months">
                        <div class="text-center">
                            <p class="text-sm font-medium uppercase text-purple-600">Half-Year Plan</p>
                            <h3 class="text-4xl font-extrabold text-gray-900 my-2">
                                ₱6,999
                            </h3>
                            <p class="text-xl font-semibold text-gray-600 mb-4">/ 6 Months</p>
                            <p class="text-sm text-gray-500 min-h-10">
                                Reliable access for a full half-year period.
                            </p>
                        </div>
                    </label>

                    <!-- Non-Student Card 6: 12 Months -->
                    <label for="nonstudent_12months" class="card-container rounded-xl shadow-lg bg-card-bg hover:shadow-xl p-6 flex flex-col justify-between">
                        <input type="radio" id="nonstudent_12months" name="membership" value="nonstudent_12months">
                        <div class="text-center">
                            <p class="text-sm font-medium uppercase text-primary-blue">Max Savings</p>
                            <h3 class="text-4xl font-extrabold text-gray-900 my-2">
                                ₱12,999
                            </h3>
                            <p class="text-xl font-semibold text-gray-600 mb-4">/ 12 Months</p>
                            <p class="text-sm text-gray-500 min-h-10">
                                Our most cost-effective annual subscription.
                            </p>
                        </div>
                    </label>

                </div>
            </section>

            <!-- Single Payment Button (Kept in the form) -->
            <div class="mt-12 pt-6 border-t border-gray-300">
                <button type="submit" id="finalPaymentButton" disabled
                    class="w-full py-4 text-xl font-extrabold rounded-lg transition duration-200 
                           bg-gray-400 text-white cursor-not-allowed shadow-md"
                    title="Please select a membership plan first."
                >
                    Paypal Button
                </button>
            </div>
            
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('membershipForm');
            const cards = document.querySelectorAll('.card-container');
            const radioButtons = form.querySelectorAll('input[type="radio"]');
            const paymentButton = document.getElementById('finalPaymentButton');

            /**
             * Updates the visual state of all cards based on the checked radio button.
             */
            function updateCardSelection() {
                let isSelected = false;
                cards.forEach(card => {
                    const radio = card.querySelector('input[type="radio"]');
                    if (radio.checked) {
                        card.classList.add('selected');
                        isSelected = true;
                    } else {
                        card.classList.remove('selected');
                    }
                });

                // Update payment button state
                if (isSelected) {
                    paymentButton.disabled = false;
                    paymentButton.classList.remove('bg-gray-400', 'cursor-not-allowed');
                    paymentButton.classList.add('bg-primary-yellow', 'hover:bg-yellow-500', 'text-primary-blue');
                    paymentButton.removeAttribute('title');
                } else {
                    paymentButton.disabled = true;
                    paymentButton.classList.remove('bg-primary-yellow', 'hover:bg-yellow-500', 'text-primary-blue');
                    paymentButton.classList.add('bg-gray-400', 'cursor-not-allowed');
                    paymentButton.setAttribute('title', 'Please select a membership plan first.');
                }
            }

            // Initial check on load (in case a browser remembered selection)
            updateCardSelection();

            // Attach event listener to all radio buttons
            radioButtons.forEach(radio => {
                radio.addEventListener('change', updateCardSelection);
            });

            // Attach click listener to cards (labels) for selection/radio-button checking
            cards.forEach(card => {
                card.addEventListener('click', (e) => {
                    // Find the associated radio button and check it
                    const radio = card.querySelector('input[type="radio"]');
                    // Prevent propagation if the target is the radio button itself (rare since it's hidden)
                    if (e.target !== radio) {
                        radio.checked = true;
                        updateCardSelection();
                    }
                });
            });

            // Prevent form submission if no plan is selected (redundant due to 'disabled' but good practice)
            form.addEventListener('submit', (e) => {
                if (!form.querySelector('input[name="membership"]:checked')) {
                    e.preventDefault();
                    console.error("Please select a membership plan before proceeding.");
                }
            });
        });
    </script>
</body>
</html>