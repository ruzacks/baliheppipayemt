@extends('layout.customer-layout')

@section('main')
    {{-- <div class="w-full px-4 py-6">
    <div class="mb-6 text-center">
        <h1 class="text-2xl font-bold text-gray-800">Pilihan Product</h1>
    </div>

    <div class="mb-4 text-right">
        <button 
            onclick="toggleModal('cartModal')" 
            class="inline-block rounded-lg bg-blue-500 px-4 py-2 text-sm font-medium text-white hover:bg-blue-600"
        >
            View Cart
        </button>
    </div>

    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
        @foreach ($products as $product)
        <div class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow hover:shadow-lg">
            <a href="{{ route('product-single', $product->id) }}" class="block">
                <div class="aspect-w-1 aspect-h-1 w-full overflow-hidden">
                    <img 
                        src="https://www.static-src.com/wcsstore/Indraprastha/images/catalog/full//catalog-image/100/MTA-150688314/no-brand_no-brand_full01.jpg" 
                        alt="{{ $product->name }}" 
                        class="object-cover w-full h-full"
                    />
                </div>
                <div class="p-4">
                    <h2 class="text-lg font-medium text-gray-800">{{ $product->name }}</h2>
                </div>
            </a>
            <div class="p-4">
                <p class="text-gray-600">Rp.  {{ number_format($product->price, 0, ',', '.') }}</p>
                <div class="mt-3 text-center">
                    <button 
                        onclick="addToCart({{ $product->id }}, '{{ $product->name }}', {{ $product->price }})" 
                        class="inline-block rounded-lg bg-green-500 px-4 py-2 text-sm font-medium text-white hover:bg-green-600"
                    >
                        Add to Cart
                    </button>
                </div>
            </div>
        </div>
        
        @endforeach
    </div>
</div> --}}

    <div class="mb-6 text-center">
        <h1 class="text-2xl font-bold text-gray-800">Pilihan Product</h1>
    </div>

    <section id="Projects"
        class="w-fit mx-auto grid grid-cols-1 lg:grid-cols-4 md:grid-cols-2 justify-items-center justify-center gap-y-20 gap-x-14 mt-10 mb-5">


        @foreach ($products as $product)
            <!--   ✅ Product card 1 - Starts Here 👇 -->
            <div class="w-72 bg-white shadow-md rounded-xl duration-500 hover:scale-105 hover:shadow-xl">
                <a href="{{ route('product-single', $product->id) }}">
                    @if($product->image_url)
                        @if(filter_var($product->image_url, FILTER_VALIDATE_URL))
                            <!-- If image_url is a full URL -->
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="h-80 w-72 object-cover rounded-t-xl">
                        @else
                            <!-- If image_url is a file path -->
                            <img src="{{ asset('storage/app/public/' . $product->image_url) }}" alt="{{ $product->name }}" class="h-80 w-72 object-cover rounded-t-xl">
                        @endif
                    @else
                    <img src="https://www.static-src.com/wcsstore/Indraprastha/images/catalog/full//catalog-image/100/MTA-150688314/no-brand_no-brand_full01.jpg"
                    alt="Product" class="h-80 w-72 object-cover rounded-t-xl" />
                    @endif
                </a>
                <div class="px-4 py-3 w-72">
                    {{-- <span class="text-gray-400 mr-3 uppercase text-xs">Brand</span> --}}
                    <a href="{{ route('product-single', $product->id) }}">
                        <p class="text-lg font-bold text-black truncate block capitalize">{{ $product->name }}</p>
                    </a>
                    <div class="flex items-center">
                        <p class="text-lg font-semibold text-black cursor-auto my-3">Rp.
                            {{ number_format($product->price, 0, ',', '.') }}</p>
                        {{-- <del>
                    <p class="text-sm text-gray-600 cursor-auto ml-2">$199</p>
                </del> --}}
                        <div class="ml-auto">
                            <button data-id="{{ $product->id }}" data-name="{{ $product->name }}"
                                data-price="{{ $product->price }}" fill="currentColor"
                                class="w-full bg-gray-900 dark:bg-gray-600 text-white py-1.5 px-3 rounded-full text-sm font-semibold hover:bg-gray-800 dark:hover:bg-gray-700 add-to-cart"
                                viewBox="0 0 16 16">
                                Add To Cart
                            </button>
                        </div>
                    </div>
                </div>

            </div>
            <!--   🛑 Product card 1 - Ends Here  -->
        @endforeach


    </section>


    <!-- Cart Modal -->
    <div id="cartModal" class="fixed inset-0 hidden bg-gray-900 bg-opacity-50">
        <div class="relative mx-auto mt-24 w-11/12 max-w-2xl rounded-lg bg-white p-6">
            <h2 class="text-lg font-bold">Shopping Cart</h2>
            <div id="cartItems" class="mt-4"></div>
            <div class="mt-6 text-right">
                <button onclick="toggleModal('cartModal')" class="mr-2 rounded bg-gray-300 px-4 py-2">Close</button>
                <button onclick="toggleModal('custDataModal')"
                    class="rounded bg-blue-500 px-4 py-2 text-white">Checkout</button>
            </div>
        </div>
    </div>

    <!-- Checkout Modal -->
    <!-- Modal -->
    <div id="checkoutModal" class="fixed inset-0 z-50 hidden h-full w-full overflow-y-auto bg-gray-900 bg-opacity-50">
        <div class="relative mx-auto mt-24 w-11/12 max-w-lg rounded-lg bg-white shadow-lg">
            <!-- Modal Header -->
            <div class="flex items-center justify-between rounded-t-md border-b-2 border-gray-200 p-4">
                <h5 class="text-lg font-bold text-gray-800">
                    Checkout
                </h5>
                <button type="button" class="text-gray-500 hover:text-gray-800" onclick="toggleModal('checkoutModal')">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="relative max-h-[60vh] overflow-y-auto p-4">
                <h2 class="text-lg font-bold mb-6">Choose Your Payment Method</h2>

                <!-- Virtual Account Section -->
                <details class="mb-4">
                    <summary class="bg-gray-200 p-4 rounded-lg cursor-pointer shadow-md">
                        <span class="font-semibold">Virtual Account</span>
                    </summary>
                    <ul class="mt-2 space-y-2">
                        <li>
                            <button
                                class="flex items-center justify-between w-full border rounded-md p-2 hover:bg-gray-100">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/5/5c/Bank_Central_Asia.svg" alt="BCA" class="h-6">
                                <span class="font-medium text-gray-800">BCA Virtual Account</span>
                            </button>
                        </li>
                        <!-- Add other payment methods here -->
                    </ul>
                </details>

                <!-- Other sections -->
                <details class="mb-4">
                    <summary class="bg-gray-200 p-4 rounded-lg cursor-pointer shadow-md">
                        <span class="font-semibold">Internet Banking</span>
                    </summary>
                    <ul class="mt-2 space-y-2">
                        <li>
                            <button
                                class="flex items-center justify-between w-full border rounded-md p-2 hover:bg-gray-100">
                                <img src="https://whatthelogo.com/storage/logos/quick-response-code-indonesia-standard-qris-274928.png" alt="BCA" class="h-6">
                                <span class="font-medium text-gray-800">QRIS</span>
                            </button>
                        </li>
                        <li>
                            <button class="flex items-center justify-between w-full border rounded-md p-2 hover:bg-gray-100">
                                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcThBU-nZdrzapGQLA8dnPcXpqyCVgFH2YTmWw&s" alt="BCA" class="max-h-6">
                                <span class="font-medium text-gray-800">Akulaku</span>
                            </button>
                        </li>
                        <li>
                            <button class="flex items-center justify-between w-full border rounded-md p-2 hover:bg-gray-100">
                                <img src="https://afpi.or.id/fm/Members/4031_a9d7856fce7.png" alt="BCA" class="max-h-6">
                                <span class="font-medium text-gray-800">indodana</span>
                            </button>
                        </li>
                        <li>
                            <button class="flex items-center justify-between w-full border rounded-md p-2 hover:bg-gray-100">
                                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRCIt3xmqpeMYo8VsFgFdMoZ4pIVdcmh0HSmQ&s" alt="BCA" class="max-h-6">
                                <span class="font-medium text-gray-800">Kredivo</span>
                            </button>
                        </li>
                        <li>
                            <button class="flex items-center justify-between w-full border rounded-md p-2 hover:bg-gray-100">
                                <img src="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEjC8J0HHOLKSppss14Im84sOJ5D-qB0LAKsxZ8esss0VNs2LJhNYR4S9KCDV7q-U332uEe9BlF1E7rzW6tqvrZfGiivxobhls2I2E9dWgok7LzdJuNOp_s-h4RmUvc4ENhs-RZ9hVEgrPkK9DUlTvhzOFY-WW0CYEAI_xgSFRjmLLYf77QOxNC5yg/w320-h141/ShopeePay%20Logo%20-%20%20(Koleksilogo.com).png" alt="BCA" class="max-h-6">
                                <span class="font-medium text-gray-800">Shopee Pay</span>
                            </button>
                        </li>
                        
                        
                    </ul>
                </details>

                {{-- <details class="mb-4">
                    <summary class="bg-gray-200 p-4 rounded-lg cursor-pointer shadow-md">
                        <span class="font-semibold">Mobile Banking</span>
                    </summary>
                    <ul class="mt-2 space-y-2">
                        <li>
                            <button
                                class="flex items-center justify-between w-full border rounded-md p-2 hover:bg-gray-100">
                                <span class="font-medium text-gray-800">Mobile Banking Option 1</span>
                            </button>
                        </li>
                    </ul>
                </details> --}}
            </div>

            <!-- Modal Footer -->
            {{-- <div class="sticky bottom-0 flex justify-end gap-4 rounded-b-md border-t-2 border-gray-200 bg-white p-4">
                <button onclick="toggleModal('checkoutModal')" class="rounded bg-gray-300 px-4 py-2 hover:bg-gray-400">
                    Cancel
                </button>
                <button onclick="confirmCheckout()" class="rounded bg-green-500 px-4 py-2 text-white hover:bg-green-600">
                    Confirm
                </button>
            </div> --}}
        </div>
    </div>

    <div id="custDataModal" class="fixed inset-0 z-50 hidden h-full w-full overflow-y-auto bg-gray-900 bg-opacity-50">
        <div class="relative mx-auto mt-24 w-11/12 max-w-2xl rounded-lg bg-white shadow-lg">
            <!-- Modal Header -->
            <div class="flex items-center justify-between rounded-t-lg border-b border-gray-200 bg-gray-50 p-6">
                <h5 class="text-xl font-semibold text-gray-800">
                    Shipping Address
                </h5>
                <button type="button" class="text-gray-500 hover:text-gray-800" onclick="toggleModal('custDataModal')">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
    
            <!-- Modal Body -->
            <div class="max-h-[60vh] overflow-y-auto p-6">
                <form id="customerDataForm" class="space-y-6">
                    <!-- Grid Layout for Nama Depan and Nama Belakang -->
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div>
                            <label for="first_name" class="block text-sm font-medium text-gray-700">Nama Depan</label>
                            <input type="text" id="first_name" name="first_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 sm:text-sm h-10 px-4" required>
                        </div>
                        <div>
                            <label for="last_name" class="block text-sm font-medium text-gray-700">Nama Belakang</label>
                            <input type="text" id="last_name" name="last_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 sm:text-sm h-10 px-4" required>
                        </div>
                    </div>
    
                    <!-- Email and Nomor Telepon -->
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" id="email" name="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 sm:text-sm h-10 px-4" required>
                        </div>
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                            <input type="text" id="phone" name="phone" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 sm:text-sm h-10 px-4" required>
                        </div>
                    </div>
    
                    <!-- Alamat -->
                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700">Alamat</label>
                        <textarea id="address" name="address" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 sm:text-sm p-4"></textarea>
                    </div>
    
                    <!-- Kota, Provinsi, and Kode Pos -->
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
                        <div>
                            <label for="city" class="block text-sm font-medium text-gray-700">Kota</label>
                            <input type="text" id="city" name="city" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 sm:text-sm h-10 px-4" required>
                        </div>
                        <div>
                            <label for="state" class="block text-sm font-medium text-gray-700">Provinsi</label>
                            <input type="text" id="state" name="state" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 sm:text-sm h-10 px-4" required>
                        </div>
                        <div>
                            <label for="postcode" class="block text-sm font-medium text-gray-700">Kode Pos</label>
                            <input type="text" id="postcode" name="postcode" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 sm:text-sm h-10 px-4" required>
                        </div>
                    </div>
                </form>
            </div>
        
            <!-- Modal Footer -->
            <div class="sticky bottom-0 flex justify-end gap-4 rounded-b-lg border-t border-gray-200 bg-gray-50 p-6">
                <button onclick="toggleModal('custDataModal')" class="rounded-md bg-gray-300 px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-400">
                    Batal
                </button>
                <button onclick="confirmCheckout()" class="rounded-md bg-indigo-600 px-5 py-2.5 text-sm font-medium text-white hover:bg-indigo-700">
                    Konfirmasi
                </button>
            </div>
        </div>
    </div>


    <!-- Invoice Modal -->
    <div id="invoiceModal" class="fixed inset-0 hidden bg-gray-900 bg-opacity-50">
        <div class="relative mx-auto mt-24 w-11/12 max-w-lg rounded-lg bg-white p-6">
            <h2 class="text-lg font-bold">Terima kasih!</h2>
            <p class="mt-4">Kode Invoice: <span id="invoiceCode"></span></p>
            <p class="mt-4">
                Lakukan Pembayaran
                <a href="{{ route('linkbayar') }}" target="_blank"
                    class="text-blue-600 font-semibold underline hover:text-blue-800">
                    disini
                </a>
            </p>
            <div class="mt-6 text-right">
                <button onclick="toggleModal('invoiceModal')"
                    class="rounded bg-blue-500 px-4 py-2 text-white">Close</button>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div id="toast" class="fixed bottom-5 right-5 hidden transform translate-y-5 opacity-0 rounded bg-green-500 px-4 py-2 text-white shadow-lg flex items-center space-x-3 transition-all duration-300 ease-in-out">
        <!-- Icon -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8.5 8.5a1 1 0 01-1.414 0l-4.5-4.5a1 1 0 011.414-1.414L8 12.086l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
        </svg>
    
        <!-- Message -->
        <div>
            <p class="font-bold">Success</p>
            <p class="text-sm">Item added to cart</p>
        </div>
    
        <!-- Close Button -->
        <button onclick="hideToast()" class="text-white hover:text-gray-300 focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 011.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </button>
    </div>
    

    <script>
        let cart = [];

        function addToCart(id, name, price) {
            const existingItem = cart.find(item => item.id === id);
            if (existingItem) {
                existingItem.qty++;
            } else {
                cart.push({
                    id,
                    name,
                    price,
                    qty: 1
                });
            }
            updateCartDisplay();
            showToast();
        }

        function updateCartDisplay() {
            const cartItemsContainer = document.getElementById('cartItems');
            cartItemsContainer.innerHTML = `
                <div class="bg-white-100 rounded-lg p-0">
                    <div id="cartContent"></div>
                    <hr class="my-4">
                    <div class="flex justify-between items-center">
                        <span class="font-bold">Total:</span>
                        <span class="font-bold" id="checkoutTotal">Rp.  0</span>
                    </div>
                </div>
            `;

            const cartContent = document.getElementById('cartContent');
            let total = 0;

            cart.forEach((item, index) => {
                total += item.price * item.qty;
                cartContent.innerHTML += `
                    <div class="flex justify-between mb-4">
                        <div class="flex items-center">
                            <div>
                                <h2 class="font-bold">${item.name}</h2>
                                <label class="text-gray-700">Qty: 
                                    <input type="number" 
                                        class="cart-qty-input border rounded p-1 w-16" 
                                        data-index="${index}" 
                                        value="${item.qty}" 
                                        min="1">
                                </label>
                                <p class="text-sm text-gray-600">Price: Rp.  ${item.price.toLocaleString('id-ID')}</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <span class="font-bold">Rp.  ${(item.price * item.qty).toLocaleString('id-ID')}</span>
                            <button 
                                class="delete-item-button p-1" 
                                data-index="${index}" 
                                aria-label="Remove Item">
                                <img src="{{ asset('resources/img/delete-175-16.png') }}" 
                                    alt="Remove" 
                                    class="w-4 h-4">
                            </button>
                        </div>
                    </div>
                `;
            });

            document.getElementById('checkoutTotal').innerText = 'Rp. ' + total.toLocaleString('id-ID');
            const itemInChart = document.getElementById('itemInChart');
            itemInChart.textContent = cart.length;

            // Attach event listeners to quantity inputs
            document.querySelectorAll('.cart-qty-input').forEach(input => {
                input.addEventListener('change', updateQty);
            });

            // Attach event listeners to delete buttons
            document.querySelectorAll('.delete-item-button').forEach(button => {
                button.addEventListener('click', deleteItem);
            });
        }



        function updateQty(event) {
            const index = event.target.getAttribute('data-index');
            const newQty = parseInt(event.target.value);

            if (newQty > 0) {
                cart[index].qty = newQty;
                updateCartDisplay(); // Recalculate the total and update the cart display
            } else {
                // Optional: Reset the input value to 1 if user enters invalid number
                event.target.value = cart[index].qty;
            }
        }

        function deleteItem(event) {
            const index = event.target.getAttribute('data-index');
            cart.splice(index, 1); // Remove the item at the specified index
            updateCartDisplay(); // Update the cart display
        }




        function toggleModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.toggle('hidden');
        }

        function showToast() {
            const toast = document.getElementById('toast');
            toast.classList.remove('hidden');
            toast.classList.add('translate-y-0', 'opacity-100');
            toast.classList.remove('translate-y-5', 'opacity-0');

            // Hide after 2 seconds
            setTimeout(() => {
                hideToast();
            }, 2000);
        }

        function hideToast() {
            const toast = document.getElementById('toast');
            toast.classList.add('translate-y-5', 'opacity-0');
            toast.classList.remove('translate-y-0', 'opacity-100');

            // Add 'hidden' class after animation ends
            setTimeout(() => {
                toast.classList.add('hidden');
            }, 300); // Match the CSS transition duration
        }

        async function confirmCheckout() {
            const form = document.getElementById('customerDataForm');
            const formData = new FormData(form);
            const data = {};

            formData.forEach((value, key) => {
            data[key] = value;
            });

            // Check if all required fields are filled
            const requiredFields = ['first_name', 'last_name', 'email', 'phone', 'address', 'city', 'state', 'postcode'];
            for (const field of requiredFields) {
            if (!data[field]) {
                alert('Please fill in all fields.');
                return;
            }
            }

            try {
            const response = await fetch("{{ route('create-invoice') }}", {
                method: 'POST',
                headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                ...data,
                cart
                })
            });

            if (response.ok) {
                const result = await response.json();
                cart = [];
                // updateCartDisplay();
                // toggleModal('custDataModal');
                window.location.href = `{{ route('checkout') }}?invoice_code=${result.invoice_code}&customer_code=${result.customer_code}`;
            } else {
                alert('Failed to create invoice. Please try again.');
            }
            } catch (error) {
            alert('An error occurred. Please try again later.');
            }
        }

        document.querySelectorAll('.add-to-cart').forEach(function(element) {
            element.addEventListener('click', function(event) {
                event.preventDefault();

                const productId = this.getAttribute('data-id');
                const productName = this.getAttribute('data-name');
                const productPrice = parseFloat(this.getAttribute(
                'data-price')); // Ensure price is a number

                addToCart(productId, productName, productPrice);
            });
        });
    </script>
@endsection
