<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>Payment App</title>
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
<body class="text-gray-800">

  <!-- Wrapper -->
  <div class="flex h-screen">

    @include('layout.sidebar')

    <main class="flex-1">
      
      <!-- Navbar -->
      <header class="bg-white shadow p-6 flex justify-between items-center">
          <h2 class="text-2xl font-bold text-gray-800">Dashboard</h2>
          
          <form action="{{ route('logout') }}" method="POST" class="flex items-center space-x-2">
              @csrf
              <button type="submit" class="flex items-center text-white bg-red-600 hover:bg-red-700 px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m4-4H7m7 4V7" />
                  </svg>
                  <span class="ml-2">Logout</span>
              </button>
          </form>
      </header>
    

    <!-- Main Content -->
    @yield('main')

  </main>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/inputmask/5.0.7/inputmask.min.js"></script>
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
