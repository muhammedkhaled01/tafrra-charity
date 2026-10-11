<!DOCTYPE html>
<html lang="ar" dir="rtl" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>من نحن | منصة طفرة</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700;800;900&family=Cairo:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Cairo', 'Inter', sans-serif; }
        .font-heading { font-family: 'Cairo', 'Outfit', sans-serif; }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-gray-900 bg-white selection:bg-brand-500 selection:text-white" x-data="{ scrolled: false }" @scroll.window="scrolled = (window.pageYOffset > 20)">

    <!-- Navbar -->
    <nav :class="scrolled ? 'bg-white/80 backdrop-blur-md shadow-sm border-b border-gray-100' : 'bg-transparent'" class="fixed w-full z-50 top-0 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <a href="{{ route('home') }}" class="flex-shrink-0 flex items-center gap-3 cursor-pointer">
                    <svg viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-10 h-10">
                        <rect x="15" y="20" width="70" height="20" rx="10" fill="url(#logoGradNav)"/>
                        <rect x="40" y="30" width="20" height="55" rx="10" fill="url(#logoGradNav)"/>
                        <circle cx="80" cy="20" r="12" fill="#e7a42b"/>
                        <defs>
                            <linearGradient id="logoGradNav" x1="15" y1="20" x2="85" y2="85" gradientUnits="userSpaceOnUse">
                                <stop stop-color="#006bc8"/>
                                <stop offset="1" stop-color="#36a6fa"/>
                            </linearGradient>
                        </defs>
                    </svg>
                    <span :class="scrolled ? 'text-brand-700' : 'text-white'" class="font-heading font-bold text-3xl tracking-tight transition-colors">طفرة</span>
                </a>
                
                <div class="hidden md:flex space-x-8 space-x-reverse items-center">
                    <a href="{{ route('home') }}" :class="scrolled ? 'text-gray-600 hover:text-brand-600' : 'text-gray-300 hover:text-white'" class="font-medium transition-colors">الرئيسية</a>
                    <a href="{{ route('about') }}" :class="scrolled ? 'text-brand-600 border-brand-600' : 'text-white border-white'" class="font-medium transition-colors border-b-2 pb-1">من نحن</a>
                    <a href="{{ route('home') }}#features" :class="scrolled ? 'text-gray-600 hover:text-brand-600' : 'text-gray-300 hover:text-white'" class="font-medium transition-colors">المميزات</a>
                    <a href="{{ route('home') }}#pricing" :class="scrolled ? 'text-gray-600 hover:text-brand-600' : 'text-gray-300 hover:text-white'" class="font-medium transition-colors">الباقات</a>
                    
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-6 py-2.5 rounded-full font-medium text-white bg-gradient-brand shadow-lg shadow-brand-500/30 hover:shadow-brand-500/50 hover:-translate-y-0.5 transition-all mr-4">
                            لوحة التحكم
                        </a>
                    @else
                        <a href="{{ route('login') }}" :class="scrolled ? 'text-gray-900 hover:text-brand-600' : 'text-white hover:text-gray-200'" class="font-medium transition-colors mr-4">تسجيل الدخول</a>
                        <a href="{{ route('login') }}" class="px-6 py-2.5 rounded-full font-medium text-white bg-gradient-brand shadow-lg shadow-brand-500/30 hover:shadow-brand-500/50 hover:-translate-y-0.5 transition-all mr-4">
                            ابدأ الآن
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Page Header -->
    <div class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden bg-brand-950">
        <div class="absolute inset-0 z-0 opacity-20">
            <div class="absolute -top-24 -right-24 w-96 h-96 bg-brand-400 rounded-full blur-[100px]"></div>
            <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-brand-600 rounded-full blur-[120px]"></div>
        </div>
        
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white">
            <h1 class="font-heading font-extrabold text-5xl md:text-6xl tracking-tight mb-6 leading-tight">
                منصة طفرة لتقنية نظم المعلومات
            </h1>
            <p class="mt-4 text-xl md:text-2xl text-brand-100 max-w-3xl mx-auto font-light leading-relaxed">
                الشريك التقني الأقوى لتطوير وإدارة عمليات القطاع الثالث بأساليب حديثة ومبتكرة
            </p>
        </div>
    </div>

    <!-- The Story -->
    <section class="py-24 bg-white relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:grid lg:grid-cols-2 lg:gap-16 items-center">
                <div class="mb-12 lg:mb-0 relative order-2 lg:order-1 mt-10 lg:mt-0">
                    <div class="absolute inset-0 bg-gradient-brand rounded-3xl transform -rotate-3 scale-105 opacity-10 blur-lg"></div>
                    <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1740&q=80" alt="فريق طفرة" class="relative rounded-3xl shadow-2xl object-cover h-[500px] w-full">
                </div>
                <div class="order-1 lg:order-2">
                    <h2 class="text-sm font-bold text-brand-600 tracking-wide mb-3">من نحن</h2>
                    <h3 class="font-heading font-bold text-4xl text-gray-900 mb-6 leading-tight">الشريك التقني الأول <br>للقطاع الخيري</h3>
                    <p class="text-lg text-gray-600 mb-6 leading-relaxed">
                        نحن منظومة متكاملة في مجال تقنية المعلومات، نقدم خدماتنا لمنظمات القطاع الثالث ابتداءً من الدراسات التحليلية وصولاً إلى ابتكار الحلول التقنية الشاملة التي تساعدها في تحقيق أهدافها التنموية.
                    </p>
                    <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                        نمتلك نظام "رَفْد" الإلكتروني، وهو نظام مسجل رسمياً في الهيئة السعودية للملكية الفكرية. ونفتخر بتقديم خدماتنا من خلاله لأكثر من 1500 جمعية في المملكة العربية السعودية، لنسهم معاً في تحقيق التحول الرقمي بأعلى معايير السرعة والأمان.
                    </p>
                    <div class="grid grid-cols-2 gap-6 mt-8 border-t border-gray-100 pt-8">
                        <div>
                            <h4 class="font-bold text-gray-900 text-xl mb-2 flex items-center">
                                <svg class="w-6 h-6 text-brand-500 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                                السرعة
                            </h4>
                            <p class="text-sm text-gray-600">أتمتة كاملة للعمليات الروتينية وتقارير تصدر بضغطة زر واحدة.</p>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 text-xl mb-2 flex items-center">
                                <svg class="w-6 h-6 text-brand-500 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                                الأمان
                            </h4>
                            <p class="text-sm text-gray-600">بيانات مستفيديك وداعميك مشفرة ومحفوظة في خوادم سحابية محلية.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-20 bg-brand-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h3 class="font-heading font-bold text-3xl text-gray-900 mb-4">أرقام نفخر بها</h3>
                <p class="text-gray-600 text-lg">أثر تقني يمتد ليصنع أثراً تنموياً على أرض الواقع.</p>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div class="bg-white p-8 rounded-3xl shadow-sm text-center border border-gray-100">
                    <div class="w-16 h-16 mx-auto bg-brand-100 text-brand-600 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                    </div>
                    <span class="block text-4xl font-heading font-bold text-gray-900 mb-2">{{ number_format($stats['charities'] ?? 0) }}+</span>
                    <span class="text-gray-500 font-medium">جمعية خيرية</span>
                </div>
                
                <div class="bg-white p-8 rounded-3xl shadow-sm text-center border border-gray-100">
                    <div class="w-16 h-16 mx-auto bg-green-100 text-green-600 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                    </div>
                    <span class="block text-4xl font-heading font-bold text-gray-900 mb-2">{{ number_format($stats['beneficiaries'] ?? 0) }}+</span>
                    <span class="text-gray-500 font-medium">مستفيد مسجل</span>
                </div>
                
                <div class="bg-white p-8 rounded-3xl shadow-sm text-center border border-gray-100">
                    <div class="w-16 h-16 mx-auto bg-purple-100 text-purple-600 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                    </div>
                    <span class="block text-4xl font-heading font-bold text-gray-900 mb-2">{{ number_format($stats['projects'] ?? 0) }}+</span>
                    <span class="text-gray-500 font-medium">مشروع تنموي</span>
                </div>

                <div class="bg-white p-8 rounded-3xl shadow-sm text-center border border-gray-100">
                    <div class="w-16 h-16 mx-auto bg-yellow-100 text-yellow-600 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <span class="block text-4xl font-heading font-bold text-gray-900 mb-2">{{ number_format($stats['approved'] ?? 0) }}+</span>
                    <span class="text-gray-500 font-medium">طلب تم الموافقة عليه</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to action -->
    <section class="py-24 bg-white relative overflow-hidden">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <h2 class="font-heading font-bold text-4xl text-gray-900 mb-6">جاهز لنقل جمعيتك للمستوى التقني القادم؟</h2>
            <p class="text-xl text-gray-600 mb-10">انضم لأكثر من 1500 جمعية تثق في منصة طفرة لإدارة عملياتها اليومية.</p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('home') }}#pricing" class="px-8 py-4 rounded-full font-semibold text-lg text-white bg-gradient-brand shadow-xl shadow-brand-500/30 hover:shadow-brand-500/50 hover:-translate-y-1 transition-all">
                    تصفح باقاتنا الآن
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-brand-950 py-12 border-t border-brand-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center md:text-right md:flex md:justify-between md:items-center">
            <div class="flex items-center justify-center md:justify-start gap-2 mb-4 md:mb-0">
                <svg viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-8 h-8">
                    <rect x="15" y="20" width="70" height="20" rx="10" fill="url(#logoGradFooter)"/>
                    <rect x="40" y="30" width="20" height="55" rx="10" fill="url(#logoGradFooter)"/>
                    <circle cx="80" cy="20" r="12" fill="#e7a42b"/>
                    <defs>
                        <linearGradient id="logoGradFooter" x1="15" y1="20" x2="85" y2="85" gradientUnits="userSpaceOnUse">
                            <stop stop-color="#006bc8"/>
                            <stop offset="1" stop-color="#36a6fa"/>
                        </linearGradient>
                    </defs>
                </svg>
                <span class="font-heading font-bold text-2xl text-white tracking-tight">طفرة</span>
            </div>
            <p class="text-gray-400 text-sm">
                &copy; {{ date('Y') }} منصة طفرة لتقنية نظم المعلومات. جميع الحقوق محفوظة.
            </p>
        </div>
    </footer>

</body>
</html>
