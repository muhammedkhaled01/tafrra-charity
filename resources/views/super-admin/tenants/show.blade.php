<x-app-layout>
    <x-slot name="header">
        <h2 class="font-heading font-bold text-3xl text-gray-900 dark:text-white leading-tight">
            تفاصيل الجمعية: {{ $tenant->name }}
        </h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">عرض جميع البيانات والإحصائيات الخاصة بالجمعية</p>
    </x-slot>

    <div class="mb-6 flex justify-end items-center gap-3">
        <a href="{{ route('super-admin.tenants.edit', $tenant) }}" class="px-4 py-2 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition flex items-center shadow-sm">
            <svg class="w-4 h-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            تعديل البيانات
        </a>
        <a href="{{ route('super-admin.tenants.index') }}" class="px-4 py-2 bg-brand-50 dark:bg-brand-900/30 text-brand-600 dark:text-brand-400 rounded-lg hover:bg-brand-100 dark:hover:bg-brand-900/50 transition">
            العودة للقائمة
        </a>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-5 flex items-center gap-4">
            <div class="w-12 h-12 flex-shrink-0 flex items-center justify-center rounded-xl bg-brand-50 text-brand-600 dark:bg-brand-900/30 dark:text-brand-400">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">المستفيدين</p>
                <h4 class="text-2xl font-bold text-gray-900 dark:text-white" dir="ltr">{{ number_format($tenant->beneficiaries_count) }}</h4>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-5 flex items-center gap-4">
            <div class="w-12 h-12 flex-shrink-0 flex items-center justify-center rounded-xl bg-purple-50 text-purple-600 dark:bg-purple-900/30 dark:text-purple-400">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">المشاريع</p>
                <h4 class="text-2xl font-bold text-gray-900 dark:text-white" dir="ltr">{{ number_format($tenant->projects_count) }}</h4>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-5 flex items-center gap-4">
            <div class="w-12 h-12 flex-shrink-0 flex items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-900/30 dark:text-emerald-400">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">الداعمين (الكفلاء)</p>
                <h4 class="text-2xl font-bold text-gray-900 dark:text-white" dir="ltr">{{ number_format($tenant->donors_count) }}</h4>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-5 flex items-center gap-4">
            <div class="w-12 h-12 flex-shrink-0 flex items-center justify-center rounded-xl bg-amber-50 text-amber-600 dark:bg-amber-900/30 dark:text-amber-400">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">عمليات الدفع بالمنصة</p>
                <h4 class="text-2xl font-bold text-gray-900 dark:text-white" dir="ltr">{{ number_format($tenant->payments_count) }}</h4>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Tenant Info -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="p-6 border-b border-gray-100 dark:border-gray-800">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">البيانات الأساسية</h3>
            </div>
            <div class="p-6">
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-6">
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">اسم الجمعية</dt>
                        <dd class="mt-1 text-sm font-semibold text-gray-900 dark:text-white">{{ $tenant->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">الرابط المخصص (Subdomain)</dt>
                        <dd class="mt-1 text-sm font-semibold text-gray-900 dark:text-white" dir="ltr">{{ $tenant->domain }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">رقم الهاتف</dt>
                        <dd class="mt-1 text-sm font-semibold text-gray-900 dark:text-white" dir="ltr">{{ $tenant->phone ?? 'غير محدد' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">البريد الإلكتروني</dt>
                        <dd class="mt-1 text-sm font-semibold text-gray-900 dark:text-white">{{ $tenant->email ?? 'غير محدد' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">المدينة</dt>
                        <dd class="mt-1 text-sm font-semibold text-gray-900 dark:text-white">{{ $tenant->city ?? 'غير محدد' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">تاريخ الانضمام</dt>
                        <dd class="mt-1 text-sm font-semibold text-gray-900 dark:text-white" dir="ltr">{{ $tenant->created_at->format('Y-m-d') }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Subscription Info -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="p-6 border-b border-gray-100 dark:border-gray-800">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">بيانات الاشتراك</h3>
            </div>
            <div class="p-6">
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-6">
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">الباقة المشترك بها</dt>
                        <dd class="mt-1">
                            @if($tenant->subscription)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400">
                                    {{ $tenant->subscription->name }}
                                </span>
                            @else
                                <span class="text-sm font-semibold text-gray-400">لا يوجد اشتراك</span>
                            @endif
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">حالة الاشتراك</dt>
                        <dd class="mt-1">
                            @if($tenant->hasActiveSubscription())
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400">
                                    <svg class="w-3 h-3 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    نشط
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400">
                                    <svg class="w-3 h-3 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    منتهي
                                </span>
                            @endif
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">تاريخ انتهاء الباقة</dt>
                        <dd class="mt-1 text-sm font-semibold text-gray-900 dark:text-white" dir="ltr">{{ $tenant->subscription_expires_at?->format('Y-m-d') ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">تكلفة الباقة (MRR)</dt>
                        <dd class="mt-1 text-sm font-semibold text-gray-900 dark:text-white" dir="ltr">
                            {{ $tenant->subscription ? number_format($tenant->subscription->price, 2) . ' ر.س' : '-' }}
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>

    <!-- Users/Admins list -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="p-6 border-b border-gray-100 dark:border-gray-800 flex justify-between items-center bg-gray-50/30 dark:bg-gray-800/30">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white">حسابات الإدارة (الموظفين)</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-right">
                <thead class="bg-gray-50 dark:bg-gray-900/50 border-b border-gray-100 dark:border-gray-800">
                    <tr>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 dark:text-gray-400">الاسم</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 dark:text-gray-400">البريد الإلكتروني</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 dark:text-gray-400">الصلاحية</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 dark:text-gray-400">تاريخ الإضافة</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse($tenant->users as $user)
                        <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center font-bold text-gray-600 dark:text-gray-300 text-xs">
                                        {{ mb_substr($user->name, 0, 1) }}
                                    </div>
                                    <span class="text-sm font-bold text-gray-900 dark:text-white">{{ $user->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500" dir="ltr">{{ $user->email }}</td>
                            <td class="px-6 py-4">
                                @if($user->hasRole('charity-admin'))
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-brand-100 text-brand-700 dark:bg-brand-900/30 dark:text-brand-400">
                                        مدير نظام
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-400">
                                        موظف
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500" dir="ltr">{{ $user->created_at->format('Y-m-d') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-gray-500">لا يوجد موظفين مسجلين للجمعية.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</x-app-layout>
