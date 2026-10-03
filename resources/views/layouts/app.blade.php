<!DOCTYPE html>
<html lang="ar" dir="rtl" class="antialiased bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Tafrra') }} - Dashboard</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="font-sans antialiased text-gray-900 dark:text-gray-100 bg-gray-50 dark:bg-gray-900 selection:bg-brand-500 selection:text-white" x-data="{ sidebarOpen: false }">
    
    <!-- Sidebar / Topbar wrapper -->
    <div class="flex h-screen overflow-hidden">
        
        <!-- Sidebar -->
        <aside 
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="fixed inset-y-0 left-0 z-50 w-64 glass-card transition-transform duration-300 ease-in-out md:translate-x-0 md:static md:inset-0 flex flex-col justify-between"
        >
            <div>
                <div class="h-16 flex items-center justify-center border-b border-gray-100 dark:border-gray-800">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                        <svg viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-8 h-8">
                            <rect x="15" y="20" width="70" height="20" rx="10" fill="url(#logoGradApp)"/>
                            <rect x="40" y="30" width="20" height="55" rx="10" fill="url(#logoGradApp)"/>
                            <circle cx="80" cy="20" r="12" fill="#e7a42b"/>
                            <defs>
                                <linearGradient id="logoGradApp" x1="15" y1="20" x2="85" y2="85" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#006bc8"/>
                                    <stop offset="1" stop-color="#36a6fa"/>
                                </linearGradient>
                            </defs>
                        </svg>
                        <span class="font-heading font-bold text-2xl tracking-tight text-brand-700 dark:text-brand-400">طفرة</span>
                    </a>
                </div>
                <nav class="p-4 space-y-1">
                    @if(auth()->user()->isSuperAdmin())
                        <x-nav-link href="{{ route('super-admin.dashboard') }}" :active="request()->routeIs('super-admin.dashboard')" icon="home">
                            الرئيسية
                        </x-nav-link>
                        <x-nav-link href="{{ route('super-admin.tenants.index') }}" :active="request()->routeIs('super-admin.tenants.*')" icon="users">
                            الجمعيات الخيرية
                        </x-nav-link>
                        <x-nav-link href="{{ route('super-admin.payments.index') }}" :active="request()->routeIs('super-admin.payments.*')" icon="credit-card">
                            المدفوعات والاشتراكات
                        </x-nav-link>
                        <x-nav-link href="{{ route('super-admin.roles.index') }}" :active="request()->routeIs('super-admin.roles.*')" icon="folder">
                            إدارة الصلاحيات والمدراء
                        </x-nav-link>
                        <x-nav-link href="#" icon="folder">
                            إعدادات الموقع (SEO)
                        </x-nav-link>
                    @else
                        <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')" icon="home">
                            الرئيسية
                        </x-nav-link>
                        <x-nav-link href="{{ route('beneficiaries.index') }}" :active="request()->routeIs('beneficiaries.*')" icon="users">
                            المستفيدين
                        </x-nav-link>
                        <x-nav-link href="{{ route('projects.index') }}" :active="request()->routeIs('projects.*')" icon="folder">
                            المشاريع
                        </x-nav-link>
                    @endif
                </nav>
            </div>
            
            <div class="p-4 border-t border-gray-100 dark:border-gray-800">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-2 text-sm font-medium text-red-600 dark:text-red-400 rounded-xl hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                        <svg class="w-5 h-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        تسجيل الخروج
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden bg-gray-50 dark:bg-gray-900/50">
            <!-- Topbar -->
            <header class="h-16 glass z-40 px-4 md:px-8 flex items-center justify-between">
                <button @click="sidebarOpen = true" class="md:hidden p-2 rounded-lg text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
                
                <div class="flex-1 px-4 flex justify-between">
                    <div class="flex-1 flex">
                        <!-- Search can go here -->
                    </div>
                    <div class="ml-4 flex items-center gap-4">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-full bg-brand-100 dark:bg-brand-900/50 text-brand-600 dark:text-brand-300 flex items-center justify-center font-bold text-sm">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                            <span class="text-sm font-medium hidden md:block">{{ auth()->user()->name }}</span>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 dark:bg-gray-900 p-4 md:p-8">
                @if(isset($header))
                    <div class="mb-8">
                        {{ $header }}
                    </div>
                @endif
                {{ $slot }}
            </main>
        </div>
        
        <!-- Sidebar Overlay -->
        <div 
            x-show="sidebarOpen" 
            @click="sidebarOpen = false"
            x-transition:enter="transition-opacity ease-linear duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-linear duration-300"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-gray-900/80 backdrop-blur-sm z-40 md:hidden"
        ></div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(event, form, itemName = 'هذا العنصر') {
            event.preventDefault();
            Swal.fire({
                title: 'هل أنت متأكد؟',
                text: "لن تتمكن من التراجع عن حذف " + itemName + "!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#4b5563',
                confirmButtonText: 'نعم، احذف!',
                cancelButtonText: 'إلغاء',
                background: document.documentElement.classList.contains('dark') ? '#1f2937' : '#ffffff',
                color: document.documentElement.classList.contains('dark') ? '#ffffff' : '#111827',
                customClass: {
                    popup: 'rounded-2xl',
                    confirmButton: 'rounded-xl px-4 py-2 text-sm font-medium',
                    cancelButton: 'rounded-xl px-4 py-2 text-sm font-medium'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }
    </script>
    @stack('scripts')
</body>
</html>
