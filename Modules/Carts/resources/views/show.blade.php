<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>سبد خرید</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
</head>
<body class="bg-gray-100">
    <header class="bg-white shadow-md p-4 flex items-center justify-between">
        <div class="text-xl font-bold text-gray-800">
            <a href="{{ url('/') }}">فروشگاه من</a>
        </div>
        <nav class="flex items-center gap-6">
            <a href="{{ url('/') }}" class="text-gray-700 hover:text-blue-600">خانه</a>
            <a href="{{ url('/shop') }}" class="text-gray-700 hover:text-blue-600">محصولات</a>
            @auth

                {{-- <button data-drawer-target="cart-drawer" data-drawer-show="cart-drawer" aria-controls="cart-drawer" class="relative flex items-center gap-1 text-gray-700 hover:text-blue-600">
                    🛒
                    <span>سبد خرید</span>
                    @if($count > 0)
                        <span class="absolute -top-2 -right-3 bg-red-600 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                            {{ $count }}
                        </span>
                    @endif
                </button> --}}
            @else
                <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600">ورود</a>
            @endauth
        </nav>
    </header>

    <div class="max-w-screen-xl mx-auto p-4">
        <!-- Display Success/Error Messages -->
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-3xl font-bold mb-6">سبد خرید</h1>
            @if($cartItems->isEmpty())
                <p class="text-gray-500">سبد خرید شما خالی است.</p>
            @else
                <div class="space-y-4">
                    @foreach($cartItems as $item)
                        <div class="flex items-center gap-4 border-b pb-4">
                            <img src="{{ $item->product->image ?? 'https://via.placeholder.com/100' }}" alt="{{ $item->product->name }}" class="w-24 h-24 object-cover rounded">
                            <div class="flex-1">
                                <h2 class="text-lg font-semibold">{{ $item->product->name }}</h2>
                                <p class="text-gray-600">قیمت واحد: {{ number_format($item->price / 100, 2) }} تومان</p>
                                <p class="text-gray-600">تعداد: {{ $item->quantity }}</p>
                                <p class="text-gray-600">جمع: {{ number_format($item->total / 100, 2) }} تومان</p>
                                @if($item->discount_amount > 0)
                                    <p class="text-green-600">تخفیف: {{ number_format($item->discount_amount / 100, 2) }} تومان</p>
                                @endif
                            </div>
                            <div class="flex items-center gap-2">
                                <form action="{{ route('cart.addQuantity', $item->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-3 py-2 bg-gray-200 hover:bg-gray-300 rounded">+</button>
                                </form>
                                <form action="{{ route('cart.loseQuantity', $item->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-3 py-2 bg-gray-200 hover:bg-gray-300 rounded">-</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                    <div class="flex justify-between items-center mt-6">
                        <form action="{{ route('cart.clear') }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">خالی کردن سبد خرید</button>
                        </form>
                        <p class="text-xl font-semibold">جمع کل: {{ number_format($cartItems->sum('total') / 100, 2) }} تومان</p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Include Cart Drawer -->


</body>
</html>