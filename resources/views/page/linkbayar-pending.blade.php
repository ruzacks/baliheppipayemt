<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Pending</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Spinner Animation */
        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body class="flex items-center justify-center h-screen bg-gray-800">
    <div class="w-96 bg-white rounded-lg p-8 shadow-lg text-center">
        <!-- Spinner Icon -->
        <div class="flex items-center justify-center mb-6">
            <svg
                class="text-yellow-500 w-20 h-20"
                viewBox="0 0 24 24"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
                style="animation: spin 1s linear infinite;"
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
                    d="M12 6v6h6"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                />
            </svg>
        </div>

        <!-- Payment Pending Message -->
        <h2 class="text-2xl font-semibold text-gray-800 mb-2">Pembayaran Tertunda!</h2>
        <p class="text-gray-600 mb-4">
            Pembayaran Anda sedang diproses. Silakan tunggu pengecekan admin.
        </p>

        <!-- Button to Check Status -->
        
    </div>
</body>

</html>
