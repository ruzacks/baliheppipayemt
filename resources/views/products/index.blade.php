@extends('layout.admin-layout')

@section('main')
<div class="w-full px-4 py-6">
    <div class="mb-6 flex justify-between">
        <h1 class="text-xl font-bold text-gray-800">Products</h1>
        <a
            href="{{ route('products.create') }}"
            class="rounded-lg bg-blue-500 px-4 py-2 text-white text-sm hover:bg-blue-600"
        >
            Add New Product
        </a>
    </div>

    <div class="w-full rounded-lg border border-gray-200 bg-white">
        <table class="w-full text-left text-sm">
            <thead class="bg-gray-100 text-gray-600">
                <tr>
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">Image</th>
                    <th class="px-4 py-2">Price</th>
                    <th class="px-4 py-2">SKU</th>
                    <th class="px-4 py-2 text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr class="border-b last:border-none">
                    <td class="px-4 py-3">{{ $product->name }}</td>
                    <td class="px-4 py-3">
                        @if($product->image_url)
                            @if(filter_var($product->image_url, FILTER_VALIDATE_URL))
                                <!-- If image_url is a full URL -->
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="h-10 w-10 rounded-lg">
                            @else
                                <!-- If image_url is a file path -->
                                <img src="{{ asset('storage/app/public/' . $product->image_url) }}" alt="{{ $product->name }}" class="h-10 w-10 rounded-lg">
                            @endif
                        @else
                            <span class="text-gray-500">No image</span>
                        @endif
                    </td>
                    <td class="px-4 py-3">Rp. {{ number_format($product->price, 0) }}</td>
                    <td>{{ $product->sku }}</td>
                    <td class="px-4 py-3 text-right">
                        <a
                            href="{{ route('products.edit', $product) }}"
                            class="inline-flex items-center justify-center rounded-md bg-gray-100 px-3 py-1.5 text-sm text-gray-600 hover:bg-gray-200"
                        >
                            Edit
                        </a>
                        <form
                            action="{{ route('products.destroy', $product) }}"
                            method="POST"
                            class="inline-block"
                            onsubmit="return confirm('Are you sure you want to delete this product?');"
                        >
                            @csrf
                            @method('DELETE')
                            <button
                                type="submit"
                                class="inline-flex items-center justify-center rounded-md bg-red-100 px-3 py-1.5 text-sm text-red-600 hover:bg-red-200"
                            >
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
