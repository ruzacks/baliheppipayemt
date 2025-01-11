@extends('layout.admin-layout')

@section('main')
   

<div class="w-full px-4 py-6">
    <div class="mb-6 flex flex-col justify-between gap-6 md:flex-row md:items-center">
        <div class="flex items-center gap-4">
            <button
                id="addFeeSetting"
                onclick="window.location.href='{{ route('fee-settings.create') }}'"
                class="inline-flex items-center justify-center rounded-lg bg-blue-500 px-4 py-2 text-sm font-medium text-white hover:bg-blue-600"
            >
                Add New Fee Setting
            </button>
        </div>
    </div>

    <div class="w-full overflow-hidden rounded-lg border border-gray-200 bg-white">
        <table class="w-full text-left text-sm">
            <thead class="border-b border-gray-200 bg-gray-100 text-gray-600">
                <tr>
                    <th class="px-4 py-2 font-medium">Metode Transaksi</th>
                    <th class="px-4 py-2 font-medium">Biaya Transaksi (%)</th>
                    <th class="px-4 py-2 font-medium">Pajak Transaksi (%)</th>
                    <th class="px-4 py-2 font-medium">RajaGestun Fee (%)</th>
                    <th class="px-4 py-2 font-medium text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($feeSettings as $fee)
                    <tr class="border-b last:border-none">
                        <td class="px-4 py-3 text-gray-800">{{ $fee->method_name }}</td>
                        <td class="px-4 py-3 text-gray-800">{{ $fee->transaction_fee_percentage }}</td>
                        <td class="px-4 py-3 text-gray-800">{{ $fee->tax_percentage }}</td>
                        <td class="px-4 py-3 text-gray-800">{{ $fee->rajagestun_fee }}</td>
                        <td class="px-4 py-3 text-right">
                            <a
                                href="{{ route('fee-settings.edit', $fee) }}"
                                class="inline-flex items-center justify-center rounded-md bg-gray-100 px-3 py-1.5 text-sm text-gray-600 hover:bg-gray-200"
                            >
                                Edit
                            </a>
                            <form
                                action="{{ route('fee-settings.destroy', $fee) }}"
                                method="POST"
                                class="inline-block"
                                onsubmit="return confirm('Are you sure you want to delete this fee setting?');"
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

        {{-- <div class="flex items-center justify-between border-t border-gray-200 bg-gray-50 px-4 py-3">
            {{ $feeSettings->links('pagination::tailwind') }}
        </div> --}}
    </div>
</div>

@endsection