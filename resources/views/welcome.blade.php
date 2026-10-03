<!DOCTYPE html>
<html lang="ar" dir="rtl" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>منصة طفرة - لتقنية نظم المعلومات</title>

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
                <div class="flex-shrink-0 flex items-center gap-3 cursor-pointer">
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
                    <span class="font-heading font-bold text-3xl tracking-tight text-brand-700">طفرة</span>
                </div>
                
                <div class="hidden md:flex space-x-8 space-x-reverse items-center">
                    <a href="#about" class="text-gray-600 hover:text-brand-600 font-medium transition-colors">من نحن</a>
                    <a href="#features" class="text-gray-600 hover:text-brand-600 font-medium transition-colors">المميزات</a>
                    <a href="#pricing" class="text-gray-600 hover:text-brand-600 font-medium transition-colors">الباقات</a>
                    
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-6 py-2.5 rounded-full font-medium text-white bg-gradient-brand shadow-lg shadow-brand-500/30 hover:shadow-brand-500/50 hover:-translate-y-0.5 transition-all mr-4">
                            لوحة التحكم
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="font-medium text-gray-900 hover:text-brand-600 transition-colors mr-4">تسجيل الدخول</a>
                        <a href="{{ route('login') }}" class="px-6 py-2.5 rounded-full font-medium text-white bg-gradient-brand shadow-lg shadow-brand-500/30 hover:shadow-brand-500/50 hover:-translate-y-0.5 transition-all mr-4">
                            ابدأ الآن
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden">
        <div class="absolute inset-0 z-0">
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[1000px] h-[600px] bg-brand-100 rounded-full blur-[120px] mix-blend-multiply opacity-70"></div>
            <div class="absolute top-40 right-10 w-[600px] h-[600px] bg-brand-200 rounded-full blur-[100px] mix-blend-multiply opacity-50"></div>
        </div>
        
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="font-heading font-extrabold text-5xl md:text-7xl tracking-tight text-gray-900 mb-6 leading-tight">
                منصة طفرة <br class="hidden md:block"/>
                <span class="text-gradient">لتقنية نظم المعلومات</span>
            </h1>
            <p class="mt-4 text-xl md:text-2xl text-gray-600 max-w-3xl mx-auto font-light leading-relaxed">
                نحن منظومة متكاملة في مجال تقنية المعلومات وتصميم المحتوى، نقدم خدماتنا لمنظمات القطاع الثالث ابتداء من الدراسات التحليلية إلى تقديم الحلول التقنية المناسبة لتحقيق أهدافها.
            </p>
            <div class="mt-10 flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('login') }}" class="px-8 py-4 rounded-full font-semibold text-lg text-white bg-gradient-brand shadow-xl shadow-brand-500/30 hover:shadow-brand-500/50 hover:-translate-y-1 transition-all">
                    ابدأ رحلتك
                </a>
                <a href="#about" class="px-8 py-4 rounded-full font-semibold text-lg text-gray-700 bg-white border border-gray-200 shadow-sm hover:border-gray-300 hover:bg-gray-50 transition-all">
                    اعرف المزيد
                </a>
            </div>

            <!-- Stats Highlight -->
            <div class="mt-20 grid grid-cols-2 md:grid-cols-4 gap-8 border-t border-gray-100 pt-12 max-w-5xl mx-auto">
                <div class="flex flex-col">
                    <span class="text-4xl font-heading font-bold text-gray-900">{{ number_format($stats['charities'] ?? 0) }}+</span>
                    <span class="text-gray-500 font-medium mt-2 uppercase tracking-wide text-sm">جمعية</span>
                </div>
                <div class="flex flex-col">
                    <span class="text-4xl font-heading font-bold text-gray-900">{{ number_format($stats['beneficiaries'] ?? 0) }}+</span>
                    <span class="text-gray-500 font-medium mt-2 uppercase tracking-wide text-sm">مستفيد</span>
                </div>
                <div class="flex flex-col">
                    <span class="text-4xl font-heading font-bold text-gray-900">{{ number_format($stats['projects'] ?? 0) }}+</span>
                    <span class="text-gray-500 font-medium mt-2 uppercase tracking-wide text-sm">مشروع</span>
                </div>
                <div class="flex flex-col">
                    <span class="text-4xl font-heading font-bold text-gray-900">{{ number_format($stats['approved'] ?? 0) }}+</span>
                    <span class="text-gray-500 font-medium mt-2 uppercase tracking-wide text-sm">أثر مُحقق</span>
                </div>
            </div>
        </div>
    </div>

    <!-- About Section -->
    <section id="about" class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:grid lg:grid-cols-2 lg:gap-16 items-center">
                <div class="mb-12 lg:mb-0 relative order-2 lg:order-1 mt-10 lg:mt-0">
                    <div class="absolute inset-0 bg-gradient-brand rounded-3xl transform -rotate-3 scale-105 opacity-20 blur-lg"></div>
                    <img src="https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1740&q=80" alt="عن طفرة" class="relative rounded-3xl shadow-2xl object-cover h-[500px] w-full">
                </div>
                <div class="order-1 lg:order-2">
                    <h2 class="text-sm font-bold text-brand-600 tracking-wide uppercase mb-3">من نحن</h2>
                    <h3 class="font-heading font-bold text-4xl text-gray-900 mb-6 leading-tight">نظام رَفْد <br>لإدارة الجمعيات</h3>
                    <p class="text-lg text-gray-600 mb-6 leading-relaxed">
                        نملك نظام رافد الإلكتروني، وهو مسجل في الهيئة السعودية للملكية الفكرية ونفتخر بتقديم الخدمة من خلاله لأكثر من 1500 جمعية في المملكة العربية السعودية.
                    </p>
                    <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                        نطمح في طفرة أن نكون الشريك التقني الأول في القطاع الخيري، موفرين أدوات حديثة لتصميم المواقع وبناء التطبيقات الإدارية والمالية.
                    </p>
                    <ul class="space-y-4">
                        <li class="flex items-center text-gray-700 font-medium">
                            <svg class="w-6 h-6 text-accent-500 ml-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            عمليات إدارية ومالية شفافة
                        </li>
                        <li class="flex items-center text-gray-700 font-medium">
                            <svg class="w-6 h-6 text-accent-500 ml-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            تقارير وتحليلات فورية متقدمة
                        </li>
                        <li class="flex items-center text-gray-700 font-medium">
                            <svg class="w-6 h-6 text-accent-500 ml-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            بنية تحتية آمنة وموثوقة
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="py-24 bg-white relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="font-heading font-bold text-4xl text-gray-900 mb-4">باقات بسيطة وواضحة</h2>
                <p class="text-xl text-gray-600">اختر الباقة التي تناسب احتياجات منظمتك.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @php
                    // Features mapping to avoid showing "1"
                    $planFeatures = [
                        'الباقة الأساسية' => ['إدارة المستفيدين', 'تقارير أساسية', 'دعم فني عبر البريد'],
                        'الباقة الاحترافية' => ['إدارة المستفيدين', 'تقارير متقدمة', 'دعم فني أولوية', 'إدارة المشاريع اللامحدودة'],
                        'باقة المؤسسات' => ['جميع الميزات', 'خوادم مخصصة', 'دعم فني 24/7', 'تخصيص النظام']
                    ];
                @endphp

                @foreach($plans ?? [] as $plan)
                    @php
                        // Fallback features in Arabic if missing
                        $features = $planFeatures[$plan->name] ?? ['ميزات النظام', 'إدارة المشاريع', 'دعم فني'];
                    @endphp
                    <div class="bg-white rounded-3xl border {{ $loop->iteration == 2 ? 'border-brand-500 shadow-2xl shadow-brand-500/20 relative md:scale-105' : 'border-gray-200 shadow-lg' }} p-8 flex flex-col">
                        @if($loop->iteration == 2)
                            <div class="absolute top-0 inset-x-0 h-2 bg-gradient-brand rounded-t-3xl"></div>
                            <span class="absolute top-6 left-6 bg-brand-100 text-brand-700 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wide">الأكثر طلباً</span>
                        @endif
                        <h3 class="text-2xl font-heading font-bold text-gray-900 mb-2">{{ $plan->name }}</h3>
                        <div class="my-6 flex items-baseline">
                            <span class="text-5xl font-extrabold text-gray-900">{{ number_format($plan->price) }}</span>
                            <span class="text-gray-500 mr-2">ريال / شهرياً</span>
                        </div>
                        <ul class="mb-8 space-y-4 flex-1">
                            @foreach($features as $feature)
                                <li class="flex items-center text-gray-600">
                                    <svg class="w-5 h-5 text-green-500 ml-3 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    {{ $feature }}
                                </li>
                            @endforeach
                        </ul>
                        <a href="{{ route('login') }}" class="w-full py-4 rounded-xl font-bold text-center transition-all {{ $loop->iteration == 2 ? 'bg-brand-600 text-white hover:bg-brand-700 shadow-lg shadow-brand-500/30' : 'bg-gray-50 text-gray-900 hover:bg-gray-100' }}">
                            اشترك الآن
                        </a>
                    </div>
                @endforeach
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
