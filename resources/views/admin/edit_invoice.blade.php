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
                <!-- Sales Input Section (3/4 width) -->
                <div class="md:w-3/4">
                    <div class="bg-white rounded-lg shadow-md p-6 mb-4">
                        <label for="sales" class="block text-sm font-medium text-gray-600">Sales</label>
                        <input type="text" id="sales" name="sales" placeholder="Search sales..."
                            class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 text-gray-800 text-sm py-2 px-3"
                            autocomplete="off"
                            value="{{ $invoice->sales_person_id != null ? $invoice->sales_person->name : null }}" />
                        <ul id="salesSuggestions"
                            class="absolute bg-white border border-gray-300 rounded-lg shadow-lg mt-1 w-full hidden"></ul>
                        <input type="hidden" name="salesPersonId" id="salesPersonId"
                            value="{{ $invoice->sales_person_id }}">
                    </div>

                    <!-- Products Table Section -->
                    <div class="bg-white rounded-lg shadow-md p-6 mb-4">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-lg font-semibold">Products</h2>
                            <button id="openProductModal"
                                class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg">
                                Add Product
                            </button>
                        </div>

                        <table class="w-full">
                            <thead>
                                <tr>
                                    <th class="text-left font-semibold" style="width: 40%;">Product</th>
                                    <th class="text-left font-semibold" style="width: 20%;">Price</th>
                                    <th class="text-left font-semibold" style="width: 15%;">Quantity</th>
                                    <th class="text-left font-semibold" style="width: 15%;">Total</th>
                                    <th class="text-left font-semibold" style="width: 10%;">Action</th>
                                </tr>
                            </thead>
                            <tbody id="productTableBody">
                                @foreach ($invoice->invoice_detail as $item)
                                    <tr id="product-row-{{ $item->product_id }}">
                                        <td class="py-4">{{ $item->product_name }}</td>
                                        <td class="py-4">Rp. {{ number_format($item->price, 0) }}</td>
                                        <td class="py-4">
                                            <input type="number" name="qty" class="w-16 border rounded-lg py-1 px-2"
                                                value="{{ $item->qty }}" data-price="{{ $item->price }}" />
                                        </td>
                                        <td class="py-4"><span class="product-total">Rp.
                                                {{ number_format($item->qty * $item->price, 0) }}</span>
                                        </td>
                                        <td class="py-4">
                                            <button
                                                class="bg-red-500 hover:bg-red-600 text-white py-1 px-3 rounded-lg removeProductButton">Remove</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Summary Section (1/4 width) -->
                <div class="md:w-1/4">
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-lg font-semibold mb-4">Invoice Data</h2>

                        <!-- Datetime Input -->
                        <div class="mb-4">
                            <label for="expire_date" class="block text-sm font-medium text-gray-700 mb-1">Expire
                                Date</label>
                            <input type="datetime-local" id="expire_date" name="expire_date"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                value="{{ $invoice->expire_date }}">
                        </div>

                        <div class="flex justify-between mb-2">
                            <span>Subtotal</span>
                            <span id="subtotal">Rp. {{ number_format($invoice->amount, 0) }}</span>
                        </div>
                        <div class="mb-4">
                            <label for="payment_by" class="block text-sm font-medium text-gray-700 mb-1">Payment
                                Gateway Type</label>
                            <input type="text" id="payment_by" name="payment_by"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                value="{{ $invoice->payment_by }}" autocomplete="off" placeholder="Akulaku, Kredivo, Shoppee Etc">
                        </div>
                        <div class="mb-4">
                            <label for="netto" class="block text-sm font-medium text-gray-700 mb-1">Payment
                                Gateway</label>
                            <input type="number" id="netto" name="netto"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                value="{{ $invoice->netto }}" autocomplete="off">
                        </div>
                        <div class="mb-4">
                            <label for="tax" class="block text-sm font-medium text-gray-700 mb-1">Adm / Tax (%)</label>
                            <input type="number" id="tax" name="tax"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                value="{{ $invoice->tax }}" autocomplete="off">
                        </div>
                        <div class="mb-4">
                            <label for="fee" class="block text-sm font-medium text-gray-700 mb-1">Fee Layanan
                                (%)</label>
                            <input type="number" id="fee" name="fee"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                value="{{ $invoice->fee }}" autocomplete="off">
                        </div>
                        <div class="mb-4">
                            <label for="sales_commission" class="block text-sm font-medium text-gray-700 mb-1">Sales
                                Commission(%)</label>
                            <input type="number" id="sales_commission" name="sales_commission"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                value="{{ $invoice->sales_commission }}" autocomplete="off">
                        </div>
                        <hr class="my-2">
                        <div class="flex justify-between mb-1">
                            <span>Payment Gateway</span>
                            <span id="payment_gateway">Rp. {{ number_format($invoice->netto, 0) }}</span>
                        </div>
                        <div class="flex justify-between mb-1">
                            <span>Tax</span>
                            <span id="tax_price">Rp. {{ number_format($invoice->tax_price(), 0) }}</span>
                        </div>
                        <div class="flex justify-between mb-1">
                            <span>Fee</span>
                            <span id="fee_price">Rp. {{ number_format($invoice->fee_price(), 0) }}</span>
                        </div>
                        <div class="flex justify-between mb-1">
                            <span>Sales</span>
                            <span id="sales_price">Rp. {{ number_format($invoice->sales_price(), 0) }}</span>
                        </div>
                        <div class="flex justify-between mb-1">
                            <span>Customer</span>
                            <span id="cust_price">Rp. {{ number_format($invoice->cust_netto(), 0) }}</span>
                        </div>
                        <hr class="my-2">
                        <div class="flex justify-between mb-2">
                            <span class="font-semibold">Profit</span>
                            <span class="font-semibold" id="total">Rp. {{ number_format($invoice->profit()) }}</span>
                        </div>
                        <button class="bg-blue-500 text-white py-2 px-4 rounded-lg mt-4 w-full"
                            onclick="openConfirmationModal()">
                            Update
                        </button>
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

    </div>

    <script>
        // Initialize an array to store products in the cart
        let productsInCart = [];
        @foreach ($invoice->invoice_detail as $item)
            productsInCart.push({
                id: "{{ $item->product_id }}",
                name: "{{ $item->product_name }}", // Wrap strings in quotes
                price: {{ $item->price }}, // Numbers are fine without quotes
                qty: {{ $item->qty }} // Numbers are fine without quotes
            });
        @endforeach

        // Get input elements
        const paymentByInput = document.getElementById("payment_by");
        const nettoInput = document.getElementById("netto");
        const taxInput = document.getElementById("tax");
        const feeInput = document.getElementById("fee");
        const salesCommissionInput = document.getElementById("sales_commission");

        // Get span elements
        const paymentGatewaySpan = document.getElementById("payment_gateway");
        const taxPriceSpan = document.getElementById("tax_price");
        const feePriceSpan = document.getElementById("fee_price");
        const salesPriceSpan = document.getElementById("sales_price");
        const custPriceSpan = document.getElementById("cust_price");
        const totalProfitSpan = document.getElementById("total");

        function calculateAndUpdate(){ 
            const orderAmount = updateTotals(false) || 0
            const netto = parseFloat(nettoInput.value) || 0;
            const tax = parseFloat(taxInput.value) || 0;
            const fee = parseFloat(feeInput.value) || 0;
            const salesCommission = parseFloat(salesCommissionInput.value) || 0;

            // Perform calculations
            const taxPrice = (tax / 100) * orderAmount;
            const feePrice = (fee / 100) * orderAmount;
            const custNetto = orderAmount - taxPrice - feePrice;
            const salesPrice = (feePrice * salesCommission) / 100;
            const profit = netto - custNetto - salesPrice;

            // Update spans
            paymentGatewaySpan.textContent = formatNumber(netto);
            taxPriceSpan.textContent = formatNumber(taxPrice);
            feePriceSpan.textContent = formatNumber(feePrice);
            salesPriceSpan.textContent = formatNumber(salesPrice);
            custPriceSpan.textContent = formatNumber(custNetto);
            totalProfitSpan.textContent = formatNumber(profit);
        }

        // Attach event listeners to inputs
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

            if(isResult == false){
                return subtotal;
            }

            // Update the UI with formatted values
            document.getElementById("subtotal").textContent = formatNumber(subtotal);
            document.getElementById("total").textContent = formatNumber(total);
        }

        // Modal Logic for Products (For Adding Products)
        const productModal = document.getElementById("productModal");
        const openProductModal = document.getElementById("openProductModal");
        const closeProductModal = document.getElementById("closeProductModal");
        const productList = document.getElementById("productList");
        const productTableBody = document.getElementById("productTableBody");

        openProductModal.addEventListener("click", async () => {
            productModal.classList.remove("hidden");
            const response = await fetch("{{ route('products-ajax') }}");
            const products = await response.json();
            productList.innerHTML = products
                .map(
                    (product) =>
                    `<li class="py-4 flex justify-between items-center">
                        <div>
                            <p class="font-semibold">${product.name}</p>
                            <p class="text-sm text-gray-600">${formatNumber(product.price)}</p>
                        </div>
                        <button class="bg-blue-500 hover:bg-blue-600 text-white py-1 px-3 rounded-lg addProductButton" data-id="${product.id}" data-name="${product.name}" data-price="${product.price}">
                            Pick
                        </button>
                    </li>`
                )
                .join("");
        });

        closeProductModal.addEventListener("click", () => {
            productModal.classList.add("hidden");
        });

        // When a product is added to the cart
        productList.addEventListener("click", (event) => {
            if (event.target.classList.contains("addProductButton")) {
                const productId = event.target.dataset.id;
                const productName = event.target.dataset.name;
                const productPrice = parseFloat(event.target.dataset.price);

                // Check if product already exists in the cart
                const productIndex = productsInCart.findIndex(product => product.id === productId);

                if (productIndex !== -1) {
                    // Product already exists in the cart, increase the quantity by 1
                    productsInCart[productIndex].qty += 1;

                    // Update the quantity in the existing row
                    const qtyInput = document.querySelector(`#product-row-${productId} input[name="qty"]`);
                    qtyInput.value = productsInCart[productIndex].qty;

                    // Update the total for the existing row
                    const productTotal = document.querySelector(`#product-row-${productId} .product-total`);
                    productTotal.textContent = formatNumber(productsInCart[productIndex].price * productsInCart[
                        productIndex].qty);
                } else {
                    // Product doesn't exist, add it to the cart
                    productsInCart.push({
                        id: productId,
                        name: productName,
                        price: productPrice,
                        qty: 1
                    });

                    // Add product to table (new row creation)
                    const newRow = `
                <tr id="product-row-${productId}">
                    <td class="py-4">${productName}</td>
                    <td class="py-4">${formatNumber(productPrice)}</td>
                    <td class="py-4">
                        <input type="number" name="qty" class="w-16 border rounded-lg py-1 px-2" value="1" data-price="${productPrice}" />
                    </td>
                    <td class="py-4"><span class="product-total">${formatNumber(productPrice)}</span></td>
                    <td class="py-4">
                        <button class="bg-red-500 hover:bg-red-600 text-white py-1 px-3 rounded-lg removeProductButton">Remove</button>
                    </td>
                </tr>
            `;

                    // Append row to the product table
                    productTableBody.insertAdjacentHTML("beforeend", newRow);
                }

                // Update totals after adding or updating a product
                updateTotals();
                calculateAndUpdate();
                productModal.classList.add("hidden");
            }
        });


        // Update total when quantity is changed
        productTableBody.addEventListener("input", (event) => {
            if (event.target.name === "qty") {
                const qty = parseInt(event.target.value);
                const price = parseFloat(event.target.dataset.price);
                const row = event.target.closest("tr");
                const totalElem = row.querySelector(".product-total");

                // Get the product ID from the row's ID or another attribute
                const productId = parseInt(row.id.replace("product-row-", ""));

                if (!isNaN(qty) && qty > 0) {
                    const total = qty * price;
                    totalElem.textContent = formatNumber(total);

                    // Update the qty in productsInCart
                    const product = productsInCart.find((p) => p.id === productId);
                    if (product) {
                        product.qty = qty;
                    }

                    // Update totals (function assumed to exist)
                    updateTotals();
                    calculateAndUpdate();
                }
            }
        });

        // Remove product from cart
        productTableBody.addEventListener("click", (event) => {
            if (event.target.classList.contains("removeProductButton")) {
                const row = event.target.closest("tr");
                const productId = row.id.replace('product-row-', '');
                row.remove();

                // Remove product from productsInCart
                productsInCart = productsInCart.filter(
                    (product) => product.id !== productId
                );

                // Update totals after removing a product
                updateTotals();
                calculateAndUpdate();
            }
        });

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
            const expireDate = document.getElementById('expire_date').value;
            const tax = taxInput.value;
            const fee = feeInput.value;
            const netto = nettoInput.value;
            const commission = salesCommissionInput.value;
            const paymentBy = paymentByInput.value;

            try {
                const response = await fetch("{{ route('update-invoice', ['invoice' => $invoice->id]) }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        // name,
                        // address,
                        // phone,
                        productsInCart,
                        salesId,
                        expireDate,
                        tax,
                        fee,
                        netto,
                        commission,
                        paymentBy
                    })
                });

                if (response.ok) {
                    const result = await response.json();
                    if (result.status === "success") {
                        Swal.fire({
                            icon: result.status,
                            title: result.status,
                            text: result.message,
                            showConfirmButton: false,
                            timer: 2000
                        }).then(() => {
                            // Redirect after the modal closes
                            window.location.href = "{{ route('admin-panel') }}";
                        });
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
            } catch (error) {
                alert('An error occurred. Please try again later.');
            }
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
