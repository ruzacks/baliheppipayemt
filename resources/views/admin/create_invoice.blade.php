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
                            autocomplete="off" />
                        <ul id="salesSuggestions"
                            class="absolute bg-white border border-gray-300 rounded-lg shadow-lg mt-1 w-full hidden"></ul>
                        <input type="hidden" name="salesPersonId" id="salesPersonId">
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
                                <!-- Dynamically added rows will appear here -->
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
                            <label for="expire_date" class="block text-sm font-medium text-gray-700 mb-1">Expire Date(Minutes)</label>
                            <input type="number" id="expire_date" name="expire_date"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                value="60">
                        </div>

                        <div class="flex justify-between mb-2">
                            <span>Subtotal</span>
                            <span id="subtotal">Rp. 0</span>
                        </div>
                        <hr class="my-2">
                        <div class="flex justify-between mb-2">
                            <span class="font-semibold">Total</span>
                            <span class="font-semibold" id="total">Rp. 0</span>
                        </div>
                        <button class="bg-blue-500 text-white py-2 px-4 rounded-lg mt-4 w-full"
                            onclick="openConfirmationModal()">
                            Create
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

        <div id="confirmationModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center hidden">
            <div class="bg-white p-6 rounded-lg shadow-lg w-96">
                <h2 class="text-xl font-semibold mb-4">Confirm Action</h2>
                <p class="mb-6">Are you sure you want to proceed?</p>
                <div class="flex justify-end">
                    <button class="bg-gray-300 text-gray-800 py-2 px-4 rounded-lg mr-2" onclick="closeConfirmationModal()">
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

        // Initialize an array to store products in the cart
        let productsInCart = [];

        // Update totals: Subtotal, Taxes, Total
        function updateTotals() {
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

                // Add product to table and cart array
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

                productTableBody.insertAdjacentHTML("beforeend", newRow);
                const productIndex = productsInCart.findIndex(product => product.id === productId);

                if (productIndex !== -1) {
                    // Product already exists in the cart, increase the quantity by 1
                    productsInCart[productIndex].qty += 1;
                } else {
                    // Product doesn't exist, add it to the cart
                    productsInCart.push({
                        id: productId,
                        name: productName,
                        price: productPrice,
                        qty: 1
                    });
                }

                // Update totals after adding a product
                updateTotals();
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
                    const product = productsInCart.find((p) => parseInt(p.id) === productId);
                    if (product) {
                        product.qty = qty;
                    }

                    // Update totals (function assumed to exist)
                    updateTotals();
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

            try {
                const response = await fetch("{{ route('create-invoice') }}", {
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
                    })
                });

                if (response.ok) {
                    const result = await response.json();
                    if (result.status === "success") {
                        closeConfirmationModal();
                        openSuccessModal(result.message, result.invoice_code);
                    }
                    else {
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
