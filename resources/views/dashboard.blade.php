<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'داشبورد')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans min-h-screen">
    <!-- Sidebar -->
    <button data-drawer-target="default-sidebar" data-drawer-toggle="default-sidebar" aria-controls="default-sidebar" type="button" class="inline-flex items-center p-2 mt-2 mr-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200">
        <span class="sr-only">باز کردن منو</span>
        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
        </svg>
    </button>

    <aside id="default-sidebar" class="fixed top-0 right-0 z-40 w-64 h-screen transition-transform translate-x-full sm:translate-x-0 bg-gray-50 dark:bg-gray-800">
        <div class="h-full flex flex-col justify-between px-3 py-4 overflow-y-auto">
            <ul class="space-y-2 font-medium">
                <li>
                    <a href="{{ route('dashboard.orders.index') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-white group">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="48" height="48" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-labelledby="title-orders">
                            <title id="title-orders">Orders</title>
                            <rect x="3" y="3" width="16" height="16" rx="2" />
                            <line x1="8" y1="8" x2="16" y2="8" />
                            <line x1="8" y1="12" x2="16" y2="12" />
                            <line x1="8" y1="16" x2="12" y2="16" />
                            <polyline points="5.5 8 6.5 9 8.5 7" />
                            <polyline points="5.5 12 6.5 13 8.5 11" />
                        </svg>
                        <span class="flex-1 mr-3 whitespace-nowrap">سفارشات</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('dashboard.products.index') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-white group">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="46" height="46" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-labelledby="title-products">
                            <title id="title-products">Products</title>
                            <path d="M12 2l8 4.5v9L12 22 4 15.5v-9L12 2z" />
                            <path d="M12 6.5v6.5" />
                            <line x1="20" y1="6.5" x2="12" y2="11" />
                            <line x1="4" y1="6.5" x2="12" y2="11" />
                        </svg>
                        <span class="flex-1 mr-3 whitespace-nowrap">محصولات</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('dashboard.categories.index') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-white group">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="46" height="46" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-labelledby="title-categories">
                            <title id="title-categories">Categories</title>
                            <path d="M21 11.5v5a2 2 0 0 1-2 2h-5L7 11l4-4 7 4.5z" />
                            <circle cx="11" cy="9" r="1.2" />
                            <line x1="3" y1="3" x2="8.5" y2="8.5" />
                        </svg>
                        <span class="flex-1 mr-3 whitespace-nowrap">دسته بندی</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('dashboard.users.index') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-white group">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="46" height="46" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-labelledby="title-users">
                            <title id="title-users">Users</title>
                            <circle cx="9" cy="8" r="2.4" />
                            <path d="M4.5 18.5a5.5 5.5 0 0 1 9 0" />
                            <circle cx="17" cy="9.5" r="1.6" />
                            <path d="M14.5 19a3.5 3.5 0 0 1 5 0" />
                        </svg>
                        <span class="flex-1 mr-3 whitespace-nowrap">کاربران</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('dashboard') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-white group">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="46" height="46" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-labelledby="title-payments">
                            <title id="title-payments">Payments</title>
                            <rect x="1.5" y="5" width="21" height="14" rx="2.2" />
                            <rect x="3.5" y="9" width="6" height="3" rx="0.6" />
                            <line x1="3.5" y1="15" x2="20.5" y2="15" />
                            <circle cx="17" cy="11.5" r="1.2" />
                        </svg>
                        <span class="flex-1 mr-3 whitespace-nowrap">پرداخت ها</span>
                    </a>
                </li>
            </ul>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition">خروج</button>
            </form>
        </div>
    </aside>

    <!-- Main content -->
    <div class="sm:mr-64">
        <div class="max-w-7xl mx-auto p-6">
            <div class="flex justify-end items-center mb-6">
                <h1 class="text-3xl font-bold text-gray-800">خوش آمدید، {{ Auth::user()->name }}!</h1>
            </div>
            @yield('content')
        </div>
    </div>

    <!-- Sidebar Toggle Script -->
    <script>
        const sidebar = document.getElementById('default-sidebar');
        const toggleButton = document.querySelector('[data-drawer-toggle="default-sidebar"]');
        
        toggleButton.addEventListener('click', () => {
            sidebar.classList.toggle('translate-x-full');
            sidebar.classList.toggle('translate-x-0');
        });
    </script>
</body>
</html>