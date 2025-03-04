@csrf

<div class="space-y-4">
    <div>
        <label for="name" class="block text-sm font-medium text-gray-600">Product Name</label>
        <input
            type="text"
            name="name"
            id="name"
            value="{{ old('name', $product->name ?? '') }}"
            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 @error('name') border-red-500 @enderror"
            required
        />
        @error('name')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-600">Image Options</label>
        <div class="mt-1 space-y-2">
            <div>
                <label for="image_url" class="block text-sm font-medium text-gray-600">Image URL</label>
                <input
                    type="text"
                    name="image_url"
                    id="image_url"
                    value="{{ old('image_url', $product->image_url ?? '') }}"
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 @error('image_url') border-red-500 @enderror"
                />
                @error('image_url')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="image_file" class="block text-sm font-medium text-gray-600">Upload Image</label>
                <input
                    type="file"
                    name="image_file"
                    id="image_file"
                    accept="image/*"
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 @error('image_file') border-red-500 @enderror"
                />
                @error('image_file')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    <div>
        <label for="price" class="block text-sm font-medium text-gray-600">Price</label>
        <input
            type="number"
            name="price"
            id="price"
            value="{{ old('price', $product->price ?? '') }}"
            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 @error('price') border-red-500 @enderror"
            step="0.01"
            required
        />
        @error('price')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="sku" class="block text-sm font-medium text-gray-600">SKU</label>
        <input
            type="text"
            name="sku"
            id="sku"
            value="{{ old('sku', $product->sku ?? '') }}"
            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 @error('sku') border-red-500 @enderror"
            required
        />
        @error('sku')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="mt-4">
        <label for="description" class="block text-sm font-medium text-gray-600">Description</label>
        <textarea
            name="description"
            id="description"
            rows="4"
            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 @error('description') border-red-500 @enderror"
            required
        >{{ old('description', $product->description ?? '') }}</textarea>
        @error('description')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>
</div>
