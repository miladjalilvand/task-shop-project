@extends('dashboard')

@section('title', 'لیست محصولات')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold text-gray-800">لیست محصولات</h2>
            <a href="{{ route('products.create') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                افزودن محصول جدید
            </a>
        </div>
        @if ($products->isEmpty())
            <p class="text-gray-600">هیچ محصولی یافت نشد.</p>
        @else
            <div class="overflow-x-auto">
                <table class="w-full table-auto border-collapse">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2 text-right text-sm font-medium text-gray-700">شناسه</th>
                            <th class="px-4 py-2 text-right text-sm font-medium text-gray-700">نام</th>
                            <th class="px-4 py-2 text-right text-sm font-medium text-gray-700">دسته‌بندی</th>
                            <th class="px-4 py-2 text-right text-sm font-medium text-gray-700">توضیحات</th>
                            <th class="px-4 py-2 text-right text-sm font-medium text-gray-700">قیمت</th>
                            <th class="px-4 py-2 text-right text-sm font-medium text-gray-700">موجودی</th>
                            <th class="px-4 py-2 text-right text-sm font-medium text-gray-700">تخفیف</th>
                            <th class="px-4 py-2 text-right text-sm font-medium text-gray-700">تصویر</th>
                            <th class="px-4 py-2 text-right text-sm font-medium text-gray-700">عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr class="border-b">
                                <td class="px-4 py-2 text-right">{{ $product->id }}</td>
                                <td class="px-4 py-2 text-right">{{ $product->name }}</td>
                                <td class="px-4 py-2 text-right">
                                    {{ $product->category ? $product->category->name : 'بدون دسته‌بندی' }}
                                </td>
                                <td class="px-4 py-2 text-right">
                                    {{ Str::limit($product->description, 50, '...') }}
                                </td>
                                <td class="px-4 py-2 text-right">{{ number_format($product->price) }} تومان</td>
                                <td class="px-4 py-2 text-right">{{ $product->stock }}</td>
                                <td class="px-4 py-2 text-right">{{ $product->discount }}%</td>
                                <td class="px-4 py-2 text-right">
                                    @if ($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                             class="w-16 h-16 object-cover rounded">
                                    @else
                                        بدون تصویر
                                    @endif
                                </td>
                                <td class="px-4 py-2 text-right">
                                     <div class="flex space-x-2 space-x-reverse">
                                        <a href="{{ route('products.edit', $product->id) }}"
                                           class="bg-yellow-500 text-white px-3 py-1 rounded-lg hover:bg-yellow-600">
                                            ویرایش
                                        </a>
                                        <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                                              onsubmit="return confirm('آیا مطمئن هستید که می‌خواهید این محصول را حذف کنید؟');">
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
                {{ $products->links() }}
            </div> --}}
        @endif
    </div>
@endsection