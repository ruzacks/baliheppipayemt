<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Our Products') - Soojabali</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">
    <!-- Navbar -->
    <header class="bg-white shadow">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <a href="{{ url('/') }}" class="flex items-center">
                <img 
                    src="https://soojabali.com/wp-content/uploads/2024/02/new-sooja-logo.png" 
                    alt="Your Store Logo" 
                    class="h-10"
                />
            </a>
            <nav class="flex items-center space-x-4">
                <a href="{{ url('/product-list') }}" class="text-gray-600 hover:text-blue-500">Products</a>
                <div class="text-right">
                    <button onclick="toggleModal('cartModal')" class="py-4 px-1 relative border-2 border-transparent text-gray-800 rounded-full hover:text-gray-400 focus:outline-none focus:text-gray-500 transition duration-150 ease-in-out" aria-label="Cart">
                        <svg class="h-6 w-6" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                          <path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <span class="absolute inset-0 object-right-top -mr-6">
                          <div id="itemInChart" class="inline-flex items-center px-1.5 py-0.5 border-2 border-white rounded-full text-xs font-semibold leading-4 bg-red-500 text-white">
                            0   
                          </div>
                        </span>
                    </button>
                </div>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-6">
        @yield('main')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-gray-200 py-6">
        <div class="container mx-auto text-center">
            <p>&copy; {{ date('Y') }} Soojabali. All rights reserved.</p>
            <p class="mt-2">
                <a href="{{ url('/privacy') }}" class="text-gray-400 hover:text-white">Privacy Policy</a> |
                <a href="{{ url('/terms') }}" class="text-gray-400 hover:text-white">Terms of Service</a>
            </p>
        </div>
    </footer>
</body>
</html>
