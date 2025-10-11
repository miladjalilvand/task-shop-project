<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>@yield('title', config('app.name', 'فروشگاه'))</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Flowbite CSS (cdn) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
</head>
<body class="antialiased bg-gray-50">
    <header class="bg-white shadow-md p-4 flex items-center justify-between">
        <div class="text-xl font-bold text-gray-800">
            <a href="{{ url('/') }}">فروشگاه من</a>
        </div>

        <nav class="flex items-center gap-6">
            <a href="{{ url('/') }}" class="text-gray-700 hover:text-blue-600">خانه</a>
            <a href="{{ url('/shop') }}" class="text-gray-700 hover:text-blue-600">محصولات</a>

            @auth
                {{-- بهتر است تعداد آیتم‌های سبد در کنترلر محاسبه و ارسال شود (Performance) --}}
                @php
                    $count = isset($cartCount) ? $cartCount : (Auth::user()->cart ? Auth::user()->cart->cartItems()->count() : 0);
                @endphp

                <a  class="relative flex items-center gap-1 text-gray-700 hover:text-blue-600">
                    🛒
                    <span>سبد خرید</span>
                    @if($count > 0)
                        <span class="absolute -top-2 -right-3 bg-red-600 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                            {{ $count }}
                        </span>
                    @endif
                </a>
            @else
                <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600">ورود</a>
            @endauth
        </nav>
    </header>

    <main class="flex flex-col min-h-screen">
        <div class="container mx-auto px-4 py-6">
            @yield('content')
        </div>
    </main>

    {{-- در صورت نیاز کامپوننت‌های جاوااسکریپت Flowbite را وارد کنید --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
</body>
</html>
