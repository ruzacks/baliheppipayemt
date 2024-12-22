@extends('layout.app')

@section('main')
<main class="flex-1" style="background-color: #645AE0;">
    <div class="max-w-4xl mx-auto p-6">
        <div class="bg-white shadow-lg rounded-lg p-8 text-center space-y-6">
            <!-- Failure Icon -->
            <div class="flex justify-center">
                <svg class="w-16 h-16 text-red-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </div>

            <!-- Failure Message -->
            <h1 class="text-3xl font-bold text-gray-800">Payment Failed</h1>
            <p class="text-gray-600">{{ $response->status_message }}</p>
            <p class="text-gray-600">Please try again or contact support or bank provider if the issue persists.</p>


            <!-- Suggested Actions -->
            <div class="space-y-4">
                <a href="/payment" class="inline-block bg-indigo-600 text-white font-semibold py-3 px-6 rounded-lg shadow hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 try-again">
                    Try Again
                </a>
                
            </div>
        </div>
    </div>
</main>

<script>
    document.querySelector('.try-again').addEventListener('click', function (e) {
        e.preventDefault();
        window.parent.location.href = "/mybill";
    });
</script>

@endsection