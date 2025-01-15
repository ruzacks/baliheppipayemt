@extends('layout.customer-layout')

@section('main')
<div class="w-full px-4 py-6">
    <div class="mb-6 text-center">
        <h1 class="text-2xl font-bold text-gray-800">{{ $product->name }}</h1>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Product Image -->
        <div class="aspect-w-1 aspect-h-1 overflow-hidden rounded-lg border border-gray-200 bg-white shadow">
            <img 
                src="https://www.static-src.com/wcsstore/Indraprastha/images/catalog/full//catalog-image/100/MTA-150688314/no-brand_no-brand_full01.jpg" 
                alt="{{ $product->name }}" 
                class="object-cover w-full h-full"
            />
        </div>

        <!-- Product Details -->
        <div class="p-6">
            <h2 class="text-xl font-medium text-gray-800 mb-4">Product Details</h2>
            <p class="text-gray-600 mb-6">{{ $product->description }}</p>
            
            <p class="text-lg font-semibold text-gray-800 mb-4">Price: IDR {{ number_format($product->price, 0, ',', '.') }}</p>

            {{-- <div class="mt-6">
                <button 
                    onclick="addToCart({{ $product->id }}, '{{ $product->name }}', {{ $product->price }})" 
                    class="inline-block rounded-lg bg-green-500 px-6 py-3 text-lg font-medium text-white hover:bg-green-600"
                >
                    Add to Cart
                </button>
            </div> --}}
        </div>
    </div>
</div>
@endsection