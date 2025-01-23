@extends('layout.admin-layout')

@section('main')
    <style>
        #salesSuggestions {
            max-width: 100%;
            /* Ensure suggestions are within the container's width */
            max-height: 200px;
            /* Optional: Limit height to avoid excessive scrolling */
            overflow-y: auto;
            /* Add vertical scroll if content overflows */
            overflow-x: hidden;
            /* Hide horizontal overflow */
            position: absolute;
            z-index: 10;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            width: calc(100% - 20px);
            /* Ensure the suggestions container doesn't overflow */
        }
    </style>
    <div class="bg-gray-100 h-screen py-8">
        <div class="container mx-auto px-4">
            <h1 class="text-2xl font-semibold mb-4">Transaksi</h1>
            <div class="flex flex-col md:flex-row gap-4">
                <!-- Summary Section (1/4 width) -->
                <div class="md:w-3/4">
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-lg font-semibold mb-4">Invoice Data</h2>

                        <!-- Datetime Input -->
                        {{-- <div class="mb-4">
                            <label for="expire_date" class="block text-sm font-medium text-gray-700 mb-1">Expire Date</label>
                            <input type="datetime-local" id="expire_date" name="expire_date"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                value="{{ $invoice->expire_date ?? '' }}">
                        </div> --}}
                        <div class="mb-4">
                            <label for="amount" class="block text-sm font-medium text-gray-700 mb-1">Transaction Amount</label>
                            <input type="text" id="amount" name="amount"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                value="{{ isset($invoice) ? number_format($invoice->amount, 0) : '' }}" autocomplete="off" oninput="formatInputNumber(this)" />
                        </div>

                        <div class="mb-4">
                            <label for="payment_by" class="block text-sm font-medium text-gray-700 mb-1">Payment
                                Gateway Type</label>
                            <input type="text" id="payment_by" name="payment_by"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                value="{{ $invoice->payment_by ?? '' }}" autocomplete="off"
                                placeholder="Akulaku, Kredivo, Shoppee Etc">
                        </div>

                        <div class="mb-4">
                            <label for="netto" class="block text-sm font-medium text-gray-700 mb-1">Payment Gateway</label>
                            <input type="text" id="netto" name="netto"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                value="{{ isset($invoice) ? number_format($invoice->netto, 0) : '' }}" autocomplete="off" oninput="formatInputNumber(this)" />
                        </div>
                        
                        <div class="mb-4">
                            <label for="sales" class="block text-sm font-medium text-gray-600">Sales</label>
                            <input type="text" id="sales" name="sales" placeholder="Search sales..."
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                autocomplete="off"
                                value="{{ isset($invoice) && $invoice->sales_person_id != null ? $invoice->sales_person->name : '' }}" />
                            <ul id="salesSuggestions"
                                class="absolute bg-white border border-gray-300 rounded-lg shadow-lg mt-1 w-full hidden">
                            </ul>
                            <input type="hidden" name="salesPersonId" id="salesPersonId"
                                value="{{ $invoice->sales_person_id ?? '' }}">
                        </div>

                        <div class="mb-4">
                            <label for="tax" class="block text-sm font-medium text-gray-700 mb-1">Adm / Tax (%)</label>
                            <input type="text" id="tax" name="tax"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                value="{{ $invoice->tax ?? '' }}" autocomplete="off" oninput="formatInputNumber(this)" />
                        </div>
                        
                        <div class="mb-4">
                            <label for="fee" class="block text-sm font-medium text-gray-700 mb-1">Fee Layanan (%)</label>
                            <input type="text" id="fee" name="fee"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                value="{{ $invoice->fee ?? '' }}" autocomplete="off" oninput="formatInputNumber(this)" />
                        </div>
                        
                        <div class="mb-4">
                            <label for="sales_commission" class="block text-sm font-medium text-gray-700 mb-1">Sales Commission (%)</label>
                            <input type="text" id="sales_commission" name="sales_commission"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                value="{{ $invoice->sales_commission ?? '' }}" autocomplete="off" oninput="formatInputNumber(this)" />
                        </div>
                        

                        <hr class="my-2">

                        <button class="bg-blue-500 text-white py-2 px-4 rounded-lg mt-4 w-full"
                            onclick="openConfirmationModal()">
                            {{ isset($invoice) ? 'Update' : 'Create' }}
                        </button>
                    </div>
                </div>
                <div class="md:w-1/4">
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-lg font-semibold mb-4">Invoice Summary</h2>
                        <div class="flex justify-between mb-1">
                            <span>Transaction Amount</span>
                            <span id="transaction_amount">Rp.
                                {{ isset($invoice) ? number_format($invoice->amount, 0) : '0' }}</span>
                        </div>
                        <div class="flex justify-between mb-1">
                            <span>Payment Gateway</span>
                            <span id="payment_gateway">Rp.
                                {{ isset($invoice) ? number_format($invoice->netto, 0) : '0' }}</span>
                        </div>
                        <div class="flex justify-between mb-1">
                            <span>Tax</span>
                            <span id="tax_price">Rp.
                                {{ isset($invoice) ? number_format($invoice->tax_price(), 0) : '0' }}</span>
                        </div>
                        <div class="flex justify-between mb-1">
                            <span>Fee</span>
                            <span id="fee_price">Rp.
                                {{ isset($invoice) ? number_format($invoice->fee_price(), 0) : '0' }}</span>
                        </div>
                        <div class="flex justify-between mb-1">
                            <span>Sales</span>
                            <span id="sales_price">Rp.
                                {{ isset($invoice) ? number_format($invoice->sales_price(), 0) : '0' }}</span>
                        </div>
                        <div class="flex justify-between mb-1">
                            <span>Customer</span>
                            <span id="cust_price">Rp.
                                {{ isset($invoice) ? number_format($invoice->cust_netto(), 0) : '0' }}</span>
                        </div>
                        <hr class="my-2">
                        <div class="flex justify-between mb-2">
                            <span class="font-semibold">Profit</span>
                            <span class="font-semibold" id="total">Rp.
                                {{ isset($invoice) ? number_format($invoice->profit()) : '0' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Modal -->
        <div id="productModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden">
            <div class="bg-white rounded-lg shadow-lg p-6 w-1/2">
                <h3 class="text-lg font-semibold mb-4">Select Product</h3>
                <ul id="productList" class="divide-y divide-gray-200">
                    <!-- Dynamically load products here -->
                </ul>
                <button id="closeProductModal"
                    class="mt-4 bg-red-500 hover:bg-red-600 text-white font-medium py-2 px-4 rounded-lg">
                    Close
                </button>
            </div>
        </div>

        <div id="confirmationModal"
            class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center hidden">
            <div class="bg-white p-6 rounded-lg shadow-lg w-96">
                <h2 class="text-xl font-semibold mb-4">Confirm Action</h2>
                <p class="mb-6">Are you sure you want to proceed?</p>
                <div class="flex justify-end">
                    <button class="bg-gray-300 text-gray-800 py-2 px-4 rounded-lg mr-2"
                        onclick="closeConfirmationModal()">
                        Cancel
                    </button>
                    <button class="bg-blue-500 text-white py-2 px-4 rounded-lg" onclick="confirmCheckout()">
                        Confirm
                    </button>
                </div>
            </div>
        </div>

        <div id="successModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
            <div class="bg-white rounded-lg shadow-lg p-6 max-w-md w-full relative">
                <!-- Close Button (Top-Right) -->
                <button 
                    id="closeSuccessModal" 
                    class="absolute top-2 right-2 text-gray-400 hover:text-gray-600 focus:outline-none"
                    aria-label="Close modal"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
        
                <!-- Modal Content -->
                <h2 class="text-lg font-semibold text-gray-800 mb-4" id="modalMessage"></h2>
                <div class="flex items-center gap-4">
                    <input 
                        type="text" 
                        id="modalInvoiceCode" 
                        readonly 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md text-gray-800"
                    />
                    <button 
                        id="copyButton" 
                        class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300"
                    >
                        Copy
                    </button>
                </div>
            </div>
        </div>

    </div>

    <script>
        // Initialize an array to store products in the cart
        let productsInCart = [];
        @if (isset($invoice) && isset($invoice->invoice_detail))
            @foreach ($invoice->invoice_detail as $item)
                productsInCart.push({
                    id: "{{ $item->product_id }}",
                    name: "{{ $item->product_name }}", // Wrap strings in quotes
                    price: {{ $item->price }}, // Numbers are fine without quotes
                    qty: {{ $item->qty }} // Numbers are fine without quotes
                });
            @endforeach
        @endif

        // Get input elements
        const amountInput = document.getElementById("amount");
        const paymentByInput = document.getElementById("payment_by");
        const nettoInput = document.getElementById("netto");
        const taxInput = document.getElementById("tax");
        const feeInput = document.getElementById("fee");
        const salesCommissionInput = document.getElementById("sales_commission");

        // Get span elements
        const transactionAmountSpan = document.getElementById("transaction_amount");
        const paymentGatewaySpan = document.getElementById("payment_gateway");
        const taxPriceSpan = document.getElementById("tax_price");
        const feePriceSpan = document.getElementById("fee_price");
        const salesPriceSpan = document.getElementById("sales_price");
        const custPriceSpan = document.getElementById("cust_price");
        const totalProfitSpan = document.getElementById("total");

        function calculateAndUpdate() {
            const orderAmount = parseFloat(amountInput.value.replace(/[^0-9.]/g, '')) || 0
            const netto = parseFloat(nettoInput.value.replace(/[^0-9.]/g, '')) || 0;
            const tax = parseFloat(taxInput.value.replace(/[^0-9.]/g, '')) || 0;
            const fee = parseFloat(feeInput.value.replace(/[^0-9.]/g, '')) || 0;
            const salesCommission = parseFloat(salesCommissionInput.value.replace(/[^0-9.]/g, '')) || 0;

            // Perform calculations
            const taxPrice = (tax / 100) * orderAmount;
            const feePrice = (fee / 100) * orderAmount;
            const custNetto = orderAmount - taxPrice - feePrice;
            const salesPrice = (feePrice * salesCommission) / 100;
            const profit = netto - custNetto - salesPrice;

            // Update spans
            transactionAmountSpan.textContent = formatNumber(orderAmount);
            paymentGatewaySpan.textContent = formatNumber(netto);
            taxPriceSpan.textContent = formatNumber(taxPrice);
            feePriceSpan.textContent = formatNumber(feePrice);
            salesPriceSpan.textContent = formatNumber(salesPrice);
            custPriceSpan.textContent = formatNumber(custNetto);
            totalProfitSpan.textContent = formatNumber(profit);
        }

        // Attach event listeners to inputs
        amountInput.addEventListener("input", calculateAndUpdate);
        nettoInput.addEventListener("input", calculateAndUpdate);
        taxInput.addEventListener("input", calculateAndUpdate);
        feeInput.addEventListener("input", calculateAndUpdate);
        salesCommissionInput.addEventListener("input", calculateAndUpdate);

        // Initial calculation
        calculateAndUpdate();

        // Format number with commas as separator
        function formatNumber(number) {
            // Format the number with commas for thousands separator and no decimals
            const integerNumber = Math.floor(number);
            const formattedNumber = integerNumber.toLocaleString('en-US', {
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            });

            // Return the formatted number with "Rp." at the front
            return `Rp. ${formattedNumber}`;
        }

        function formatInputNumber(input) {
            // Remove any non-digit characters except periods
            let value = input.value.replace(/[^0-9.]/g, '');
            
            // Split the value into integer and decimal parts
            const parts = value.split('.');
            parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ','); // Add commas to the integer part

            // Rejoin the integer and decimal parts (if any)
            input.value = parts.join('.');
        }

        // Update totals: Subtotal, Taxes, Total
        function updateTotals(isResult = true) {
            let subtotal = 0;

            // Calculate the subtotal based on products in the cart
            productsInCart.forEach(product => {
                // Find the product row by ID
                const row = document.querySelector(`#product-row-${product.id}`);
                const qty = parseInt(row.querySelector("input[name='qty']").value);
                subtotal += product.price * qty;
            });

            // Calculate taxes (example 10%)
            const taxes = subtotal * 0.1;
            const total = subtotal;

            if (isResult == false) {
                return subtotal;
            }

            // Update the UI with formatted values
            document.getElementById("subtotal").textContent = formatNumber(subtotal);
            document.getElementById("total").textContent = formatNumber(total);
        }

        // Modal Logic for Products (For Adding Products)
        const productModal = document.getElementById("productModal");
        const closeProductModal = document.getElementById("closeProductModal");
        const productList = document.getElementById("productList");

        closeProductModal.addEventListener("click", () => {
            productModal.classList.add("hidden");
        });

        // When a product is added to the cart


        // Get references to the input field and the suggestions list
        const salesInput = document.getElementById('sales');
        const salesSuggestions = document.getElementById('salesSuggestions');
        const salesId = document.getElementById('salesPersonId')

        // Event listener for input changes
        salesInput.addEventListener('input', async () => {
            const query = salesInput.value.trim();

            if (query.length >= 2) { // Start searching after 2 characters
                try {
                    // Fetch the sales persons based on the input value
                    const response = await fetch("{{ route('sales-persons-ajax') }}?query=" + query);
                    const sales = await response.json();

                    // Clear previous suggestions
                    salesSuggestions.innerHTML = '';

                    // Show suggestions if there are any results
                    if (sales.length > 0) {
                        salesSuggestions.classList.remove('hidden');
                        sales.forEach(sale => {
                            const suggestionItem = document.createElement('li');
                            suggestionItem.textContent = sale
                                .name; // Adjust according to the data returned

                            suggestionItem.classList.add('py-2', 'px-3', 'cursor-pointer', 'max-w-full',
                                'truncate');

                            // Event listener for selecting a suggestion
                            suggestionItem.addEventListener('click', () => {
                                salesInput.value = sale
                                    .name; // Set the selected name in the input field
                                salesId.value = sale.id;
                                salesCommissionInput.value = sale.commission;
                                salesSuggestions.classList.add('hidden'); // Hide suggestions
                                updateTotals();
                            });

                            salesSuggestions.appendChild(suggestionItem);
                        });
                    } else {
                        salesSuggestions.classList.add('hidden');
                    }
                } catch (error) {
                    console.error('Error fetching sales:', error);
                }
            } else {
                salesSuggestions.classList.add('hidden');
            }
        });

        // Close suggestions when clicking outside the input or suggestions list
        document.addEventListener('click', (event) => {
            if (!salesInput.contains(event.target) && !salesSuggestions.contains(event.target)) {
                salesSuggestions.classList.add('hidden');
            }
        });

        function openConfirmationModal() {
            document.getElementById("confirmationModal").classList.remove("hidden");
        }

        function closeConfirmationModal() {
            document.getElementById("confirmationModal").classList.add("hidden");
        }


        async function confirmCheckout() {
                let salesId = document.getElementById('salesPersonId').value;
                const salesName = document.getElementById('sales').value;
                if (salesName == '' || salesName == null){
                    salesId = null;
                }

                // const expireDate = document.getElementById('expire_date').value;
                const tax = taxInput.value.replace(/[^0-9.]/g, '');
                const fee = feeInput.value.replace(/[^0-9.]/g, '');
                const netto = nettoInput.value.replace(/[^0-9.]/g, '');
                const commission = salesCommissionInput.value.replace(/[^0-9.]/g, '');
                const amount = amountInput.value.replace(/[^0-9.]/g, '');
                const paymentBy = paymentByInput.value;

                try {
                    @if (isset($invoice) && isset($invoice->id))
                        const response = await fetch("{{ route('update-invoice-manual', ['invoice' => $invoice->id]) }}", {
                            @else
                                const response = await fetch("{{ route('store-invoice-admin-manual') }}", {
                                    @endif
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    },
                                    body: JSON.stringify({
                                        // name,
                                        // address,
                                        // phone,
                                        // productsInCart,
                                        salesId,
                                        paymentBy,
                                        amount,
                                        tax,
                                        fee,
                                        netto,
                                        commission
                                    })
                                });

                            if (response.ok) {
                                const result = await response.json();
                                if (result.status === "success") {
                                    closeConfirmationModal();
                                    openSuccessModal(result.message, result.invoice_code);
                                } else {
                                    Swal.fire({
                                        icon: result.status,
                                        title: result.status,
                                        text: result.message,
                                        showConfirmButton: false,
                                        timer: 2000
                                    });
                                }

                            } else {
                                alert('Failed to create invoice. Please try again.');
                            }
                        }
                        catch (error) {
                            alert('An error occurred. Please try again later.');
                        }
                    }

                    function openSuccessModal(message, invoiceCode) {
                        const modal = document.getElementById('successModal');
                        const modalMessage = document.getElementById('modalMessage');
                        const modalInvoiceCode = document.getElementById('modalInvoiceCode');

                        // Set the message and invoice code
                        modalMessage.textContent = message;
                        modalInvoiceCode.value = "https://linkbayar.my.id/?inv_code=" + invoiceCode;

                        // Show the modal
                        modal.classList.remove('hidden');

                        // Add event listener for the copy button
                        document.getElementById('copyButton').addEventListener('click', () => {
                            modalInvoiceCode.select();
                            document.execCommand('copy');

                            // Show SweetAlert toast
                            Swal.fire({
                                toast: true,
                                icon: 'success',
                                title: 'Copied',
                                position: 'bottom',
                                showConfirmButton: false,
                                timer: 1500,
                            });
                        });

                        // Close the modal
                        document.getElementById('closeSuccessModal').addEventListener('click', () => {
                            modal.classList.add('hidden');
                            window.location.href = "{{ route('admin-panel') }}";
                        });
                    }
    </script>
@endsection

{{-- <div class="md:w-1/4">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-lg font-semibold mb-4">Summary</h2>
                    <div class="flex justify-between mb-2">
                        <span>Subtotal</span>
                        <span>$19.99</span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span>Taxes</span>
                        <span>$1.99</span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span>Shipping</span>
                        <span>$0.00</span>
                    </div>
                    <hr class="my-2">
                    <div class="flex justify-between mb-2">
                        <span class="font-semibold">Total</span>
                        <span class="font-semibold">$21.98</span>
                    </div>
                    <button class="bg-blue-500 text-white py-2 px-4 rounded-lg mt-4 w-full">Checkout</button>
                </div>
            </div> --}}
