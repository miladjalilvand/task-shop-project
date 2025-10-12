@extends('dashboard')

@section('title', 'لیست سفارشات')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold text-gray-800">لیست سفارشات</h2>
        </div>
        @if ($orders->isEmpty())
            <p class="text-gray-600">هیچ سفارشی یافت نشد.</p>
        @else
            <div class="overflow-x-auto">
                <table class="w-full table-auto border-collapse">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2 text-right text-sm font-medium text-gray-700">شناسه</th>
                            <th class="px-4 py-2 text-right text-sm font-medium text-gray-700">سبد خرید</th>
                            <th class="px-4 py-2 text-right text-sm font-medium text-gray-700">وضعیت</th>
                            <th class="px-4 py-2 text-right text-sm font-medium text-gray-700">تاریخ ایجاد</th>
                            <th class="px-4 py-2 text-right text-sm font-medium text-gray-700">عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr class="border-b">
                                <td class="px-4 py-2 text-right">{{ $order->id }}</td>
                                <td class="px-4 py-2 text-right">
                                    {{ $order->cart ? $order->cart->id : 'بدون سبد خرید' }}
                                </td>
                                <td class="px-4 py-2 text-right">
                                    <form action="{{ route('orders.update-status', $order->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" onchange="this.form.submit()"
                                                class="mt-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>در انتظار</option>
                                            <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>در حال پردازش</option>
                                            <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>تحویل شده</option>
                                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>لغو شده</option>
                                        </select>
                                    </form>
                                </td>
                                <td class="px-4 py-2 text-right">{{ $order->created_at->format('Y-m-d H:i') }}</td>
                                {{-- <td class="px-4 py-2 text-right">
                                    <div class="flex space-x-2 space-x-reverse">
                                        <form action="{{ route('orders.destroy', $order->id) }}" method="POST"
                                              onsubmit="return confirm('آیا مطمئن هستید که می‌خواهید این سفارش را حذف کنید؟');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="bg-red-600 text-white px-3 py-1 rounded-lg hover:bg-red-700">
                                                حذف
                                            </button>
                                        </form>
                                    </div>
                                </td> --}}
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        @endif
    </div>
@endsection