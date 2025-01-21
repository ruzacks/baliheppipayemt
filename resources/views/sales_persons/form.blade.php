@csrf

<div class="grid grid-cols-1 gap-4">

    <!-- Name Field -->
    <div>
        <label for="name" class="block text-sm font-medium text-gray-600">Nama Sales</label>
        <input
            type="text"
            name="name"
            id="name"
            value="{{ old('name', $salesPerson->name ?? '') }}"
            class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 text-gray-800 text-sm py-2 px-3
                @error('name') border-red-500 @enderror"
            required
        />
        @error('name')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Phone Field -->
    <div>
        <label for="phone" class="block text-sm font-medium text-gray-600">No. Telp</label>
        <input
            type="tel"
            name="phone"
            id="phone"
            pattern="[0-9]*" 
            inputmode="numeric"
            value="{{ old('phone', $salesPerson->phone ?? '') }}"
            class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 text-gray-800 text-sm py-2 px-3
                @error('phone') border-red-500 @enderror"
            required
        />
        @error('phone')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Commission Field -->
    <div>
        <label for="commission" class="block text-sm font-medium text-gray-600">Komisi (%)</label>
        <input
            type="number"
            name="commission"
            id="commission"
            value="{{ old('commission', $salesPerson->commission ?? '') }}"
            class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 text-gray-800 text-sm py-2 px-3
                @error('commission') border-red-500 @enderror"
            step="0.01"
            required
        />
        @error('commission')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

</div>
