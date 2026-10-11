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
                    <a href="{{ route('about') }}" class="text-gray-600 hover:text-brand-600 font-medium transition-colors">من نحن</a>
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

    <!-- System Features Section (New) -->
    <section id="features" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-brand-600 font-bold tracking-wide uppercase text-sm mb-3">مميزات النظام</h2>
                <h3 class="font-heading font-bold text-4xl text-gray-900 mb-4">كل ما تحتاجه جمعيتك في مكان واحد</h3>
                <p class="text-xl text-gray-600">نظام متكامل يغطي كافة الجوانب الإدارية، المالية، والميدانية للجمعيات الخيرية.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="p-8 rounded-3xl bg-gray-50 hover:bg-white hover:shadow-xl hover:-translate-y-1 border border-gray-100 transition-all duration-300">
                    <div class="w-14 h-14 rounded-2xl bg-brand-100 text-brand-600 flex items-center justify-center mb-6">
                        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-3">إدارة المستفيدين والداعمين</h4>
                    <p class="text-gray-600 leading-relaxed">قاعدة بيانات متكاملة لإدارة بيانات المستفيدين والجهات المانحة مع تتبع دقيق لتاريخ التبرعات والمساعدات.</p>
                </div>

                <!-- Feature 2 -->
                <div class="p-8 rounded-3xl bg-gray-50 hover:bg-white hover:shadow-xl hover:-translate-y-1 border border-gray-100 transition-all duration-300">
                    <div class="w-14 h-14 rounded-2xl bg-green-100 text-green-600 flex items-center justify-center mb-6">
                        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" /></svg>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-3">إدارة المشاريع التنموية</h4>
                    <p class="text-gray-600 leading-relaxed">تخطيط، تنفيذ، ومتابعة المشاريع التنموية والإغاثية، مع ربط مباشر بين المستفيدين والمشاريع المخصصة لهم.</p>
                </div>

                <!-- Feature 3 -->
                <div class="p-8 rounded-3xl bg-gray-50 hover:bg-white hover:shadow-xl hover:-translate-y-1 border border-gray-100 transition-all duration-300">
                    <div class="w-14 h-14 rounded-2xl bg-purple-100 text-purple-600 flex items-center justify-center mb-6">
                        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-3">نظام الكفالات المتكامل</h4>
                    <p class="text-gray-600 leading-relaxed">إدارة كفالات الأيتام، الأسر، وطالبي العلم، مع متابعة دورية للمدفوعات وتقارير حالة المكفولين للداعمين.</p>
                </div>

                <!-- Feature 4 -->
                <div class="p-8 rounded-3xl bg-gray-50 hover:bg-white hover:shadow-xl hover:-translate-y-1 border border-gray-100 transition-all duration-300">
                    <div class="w-14 h-14 rounded-2xl bg-yellow-100 text-yellow-600 flex items-center justify-center mb-6">
                        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2zM10 8.5a.5.5 0 11-1 0 .5.5 0 011 0zm5 5a.5.5 0 11-1 0 .5.5 0 011 0z" /></svg>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-3">السندات المالية الدقيقة</h4>
                    <p class="text-gray-600 leading-relaxed">إصدار وإدارة سندات القبض والصرف، مع دورة مستندية محكمة توافق معايير المحاسبة والشفافية المالية.</p>
                </div>

                <!-- Feature 5 -->
                <div class="p-8 rounded-3xl bg-gray-50 hover:bg-white hover:shadow-xl hover:-translate-y-1 border border-gray-100 transition-all duration-300">
                    <div class="w-14 h-14 rounded-2xl bg-red-100 text-red-600 flex items-center justify-center mb-6">
                        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2" /></svg>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-3">الوثائق والخطابات</h4>
                    <p class="text-gray-600 leading-relaxed">إصدار الوكالات، الخطابات الرسمية، والشهادات، مع نظام أرشفة قوي واستخراج فوري للنماذج بصيغة PDF.</p>
                </div>

                <!-- Feature 6 -->
                <div class="p-8 rounded-3xl bg-gray-50 hover:bg-white hover:shadow-xl hover:-translate-y-1 border border-gray-100 transition-all duration-300">
                    <div class="w-14 h-14 rounded-2xl bg-blue-100 text-blue-600 flex items-center justify-center mb-6">
                        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-3">صلاحيات مرنة وتصدير شامل</h4>
                    <p class="text-gray-600 leading-relaxed">تحكم دقيق بصلاحيات فريق العمل، مع إمكانية تصدير كافة البيانات والتقارير بصيغ متعددة بضغطة زر.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="py-24 bg-gray-50 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="font-heading font-bold text-4xl text-gray-900 mb-4">باقات بسيطة وواضحة</h2>
                <p class="text-xl text-gray-600">اختر الباقة التي تناسب حجم واحتياجات جمعيتك بدقة.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 justify-center">
                @forelse($plans ?? [] as $plan)
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

                        <div class="mb-6 pb-6 border-b border-gray-100">
                            <div class="text-sm font-semibold text-gray-700 flex items-center">
                                الحد الأقصى للمستفيدين: 
                                <span class="mr-2 bg-gray-100 text-gray-800 px-2 py-0.5 rounded font-bold">
                                    {{ $plan->max_beneficiaries == -1 ? 'غير محدود' : number_format($plan->max_beneficiaries) }}
                                </span>
                            </div>
                        </div>

                        <ul class="mb-8 space-y-4 flex-1">
                            @foreach(\App\Enums\SubscriptionFeature::cases() as $feature)
                                @php
                                    $isAvailable = is_array($plan->features) && isset($plan->features[$feature->value]) && $plan->features[$feature->value] === true;
                                @endphp
                                <li class="flex items-center text-sm {{ $isAvailable ? 'text-gray-700 font-medium' : 'text-gray-400 line-through' }}">
                                    @if($isAvailable)
                                        <svg class="w-5 h-5 text-green-500 ml-3 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                        </svg>
                                    @else
                                        <svg class="w-5 h-5 text-gray-300 ml-3 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    @endif
                                    {{ $feature->label() }}
                                </li>
                            @endforeach
                        </ul>
                        <a href="{{ route('subscribe', $plan->id) }}" class="w-full py-4 rounded-xl font-bold text-center transition-all {{ $loop->iteration == 2 ? 'bg-brand-600 text-white hover:bg-brand-700 shadow-lg shadow-brand-500/30' : 'bg-gray-50 text-gray-900 hover:bg-gray-100 border border-gray-200' }}">
                            اشترك في الباقة
                        </a>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <p class="text-gray-500 text-lg">لا توجد باقات متاحة حالياً.</p>
                    </div>
                @endforelse
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
