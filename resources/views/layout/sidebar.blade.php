<!-- Sidebar -->
<aside
    class="w-64 bg-white shadow-md h-full flex-shrink-0 transition-all duration-300 ease-in-out md:block lg:block hidden">
    <div class="p-6 border-b" style="background-color: #102c42; color: white;">
        <h1 class="text-2xl font-bold">Payment App</h1>
    </div>
    <nav class="p-4">
        <ul class="space-y-3">
            <li>
                <a href="{{ route('admin-panel') }}"
                    class="flex items-center text-gray-600 hover:bg-gray-100 p-3 rounded-lg">
                    Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('fee-settings.index') }}"
                    class="flex items-center text-gray-600 hover:bg-gray-100 p-3 rounded-lg">
                    Fee Settings
                </a>
            </li>
            <li>
                <a href="{{ route('products.index') }}"
                    class="flex items-center text-gray-600 hover:bg-gray-100 p-3 rounded-lg">
                    Produk
                </a>
            </li>
            <li>
                <a href="{{ route('sales_persons.index') }}"
                    class="flex items-center text-gray-600 hover:bg-gray-100 p-3 rounded-lg">
                    Sales
                </a>
            </li>
            <li>
                <a href="{{ route('api_services.index') }}"
                    class="flex items-center text-gray-600 hover:bg-gray-100 p-3 rounded-lg">
                    Payment API
                </a>
            </li>
        </ul>
    </nav>
</aside>

<!-- Sidebar Toggle for mobile -->
<div class="md:hidden flex items-center justify-between p-4 bg-gray-100">
    <button id="sidebar-toggle" class="text-gray-600">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"
            stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>
</div>

<!-- Sidebar content for mobile view, hidden by default -->
<aside id="mobile-sidebar" class="fixed inset-0 bg-gray-800 bg-opacity-50 hidden">
    <div class="w-64 bg-white shadow-md h-full flex-shrink-0">
        <div class="p-6 border-b" style="background-color: #102c42; color: white;">
            <h1 class="text-2xl font-bold">Payment App</h1>
        </div>
        <nav class="p-4">
            <ul class="space-y-3">
                <li>
                    <a href="{{ route('admin-panel') }}"
                        class="flex items-center text-gray-600 hover:bg-gray-100 p-3 rounded-lg">
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('fee-settings.index') }}"
                        class="flex items-center text-gray-600 hover:bg-gray-100 p-3 rounded-lg">
                        Fee Settings
                    </a>
                </li>
                <li>
                    <a href="{{ route('products.index') }}"
                        class="flex items-center text-gray-600 hover:bg-gray-100 p-3 rounded-lg">
                        Produk
                    </a>
                </li>
                <li>
                    <a href="{{ route('sales_persons.index') }}"
                        class="flex items-center text-gray-600 hover:bg-gray-100 p-3 rounded-lg">
                        Sales
                    </a>
                </li>
                <li>
                    <a href="{{ route('api_services.index') }}"
                        class="flex items-center text-gray-600 hover:bg-gray-100 p-3 rounded-lg">
                        Payment API
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>

<script>
    // Sidebar toggle for mobile
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const mobileSidebar = document.getElementById('mobile-sidebar');

    sidebarToggle.addEventListener('click', () => {
        mobileSidebar.classList.toggle('hidden');
    });
</script>


{{-- <li>
            <!-- Parent Menu Item -->
            <button 
              class="flex items-center justify-between w-full text-gray-600 hover:bg-gray-100 p-3 rounded-lg" 
              onclick="toggleMenuWithAnimation('submenu1')">
              <span class="flex items-center">
                  <!-- <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mr-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h11M9 21v-7m4 0h8m0 0l-4-4m4 4l-4 4" />
                  </svg> -->
                Payment
              </span>
              <svg xmlns="http://www.w3.org/2000/svg" id="arrow1" class="w-5 h-5 text-gray-500 transition-transform transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 9l6 6 6-6" />
              </svg>
            </button>
          
            <!-- Submenu -->
            <ul id="submenu1" class="pl-10 space-y-2 overflow-hidden transition-all duration-300 ease-in-out max-h-0">
              <li>
                <a href="#" class="block text-gray-600 hover:bg-gray-100 p-2 rounded-lg">Submenu Item 1</a>
              </li>
              <li>
                <a href="#" class="block text-gray-600 hover:bg-gray-100 p-2 rounded-lg">Submenu Item 2</a>
              </li>
              <li>
                <a href="#" class="block text-gray-600 hover:bg-gray-100 p-2 rounded-lg">Submenu Item 3</a>
              </li>
            </ul>
          </li>
          
          <li>
            <a href="#" class="flex items-center text-gray-600 hover:bg-gray-100 p-3 rounded-lg">
              <!-- <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mr-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M20 21v-2a4 4 0 00-3-3.87M4 10v11m16 0v-6a8 8 0 00-8-8V3m0 5V3m0 5a8 8 0 00-8 8v3" />
              </svg> -->
              Payment
            </a>
          </li>
          <li>
            <a href="#" class="flex items-center text-gray-600 hover:bg-gray-100 p-3 rounded-lg">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mr-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M7 16v-2a4 4 0 014-4h5a4 4 0 014 4v2M5 16v4m14-4v4M6 9a4 4 0 100-8 4 4 0 000 8zM18 9a4 4 0 100-8 4 4 0 000 8z" />
              </svg>
              Billing
            </a>
          </li>
          <li>
            <a href="#" class="flex items-center text-gray-600 hover:bg-gray-100 p-3 rounded-lg">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mr-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c0 1.105-1.79 3-4 3S4 9.105 4 8s1.79-3 4-3 4 1.895 4 3zM16 16s-1.895 2-4 2-4-2-4-2M16 8c0 1.105 1.79 3 4 3s4-1.895 4-3-1.79-3-4-3-4 1.895-4 3z" />
              </svg>
              Settings
            </a>
          </li> --}}
