<header class="bg-white shadow-md p-4 flex items-center justify-between">
    {{-- لوگو --}}
    <div class="text-xl font-bold text-gray-800">
        <a href="{{ url('/') }}">فروشگاه من</a>
    </div>

    {{-- منو --}}
    <nav class="flex items-center gap-6">
        <a href="{{ url('/') }}" class="text-gray-700 hover:text-blue-600">خانه</a>
        <a href="{{ url('/shop') }}" class="text-gray-700 hover:text-blue-600">محصولات</a>

        {{-- بررسی لاگین بودن کاربر --}}
        @auth
            @php
                $cart = Auth::user()->cart;
                $count = $cart ? $cart->cartItems()->count() : 0;
            @endphp

            <a href="{{ route('cart.index') }}" class="relative flex items-center gap-1 text-gray-700 hover:text-blue-600">
                🛒
                <span>سبد خرید</span>
                @if($count > 0)
                    <span
                        class="absolute -top-2 -right-3 bg-red-600 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                        {{ $count }}
                    </span>
                @endif
            </a>
        @else
            <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600">ورود</a>
        @endauth
    </nav>
</header>
