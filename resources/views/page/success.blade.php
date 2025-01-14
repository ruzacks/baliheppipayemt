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
<main class="flex-1" style="background-color: #645AE0;">
    <div class="max-w-4xl mx-auto p-6">
        <div class="bg-white shadow-lg rounded-lg p-8 text-center space-y-6">
            <!-- Success Icon -->
            <div class="flex justify-center">
                <svg class="w-16 h-16 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z" />
                </svg>
            </div>
        
            <!-- Success Message -->
            <h1 class="text-3xl font-bold text-gray-800">Payment Successful</h1>
            <p class="text-gray-600">Thank you for your payment! Your transaction was completed successfully.</p>
        
            <!-- Payment Details -->
            <div class="bg-gray-50 p-6 rounded-lg shadow-md text-left space-y-4">
                <div class="flex justify-between">
                    <span class="font-medium text-gray-700">Invoice Number:</span>
                    <span class="text-gray-800">{{ $invoice->invoice_code }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="font-medium text-gray-700">Amount Paid:</span>
                    <span class="text-gray-800">Rp. {{ number_format($invoice->amount, 2, ',', '.') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="font-medium text-gray-700">Payment Type:</span>
                    <span class="text-gray-800">{{ ucwords(str_replace('_', ' ', $invoice->payment_by)) }}</span>
                </div>
            </div>
        
            <!-- Back to Home Button -->
            <div>
                <a href="/" class="inline-block bg-indigo-600 text-white font-semibold py-3 px-6 rounded-lg shadow hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 back-to-home">
                    Back to Home
                </a>
            </div>
        </div>
        
      
        
    </div>
</main>

<script>
    document.querySelector('.back-to-home').addEventListener('click', function (e) {
        e.preventDefault();
        window.parent.location.href = "/";
    });
</script>

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
