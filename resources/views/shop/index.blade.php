@extends('layout')

@section('title', 'محصولات')

@section('content')
<div class="bg-gray-100">
   
    <div class="max-w-screen-xl mx-auto p-4 flex flex-col md:flex-row gap-6">
        <!-- Sidebar for Categories -->
        <aside class=" bg-white rounded-lg shadow-md p-4">
            <h2 class="text-xl font-bold mb-4">دسته‌بندی‌ها</h2>
            <ul class="space-y-2">
                @php
                    function renderCategoryTree($categories, $categorySlug, $depth = 0) {
                        foreach ($categories as $category) {
                            echo '<li>';
                            echo '<a href="' . route('shop.index', ['category' => $category->slug]) . '" class="block py-2 px-3 text-gray-900 hover:bg-gray-100 rounded ' 
                                . ($categorySlug == $category->slug ? 'text-blue-700 font-semibold' : '') . '" style="padding-right: ' .
                                 ($depth * 1.5) . 'rem;">' . ($depth > 0 ? '↳ ' : '') . $category->name . '
                                 </a>';
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
                        @if ($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                 class="w-full h-48 object-cover">
                        @else
                            بدون تصویر
                        @endif
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
</div>
@endsection
