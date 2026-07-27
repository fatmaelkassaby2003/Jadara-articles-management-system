<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'نظام إدارة المقالات')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Tajawal', sans-serif; } </style>
</head>
<body class="bg-gray-50 text-gray-800 flex flex-col min-h-screen">

    <!-- Header -->
    <header class="bg-white shadow-sm border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <a href="{{ route('home') }}" class="text-2xl font-bold text-indigo-600">✍️ مقالاتي</a>
            <nav class="space-x-6 space-x-reverse">
                <a href="{{ route('home') }}" class="hover:text-indigo-600 font-medium">الرئيسية</a>
                <a href="{{ route('web.articles.index') }}" class="hover:text-indigo-600 font-medium">جميع المقالات</a>
                <a href="/admin" class="bg-indigo-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-indigo-700">لوحة التحكم</a>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow max-w-7xl mx-auto px-4 py-8 w-full">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-gray-300 py-6 mt-12 text-center">
        <p>&copy; {{ date('Y') }} Articles Management System — جميع الحقوق محفوظة.</p>
    </footer>

</body>
</html>
