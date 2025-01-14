<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Our Products') - Your Store</title>
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
            <nav class="space-x-4">
                <a href="{{ url('/products') }}" class="text-gray-600 hover:text-blue-500">Products</a>
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
