@extends('dashboard')

@section('title', 'لیست کاربران')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold text-gray-800">لیست کاربران</h2>
        </div>
        @if ($users->isEmpty())
            <p class="text-gray-600">هیچ کاربری یافت نشد.</p>
        @else
            <div class="overflow-x-auto">
                <table class="w-full table-auto border-collapse">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2 text-right text-sm font-medium text-gray-700">شناسه</th>
                            <th class="px-4 py-2 text-right text-sm font-medium text-gray-700">نام</th>
                            <th class="px-4 py-2 text-right text-sm font-medium text-gray-700">ایمیل</th>
                            <th class="px-4 py-2 text-right text-sm font-medium text-gray-700">نقش</th>
                            <th class="px-4 py-2 text-right text-sm font-medium text-gray-700">عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr class="border-b">
                                <td class="px-4 py-2 text-right">{{ $user->id }}</td>
                                <td class="px-4 py-2 text-right">{{ $user->name }}</td>
                                <td class="px-4 py-2 text-right">{{ $user->email }}</td>
                                <td class="px-4 py-2 text-right">
                                    <form action="{{ route('users.update-role', $user->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <select name="role" onchange="this.form.submit()"
                                                class="mt-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                            <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>کاربر</option>
                                            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>مدیر</option>
                                        </select>
                                    </form>
                                </td>
                                {{-- <td class="px-4 py-2 text-right">
                                    <div class="flex space-x-2 space-x-reverse">
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                              onsubmit="return confirm('آیا مطمئن هستید که می‌خواهید این کاربر را حذف کنید؟');">
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
            <div class="mt-4">
                {{ $users->links() }}
            </div>
        @endif
    </div>
@endsection