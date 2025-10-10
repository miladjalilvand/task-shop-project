@extends('dashboard')

@section('title', 'لیست دسته‌بندی‌ها')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold text-gray-800">لیست دسته‌بندی‌ها</h2>
            <a href="{{ route('categories.create') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                افزودن دسته‌بندی جدید
            </a>
        </div>
        @if ($categories->isEmpty())
            <p class="text-gray-600">هیچ دسته‌بندی‌ای یافت نشد.</p>
        @else
            <div class="overflow-x-auto">
                <table class="w-full table-auto border-collapse">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2 text-right text-sm font-medium text-gray-700">شناسه</th>
                            <th class="px-4 py-2 text-right text-sm font-medium text-gray-700">نام</th>
                            <th class="px-4 py-2 text-right text-sm font-medium text-gray-700">دسته‌بندی والد</th>
                            <th class="px-4 py-2 text-right text-sm font-medium text-gray-700">توضیحات</th>
                            <th class="px-4 py-2 text-right text-sm font-medium text-gray-700">تصویر</th>
                            <th class="px-4 py-2 text-right text-sm font-medium text-gray-700">عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr class="border-b">
                                <td class="px-4 py-2 text-right">{{ $category->id }}</td>
                                <td class="px-4 py-2 text-right">{{ $category->name }}</td>
                                <td class="px-4 py-2 text-right">
                                    {{ $category->parent ? $category->parent->name : 'بدون والد' }}
                                </td>
                                <td class="px-4 py-2 text-right">
                                    {{ Str::limit($category->description, 50, '...') }}
                                </td>
                                <td class="px-4 py-2 text-right">
                                    @if ($category->image)
                                        <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}"
                                             class="w-16 h-16 object-cover rounded">
                                    @else
                                        بدون تصویر
                                    @endif
                                </td>
                                <td class="px-4 py-2 text-right">
                                    <div class="flex space-x-2 space-x-reverse">
                                        <a href="{{ route('categories.edit', $category->id) }}"
                                           class="bg-yellow-500 text-white px-3 py-1 rounded-lg hover:bg-yellow-600">
                                            ویرایش
                                        </a>
                                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST"
                                              onsubmit="return confirm('آیا مطمئن هستید که می‌خواهید این دسته‌بندی را حذف کنید؟');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="bg-red-600 text-white px-3 py-1 rounded-lg hover:bg-red-700">
                                                حذف
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{-- <div class="mt-4">
                {{ $categories->links() }}
            </div> --}}
        @endif
    </div>
@endsection