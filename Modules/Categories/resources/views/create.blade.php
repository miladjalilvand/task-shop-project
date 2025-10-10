@extends('dashboard')

@section('title', 'ایجاد دسته‌بندی')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">ایجاد دسته‌بندی جدید</h2>
        <form method="POST" action="{{ route('categories.store') }}" class="space-y-6" enctype="multipart/form-data">
            @csrf
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
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('parent_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">نام</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                       class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                       placeholder="نام دسته‌بندی">
            </div>
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">توضیحات (اختیاری)</label>
                <textarea name="description" id="description" class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                          placeholder="توضیحات دسته‌بندی">{{ old('description') }}</textarea>
            </div>
            <div>
                <label for="image" class="block text-sm font-medium text-gray-700">تصویر (اختیاری)</label>
                <input type="file" name="image" id="image" class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                       accept="image/*">
            </div>
            <div>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    ایجاد
                </button>
            </div>
        </form>
    </div>
@endsection