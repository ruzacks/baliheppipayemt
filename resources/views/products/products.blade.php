@extends('layout.customer-layout')

@section('main')
<div class="w-full px-4 py-6">
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
        @foreach($products as $product)
        <div class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow hover:shadow-lg">
            <div class="aspect-w-1 aspect-h-1 w-full overflow-hidden">
                <img 
                    src="https://www.static-src.com/wcsstore/Indraprastha/images/catalog/full//catalog-image/100/MTA-150688314/no-brand_no-brand_full01.jpg" 
                    alt="{{ $product->name }}" 
                    class="object-cover w-full h-full"
                />
            </div>
            <div class="p-4">
                <h2 class="text-lg font-medium text-gray-800">{{ $product->name }}</h2>
                <p class="text-gray-600">IDR {{ number_format($product->price, 0, ',', '.') }}</p>
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
</div>

<!-- Cart Modal -->
<div id="cartModal" class="fixed inset-0 hidden bg-gray-900 bg-opacity-50">
    <div class="relative mx-auto mt-24 w-11/12 max-w-2xl rounded-lg bg-white p-6">
        <h2 class="text-lg font-bold">Your Cart</h2>
        <div id="cartItems" class="mt-4"></div>
        <div class="mt-6 text-right">
            <button onclick="toggleModal('cartModal')" class="mr-2 rounded bg-gray-300 px-4 py-2">Close</button>
            <button onclick="toggleModal('checkoutModal')" class="rounded bg-blue-500 px-4 py-2 text-white">Checkout</button>
        </div>
    </div>
</div>

<!-- Checkout Modal -->
<div id="checkoutModal" class="fixed inset-0 hidden bg-gray-900 bg-opacity-50">
    <div class="relative mx-auto mt-24 w-11/12 max-w-lg rounded-lg bg-white p-6">
        <h2 class="text-lg font-bold">Checkout</h2>
        {{-- <form id="checkoutForm" class="mt-4 space-y-4">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" id="name" name="name" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>
            <div>
                <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                <input type="text" id="address" name="address" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>
            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                <input type="text" id="phone" name="phone" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>
        </form> --}}
        <p class="mt-4">Total: IDR <span id="checkoutTotal">0</span></p>
        <div class="mt-6 text-right">
            <button onclick="toggleModal('checkoutModal')" class="mr-2 rounded bg-gray-300 px-4 py-2">Cancel</button>
            <button onclick="confirmCheckout()" class="rounded bg-green-500 px-4 py-2 text-white">Confirm</button>
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
            <a href="{{ route('linkbayar') }}" target="_blank" class="text-blue-600 font-semibold underline hover:text-blue-800">
                disini
            </a>
        </p>
        <div class="mt-6 text-right">
            <button onclick="toggleModal('invoiceModal')" class="rounded bg-blue-500 px-4 py-2 text-white">Close</button>
        </div>
    </div>
</div>

<!-- Toast Notification -->
<div id="toast" class="fixed bottom-5 right-5 hidden rounded bg-green-500 px-4 py-2 text-white shadow-lg">Item added to cart</div>

<script>
    let cart = [];

    function addToCart(id, name, price) {
        const existingItem = cart.find(item => item.id === id);
        if (existingItem) {
            existingItem.qty++;
        } else {
            cart.push({ id, name, price, qty: 1 });
        }
        updateCartDisplay();
        showToast();
    }

    function updateCartDisplay() {
        const cartItemsContainer = document.getElementById('cartItems');
        cartItemsContainer.innerHTML = '';
        let total = 0;
        cart.forEach(item => {
            total += item.price * item.qty;
            cartItemsContainer.innerHTML += `
                <div class="flex justify-between border-b py-2">
                    <span>${item.name} (x${item.qty})</span>
                    <span>IDR ${item.price * item.qty}</span>
                </div>
            `;
        });
        document.getElementById('checkoutTotal').innerText = total;
    }

    function toggleModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.classList.toggle('hidden');
    }

    function showToast() {
        const toast = document.getElementById('toast');
        toast.classList.remove('hidden');
        setTimeout(() => {
            toast.classList.add('hidden');
        }, 2000);
    }

    async function confirmCheckout() {
        // const name = document.getElementById('name').value;
        // const address = document.getElementById('address').value;
        // const phone = document.getElementById('phone').value;

        // if (!name || !address || !phone) {
        //     alert('Please fill in all fields.');
        //     return;
        // }

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
                    cart
                })
            });

            if (response.ok) {
                const result = await response.json();
                cart = [];
                updateCartDisplay();
                toggleModal('checkoutModal');
                document.getElementById('invoiceCode').innerText = result.invoice_code;
                toggleModal('invoiceModal');
            } else {
                alert('Failed to create invoice. Please try again.');
            }
        } catch (error) {
            alert('An error occurred. Please try again later.');
        }
    }
</script>
@endsection
