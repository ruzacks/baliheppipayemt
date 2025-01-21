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
                    <div class="flex items-center space-x-2 rtl:space-x-reverse text-sm font-medium text-gray-500 dark:text-gray-400">
                        <span>Count Transaction</span>
                    </div>
                    <div class="text-3xl dark:text-gray-100">
                        {{ $countOfTransaction }}
                    </div>
                </div>
            </div>
        
            <div class="relative p-6 rounded-2xl bg-white shadow dark:bg-gray-800">
                <div class="space-y-2">
                    <div class="flex items-center space-x-2 rtl:space-x-reverse text-sm font-medium text-gray-500 dark:text-gray-400">
                        <span>Sum Transaction</span>
                    </div>
                    <div class="text-3xl dark:text-gray-100">
                        Rp. {{ number_format($sumOfTransaction, 0) }}
                    </div>
                </div>
            </div>
        
            <div class="relative p-6 rounded-2xl bg-white shadow dark:bg-gray-800">
                <div class="space-y-2">
                    <div class="flex items-center space-x-2 rtl:space-x-reverse text-sm font-medium text-gray-500 dark:text-gray-400">
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
                            <td class="px-4 py-2 border-b border-surface-light">
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
        <div id="modal" class="fixed inset-0 hidden bg-black/50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-medium">Create New Invoice</h2>
                    <button id="closeModalBtn" class="text-gray-500 hover:text-gray-700">
                        &times;
                    </button>
                </div>
                <form action="{{ route('invoices.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label for="invoiceNumber" class="block text-sm font-medium">Invoice Number</label>
                            <input type="text" id="invoiceNumber" name="number"
                                class="w-full border border-stone-300 rounded-lg py-2 px-3 text-sm bg-gray-100 focus:outline-none"
                                placeholder="Auto-generated" readonly />
                        </div>
                        <div>
                            <label for="amount" class="block text-sm font-medium">Amount</label>
                            <input type="text" id="amount" name="amount"
                                class="w-full border border-stone-300 rounded-lg py-2 px-3 text-sm focus:outline-none focus:ring focus:ring-blue-300"
                                placeholder="Enter Amount" autocomplete="off" required />
                        </div>
                        {{-- <div>
                <label for="date" class="block text-sm font-medium">Date</label>
                <input 
                    type="date" 
                    id="date" 
                    class="w-full border border-stone-300 rounded-lg py-2 px-3 text-sm focus:outline-none focus:ring focus:ring-blue-300"
                    required
                />
                </div>
                <div>
                <label for="status" class="block text-sm font-medium">Status</label>
                <select 
                    id="status" 
                    class="w-full border border-stone-300 rounded-lg py-2 px-3 text-sm focus:outline-none focus:ring focus:ring-blue-300"
                    required
                    >
                    <option value="unpaid">Unpaid</option>
                    <option value="paid">Paid</option>
                </select>
                </div> --}}
                    </div>
                    <div class="mt-6 flex justify-end space-x-2">
                        <button type="button" id="cancelModalBtn"
                            class="px-4 py-2 text-sm font-medium text-gray-600 bg-gray-200 rounded-lg hover:bg-gray-300">
                            Cancel
                        </button>
                        <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-blue-500 rounded-lg hover:bg-blue-600">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal -->
        <div id="edit-modal" class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center">
            <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold mb-4">Edit Invoice</h2>
                    <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700">
                        &times;
                    </button>
                </div>
                <form action="" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Invoice Number -->
                    <div class="mb-4">
                        <label for="number" class="block">Invoice Number</label>
                        <input type="text" id="edit-number" name="number"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg" disabled>
                    </div>

                    <!-- Amount -->
                    <div class="mb-4">
                        <label for="amount" class="block">Amount</label>
                        <input type="text" id="edit-amount" name="amount"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                    </div>

                    <div class="mt-6 flex justify-end space-x-2">
                        <button type="button" onclick="closeModal()"
                            class="px-4 py-2 text-sm font-medium text-gray-600 bg-gray-200 rounded-lg hover:bg-gray-300">
                            Cancel
                        </button>
                        <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-blue-500 rounded-lg hover:bg-blue-600">
                            Save
                        </button>
                    </div>
                </form>


            </div>
        </div>

        <script>
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

            // Attach event listener to amount input
            const amountInput = document.getElementById('amount');
            amountInput.addEventListener('input', (e) => {
                const input = e.target;
                input.value = formatWithCommas(input.value);
            });

            const editAmountInput = document.getElementById('edit-amount');
            editAmountInput.addEventListener('input', (e) => {
                const input = e.target;
                input.value = formatWithCommas(input.value);
            });

            // Function to generate the next invoice number
            function generateNextInvoiceNumber(lastNumber) {
                const prefix = "INV";
                const date = new Date();
                const year = date.getFullYear();
                const month = String(date.getMonth() + 1).padStart(2, "0");

                // Extract the numeric part of the last invoice and increment
                const lastNumericPart = parseInt(lastNumber.slice(-4), 10);
                const nextNumericPart = String(lastNumericPart + 1).padStart(4, "0");

                return `${prefix}-${year}${month}${nextNumericPart}`;
            }

            // Modal open/close logic
            const openModalBtn = document.getElementById('openModalBtn');
            const closeModalBtn = document.getElementById('closeModalBtn');
            const cancelModalBtn = document.getElementById('cancelModalBtn');
            const modal = document.getElementById('modal');

            openModalBtn.addEventListener('click', () => {
                const invoiceInput = document.getElementById('invoiceNumber');

                // Fetch the last invoice number using AJAX
                fetch("{{ route('get-last-inv') }}") // Replace with your actual endpoint
                    .then(response => response.json())
                    .then(data => {
                        const lastInvoiceNumber = data.lastInvoice || "INV-2025010000"; // Fallback value
                        invoiceInput.value = generateNextInvoiceNumber(
                            lastInvoiceNumber); // Set the next invoice number
                    })
                    .catch(error => {
                        console.error('Error fetching last invoice:', error);
                        invoiceInput.value = "Error fetching invoice";
                    });

                modal.classList.remove('hidden');
            });

            closeModalBtn.addEventListener('click', () => {
                modal.classList.add('hidden');
            });

            cancelModalBtn.addEventListener('click', () => {
                modal.classList.add('hidden');
            });

            // Open the modal and prefill the data
            document.querySelectorAll('.edit-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const invoiceId = this.getAttribute('data-id');
                    const invoiceNumber = this.getAttribute('data-number');
                    const invoiceAmount = this.getAttribute('data-amount');

                    // Prefill the modal with the data
                    document.getElementById('edit-number').value = invoiceNumber;
                    document.getElementById('edit-amount').value = formatWithCommas(invoiceAmount);

                    // Optionally, store the ID for future reference (e.g., to update the invoice)
                    document.getElementById('edit-modal').setAttribute('data-id', invoiceId);

                    // Show the modal
                    document.getElementById('edit-modal').classList.remove('hidden');
                });
            });

            // Close the modal
            function closeModal() {
                document.getElementById('edit-modal').classList.add('hidden');
            }

            // // Form submit logic
            // const createInvoiceForm = document.getElementById('createInvoiceForm');
            // createInvoiceForm.addEventListener('submit', (e) => {
            //     e.preventDefault();

            //     const invoiceData = {
            //     number: document.getElementById('invoiceNumber').value,
            //     amount: document.getElementById('amount').value.replace(/,/g, ''), // Remove commas for backend
            //     date: document.getElementById('date').value,
            //     status: document.getElementById('status').value,
            //     };

            //     console.log('Invoice Created:', invoiceData);

            //     modal.classList.add('hidden');

            //     // Replace this with an AJAX call to save the invoice
            // });
        </script>
    @endsection
