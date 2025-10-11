<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>فروشگاه - همه محصولات</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
</head>
<body class="bg-gray-100">
    <nav class="bg-white border-gray-200 dark:bg-gray-900">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
            <a href="/" class="flex items-center space-x-3">
                <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">فروشگاه</span>
            </a>
            <button data-collapse-toggle="navbar-default" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="navbar-default" aria-expanded="false">
                <span class="sr-only">باز کردن منوی اصلی</span>
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
                </svg>
            </button>
            <div class="hidden w-full md:block md:w-auto" id="navbar-default">
                <ul class="font-medium flex flex-col p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:space-x-8 md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
                    <li>
                        <a href="{{ route('shop.index') }}" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent {{ !$categorySlug ? 'text-blue-700' : '' }}">خانه</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="max-w-screen-xl mx-auto p-4 flex flex-col md:flex-row gap-6">
        <!-- Sidebar for Categories -->
        <aside class=" bg-white rounded-lg shadow-md p-4">
            <h2 class="text-xl font-bold mb-4">دسته‌بندی‌ها</h2>
            <ul class="space-y-2">
                @php
                    function renderCategoryTree($categories, $categorySlug, $depth = 0) {
                        foreach ($categories as $category) {
                            echo '<li>';
                            echo '<a href="' . route('shop.index', ['category' => $category->slug]) . '" class="block py-2 px-3 text-gray-900 hover:bg-gray-100 rounded ' . ($categorySlug == $category->slug ? 'text-blue-700 font-semibold' : '') . '" style="padding-right: ' . ($depth * 1.5) . 'rem;">' . ($depth > 0 ? '↳ ' : '') . $category->name . '</a>';
                            if ($category->children->isNotEmpty()) {
                                echo '<ul class="space-y-2">';
                                renderCategoryTree($category->children, $categorySlug, $depth + 1);
                                echo '</ul>';
                            }
                            echo '</li>';
                        }
                    }
                @endphp
                @php renderCategoryTree($categories, $categorySlug) @endphp
            </ul>
        </aside>

        <!-- Product Grid -->
        <div class="w-full md:w-3/4">
            <h1 class="text-3xl font-bold mb-6">{{ $categorySlug ? ($categories->firstWhere('slug', $categorySlug) ? $categories->firstWhere('slug', $categorySlug)->name : 'دسته‌بندی یافت نشد') : 'همه محصولات' }}</h1>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($products as $product)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <img src="{{ $product->image ?? 'https://via.placeholder.com/300' }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                        <div class="p-4">
                            <h2 class="text-lg font-semibold">{{ $product->name }}</h2>
                            <p class="text-gray-600">{{ number_format($product->price / 100, 2) }} تومان</p>
                            @if($product->discount > 0)
                                <p class="text-green-600">{{ $product->discount }}% تخفیف</p>
                            @endif
                            <a href="{{ route('shop.show', $product->slug) }}" class="mt-4 inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">مشاهده جزئیات</a>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-6">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</body>
</html>