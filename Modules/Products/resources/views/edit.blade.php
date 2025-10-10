@extends('dashboard')

@section('title', 'ویرایش محصول')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">ویرایش محصول: {{ $product->name }}</h2>
        <form method="POST" action="{{ route('products.update', $product->id) }}" class="space-y-6" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @if ($errors->any())
                <div class="text-red-600 text-sm">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif
            <div>
                <label for="category_id" class="block text-sm font-medium text-gray-700">دسته‌بندی</label>
                <select name="category_id" id="category_id" required
                        class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    <option value="">انتخاب دسته‌بندی</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">نام</label>
                <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" required
                       class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                       placeholder="نام محصول">
            </div>
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">توضیحات (اختیاری)</label>
                <textarea name="description" id="description" class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                          placeholder="توضیحات محصول">{{ old('description', $product->description) }}</textarea>
            </div>
            <div>
                <label for="price" class="block text-sm font-medium text-gray-700">قیمت</label>
                <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}" required
                       class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                       placeholder="قیمت محصول (به تومان)">
            </div>
            <div>
                <label for="stock" class="block text-sm font-medium text-gray-700">موجودی (اختیاری)</label>
                <input type="number" name="stock" id="stock" value="{{ old('stock', $product->stock) }}"
                       class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                       placeholder="موجودی محصول">
            </div>
            <div>
                <label for="image" class="block text-sm font-medium text-gray-700">تصویر (اختیاری)</label>
                @if ($product->image)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-32 h-32 object-cover rounded">
                        <p class="text-sm text-gray-600">تصویر کنونی</p>
                    </div>
                @endif
                <input type="file" name="image" id="image" class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                       accept="image/*">
            </div>
            <div>
                <label for="discount" class="block text-sm font-medium text-gray-700">تخفیف (اختیاری)</label>
                <input type="number" name="discount" id="discount" value="{{ old('discount', $product->discount) }}"
                       class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                       placeholder="درصد تخفیف">
            </div>
            <div>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    به‌روزرسانی
                </button>
            </div>
        </form>
    </div>
@endsection