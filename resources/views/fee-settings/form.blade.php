@csrf

<div class="grid grid-cols-1 gap-4">
    <div>
        <label for="method_name" class="block text-sm font-medium text-gray-600">Nama Metode</label>
        <input
            type="text"
            name="method_name"
            id="method_name"
            value="{{ old('method_name', $feeSetting->method_name ?? '') }}"
            class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 text-gray-800 text-sm py-2 px-3"
            required
        />
    </div>

    <div>
        <label for="transaction_fee_percentage" class="block text-sm font-medium text-gray-600">Biaya Transaksi (%)</label>
        <input
            type="number"
            name="transaction_fee_percentage"
            id="transaction_fee_percentage"
            value="{{ old('transaction_fee_percentage', $feeSetting->transaction_fee_percentage ?? '') }}"
            class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 text-gray-800 text-sm py-2 px-3"
            step="0.01"
            required
        />
    </div>

    <div>
        <label for="tax_percentage" class="block text-sm font-medium text-gray-600">Pajak Transaksi (%)</label>
        <input
            type="number"
            name="tax_percentage"
            id="tax_percentage"
            value="{{ old('tax_percentage', $feeSetting->tax_percentage ?? '') }}"
            class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 text-gray-800 text-sm py-2 px-3"
            step="0.01"
            required
        />
    </div>

    <div>
        <label for="rajagestun_fee" class="block text-sm font-medium text-gray-600">RajaGestun Fee (%)</label>
        <input
            type="number"
            name="rajagestun_fee"
            id="rajagestun_fee"
            value="{{ old('rajagestun_fee', $feeSetting->rajagestun_fee ?? '') }}"
            class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 text-gray-800 text-sm py-2 px-3"
            step="0.01"
            required
        />
    </div>
</div>

