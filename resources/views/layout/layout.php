  <!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OpenAI Dashboard Clone</title>
    <!-- Google Fonts: Roboto -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
      body {
        font-family: 'Roboto', sans-serif;
      }

      h1, h2, h3, h4, h5, h6 {
        font-weight: 700; /* Bold for headings */
      }

      p, a, span, li {
        font-weight: 400; /* Normal weight for body text */
      }
    </style>
  </head>
  <body class="bg-gray-100 text-gray-800">

    <!-- Wrapper -->
    <div class="flex h-screen">

      <?php include('sidebar.php'); ?>

      <!-- Main Content -->
      <main class="flex-1 bg-gray-50">

        <header class="bg-white shadow p-6">
          <h2 class="text-3xl font-bold text-gray-800">Enhanced Form</h2>
          <p class="text-gray-600 mt-2">Fill out the form below with the required details.</p>
        </header>
      
        <div class="max-w-4xl mx-auto p-6">
          <form class="bg-white shadow-lg rounded-lg p-8 space-y-8">
            
            <!-- Text Input -->
            <div>
              <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
              <input 
                type="text" 
                id="name" 
                class="mt-2 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm p-3" 
                placeholder="John Doe">
            </div>
      
            <!-- Number Input -->
            <div>
              <label for="age" class="block text-sm font-medium text-gray-700">Age</label>
              <input 
                type="number" 
                id="age" 
                class="mt-2 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm p-3" 
                placeholder="Enter your age">
            </div>
      
            <!-- Date Input -->
            <div>
              <label for="date" class="block text-sm font-medium text-gray-700">Date of Birth</label>
              <input 
                type="date" 
                id="date" 
                class="mt-2 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm p-3">
            </div>
      
            <!-- Select Dropdown -->
            <div>
              <label for="gender" class="block text-sm font-medium text-gray-700">Gender</label>
              <select 
                id="gender" 
                class="mt-2 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm p-3">
                <option disabled selected>Select your gender</option>
                <option>Male</option>
                <option>Female</option>
                <option>Other</option>
              </select>
            </div>
      
            <!-- Checkbox -->
            <div>
              <fieldset>
                <legend class="text-sm font-medium text-gray-700">Interests</legend>
                <div class="mt-4 space-y-2">
                  <div class="flex items-center">
                    <input 
                      id="checkbox1" 
                      name="interests" 
                      type="checkbox" 
                      class="h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500">
                    <label for="checkbox1" class="ml-3 text-sm text-gray-700">Music</label>
                  </div>
                  <div class="flex items-center">
                    <input 
                      id="checkbox2" 
                      name="interests" 
                      type="checkbox" 
                      class="h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500">
                    <label for="checkbox2" class="ml-3 text-sm text-gray-700">Sports</label>
                  </div>
                  <div class="flex items-center">
                    <input 
                      id="checkbox3" 
                      name="interests" 
                      type="checkbox" 
                      class="h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500">
                    <label for="checkbox3" class="ml-3 text-sm text-gray-700">Reading</label>
                  </div>
                </div>
              </fieldset>
            </div>
      
            <!-- Radio Buttons -->
            <div>
              <fieldset>
                <legend class="text-sm font-medium text-gray-700">Subscription Plan</legend>
                <div class="mt-4 space-y-2">
                  <div class="flex items-center">
                    <input 
                      id="plan1" 
                      name="plan" 
                      type="radio" 
                      class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-500">
                    <label for="plan1" class="ml-3 text-sm text-gray-700">Basic</label>
                  </div>
                  <div class="flex items-center">
                    <input 
                      id="plan2" 
                      name="plan" 
                      type="radio" 
                      class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-500">
                    <label for="plan2" class="ml-3 text-sm text-gray-700">Premium</label>
                  </div>
                  <div class="flex items-center">
                    <input 
                      id="plan3" 
                      name="plan" 
                      type="radio" 
                      class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-500">
                    <label for="plan3" class="ml-3 text-sm text-gray-700">Pro</label>
                  </div>
                </div>
              </fieldset>
            </div>
      
            <!-- Submit Button -->
            <div>
              <button 
                type="submit" 
                class="w-full bg-indigo-600 text-white font-semibold py-3 px-6 rounded-lg shadow hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                Submit
              </button>
            </div>
          </form>
        </div>
      </main>
    </div>

    <script>
      function toggleMenuWithAnimation(submenuId) {
        const submenu = document.getElementById(submenuId);
        const arrow = document.getElementById('arrow1');

        if (submenu.style.maxHeight) {
          // Close submenu
          submenu.style.maxHeight = null;
          arrow.classList.remove('rotate-180'); // Reset arrow
        } else {
          // Open submenu
          submenu.style.maxHeight = submenu.scrollHeight + "px";
          arrow.classList.add('rotate-180'); // Rotate arrow
        }
      }

    </script>

  </body>
  </html>
