@extends('layout.app')

@section('main')
    <main class="flex-1" style="background-color: #645AE0;">

        {{-- <header class="bg-white shadow p-6">
      <h2 class="text-3xl font-bold text-gray-800">Payment</h2>
    </header> --}}

        <div class="max-w-4xl mx-auto p-6">
            <form class="bg-white shadow-lg rounded-lg p-8 space-y-8" id="paymentForm" onsubmit="requestPayment(event)">

                <!-- No Invoice -->
                <div id="invoice-container">
                    <label for="invoice_id" class="block text-sm font-medium text-gray-700">No Invoice</label>
                    <input type="text" id="invoice_id" autocomplete="off"
                        class="mt-2 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm p-3"
                        placeholder="">
                    <p class="text-red-500 text-sm hidden" id="invoice-error">Please fill in the invoice number.</p>
                </div>

                <!-- Amount -->
                <div id="amount-container">
                    <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
                    <input type="text" id="amount"
                        class="mt-2 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm p-3"
                        placeholder="">
                    <p class="text-red-500 text-sm hidden" id="amount-error">Please fill in the amount.</p>
                </div>

                <!-- Payment Type -->
                <div id="payment-container" class="text-center">
                    <fieldset>
                        <legend class="text-lg font-semibold text-gray-800 mb-4">Payment Type</legend>
                        <div class="mt-4 flex justify-center gap-4">
                            <!-- Card Button -->
                            <button type="button" id="card-button" 
                                class="payment-btn w-36 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition"
                                onclick="selectPaymentType('card')">
                                Debit / Credit
                            </button>
                            
                            <!-- E-Wallet Button -->
                            <button type="button" id="ewallet-button" 
                                class="payment-btn w-36 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition"
                                onclick="selectPaymentType('ewallet')">
                                E-Wallet
                            </button>
                        </div>
                    </fieldset>
                    <p class="text-red-500 text-sm hidden mt-2" id="payment-error">Please select a payment type.</p>
                </div>

                <div id="snap-container" style="width: 100%; max-width: 1000px;"></div>

                <!-- Card Details Form -->
                <div id="card-details" class="hidden space-y-6">
                    <!-- Card Number -->
                    <div>
                        <label for="card_number" class="block text-sm font-medium text-gray-800">Card Number</label>
                        <input type="text" id="card_number"
                            class="mt-2 block w-full border-gray-300 rounded-lg shadow-md focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm p-4 bg-gray-50"
                            placeholder="1234 5678 9101 1121">
                    </div>

                    <!-- Expiry Date, CVV, Card Image (Same Line) -->
                    <div class="flex items-center justify-between space-x-6">
                        <!-- Expiry Date -->
                        <div id="expiry-container" class="flex-1">
                            <label for="expiry_date" class="block text-sm font-medium text-gray-800">Expiry Date</label>
                            <input type="text" id="expiry_date"
                                class="mt-2 block w-full border-gray-300 rounded-lg shadow-md focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm p-4 bg-gray-50"
                                placeholder="MM/YY"  >
                            <p class="text-red-500 text-sm hidden" id="expiry-error">Please enter a valid expiry date in MM/YY format.</p>
                        </div>

                        <!-- CVV -->
                        <div id="cvv-container" class="flex-1">
                            <label for="cvv" class="block text-sm font-medium text-gray-800">CVV</label>
                            <input type="text" id="cvv"
                                class="mt-2 block w-full border-gray-300 rounded-lg shadow-md focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm p-4 bg-gray-50"
                                placeholder="123">
                            <p class="text-red-500 text-sm hidden" id="cvv-error">Please enter a valid 3-4 digit CVV.</p>
                        </div>

                        <!-- Card Image -->
                        <div>
                            <label class="block text-sm font-medium text-gray-800">Mastercard</label>
                            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADQAAAAgCAMAAABq4atUAAAApVBMVEX3nhvrABv/////XwD+8fLtGjLsDSbtJDv/+fHzKA/+VwLuLkTwQlb7zYn+7dX94uXrBR/83KvxHhL9cAf94rv3pCv+aQT82KP6iBH95sT4n6nxUGL1go/7zNH5vmb4r0T4qzv5tE7yXW72jZn0c4H4p7D/9eb+6ev3YUb81JruDhb7ewzzZ3f7TQX5jxT3oSP3lhj5srruKT/2NQv4bFH6vmf+8d0ofNcMAAABMUlEQVQ4jZ2V6XaCMBCFhyRCrMpSwaVWFKtW7GJbte//aG0KQuxMwpH7i5PDdyZzMwuwSuJh1uuErtd/nFdnMkoXCSTLbODXPzK4fASr0KnkPQl1Nk2h1jL6D4m1hii5G7bN4FqZfwU99xykHWBFGjTvYOaeDwlqUEEByXCSyktIfGFmz5VeCCouoFfMOG9/EH/HUCIVFBBMt2D4iE4L2IqA7kqITzB0kAyEJRAdasxgY85I6QNDKQPqdjVD3w+IWthrEOW6D4aHvYh64Bjc26FxE0TaB16b6/XbGEFVnt1ykPBJQPbHzX5rj3DCXkZ5m4LdqtYIMdTYGmxtDkUEKprw1naXU+Ng6ZpKyDrCjnxE2J03DMvTARunD8t2Y1klNmtYAIsYbw3TqjmXq+ZbWzU/CLUYCqjQWk0AAAAASUVORK5CYII="
                                alt="MasterCard" class="mt-2 h-8">
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit" id="submit-btn" hidden
                        class="w-full bg-indigo-600 text-white font-semibold py-3 px-6 rounded-lg shadow hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </main>

    <!-- Modal -->
<div id="threeDSModal" class="fixed inset-0 z-50 hidden bg-gray-900 bg-opacity-50 flex items-center justify-center">
    <div class="bg-white p-4 rounded-lg w-4/5 max-w-4xl">
        <div class="flex justify-end">
            <button class="text-gray-500 hover:text-gray-700" onclick="closeModal()">
                <span class="text-xl">×</span>
            </button>
        </div>
        <iframe id="threeDSIframe" frameborder="0" class="w-full h-[90vh]" src=""></iframe>
    </div>
</div>



    <script id="midtrans-script" type="text/javascript" src="https://api.midtrans.com/v2/assets/js/midtrans-new-3ds.min.js"
        data-environment="sandbox" data-client-key="SB-Mid-client-y44CMrM32XNm4ZA0"></script>

    <script type="text/javascript" src="https://app.stg.midtrans.com/snap/snap.js"
        data-client-key="SB-Mid-client-y44CMrM32XNm4ZA0"></script>

    <script type="text/javascript"
        src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="SB-Mid-client-y44CMrM32XNm4ZA0"></script>
    {{-- @section('scripts') --}}

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Load jQuery first -->
    <script src="https://cdn.jsdelivr.net/npm/imask"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/picomodal/3.0.0/picoModal.js"></script>
    <script>

        function getSelectedPayType() {
            const selectedPayType = document.querySelector('input[name="payment_type"]:checked');
            return selectedPayType ? selectedPayType.id : null;
        }

        function toggleCardDetails(show) {
            const cardDetails = document.getElementById('card-details');
            if (show) {
                cardDetails.classList.remove('hidden');
            } else {
                cardDetails.classList.add('hidden');
            }
        }

        function validateForm() {
            // event.preventDefault();

            // Get form elements
            const invoiceInput = document.getElementById('invoice_id');
            const amountInput = document.getElementById('amount');

            // Error messages
            const invoiceError = document.getElementById('invoice-error');
            const amountError = document.getElementById('amount-error');
            const paymentError = document.getElementById('payment-error');

            // Validation status
            let isValid = true;

            // Invoice validation
            if (invoiceInput.value.trim() === '') {
                invoiceInput.classList.add('border-red-500');
                invoiceError.classList.remove('hidden');
                isValid = false;
            } else {
                invoiceInput.classList.remove('border-red-500');
                invoiceError.classList.add('hidden');
            }

            // Amount validation
            if (amountInput.value.trim() === '') {
                amountInput.classList.add('border-red-500');
                amountError.classList.remove('hidden');
                isValid = false;
            } else {
                amountInput.classList.remove('border-red-500');
                amountError.classList.add('hidden');
            }

            // If all fields are valid, submit the form
           return isValid;
        }

        function validateCard(){
            let isValid = true;

            // Get form elements
            const expiryInput = document.getElementById('expiry_date');
            const cvvInput = document.getElementById('cvv');
            const expiryError = document.getElementById('expiry-error');
            const cvvError = document.getElementById('cvv-error');

            // Error flag

            // Validate Expiry Date
            const expiryRegex = /^(0[1-9]|1[0-2])\/\d{2}$/;
            const currentDate = new Date();
            const expiryParts = expiryInput.value.split('/');
            const expiryMonth = parseInt(expiryParts[0], 10);
            const expiryYear = parseInt('20' + expiryParts[1], 10); // Assuming `20YY` format

            if (!expiryRegex.test(expiryInput.value) ||
                expiryYear < currentDate.getFullYear() ||
                (expiryYear === currentDate.getFullYear() && expiryMonth < currentDate.getMonth() + 1)) {
                expiryInput.classList.add('border-red-500');
                expiryError.classList.remove('hidden');
                isValid = false;
            } else {
                expiryInput.classList.remove('border-red-500');
                expiryError.classList.add('hidden');
            }

            // Validate CVV
            const cvvRegex = /^\d{3,4}$/;
            if (!cvvRegex.test(cvvInput.value)) {
                cvvInput.classList.add('border-red-500');
                cvvError.classList.remove('hidden');
                isValid = false;
            } else {
                cvvInput.classList.remove('border-red-500');
                cvvError.classList.add('hidden');
            }

            // If all fields are valid, submit the form
           return isValid;
        }

        document.addEventListener('DOMContentLoaded', function() {
            var expiryDateElement = document.getElementById('expiry_date');
            var maskOptions = {
                mask: 'MM/YY',
                blocks: {
                    MM: {
                        mask: IMask.MaskedRange,
                        from: 1,
                        to: 12  
                    },
                    YY: {
                        mask: IMask.MaskedRange,
                        from: 0,
                        to: 99
                    }
                }
            };
            var mask = IMask(expiryDateElement, maskOptions);

            // Mask for card number
            var cardNumberElement = document.getElementById('card_number');
            var cardNumberMask = IMask(cardNumberElement, {
                mask: '0000 0000 0000 0000' // Credit card format
            });

            // Mask for amount with thousand separators
            var amountElement = document.getElementById('amount');
            var amountMask = IMask(amountElement, {
                mask: Number,
                thousandsSeparator: ',' // Add comma as thousands separator
            });
        });

        function selectPaymentType(payType){
            event.preventDefault();
            isValid = validateForm();

            if(isValid == false){
                return;
            }

            const payTySelection = document.getElementById('payment-container');
            payTySelection.classList.add('hidden');

            if(payType == 'card'){
                toggleCardDetails(true);

                const submitBtn = document.getElementById('submit-btn');
                submitBtn.removeAttribute('hidden');

            } else {
                
                $('#snap-container').empty();
                    $.ajax({
                        url: "{{ route('token.request') }}",
                        method: "POST", // Use POST for secure operations
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            invoice_id : $('#invoice_id').val(),
                            amount: $('#amount').val().replace(/,/g, '')
                        },
                        success: function(response) {
                            window.snap.embed(response, {
                            embedId: 'snap-container',
                            onSuccess: function (result) {
                                /* You may add your own implementation here */
                                alert("payment success!"); console.log(result.transaction_id);
                                getResult(result.transaction_id);
                            },
                            onPending: function (result) {
                                /* You may add your own implementation here */
                                alert("wating your payment!"); console.log(result);
                                // getResult(result.transaction_id);
                            },
                            onError: function (result) {
                                /* You may add your own implementation here */
                                alert("payment failed!"); console.log(result);
                            },
                            onClose: function () {
                                /* You may add your own implementation here */
                                alert('you closed the popup without finishing the payment');
                            }
                            });
                        },
                        error: function(xhr, status, error) {
                            // Handle error response
                            console.error("Payment failed:", status, error);
                        }
                    });

                    return;
              
            }
        }

        function requestPayment() {
            event.preventDefault();

            isValid = validateForm();

            if(isValid == false){
                return;
            }

            isValid = validateCard();

            if(isValid == false){
                return;
            }

            const cardNumber = $('#card_number').val(); // while this not, why?
            const expDate = $('#expiry_date').val();
            var [expMonth, expYear] = expDate.split('/');
            expYear = '20' + expYear;

            var cardData = {
                "card_number": cardNumber,
                "card_exp_month": expMonth,
                "card_exp_year": expYear,
                "card_cvv": 123,
                // "OTP/3DS": 112233,
                // "bank_one_time_token": "12345678"
            };

            // callback functions
            var options = {
                onSuccess: function(response) {
                    // Success to get card token_id, implement as you wish here
                    console.log('Success to get card token_id, response:', response);
                    var token_id = response.token_id;

                    $.ajax({
                        url: "{{ route('payment.request') }}",
                        method: "POST", // Use POST for secure operations
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            token_id: response.token_id,
                            invoice_id : $('#invoice_id').val(),
                            amount: $('#amount').val().replace(/,/g, '')
                        },
                        success: function(response) {
                            // Handle success response
                            console.log("Payment successful:", response);
                           checkingResponse(response);
                        },
                        error: function(xhr, status, error) {
                            // Handle error response
                            console.error("Payment failed:", status, error);
                        }
                    });

                },
                onFailure: function(response) {
                    // Fail to get card token_id, implement as you wish here
                    console.log('Fail to get card token_id, response:', response);

                    // you may want to implement displaying failure message to customer.
                    // Also record the error message to your log, so you can review
                    // what causing failure on this transaction.
                }
            };

            // trigger `getCardToken` function
            MidtransNew3ds.getCardToken(cardData, options);
        }

        function checkingResponse(response) {
            if (response) {
                // If the transaction_status is 'capture' and fraud_status is 'accept'
                if (response.transaction_status === 'capture' && response.fraud_status === 'accept') {
                    getResult(response.transaction_id);
                }
                // If the transaction_status is 'pending' and redirect_url exists
                else if (response.transaction_status === 'pending' && response.redirect_url) {
                    threeDSauth(response.redirect_url);
                }
            }
        }

        function threeDSauth(redirectUrl){
            var redirect_url = redirectUrl;

            // callback functions
            var options = {
                performAuthentication: function(redirect_url) {
                    // Open the modal with the 3DS authentication URL
                    openModal(redirect_url);
                },
                onSuccess: function(response) {
                    // 3ds authentication success, implement payment success scenario
                    console.log('response:', response);
                    closeModal();
                    getResult(response.transaction_id);
                },
                onFailure: function(response) {
                    // 3ds authentication failure, implement payment failure scenario
                    console.log('response:', response);
                    closeModal();
                    getResult(response.transaction_id);
                },
                onPending: function(response) {
                    // transaction is pending, transaction result will be notified later via 
                    // HTTP POST notification, implement as you wish here
                    console.log('response:', response);
                    closeModal();
                }
            };

            // trigger `authenticate` function
            MidtransNew3ds.authenticate(redirect_url, options);

            // Open the modal
            function openModal(url) {
                const modal = document.getElementById("threeDSModal");
                const iframe = document.getElementById("threeDSIframe");
                iframe.src = url;  // Set the iframe src to the 3DS authentication URL
                modal.classList.remove("hidden"); // Show the modal
            }

            // Close the modal
            function closeModal() {
                const modal = document.getElementById("threeDSModal");
                const iframe = document.getElementById("threeDSIframe");
                iframe.src = "";  // Clear iframe source
                modal.classList.add("hidden"); // Hide the modal
            }
        }

        function getResult(trans_id) {
            // Corrected syntax for window.location

            console.log(trans_id);
            const statusRequestUrl = "{{ route('status.request', ':trans_id') }}";
            window.location.href = statusRequestUrl.replace(':trans_id', trans_id);

        }

    </script>
    {{-- @endsection --}}
@endsection
