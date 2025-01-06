<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Fixed Loading Animation */
        .loader {
            border-top-color: #3498db;
            animation: spin 1s linear infinite;
        }
    
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
    <div id="toast-container" class="fixed top-5 center-5 space-y-2"></div>

    <div class="w-96 bg-gray-100 rounded-lg p-6 shadow-lg text-center">
        <!-- Link Bayar Section -->
        <div class="text-lg font-semibold text-gray-700 mb-4">Link Bayar</div>
        <div class="text-sm text-gray-600 bg-gray-200 rounded py-2 px-4 mb-4">
            <label for="invoice" class="font-semibold">No Invoice:</label>
            <input 
                type="text" 
                id="invoice" 
                name="invoice" 
                value=""
                placeholder="Enter Invoice Number"
                class="ml-2 border-none bg-transparent focus:outline-none font-medium"
            />
        </div>

        <!-- Nominal Transaksi Section -->
        <div class="text-lg font-semibold text-gray-700 mb-2">Nominal Transaksi</div>
        <div id="amount-display" class="text-2xl font-bold text-white bg-yellow-500 rounded py-3 mb-4">
            Rp. 0
        </div>

        <!-- Pilih Metode Pembayaran Section -->
        <div class="text-lg font-semibold text-gray-700 mb-4">Pilih metode Pembayaran</div>
        <div class="flex flex-col space-y-3">
            <!-- Kartu Debit/Kredit Button with Logos -->
            <button class="w-full py-3 px-2 bg-gray-400 text-white font-medium rounded flex items-center justify-between space-x-4 flex-wrap" disabled>
                <span class="whitespace-nowrap">Segera Hadir</span>
                <div class="flex space-x-2">
                    <!-- Logos for MasterCard, Visa, JCB, American Express -->
                    <img src="https://upload.wikimedia.org/wikipedia/commons/0/04/Mastercard-logo.png" alt="MasterCard" class="h-5">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/5/5e/Visa_Inc._logo.svg" alt="Visa" class="h-5">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/4/40/JCB_logo.svg" alt="JCB" class="h-5">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/f/fa/American_Express_logo_%282018%29.svg" alt="American Express" class="h-5">
                </div>
            </button>
            
        
            <!-- E-Wallet Button with QRIS Logo -->
            <button class="w-full py-3 px-2 bg-blue-300 text-white font-medium rounded flex items-center justify-between space-x-4" id="qris-btn" onclick="generateQRPayment()" disabled>
                <span>E-Wallet</span>
                <img src="https://whatthelogo.com/storage/logos/quick-response-code-indonesia-standard-qris-274928.png" alt="QRIS" class="h-5">
            </button>
        </div>
        

        <!-- Batas Waktu Pembayaran Section -->
        <div class="text-sm text-gray-500 mt-6">
            Batas Waktu Pembayaran <span id="countdown-timer" class="font-medium">0:00</span>
        </div>
    </div>

    <div id="qrModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div
            class="bg-white p-6 rounded-lg shadow-lg transform scale-90 transition-transform duration-300 ease-in-out relative">
            <!-- Loading Animation -->
            <div id="loading" class="flex items-center justify-center">
                <div class="loader ease-linear rounded-full border-4 border-t-4 border-gray-200 h-12 w-12"></div>
            </div>
            <!-- QR Code Content -->
            <div id="qrContent" class="hidden text-center">
                <canvas id="qrCanvas" class="mx-auto"></canvas>
                <p class="text-sm text-gray-500 mt-4">Scan QR code untuk melakukan pembayaran.</p>
                <button id="reloadPage"
                class="bg-blue-500 text-white px-4 py-2 rounded-md mt-6 hover:bg-blue-700">
                Ulangi
            </button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/qrcode/build/qrcode.min.js"></script>


    <script>
        let timerInterval = null;
        let countdownRunning = false;
        document.getElementById('invoice').addEventListener('input', function (e) {
        const invoiceCode = e.target.value;


        // Check if the input length is exactly 14 characters
        if (invoiceCode.length === 14) {
            // Make AJAX request to the API
            fetch('http://127.0.0.1/payment-app/api/get-invoice-detail', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ inv_code: invoiceCode })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // Update the amount display with the returned amount
                    const formattedAmount = new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        minimumFractionDigits: 0 // Remove decimal places
                    }).format(data.amount);

                    document.getElementById('amount-display').innerText = formattedAmount;
                    // Start the countdown timer
                    const invoiceDate = new Date(data.date); // the date is 2025-01-05
                    // timerInterval = null;
                    // countdownRunning = false;
                    startCountdown(invoiceDate);
                    document.getElementById('qris-btn').removeAttribute('disabled');
                } else {
                    if (data.status === 'expired') {
                        showToast('The invoice has expired.', 'error');
                    } else {
                        showToast('The invoice was not found.', 'error');
                    }
                    document.getElementById('amount-display').innerText = "Rp. 0";
                    if (countdownRunning) {
                        clearInterval(timerInterval);
                        countdownRunning = false;
                        const countdownElement = document.getElementById('countdown-timer');
                        countdownElement.innerText = '0:00';
                    }
                    document.getElementById('qris-btn').setAttribute('disabled', 'true');
                }
            })
            .catch(error => {
                console.error('Error fetching invoice details:', error);
            });
        }
    });

    function startCountdown(invoiceDate) {
        const countdownElement = document.getElementById('countdown-timer');
        const limit = 24 * 60 * 60 * 1000; // 24 hours in milliseconds
        countdownElement.innerText = '0:00';

        // Check if a countdown is already running, if so, clear it
        if (countdownRunning) {
            clearInterval(timerInterval);
            countdownRunning = false;
        }

        function updateCountdown() {
            const now = new Date();
            const timeLeft = limit - (now - invoiceDate);

            if (timeLeft <= 0) {
                countdownElement.innerText = '0:00';
                clearInterval(timerInterval);
                countdownRunning = false; // Reset the flag when countdown ends
                alert('Time limit has expired.');
                return;
            }

            const hours = Math.floor(timeLeft / (1000 * 60 * 60));
            const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

            countdownElement.innerText = `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
        }

        // Start the timer interval to update every second
        timerInterval = setInterval(updateCountdown, 1000);
        countdownRunning = true; // Set the flag to true
        updateCountdown(); // Call it once immediately
    }

    function showToast(message, type = 'info') {
        const toastContainer = document.getElementById('toast-container');

        // Create toast element
        const toast = document.createElement('div');
        toast.className = `flex items-center px-4 py-3 rounded-lg shadow-lg text-white 
            ${type === 'success' ? 'bg-green-500' : type === 'error' ? 'bg-red-500' : 'bg-gray-500'} 
            transition-opacity duration-300 opacity-100`;
        toast.innerHTML = `
            <span class="mr-3">${type === 'success' ? '✅' : '⚠️'}</span>
            <span>${message}</span>
        `;

        // Append the toast to the container
        toastContainer.appendChild(toast);

        // Remove the toast after 3 seconds
        setTimeout(() => {
            toast.classList.add('opacity-0');
            setTimeout(() => toast.remove(), 300); // Remove after fade-out
        }, 3000);
    }

    async function generateQRPayment() {
        const modal = document.getElementById('qrModal');
        modal.classList.remove('hidden');
        modal.querySelector('.transform').classList.replace('scale-90', 'scale-100');

        const invoice = document.getElementById('invoice').value;

        const loading = document.getElementById('loading');
        const qrContent = document.getElementById('qrContent');
        const qrCanvas = document.getElementById('qrCanvas');
        // const closeModal = document.getElementById('closeModal');

        loading.classList.remove('hidden');
        qrContent.classList.add('hidden');
        // closeModal.classList.add('hidden');

        try {
            const response = await fetch('http://127.0.0.1/payment-app/api/request-qr-payment', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ inv_code: invoice }),
            });

            const data = await response.json();

            if (data.status === 'success') {
                const qrString = data.qr_link;

                // Generate QR code
                QRCode.toCanvas(qrCanvas, qrString, {
                    width: 256,
                    margin: 2,
                }, (error) => {
                    if (error) {
                        console.error(error);
                        alert('Failed to generate QR code.');
                        modal.classList.add('hidden');
                        return;
                    }

                    // Show QR content
                    loading.classList.add('hidden');
                    qrContent.classList.remove('hidden');
                    // closeModal.classList.remove('hidden'); // Show the close button
                });

                // Start polling for payment status
                const endTime = Date.now() + 5 * 60 * 1000; // 5 minutes
                const interval = setInterval(async () => {
                    const checkResponse = await fetch(
                        `http://127.0.0.1/payment-app/api/check-payment?inv_code=${invoice}`
                    );
                    const checkData = await checkResponse.json();

                    console.log(checkData);

                    if (checkData.payment_status === 'paid') {
                        clearInterval(interval);
                        modal.classList.add('hidden');
                        window.location.href = 'http://127.0.0.1/payment-app/link-bayar-success';
                    } else if (Date.now() > endTime) {
                        clearInterval(interval);
                        alert('Payment timed out. Please try again.');
                        modal.classList.add('hidden');
                    }
                }, 5000);
            } else {
                throw new Error('Failed to generate QR payment link.');
            }
        } catch (error) {
            console.error(error);
            alert('An error occurred while generating the QR code.');
            modal.classList.add('hidden');
        }
    }

    // Close modal functionality
    document.getElementById('reloadPage').addEventListener('click', () => {
        location.reload();
    });


    </script>
</body>
</html>
