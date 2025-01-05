@extends('layout.admin-layout')

@section('main')


@if(session('success'))
<div 
    id="toast-success" 
    class="fixed top-5 right-5 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded shadow-md" 
    role="alert"
>
    <strong class="font-bold">Success!</strong>
    <span class="block sm:inline">{{ session('success') }}</span>
    <button 
        type="button" 
        class="text-green-700 hover:text-green-900 ml-2" 
        onclick="document.getElementById('toast-success').remove()"
    >
        ×
    </button>
</div>
@endif

@if(session('error'))
<div 
    id="toast-error" 
    class="fixed top-5 right-5 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded shadow-md" 
    role="alert"
>
    <strong class="font-bold">Error!</strong>
    <span class="block sm:inline">{{ session('error') }}</span>
    <button 
        type="button" 
        class="text-red-700 hover:text-red-900 ml-2" 
        onclick="document.getElementById('toast-error').remove()"
    >
        ×
    </button>
</div>
@endif

    

<div class="w-full px-2 py-2">
    <div class="mb-4 flex flex-col justify-between gap-8 md:flex-row md:items-center">
      <div class="flex w-full shrink-0 gap-2 md:w-max">
        <div class="w-full md:w-72">
            <div class="flex items-center space-x-2 w-full">
                <div class="relative w-full">
                    <input 
                    placeholder="Search" 
                    type="text" 
                    class="w-full aria-disabled:cursor-not-allowed outline-none focus:outline-none text-stone-800 dark:text-white placeholder:text-stone-600/60 ring-transparent border border-stone-200 transition-all ease-in disabled:opacity-50 disabled:pointer-events-none select-none text-sm py-2 px-2.5 ring shadow-sm bg-white rounded-lg duration-100 hover:border-stone-300 hover:ring-none focus:border-stone-400 focus:ring-none peer" 
                    />
                </div>
                <button 
                    id="openModalBtn"
                    class="inline-flex items-center justify-center border align-middle select-none font-sans font-medium text-center transition-all ease-in text-sm py-2 px-3 shadow-sm bg-blue-500 text-white rounded-lg hover:bg-blue-600 duration-150"
                >
                    Add
                </button>
                </div>
        </div>

      </div>
    </div>
    <div class="w-full overflow-hidden rounded-lg border border-stone-200">
        <table class="w-full text-left">
            <thead class="border-b border-stone-200 bg-gray-100 text-sm font-medium text-stone-600 dark:bg-surface-dark">
                <tr>
                    <th class="px-2.5 py-2 text-start font-medium">Invoice No</th>
                    <th class="px-2.5 py-2 text-start font-medium">Amount</th>
                    <th class="px-2.5 py-2 text-start font-medium">Date</th>
                    <th class="px-2.5 py-2 text-start font-medium">Status</th>
                    <th class="px-2.5 py-2 text-start font-medium">Paid By</th>
                    <th class="px-2.5 py-2 text-start font-medium"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoices as $invoice)
                    <tr>
                        <td class="p-4 border-b border-surface-light">
                            <div class="flex items-center gap-3">
                                {{ $invoice->invoice_code }}
                            </div>
                        </td>
                        <td class="p-4 border-b border-surface-light">
                            <small class="font-sans antialiased text-sm text-current">Rp. {{ number_format($invoice->amount, 0) }}</small>
                        </td>
                        <td class="p-4 border-b border-surface-light">
                            <small class="font-sans antialiased text-sm text-current">{{ $invoice->created_at->format('d-m-Y') }}</small>
                        </td>
                        <td class="p-4 border-b border-surface-light">
                            <div class="w-max">
                                <div class="relative inline-flex w-max items-center border font-sans font-medium rounded-md text-xs p-0.5 
                                    {{ $invoice->status === 'paid' ? 'bg-green-500/10 text-green-500' : 'bg-red-500/10 text-red-500' }}">
                                    <span class="font-sans text-current leading-none my-0.5 mx-1.5">
                                        {{ $invoice->status }}
                                    </span>
                                </div>
                            </div>
                        </td>
                        <td class="p-4 border-b border-surface-light">
                            <div class="flex items-center gap-3">
                                {{ $invoice->payment_by }}
                            </div>
                        </td>
                        <td class="p-4 border-b border-surface-light">
                            <button class="edit-btn inline-grid place-items-center border align-middle select-none font-sans font-medium text-center 
                            transition-all duration-300 ease-in text-sm min-w-[38px] min-h-[38px] rounded-md bg-transparent text-stone-800 
                            hover:bg-stone-200/10"
                            data-id="{{ $invoice->id }}" data-number="{{ $invoice->invoice_code }}" data-amount="{{ $invoice->amount }}"
                            >
                                <svg width="1.5em" height="1.5em" viewBox="0 0 24 24" stroke-width="1.5" fill="none" xmlns="http://www.w3.org/2000/svg" 
                                color="currentColor" class="h-4 w-4">
                                    <path d="M14.3632 5.65156L15.8431 4.17157C16.6242 3.39052 17.8905 3.39052 18.6716 4.17157L20.0858 5.58579C20.8668 
                                    6.36683 20.8668 7.63316 20.0858 8.41421L18.6058 9.8942M14.3632 5.65156L4.74749 15.2672C4.41542 15.5993 4.21079 
                                    16.0376 4.16947 16.5054L3.92738 19.2459C3.87261 19.8659 4.39148 20.3848 5.0115 20.33L7.75191 20.0879C8.21972 
                                    20.0466 8.65806 19.8419 8.99013 19.5099L18.6058 9.8942M14.3632 5.65156L18.6058 9.8942" stroke="currentColor" 
                                    stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="flex items-center justify-between border-t border-surface-light py-4">
            {{ $invoices->links('pagination::tailwind') }}
        </div>
        
  </div>
  

  <!-- Modal -->
  <div 
    id="modal" 
    class="fixed inset-0 hidden bg-black/50 flex items-center justify-center z-50"
    >
    <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
        <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-medium">Create New Invoice</h2>
        <button 
            id="closeModalBtn" 
            class="text-gray-500 hover:text-gray-700"
        >
            &times;
        </button>
        </div>
        <form action="{{ route('invoices.store') }}" method="POST" class="space-y-4">
            @csrf
            <div class="space-y-4">
                <div>
                <label for="invoiceNumber" class="block text-sm font-medium">Invoice Number</label>
                <input 
                    type="text" 
                    id="invoiceNumber"
                    name="number" 
                    class="w-full border border-stone-300 rounded-lg py-2 px-3 text-sm bg-gray-100 focus:outline-none" 
                    placeholder="Auto-generated"
                    readonly
                />
                </div>
                <div>
                <label for="amount" class="block text-sm font-medium">Amount</label>
                <input 
                    type="text" 
                    id="amount"
                    name="amount" 
                    class="w-full border border-stone-300 rounded-lg py-2 px-3 text-sm focus:outline-none focus:ring focus:ring-blue-300"
                    placeholder="Enter Amount"
                    autocomplete="off"
                    required
                />
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
                <button 
                type="button" 
                id="cancelModalBtn"
                class="px-4 py-2 text-sm font-medium text-gray-600 bg-gray-200 rounded-lg hover:bg-gray-300"
                >
                Cancel
                </button>
                <button 
                type="submit"
                class="px-4 py-2 text-sm font-medium text-white bg-blue-500 rounded-lg hover:bg-blue-600"
                >
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
                <button 
                    onclick="closeModal()" 
                    class="text-gray-500 hover:text-gray-700"
                >
                    &times;
                </button>
            </div>
            <form action="" method="POST">
                @csrf
                @method('PUT')
                
                <!-- Invoice Number -->
                <div class="mb-4">
                    <label for="number" class="block">Invoice Number</label>
                    <input type="text" id="edit-number" name="number" class="w-full px-3 py-2 border border-gray-300 rounded-lg" disabled>
                </div>
                
                <!-- Amount -->
                <div class="mb-4">
                    <label for="amount" class="block">Amount</label>
                    <input type="text" id="edit-amount" name="amount" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                </div>
                
                <div class="mt-6 flex justify-end space-x-2">
                    <button 
                    type="button" 
                    onclick="closeModal()"
                    class="px-4 py-2 text-sm font-medium text-gray-600 bg-gray-200 rounded-lg hover:bg-gray-300"
                    >
                    Cancel
                    </button>
                    <button 
                    type="submit"
                    class="px-4 py-2 text-sm font-medium text-white bg-blue-500 rounded-lg hover:bg-blue-600"
                    >
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
                invoiceInput.value = generateNextInvoiceNumber(lastInvoiceNumber); // Set the next invoice number
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