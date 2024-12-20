@extends('layout.app')

@section('main')

<main class="flex-1" style="background-color: #645AE0;">

    {{-- <header class="bg-white shadow p-6">
      <h2 class="text-3xl font-bold text-gray-800">Payment</h2>
    </header> --}}
  
    <div class="max-w-4xl mx-auto p-6">
      <form class="bg-white shadow-lg rounded-lg p-8 space-y-8">
        
        <!-- Text Input -->
        <div>
          <label for="invoice_id" class="block text-sm font-medium text-gray-700">No Invoice</label>
          <input 
            type="text" 
            id="invoice_id" 
            autocomplete="off"
            class="mt-2 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm p-3" 
            placeholder="">
        </div>
  
        <!-- Number Input -->
        <div>
          <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
          <input 
            type="number" 
            id="amount" 
            class="mt-2 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm p-3" 
            placeholder="">
        </div>
    
        <!-- Radio Buttons -->
        <div>
          <fieldset>
            <legend class="text-sm font-medium text-gray-700">Payment Type</legend>
            <div class="mt-4 space-y-2">
              <div class="flex items-center">
                <input 
                  id="card" 
                  name="payment_type" 
                  type="radio" 
                  class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-500"
                  onclick="toggleCardDetails(true)">
                <label for="card" class="ml-3 text-sm text-gray-700">Debet / Credit</label>
              </div>
              <div class="flex items-center">
                <input 
                  id="other" 
                  name="payment_type" 
                  type="radio" 
                  class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-500"
                  onclick="toggleCardDetails(false)">
                <label for="other" class="ml-3 text-sm text-gray-700">Other</label>
              </div>
            </div>
          </fieldset>
        </div>
  
        <!-- Card Details Form -->
        <div id="card-details" class="hidden space-y-6">
          <!-- Card Number -->
          <div>
            <label for="card_number" class="block text-sm font-medium text-gray-800">Card Number</label>
            <input 
              type="text" 
              id="card_number" 
              class="mt-2 block w-full border-gray-300 rounded-lg shadow-md focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm p-4 bg-gray-50" 
              placeholder="1234 5678 9101 1121">
          </div>
        
          <!-- Expiry Date, CVV, Card Image (Same Line) -->
          <div class="flex items-center justify-between space-x-6">
            <!-- Expiry Date -->
            <div class="flex-1">
              <label for="expiry_date" class="block text-sm font-medium text-gray-800">Expiry Date</label>
              <input 
                type="text" 
                id="expiry_date" 
                class="mt-2 block w-full border-gray-300 rounded-lg shadow-md focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm p-4 bg-gray-50" 
                placeholder="MM/YY">
            </div>
        
            <!-- CVV -->
            <div class="flex-1">
              <label for="cvv" class="block text-sm font-medium text-gray-800">CVV</label>
              <input 
                type="text" 
                id="cvv" 
                class="mt-2 block w-full border-gray-300 rounded-lg shadow-md focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm p-4 bg-gray-50" 
                placeholder="123">
            </div>
        
            <!-- Card Image -->
            <div>
              <label class="block text-sm font-medium text-gray-800">Mastercard</label>
              <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADQAAAAgCAMAAABq4atUAAAApVBMVEX3nhvrABv/////XwD+8fLtGjLsDSbtJDv/+fHzKA/+VwLuLkTwQlb7zYn+7dX94uXrBR/83KvxHhL9cAf94rv3pCv+aQT82KP6iBH95sT4n6nxUGL1go/7zNH5vmb4r0T4qzv5tE7yXW72jZn0c4H4p7D/9eb+6ev3YUb81JruDhb7ewzzZ3f7TQX5jxT3oSP3lhj5srruKT/2NQv4bFH6vmf+8d0ofNcMAAABMUlEQVQ4jZ2V6XaCMBCFhyRCrMpSwaVWFKtW7GJbte//aG0KQuxMwpH7i5PDdyZzMwuwSuJh1uuErtd/nFdnMkoXCSTLbODXPzK4fASr0KnkPQl1Nk2h1jL6D4m1hii5G7bN4FqZfwU99xykHWBFGjTvYOaeDwlqUEEByXCSyktIfGFmz5VeCCouoFfMOG9/EH/HUCIVFBBMt2D4iE4L2IqA7kqITzB0kAyEJRAdasxgY85I6QNDKQPqdjVD3w+IWthrEOW6D4aHvYh64Bjc26FxE0TaB16b6/XbGEFVnt1ykPBJQPbHzX5rj3DCXkZ5m4LdqtYIMdTYGmxtDkUEKprw1naXU+Ng6ZpKyDrCjnxE2J03DMvTARunD8t2Y1klNmtYAIsYbw3TqjmXq+ZbWzU/CLUYCqjQWk0AAAAASUVORK5CYII=" alt="MasterCard" class="mt-2 h-8">
            </div>
          </div>
        </div>
                  
        <!-- Submit Button -->
        <div>
          <button 
            type="submit" 
            class="w-full bg-indigo-600 text-white font-semibold py-3 px-6 rounded-lg shadow hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
            Submit
          </button>
        </div>
      </form>
    </div>
  </main>

@endsection

<script id="midtrans-script" type="text/javascript"
src="https://api.midtrans.com/v2/assets/js/midtrans-new-3ds.min.js"
data-environment="sandbox"
data-client-key="SB-Mid-client-y44CMrM32XNm4ZA0"></script>
{{-- @section('scripts') --}}
  <script>
    function toggleCardDetails(show) {
      const cardDetails = document.getElementById('card-details');
      if (show) {
        cardDetails.classList.remove('hidden');
      } else {
        cardDetails.classList.add('hidden');
      }
    }

    // card data from customer input, for example
    var cardData = {
      "card_number": 4811111111111114,
      "card_exp_month": 02,
      "card_exp_year": 2025,
      // "card_cvv": 123,
      "OTP/3DS": 112233,
      "bank_one_time_token": "12345678"
    };

    // callback functions
    var options = {
      onSuccess: function(response){
        // Success to get card token_id, implement as you wish here
        console.log('Success to get card token_id, response:', response);
        var token_id = response.token_id;

        console.log('This is the card token_id:', token_id);
        // Implement sending the token_id to backend to proceed to next step
      },
      onFailure: function(response){
        // Fail to get card token_id, implement as you wish here
        console.log('Fail to get card token_id, response:', response);

        // you may want to implement displaying failure message to customer.
        // Also record the error message to your log, so you can review
        // what causing failure on this transaction.
      }
    };

    // trigger `getCardToken` function
    MidtransNew3ds.getCardToken(cardData, options);
  </script>
{{-- @endsection --}}
