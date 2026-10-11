<x-app-layout>
    <x-slot name="header">
        <h2 class="font-heading font-bold text-3xl text-gray-900 dark:text-white leading-tight">
            الجمعيات الخيرية
        </h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">إدارة الجمعيات المسجلة في المنصة</p>
    </x-slot>

    <div class="mb-6 flex justify-between items-center">
        <h3 class="text-lg font-heading font-semibold text-gray-900 dark:text-white">قائمة الجمعيات المسجلة</h3>
        <a href="{{ route('super-admin.tenants.create') }}" class="px-4 py-2 bg-brand-600 text-white rounded-lg hover:bg-brand-700 transition shadow-lg shadow-brand-500/30">
            إضافة جمعية جديدة
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden mb-8">
        <div class="overflow-x-auto">
            <table class="w-full text-right">
                <thead class="bg-gray-50 dark:bg-gray-900/50 border-b border-gray-100 dark:border-gray-800">
                    <tr>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 dark:text-gray-400">الجمعية</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 dark:text-gray-400">الرابط المخصص</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 dark:text-gray-400">الباقة</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 dark:text-gray-400">المستفيدين</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 dark:text-gray-400">تاريخ الانتهاء</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 dark:text-gray-400">الحالة</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 dark:text-gray-400">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse($tenants ?? [] as $tenant)
                        <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-brand-100 text-brand-600 dark:bg-brand-900/30 dark:text-brand-400 flex items-center justify-center font-bold text-xs">
                                        {{ mb_substr($tenant->name, 0, 1) }}
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-sm font-bold text-gray-900 dark:text-white">{{ $tenant->name }}</span>
                                        <span class="text-xs text-gray-500">{{ $tenant->city ?? 'غير محدد' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-500" dir="ltr">{{ $tenant->domain }}</td>
                            <td class="px-6 py-4">
                                @if($tenant->subscription)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400">
                                        {{ $tenant->subscription->name }}
                                    </span>
                                @else
                                    <span class="text-xs text-gray-400">لا يوجد اشتراك</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm font-bold text-gray-900 dark:text-white" dir="ltr">
                                {{ number_format($tenant->beneficiaries_count ?? 0) }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500" dir="ltr">
                                {{ $tenant->subscription_expires_at?->format('Y-m-d') ?? '-' }}
                            </td>
                            <td class="px-6 py-4">
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
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <a href="{{ route('super-admin.tenants.show', $tenant) }}" class="text-gray-500 hover:text-brand-600 transition" title="عرض التفاصيل">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </a>
                                    <a href="{{ route('super-admin.tenants.edit', $tenant) }}" class="text-gray-500 hover:text-amber-500 transition" title="تعديل">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 dark:bg-gray-800 mb-4">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                </div>
                                <h3 class="text-sm font-medium text-gray-900 dark:text-white mb-1">لا توجد جمعيات مسجلة</h3>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(isset($tenants) && method_exists($tenants, 'links'))
            <div class="p-4 border-t border-gray-100 dark:border-gray-800 bg-gray-50/30 dark:bg-gray-800/30">
                {{ $tenants->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
