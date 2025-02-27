@csrf

<div class="space-y-4">
    <div>
        <label for="name" class="block text-sm font-medium text-gray-600">Product Name</label>
        <input
            type="text"
            name="name"
            id="name"
            value="{{ old('name', $product->name ?? '') }}"
            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
            required
        />
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-600">Image Options</label>
        <div class="mt-1 space-y-2">
            <div>
                <label for="image_url" class="block text-sm font-medium text-gray-600">Image URL</label>
                <input
                    type="url"
                    name="image_url"
                    id="image_url"
                    value="{{ old('image_url', $product->image_url ?? '') }}"
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                />
            </div>
            <div>
                <label for="image_file" class="block text-sm font-medium text-gray-600">Upload Image</label>
                <input
                    type="file"
                    name="image_file"
                    id="image_file"
                    accept="image/*"
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                />
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
            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
            step="0.01"
            required
        />
    </div>

    <div class="mt-4">
        <label for="description" class="block text-sm font-medium text-gray-600">Description</label>
        <textarea
            name="description"
            id="description"
            rows="4"
            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
            required
        >{{ old('description', $product->description ?? '') }}</textarea>
    </div>
</div>