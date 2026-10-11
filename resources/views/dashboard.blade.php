<x-app-layout>
    <x-slot name="header">
        <h2 class="font-heading font-bold text-3xl text-brand-800 dark:text-white leading-tight">
            {{ $tenant->name }}
            <span class="block text-sm text-gray-500 font-normal mt-1">لوحة التحكم</span>
        </h2>
    </x-slot>

    <!-- Main Banner -->
    <div class="bg-brand-800 rounded-3xl p-8 md:p-12 mb-8 relative overflow-hidden flex flex-col md:flex-row items-center justify-between shadow-2xl shadow-brand-900/20">
        <!-- Background shapes/graphics -->
        <div class="absolute left-0 bottom-0 opacity-20 pointer-events-none">
            <svg width="300" height="300" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                <!-- Abstract leaf design -->
                <path d="M50 150 C 50 100, 100 50, 150 50 C 150 100, 100 150, 50 150 Z" stroke="#ffffff" stroke-width="4" fill="transparent"/>
                <path d="M50 150 L 100 100" stroke="#ffffff" stroke-width="4"/>
            </svg>
        </div>

        <div class="text-white z-10 w-full">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h2 class="text-3xl md:text-4xl font-heading font-bold mb-2">كل ملف، حكاية تستحق الاهتمام</h2>
                    <p class="text-brand-200 text-sm md:text-base">نظرة شاملة على المستفيدين لتكون خطوتك التالية أوضح.</p>
                </div>
                <a href="{{ route('beneficiaries.create') }}" class="inline-flex items-center gap-2 bg-brand-700 hover:bg-brand-600 text-white px-5 py-2.5 rounded-xl transition-colors shadow-lg shadow-brand-900/30">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    إضافة مستفيد
                </a>
            </div>

            <div class="bg-brand-900/40 backdrop-blur-sm rounded-2xl p-6 md:p-8 mt-8 border border-brand-700/50">
                <p class="text-brand-300 text-sm mb-2">مثال لتجربة الوصول لمن يحتاج</p>
                <h3 class="text-2xl font-heading font-bold mb-3">بيانات مرتبة. رعاية أقرب.</h3>
                <p class="text-brand-100 text-sm mb-6 max-w-2xl leading-relaxed">ابدأ بتجربة النظام، تابع الملفات، واكتشف كيف يمكن لمعلومة واضحة أن تصنع فرقاً.</p>
                
                <a href="{{ route('beneficiaries.index') }}" class="inline-flex items-center gap-2 text-brand-200 hover:text-white transition-colors text-sm font-medium">
                    استعرض التقارير 
                    <svg class="w-4 h-4 rtl:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>
    </div>

    <!-- 4 Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-100 dark:border-gray-700 shadow-sm flex flex-col items-center text-center">
            <div class="w-12 h-12 rounded-full bg-brand-50 text-brand-600 flex items-center justify-center mb-4">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            </div>
            <h4 class="text-gray-500 dark:text-gray-400 text-sm font-medium mb-2">إجمالي المستفيدين</h4>
            <span class="text-3xl font-heading font-bold text-gray-900 dark:text-white">{{ number_format($kpis['total_beneficiaries']) }}</span>
            <span class="text-xs text-gray-400 mt-2">جميع الملفات المسجلة</span>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-100 dark:border-gray-700 shadow-sm flex flex-col items-center text-center">
            <div class="w-12 h-12 rounded-full bg-brand-50 text-brand-600 flex items-center justify-center mb-4">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <h4 class="text-gray-500 dark:text-gray-400 text-sm font-medium mb-2">المستفيدون النشطون</h4>
            <span class="text-3xl font-heading font-bold text-gray-900 dark:text-white">{{ number_format($kpis['active_beneficiaries']) }}</span>
            <span class="text-xs text-gray-400 mt-2">حالات قيد المتابعة</span>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-100 dark:border-gray-700 shadow-sm flex flex-col items-center text-center">
            <div class="w-12 h-12 rounded-full bg-brand-50 text-brand-600 flex items-center justify-center mb-4">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
            </div>
            <h4 class="text-gray-500 dark:text-gray-400 text-sm font-medium mb-2">المستفيدون الجدد</h4>
            <span class="text-3xl font-heading font-bold text-gray-900 dark:text-white">{{ number_format($kpis['new_this_month']) }}</span>
            <span class="text-xs text-gray-400 mt-2">خلال الشهر الحالي</span>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-100 dark:border-gray-700 shadow-sm flex flex-col items-center text-center">
            <div class="w-12 h-12 rounded-full bg-brand-50 text-brand-600 flex items-center justify-center mb-4">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            </div>
            <h4 class="text-gray-500 dark:text-gray-400 text-sm font-medium mb-2">إجمالي الأسر</h4>
            <span class="text-3xl font-heading font-bold text-gray-900 dark:text-white">{{ number_format($kpis['total_families']) }}</span>
            <span class="text-xs text-gray-400 mt-2">عائلات تم تسجيلها</span>
        </div>
    </div>

    <!-- Recent Beneficiaries Search -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-100 dark:border-gray-700 shadow-sm mb-8">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-heading font-bold text-gray-900 dark:text-white">آخر المستفيدين</h3>
            <a href="{{ route('beneficiaries.index') }}" class="text-sm text-gray-500 hover:text-brand-600 font-medium inline-flex items-center gap-1">
                عرض الكل
                <svg class="w-4 h-4 rtl:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
        </div>
        
        <div class="flex flex-col items-center justify-center py-12 text-center">
            <div class="w-16 h-16 bg-brand-50 rounded-full flex items-center justify-center text-brand-600 mb-4">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <h4 class="text-lg font-heading font-bold text-gray-900 dark:text-white mb-2">مساحة جديدة، وبداية واعدة</h4>
            <p class="text-gray-500 text-sm">ابدأ بإضافة مستفيد، أو عدّل خيارات البحث.</p>
        </div>
    </div>
</x-app-layout>
