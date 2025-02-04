@extends('layout.admin-layout')

@section('main')
    <div class="w-full px-2 py-2">
        <div class="mb-4 flex flex-col justify-between gap-8 md:flex-row md:items-center">
            <div class="flex w-full shrink-0 gap-2 md:w-max">
                <div class="w-full md:w-72">
                    <div class="flex items-center space-x-2 w-full">
                        {{-- <div class="relative w-full">
                    <input 
                    placeholder="Search" 
                    type="text" 
                    class="w-full aria-disabled:cursor-not-allowed outline-none focus:outline-none text-stone-800 placeholder:text-stone-600/60 ring-transparent border border-stone-200 transition-all ease-in disabled:opacity-50 disabled:pointer-events-none select-none text-sm py-2 px-2.5 ring shadow-sm bg-white rounded-lg duration-100 hover:border-stone-300 hover:ring-none focus:border-stone-400 focus:ring-none peer" 
                    />
                </div> --}}

                    </div>
                </div>

            </div>
        </div>
        <div class="grid gap-4 lg:gap-8 md:grid-cols-3 p-4 pt-0">
            <div class="col-span-3 flex justify-end">
                <div class="text-lg font-semibold text-gray-500 dark:text-gray-400">
                    {{ \Carbon\Carbon::now()->format('F Y') }}
                </div>
            </div>

            <div class="relative p-6 rounded-2xl bg-white shadow dark:bg-gray-800">
                <div class="space-y-2">
                    <div
                        class="flex items-center space-x-2 rtl:space-x-reverse text-sm font-medium text-gray-500 dark:text-gray-400">
                        <span>Count Transaction</span>
                    </div>
                    <div class="text-3xl dark:text-gray-100">
                        {{ $countOfTransaction }}
                    </div>
                </div>
            </div>

            <div class="relative p-6 rounded-2xl bg-white shadow dark:bg-gray-800">
                <div class="space-y-2">
                    <div
                        class="flex items-center space-x-2 rtl:space-x-reverse text-sm font-medium text-gray-500 dark:text-gray-400">
                        <span>Sum Transaction</span>
                    </div>
                    <div class="text-3xl dark:text-gray-100">
                        Rp. {{ number_format($sumOfTransaction, 0) }}
                    </div>
                </div>
            </div>

            <div class="relative p-6 rounded-2xl bg-white shadow dark:bg-gray-800">
                <div class="space-y-2">
                    <div
                        class="flex items-center space-x-2 rtl:space-x-reverse text-sm font-medium text-gray-500 dark:text-gray-400">
                        <span>Sum of Profit</span>
                    </div>
                    <div class="text-3xl dark:text-gray-100">
                        Rp. {{ number_format($sumOfProfit, 0) }}
                    </div>
                </div>
            </div>
        </div>


        <div class="w-full overflow-hidden rounded-lg border border-stone-200">
            <!-- Filter Form -->
            <form action="{{ route('admin-panel') }}" method="GET" class="mb-4 p-4 bg-white border rounded-md">
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label for="invoice_no" class="block text-sm font-medium text-gray-700">Invoice No</label>
                        <input type="text" name="invoice_no" id="invoice_no" value="{{ request('invoice_no') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                        <select name="status" id="status"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            <option value="" {{ request('status') == '' ? 'selected' : '' }}>All</option>
                            <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="unpaid" {{ request('status') == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="manual" {{ request('status') == 'manual' ? 'selected' : '' }}>Manual</option>
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button type="submit"
                            class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 mx-1 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            Filter
                        </button>
                        <a href="{{ route('admin-panel') }}"
                            class="inline-flex justify-center rounded-md border border-transparent bg-gray-300 py-2 px-4 text-sm font-medium text-gray-800 shadow-sm hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2">
                            Clear
                        </a>
                        <a href="{{ route('create-invoice-admin') }}" {{-- id="openModalBtn" --}}
                            class="mx-1 inline-flex items-center justify-center border align-middle select-none font-sans font-medium text-center transition-all ease-in text-sm py-2 px-3 shadow-sm bg-blue-500 text-white rounded-lg hover:bg-blue-600 duration-150">
                            Add
                        </a>
                        <a href="{{ route('create-invoice-admin-manual') }}" {{-- id="openModalBtn" --}}
                            class="inline-flex items-center justify-center border align-middle select-none font-sans font-medium text-center transition-all ease-in text-sm py-2 px-3 shadow-sm bg-blue-500 text-white rounded-lg hover:bg-blue-600 duration-150">
                            Add Manual
                        </a>
                    </div>
                </div>
            </form>

            <!-- Invoices Table -->
            <table class="w-full text-left text-sm font-sans text-stone-600">
                <thead class="border-b border-stone-200 bg-gray-100 font-medium">
                    <tr>
                        <th class="px-2.5 py-2 text-start">Date</th>
                        <th class="px-2.5 py-2 text-start">Invoice No</th>
                        <th class="px-2.5 py-2 text-start">Payment<br>Gateway</th>
                        <th class="px-2.5 py-2 text-start">Amount</th>
                        <th class="px-2.5 py-2 text-start">Type</th>
                        <th class="px-2.5 py-2 text-start">Tax (%)</th>
                        <th class="px-2.5 py-2 text-start">Tax Price</th>
                        <th class="px-2.5 py-2 text-start">Fee</th>
                        <th class="px-2.5 py-2 text-start">Cust</th>
                        <th class="px-2.5 py-2 text-start">Sales Price</th>
                        <th class="px-2.5 py-2 text-start">Sales (%)</th>
                        <th class="px-2.5 py-2 text-start">Profit</th>
                        <th class="px-2.5 py-2 text-start">Status</th>
                        <th class="px-2.5 py-2 text-start"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoices as $invoice)
                        <tr class="hover:bg-gray-100 transition-colors">
                            <td class="px-4 py-2 border-b border-surface-light">
                                <small class="font-sans antialiased">{{ $invoice->created_at->format('d-m-Y') }}</small>
                            </td>
                            <td class="px-4 py-2 border-b border-surface-light">
                                <small class="font-sans">{{ $invoice->invoice_code }}</small>
                            </td>
                            <td class="px-4 py-2 border-b border-surface-light text-right">
                                <small class="font-sans">{{ number_format($invoice->netto, 0) }}</small>
                            </td>
                            <td class="px-4 py-2 border-b border-surface-light text-right">
                                <small class="font-sans">{{ number_format($invoice->amount, 0) }}</small>
                            </td>
                            <td class="px-4 py-2 border-b border-surface-light">
                                <small class="font-sans">{{ $invoice->payment_by }}</small>
                            </td>
                            <td class="px-4 py-2 border-b border-surface-light">
                                <small class="font-sans">{{ $invoice->tax }}</small>
                            </td>
                            <td class="px-4 py-2 border-b border-surface-light text-right">
                                <small class="font-sans">{{ number_format($invoice->tax_price(), 0) }}</small>
                            </td>
                            <td class="px-4 py-2 border-b border-surface-light text-right">
                                <small class="font-sans">{{ number_format($invoice->fee_price(), 0) }}</small>
                            </td>
                            <td class="px-4 py-2 border-b border-surface-light text-right">
                                <small class="font-sans">{{ number_format($invoice->cust_netto(), 0) }}</small>
                            </td>
                            <td class="px-4 py-2 border-b border-surface-light text-right">
                                <small class="font-sans">{{ number_format($invoice->sales_price(), 0) }}</small>
                            </td>
                            <td class="px-4 py-2 border-b border-surface-light">
                                <small
                                    class="font-sans">{{ $invoice->sales_person ? $invoice->sales_person->name . " ($invoice->sales_commission%)" : '-' }}</small>
                            </td>
                            <td class="px-4 py-2 border-b border-surface-light text-right">
                                <small
                                    class="font-sans">{{ $invoice->netto == 0 ? '' : number_format($invoice->profit(), 0) }}</small>
                            </td>
                            <td class="px-4 py-2 border-b border-surface-light">
                                <div
                                    class="relative inline-flex w-max items-center border font-sans text-xs p-0.5
                                {{ $invoice->status === 'paid'
                                    ? 'bg-green-500/10 text-green-500'
                                    : ($invoice->status === 'unpaid'
                                        ? 'bg-red-500/10 text-red-500'
                                        : ($invoice->status === 'pending'
                                            ? 'bg-yellow-500/10 text-yellow-500'
                                            : ($invoice->status === 'manual'
                                                ? 'bg-blue-500/10 text-blue-500'
                                                : ''))) }}">
                                    <span class="font-sans text-current leading-none my-0.5 mx-1.5">
                                        {{ ucfirst($invoice->status) }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-4 py-2 border-b border-surface-light flex items-center gap-2">
                                <!-- Edit Button -->
                                <a href="{{ route('edit-invoice-admin', ['invoice' => $invoice->id]) }}">
                                    <button
                                        class="inline-grid place-items-center border rounded-md bg-transparent text-stone-800 hover:bg-stone-200/10">
                                        <svg width="1.5em" height="1.5em" viewBox="0 0 24 24" stroke-width="1.5"
                                            fill="none" xmlns="http://www.w3.org/2000/svg" color="currentColor">
                                            <path
                                                d="M14.3632 5.65156L15.8431 4.17157C16.6242 3.39052 17.8905 3.39052 18.6716 4.17157L20.0858 5.58579C20.8668
                                                    6.36683 20.8668 7.63316 20.0858 8.41421L18.6058 9.8942M14.3632 5.65156L4.74749 15.2672C4.41542 15.5993 4.21079
                                                    16.0376 4.16947 16.5054L3.92738 19.2459C3.87261 19.8659 4.39148 20.3848 5.0115 20.33L7.75191 20.0879C8.21972
                                                    20.0466 8.65806 19.8419 8.99013 19.5099L18.6058 9.8942M14.3632 5.65156L18.6058 9.8942"
                                                stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                                            </path>
                                        </svg>
                                    </button>
                                </a>

                                <!-- Delete Button -->
                                <form id="deleteForm-{{ $invoice->id }}" method="POST"
                                    action="{{ route('delete-invoice-admin', ['invoice' => $invoice->id]) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                        class="inline-grid place-items-center border rounded-md bg-transparent text-red-600 hover:bg-red-200/10"
                                        onclick="openDeleteModal('{{ $invoice->invoice_code }}','{{ $invoice->id }}')">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="3 6 5 6 21 6"></polyline>
                                            <path d="M19 6l-2 14H7L5 6"></path>
                                            <path d="M10 11v6"></path>
                                            <path d="M14 11v6"></path>
                                        </svg>
                                    </button>
                                </form>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="flex items-center justify-between border-t border-gray-300 py-4 px-6 bg-white rounded-md">
                {{ $invoices->links('pagination::tailwind') }}
            </div>
        </div>



        <!-- Modal -->
        <div id="deleteModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
            <div class="bg-white rounded-lg shadow-lg p-6 max-w-sm w-full">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Confirm Deletion</h2>
                <p class="text-gray-600 mb-6">Are you sure you want to delete invoice <span id="invoiceToDelete"></span>?
                </p>
                <div class="flex items-center justify-end gap-4">
                    <input type="hidden" id="invoiceIdToDelete">
                    <button id="cancelDelete" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">
                        Cancel
                    </button>
                    <button id="confirmDelete" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                        Delete
                    </button>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                // Select all rows in the table body
                const rows = document.querySelectorAll("table tbody tr");

                // Initialize an array to store the invoice numbers and their statuses
                const invoiceList = [];
                let checkCount = 0;
                let successFound = false;

                // Loop through each row
                rows.forEach(row => {
                    // Get the invoice number from the second cell (index 1)
                    const invoiceNumber = row.querySelector("td:nth-child(2) small").textContent.trim();

                    // Get the status from the second last cell
                    const status = row.querySelector("td:nth-last-child(2) span").textContent.trim();

                    // Add the invoice number and status to the array
                    invoiceList.push({
                        invoiceNumber,
                        status
                    });

                    // If the status is 'unpaid', make a request to checkInvoice function in DokuController
                    if (status.toLowerCase() === 'unpaid') {
                        fetch("{{ route('check-invoice') }}" + `?inv_code=${invoiceNumber}`)
                            .then(response => response.json())
                            .then(data => {
                                checkCount++;
                                if (data.status === 'success') {
                                    successFound = true;
                                }
                                console.log(`Invoice ${invoiceNumber} status checked:`, data);
                                if (checkCount === rows.length && successFound) {
                                    location.reload();
                                }
                            })
                            .catch(error => {
                                checkCount++;
                                console.error(`Error checking invoice ${invoiceNumber}:`, error);
                                if (checkCount === rows.length && successFound) {
                                    location.reload();
                                }
                            });
                    } else {
                        checkCount++;
                    }
                });

                // Output the list of invoice numbers and their statuses
                console.log(invoiceList);
            });
            // Function to format numbers with commas
            function formatWithCommas(value) {
                // Remove any non-numeric characters (except the decimal point)
                value = value.replace(/[^0-9.]/g, "");

                // Split the value into whole and decimal parts
                let [whole, decimal] = value.split(".");

                // Format the whole number part with commas
                whole = whole.replace(/\B(?=(\d{3})+(?!\d))/g, ",");

                // If there's a decimal part, reattach it
                if (decimal) {
                    return `${whole}`;
                }

                return whole;
            }

            // Open the delete confirmation modal
            function openDeleteModal(invoiceCode, invoiceId) {
                const deleteModal = document.getElementById('deleteModal');
                const invoiceToDelete = document.getElementById('invoiceToDelete');
                const invoiceIdToDelete = document.getElementById('invoiceIdToDelete');
                invoiceToDelete.textContent = invoiceCode;
                invoiceIdToDelete.value = invoiceId;
                deleteModal.classList.remove('hidden');
            }

            // Add event listeners for confirm and cancel buttons
            document.getElementById('cancelDelete').addEventListener('click', () => {
                const deleteModal = document.getElementById('deleteModal');

                deleteModal.classList.add('hidden');
            });

            document.getElementById('confirmDelete').addEventListener('click', () => {
                // Submit the form when delete is confirmed
                const invoiceIdToDelete = document.getElementById('invoiceIdToDelete');
                document.getElementById('deleteForm-' + invoiceIdToDelete.value).submit();
            });
        </script>
    @endsection
