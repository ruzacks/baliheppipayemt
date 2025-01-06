<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Success</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Checkmark Animation */
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
        <!-- Green Check Icon -->
        <div class="flex items-center justify-center mb-6">
            <svg
                class="text-green-500 w-20 h-20"
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
                    d="M9 12.5l2.5 2.5L15 10"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-dasharray="100"
                    style="animation: draw 0.5s ease-out forwards;"
                />
            </svg>
        </div>

        <!-- Payment Success Message -->
        <h2 class="text-2xl font-semibold text-gray-800 mb-2">Pembayaran Berhasil!</h2>
        <p class="text-gray-600 mb-4">
            Terima kasih! Pembayaran Anda telah berhasil diproses.
        </p>

        <!-- Button to Go Back -->
        <button
            onclick="window.location.href = '/payment-app/linkbayar'"
            class="bg-green-500 text-white px-6 py-3 rounded-md font-medium hover:bg-green-700 transition duration-300"
        >
            Transaksi Lagi
        </button>
    </div>
</body>

</html>
