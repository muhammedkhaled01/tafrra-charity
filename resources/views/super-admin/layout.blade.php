<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة تحكم المدير العام - منصة إدارة المستفيدين</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'saudi-green': '#006C35',
                        'saudi-gold': '#CBA052',
                        'saudi-light': '#F3F4F6'
                    },
                    fontFamily: {
                        'cairo': ['Cairo', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'cairo', sans-serif; }
    </style>
</head>
<body class="bg-saudi-light text-gray-800 h-screen flex overflow-hidden">

    <!-- Sidebar -->
    <aside class="w-64 bg-saudi-green text-white shadow-lg flex flex-col">
        <div class="p-6 text-center border-b border-green-700">
            <h1 class="text-2xl font-bold text-saudi-gold">منصة خير</h1>
            <p class="text-sm opacity-80 mt-1">لوحة الإدارة العليا</p>
        </div>
        <nav class="flex-1 mt-6">
            <a href="{{ route('super-admin.dashboard') }}" class="block py-3 px-6 hover:bg-green-700 transition {{ request()->routeIs('super-admin.dashboard') ? 'bg-green-700' : '' }}">الرئيسية</a>
            <a href="{{ route('super-admin.tenants.index') }}" class="block py-3 px-6 hover:bg-green-700 transition {{ request()->routeIs('super-admin.tenants.*') ? 'bg-green-700' : '' }}">الجمعيات الخيرية</a>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 overflow-y-auto bg-gray-50">
        <header class="bg-white shadow-sm p-4 flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-700">@yield('header_title', 'لوحة التحكم')</h2>
        </header>

        <div class="p-8">
            @if(session('success'))
                <div class="bg-green-100 border-r-4 border-saudi-green text-green-700 p-4 mb-6 shadow-sm rounded">
                    {{ session('success') }}
                </div>
            @endif

            @yield('content')
        </div>
    </main>

</body>
</html>
