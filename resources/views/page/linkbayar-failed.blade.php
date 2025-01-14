<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Failed</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Cross Animation */
        @keyframes draw {
            0% {
                stroke-dasharray: 0, 100;
            }
            100% {
                stroke-dasharray: 100, 0;
            }
        }
    </style>
</head>

<body class="flex items-center justify-center h-screen bg-gray-800">
    <div class="w-96 bg-white rounded-lg p-8 shadow-lg text-center">
        <!-- Red Cross Icon -->
        <div class="flex items-center justify-center mb-6">
            <svg
                class="text-red-500 w-20 h-20"
                viewBox="0 0 24 24"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
            >
                <circle
                    cx="12"
                    cy="12"
                    r="10"
                    stroke="currentColor"
                    stroke-width="2"
                    fill="none"
                />
                <path
                    d="M9 9l6 6M15 9l-6 6"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-dasharray="100"
                    style="animation: draw 0.5s ease-out forwards;"
                />
            </svg>
        </div>

        <!-- Payment Failed Message -->
        <h2 class="text-2xl font-semibold text-gray-800 mb-2">Pembayaran Gagal!</h2>
        <p class="text-gray-600 mb-4">
            Mohon maaf, pembayaran Anda tidak berhasil. Silakan coba lagi.
        </p>

        <!-- Button to Try Again -->
        <button
            onclick="window.location.href = '/payment-app/linkbayar'"
            class="bg-red-500 text-white px-6 py-3 rounded-md font-medium hover:bg-red-700 transition duration-300"
        >
            Coba Lagi
        </button>
    </div>
</body>

</html>
