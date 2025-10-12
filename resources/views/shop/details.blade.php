@extends('layout')

@section('title', $product->name ?? 'جزئیات محصول')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- تصویر محصول --}}
        <div>
            @if (!empty($product->image) && \Illuminate\Support\Facades\Storage::disk('public')->exists($product->image))
                <img src="{{ asset('storage/' . $product->image) }}" 
                     alt="{{ $product->name }}" 
                     class="w-full h-96 object-cover rounded-lg">
            @else
                <img src="https://via.placeholder.com/400x400?text=No+Image" 
                     alt="بدون تصویر" 
                     class="w-full h-96 object-cover rounded-lg">
            @endif
        </div>

        {{-- جزئیات محصول --}}
        <div>
            <h1 class="text-3xl font-bold mb-4">{{ $product->name }}</h1>
            <p class="text-gray-600 mb-4">{{ $product->description ?? 'توضیحی برای این محصول ثبت نشده است.' }}</p>

            <p class="text-2xl font-semibold mb-2">{{ number_format(($product->price ?? 0) / 100, 2) }} تومان</p>

            @if(!empty($product->discount) && $product->discount > 0)
                <p class="text-green-600 mb-2">{{ $product->discount }}% تخفیف</p>
            @endif

            <p class="text-gray-600 mb-2">موجودی: {{ $product->stock ?? 0 }}</p>
            <p class="text-gray-600 mb-4">دسته‌بندی: {{ $product->category->name ?? '—' }}</p>

            <form action="{{ route('addToCart') }}" method="POST" class="flex items-center gap-4">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock ?? 1 }}" class="w-20 p-2 border rounded">
                <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded hover:bg-blue-700">
                    افزودن به سبد خرید
                </button>
            </form>
        </div>
    </div>
</div>

{{-- محصولات مرتبط --}}
@if(!empty($relatedProducts) && $relatedProducts->isNotEmpty())
    <div class="mt-8">
        <h2 class="text-2xl font-bold mb-4">محصولات مرتبط</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($relatedProducts as $related)
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    @if (!empty($related->image) && \Illuminate\Support\Facades\Storage::disk('public')->exists($related->image))
                        <img src="{{ asset('storage/' . $related->image) }}" 
                             alt="{{ $related->name }}" 
                             class="w-full h-48 object-cover">
                    @else
                        <img src="https://via.placeholder.com/300x300?text=No+Image" 
                             alt="بدون تصویر" 
                             class="w-full h-48 object-cover">
                    @endif

                    <div class="p-4">
                        <h3 class="text-lg font-semibold">{{ $related->name }}</h3>
                        <p class="text-gray-600">{{ number_format(($related->price ?? 0) / 100, 2) }} تومان</p>
                        <a href="{{ route('shop.show', $related->slug) }}" 
                           class="mt-2 inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            مشاهده جزئیات
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif
@endsection
