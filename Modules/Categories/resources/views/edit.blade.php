@extends('dashboard')

@section('title', 'ویرایش دسته‌بندی')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">ویرایش دسته‌بندی: {{ $category->name }}</h2>
        <form method="POST" action="{{ route('categories.update', $category->id) }}" class="space-y-6" enctype="multipart/form-data">
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
                <label for="parent_id" class="block text-sm font-medium text-gray-700">دسته‌بندی والد (اختیاری)</label>
                <select name="parent_id" id="parent_id" class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    <option value="">بدون والد</option>
                    @foreach ($categories as $cat)
                        @if ($cat->id !== $category->id)
                            <option value="{{ $cat->id }}" {{ old('parent_id', $category->parent_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">نام</label>
                <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}" required
                       class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                       placeholder="نام دسته‌بندی">
            </div>
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">توضیحات (اختیاری)</label>
                <textarea name="description" id="description" class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                          placeholder="توضیحات دسته‌بندی">{{ old('description', $category->description) }}</textarea>
            </div>
            <div>
                <label for="image" class="block text-sm font-medium text-gray-700">تصویر (اختیاری)</label>
                @if ($category->image)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="w-32 h-32 object-cover rounded">
                        <p class="text-sm text-gray-600">تصویر کنونی</p>
                    </div>
                @endif
                <input type="file" name="image" id="image" class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                       accept="image/*">
            </div>
            <div>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    به‌روزرسانی
                </button>
            </div>
        </form>
    </div>
@endsection