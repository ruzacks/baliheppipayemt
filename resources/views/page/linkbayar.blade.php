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

<body class="flex-col items-center justify-center min-h-screen bg-gray-800 p-8">
    <div id="toast-container" class="fixed top-5 center-5 space-y-2"></div>

    <div class="flex flex-col md:flex-row gap-6">
        <!-- Product Table Section -->
        <div class="md:w-3/4 w-full">
            <div>
                <!-- Table View (For Desktop) -->
                <div class="hidden md:block bg-white rounded-lg shadow-md p-4 mb-4">
                    <h2 class="text-lg font-semibold text-gray-800">Pesanan</h2>
                    <div class="overflow-x-auto">
                        <table class="w-full min-w-[600px]">
                            <thead>
                                <tr class="border-b">
                                    <th class="text-left font-semibold text-gray-700 py-3">Produk</th>
                                    <th class="text-left font-semibold text-gray-700 py-3">Harga</th>
                                    <th class="text-left font-semibold text-gray-700 py-3">Qty</th>
                                    <th class="text-left font-semibold text-gray-700 py-3">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($invoice->invoice_detail as $item)
                                    <tr class="">
                                        <td class="py-4">
                                            <div class="flex items-center">
                                                <img class="h-12 w-12 mr-3 object-cover rounded"
                                                    src="{{ $item->product->image_url ? (filter_var($item->product->image_url, FILTER_VALIDATE_URL) ? $item->product->image_url : asset('storage/app/public/' . $item->product->image_url)) : 'https://www.static-src.com/wcsstore/Indraprastha/images/catalog/full//catalog-image/100/MTA-150688314/no-brand_no-brand_full01.jpg' }}"
                                                    alt="{{ $item->product->name }}">
                                                <span
                                                    class="font-semibold text-gray-800">{{ $item->product->name }}</span>
                                            </div>
                                        </td>
                                        <td class="py-4 text-gray-700">Rp {{ number_format($item->price, 0, ',', '.') }}
                                        </td>
                                        <td class="py-4 text-gray-700 text-center">{{ $item->qty }}</td>
                                        <td class="py-4 text-gray-700">Rp
                                            {{ number_format($item->qty * $item->price, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Card View (For Mobile) -->
                <div class="md:hidden flex flex-col space-y-3">
                    <div class="bg-white rounded-lg shadow-md">
                        <div class="p-3">
                            <h2 class="text-lg font-semibold text-gray-800">Pesanan</h2>
                        </div>
                        @foreach ($invoice->invoice_detail as $item)
                            <div class="p-3 flex items-center justify-between">
                                <!-- Product Image -->
                                <img class="h-14 w-14 object-cover rounded"
                                    src="{{ $item->product->image_url ? (filter_var($item->product->image_url, FILTER_VALIDATE_URL) ? $item->product->image_url : asset('storage/app/public/' . $item->product->image_url)) : 'https://www.static-src.com/wcsstore/Indraprastha/images/catalog/full//catalog-image/100/MTA-150688314/no-brand_no-brand_full01.jpg' }}"
                                    alt="{{ $item->product->name }}">

                                <!-- Product Info -->
                                <div class="flex-1 ml-4">
                                    <span
                                        class="text-xs font-semibold text-gray-800 text-sm">{{ $item->product->name }}</span>
                                    <div class="text-xs text-gray-500 mt-1">
                                        <span>Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                                    </div>
                                </div>

                                <!-- Quantity and Total Price -->
                                <div class="flex flex-col items-end">
                                    <span class="text-gray-800 font-bold text-sm">{{ $item->qty }}x</span>
                                    <span class="text-xs text-gray-500 mt-1">Rp
                                        {{ number_format($item->qty * $item->price, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Customer Details -->
                <div class="bg-white rounded-lg shadow-md p-6 mt-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Alamat Pengiriman</h2>

                    <!-- Desktop View -->
                    <div class="hidden md:grid grid-cols-2 gap-y-4 gap-x-6">
                        <div>
                            <span class="text-sm text-gray-600">Nama:</span>
                            <span class="text-sm text-gray-900 font-medium">{{ $customer->first_name }}
                                {{ $customer->last_name }}</span>
                        </div>
                        <div>
                            <span class="text-sm text-gray-600">Email:</span>
                            <span class="text-sm text-gray-900 font-medium">{{ $customer->email }}</span>
                        </div>
                        <div>
                            <span class="text-sm text-gray-600">Handphone / WA:</span>
                            <span class="text-sm text-gray-900 font-medium">{{ $customer->phone }}</span>
                        </div>
                        <div>
                            <span class="text-sm text-gray-600">Alamat:</span>
                            <span class="text-sm text-gray-900 font-medium">
                                {{ $customer->address }}, {{ $customer->city }}, {{ $customer->state }}
                                {{ $customer->postcode }}
                            </span>
                        </div>
                    </div>

                    <!-- Mobile View -->
                    <div class="md:hidden flex flex-col space-y-3">
                        <div class="bg-gray-100 p-3 rounded-lg">
                            <span class="text-xs text-gray-600 block">Name</span>
                            <span class="text-sm font-medium text-gray-900">{{ $customer->first_name }}
                                {{ $customer->last_name }}</span>
                        </div>
                        <div class="bg-gray-100 p-3 rounded-lg">
                            <span class="text-xs text-gray-600 block">Email</span>
                            <span class="text-sm font-medium text-gray-900">{{ $customer->email }}</span>
                        </div>
                        <div class="bg-gray-100 p-3 rounded-lg">
                            <span class="text-xs text-gray-600 block">Phone</span>
                            <span class="text-sm font-medium text-gray-900">{{ $customer->phone }}</span>
                        </div>
                        <div class="bg-gray-100 p-3 rounded-lg">
                            <span class="text-xs text-gray-600 block">Address</span>
                            <span class="text-sm font-medium text-gray-900">
                                {{ $customer->address }}, {{ $customer->city }}, {{ $customer->state }}
                                {{ $customer->postcode }}
                            </span>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Payment Section -->
        <div class="md:w-1/4 w-full bg-white rounded-lg p-4 shadow-lg">
            <div class="text-lg font-semibold text-gray-800 mb-4">Pembayaran</div>
            <div class="text-sm text-gray-600 bg-gray-50 rounded-lg py-3 px-4 mb-6 border border-gray-200">
                <label for="invoice" class="font-medium">No Invoice:</label>
                <input type="text" id="invoice" name="invoice" value="{{ $invoice->invoice_code }}"
                    placeholder="Masukkan Nomor Invoice"
                    class="w-full mt-1 border-none bg-transparent focus:outline-none font-medium text-gray-700"
                    readonly />
            </div>

            <div class="text-lg font-semibold text-gray-800 mb-2">Nominal Transaksi</div>
            <div id="amount-display"
                class="text-2xl font-bold text-white bg-indigo-600 rounded-lg py-4 mb-6 text-center">
                Rp 0
            </div>

            <div class="text-lg font-semibold text-gray-800 mb-4">Pilih Metode Pembayaran</div>
            <div class="flex flex-col space-y-3">
                <!-- Credit Card -->
                <button
                    class="w-full py-3 px-4 bg-gray-700 text-white font-medium rounded-lg flex items-center justify-between hover:bg-gray-800 transition-colors"
                    id="card-btn" disabled>
                    <span class="whitespace-nowrap">Kartu Kredit</span>
                    <div class="flex space-x-2">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/0/04/Mastercard-logo.png"
                            alt="MasterCard" class="h-5">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/5/5e/Visa_Inc._logo.svg" alt="Visa"
                            class="h-5">
                    </div>
                </button>

                <!-- QRIS -->
                <button
                    class="w-full py-3 px-4 bg-blue-600 text-white font-medium rounded-lg flex items-center justify-between hover:bg-blue-700 transition-colors"
                    id="qris-btn" disabled>
                    <span>QRIS</span>
                    <img src="https://whatthelogo.com/storage/logos/quick-response-code-indonesia-standard-qris-274928.png"
                        alt="QRIS" class="h-5">
                </button>

                <!-- OVO -->
                <button
                    class="w-full py-3 px-4 bg-purple-600 text-white font-medium rounded-lg flex items-center justify-between hover:bg-purple-700 transition-colors"
                    id="ovo-btn" disabled>
                    <span>OVO</span>
                    <img src="https://upload.wikimedia.org/wikipedia/commons/e/eb/Logo_ovo_purple.svg" alt="OVO"
                        class="h-5">
                </button>

                <!-- DANA -->
                <button
                    class="w-full py-3 px-4 bg-blue-300 text-white font-medium rounded-lg flex items-center justify-between hover:bg-blue-600 transition-colors"
                    id="dana-btn" disabled>
                    <span>DANA</span>
                    <img src="https://upload.wikimedia.org/wikipedia/commons/7/72/Logo_dana_blue.svg" alt="DANA"
                        class="h-5">
                </button>

                <!-- Indomaret -->
                {{-- <button
                    class="w-full py-3 px-4 bg-yellow-500 text-gray-800 font-medium rounded-lg flex items-center justify-between hover:bg-yellow-600 transition-colors"
                    id="indomaret-btn" disabled>
                    <span>Indomaret</span>
                    <img src="https://upload.wikimedia.org/wikipedia/commons/9/9d/Logo_Indomaret.png" alt="Indomaret"
                        class="h-5">
                </button> --}}

                <!-- Alfamart -->
                {{-- <button
                    class="w-full py-3 px-4 bg-red-500 text-white font-medium rounded-lg flex items-center justify-between hover:bg-red-600 transition-colors"
                    id="alfamart-btn" disabled>
                    <span>Alfamart</span>
                    <img src="https://upload.wikimedia.org/wikipedia/commons/9/9e/ALFAMART_LOGO_BARU.png"
                        alt="Alfamart" class="h-5">
                </button> --}}
                <!-- Akulaku -->
                <button
                    class="w-full py-3 px-4 bg-red-400 text-white font-medium rounded-lg flex items-center justify-between hover:bg-red-700 transition-colors"
                    id="akulaku-btn" disabled>
                    <span>Akulaku</span>
                    <img src="https://ec-cstatic.akulaku.net/web-site/_nuxt/img/m_akulaku_logo.35cf85f.png" alt="Akulaku"
                        class="h-5">
                </button>

                <!-- Kredivo -->
                <button
                    class="w-full py-3 px-4 bg-orange-400 text-white font-medium rounded-lg flex items-center justify-between hover:bg-orange-600 transition-colors"
                    id="kredivo-btn" disabled>
                    <span>Kredivo</span>
                    <img src="https://image.cermati.com/v1582185705/upcaqimam6jtf9hoy6mz.png" alt="Kredivo"
                        class="h-5">
                </button>

                <!-- Indodana -->
                {{-- <button
                    class="w-full py-3 px-4 bg-green-600 text-white font-medium rounded-lg flex items-center justify-between hover:bg-green-700 transition-colors"
                    id="indodana-btn" disabled>
                    <span>Indodana</span>
                    <img src="https://upload.wikimedia.org/wikipedia/commons/3/3d/Indodana_logo.png" alt="Indodana"
                        class="h-5">
                </button> --}}


            </div>


            <div class="text-sm text-gray-500 mt-6 text-center">
                Batas Waktu Pembayaran: <span id="countdown-timer" class="font-medium">0:00</span>
            </div>
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
                <button id="reloadPage" class="bg-blue-500 text-white px-4 py-2 rounded-md mt-6 hover:bg-blue-700">
                    Ulangi
                </button>
            </div>
        </div>
    </div>

    <div id="dokuModal" class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg overflow-hidden shadow-lg max-w-2xl w-full">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-4 border-b">
                <h2 class="text-lg font-semibold">Credit Card Payment</h2>
                <button onclick="closeModal()" class="text-gray-500 hover:text-red-600 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <!-- Modal Content -->
            <iframe src="" frameborder="0" class="w-full h-96"></iframe>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/qrcode/build/qrcode.min.js"></script>


    <script>
        let timerInterval = null;
        let countdownRunning = false;
        document.addEventListener("DOMContentLoaded", function() {
            const invoiceCode = document.getElementById('invoice').value;


            // Check if the input length is exactly 14 characters
            if (invoiceCode.length === 14) {
                // Make AJAX request to the API
                fetch("{{ route('get-invoice-detail') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            inv_code: invoiceCode
                        })
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
                            document.getElementById('card-btn').removeAttribute('disabled');
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
                            document.getElementById('card-btn').setAttribute('disabled', 'true');
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

                countdownElement.innerText =
                    `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
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

        async function generateCardPayment() {
            const invoice = document.getElementById('invoice').value;

            try {
                const response = await fetch('http://127.0.0.1/payment-app/api/request-card-payment', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        inv_code: invoice
                    }),
                });

                const result = await response.json();

                if (response.ok && result.response.credit_card_payment_page) {
                    // Set the iframe source to the payment page URL
                    document.querySelector('#dokuModal iframe').src = result.response.credit_card_payment_page.url;

                    // Display the modal
                    document.getElementById('dokuModal').classList.remove('hidden');
                } else {
                    alert('Failed to generate card payment. Please try again.');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('An error occurred while generating the payment.');
            }
        }

        function closeModal() {
            document.getElementById('dokuModal').classList.add('hidden');
            document.querySelector('#dokuModal iframe').src = ''; // Reset iframe source
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
                    body: JSON.stringify({
                        inv_code: invoice
                    }),
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
