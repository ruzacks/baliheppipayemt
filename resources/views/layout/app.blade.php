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

    {{-- @include('layout.sidebar') --}}

    <!-- Main Content -->
    @yield('main')
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
