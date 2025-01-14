<form action="{{ isset($apiService) ? route('api_services.update', $apiService->id) : route('api_services.store') }}" method="POST" class="space-y-6">
    @csrf
    @if (isset($apiService))
        @method('PUT')
    @endif

    <!-- Name Field -->
    <div>
        <label for="name" class="block text-sm font-medium text-gray-600">Service Name</label>
        <input
            type="text"
            name="name"
            id="name"
            value="{{ old('name', $apiService->name ?? '') }}"
            class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 text-gray-800 text-sm py-2 px-3"
            required
        />
    </div>

    <!-- Client ID Field -->
    <div>
        <label for="client_id" class="block text-sm font-medium text-gray-600">Client ID</label>
        <input
            type="text"
            name="attribute[client_id]"
            id="client_id"
            value="{{ old('attribute.client_id', $apiService->attribute['client_id'] ?? '') }}"
            class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 text-gray-800 text-sm py-2 px-3"
            required
        />
    </div>

    <!-- API Key Field -->
    <div>
        <label for="api_key" class="block text-sm font-medium text-gray-600">API Key</label>
        <input
            type="text"
            name="attribute[api_key]"
            id="api_key"
            value="{{ old('attribute.api_key', $apiService->attribute['api_key'] ?? '') }}"
            class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 text-gray-800 text-sm py-2 px-3"
            required
        />
    </div>

    <!-- Public Key Field -->
    <div>
        <label for="public_key" class="block text-sm font-medium text-gray-600">Public Key</label>
        <textarea
            name="attribute[public_key]"
            id="public_key"
            rows="6"
            class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 text-gray-800 text-sm py-2 px-3"
            required
        >{{ old('attribute.public_key', $apiService->attribute['public_key'] ?? '') }}</textarea>
    </div>

    <!-- Base URL Field -->
    <div>
        <label for="base_url" class="block text-sm font-medium text-gray-600">Base URL</label>
        <input
            type="text"
            name="attribute[base_url]"
            id="base_url"
            value="{{ old('attribute.base_url', $apiService->attribute['base_url'] ?? '') }}"
            class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 text-gray-800 text-sm py-2 px-3"
            required
        />
    </div>

    <!-- Submit Button -->
    <div>
        <button type="submit" class="w-full bg-blue-500 text-white rounded-lg py-2 px-4 hover:bg-blue-600 focus:outline-none focus:ring focus:ring-blue-300">
            {{ isset($apiService) ? 'Update Service' : 'Create Service' }}
        </button>
    </div>
</form>
