<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>پنل مدیریت</title>

</head>
<body class="bg-gray-100 font-sans">
    <div class="flex h-screen">
 <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-right py-2 px-4 hover:bg-gray-700">
                                <i class="fas fa-sign-out-alt ml-2"></i> خروج
                            </button>
                        </form>
       
</body>
</html>