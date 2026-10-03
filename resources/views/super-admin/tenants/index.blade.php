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

    <div class="glass-card rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50/50 dark:bg-gray-800/50 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-medium">اسم الجمعية</th>
                                <th scope="col" class="px-6 py-4 font-medium">الرابط المخصص</th>
                        <th scope="col" class="px-6 py-4 font-medium">الباقة</th>
                        <th scope="col" class="px-6 py-4 font-medium">تاريخ الانتهاء</th>
                        <th scope="col" class="px-6 py-4 font-medium">الحالة</th>
                        <th scope="col" class="px-6 py-4 font-medium">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse($tenants ?? [] as $tenant)
                        <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/50 transition-colors">
                            <td class="px-6 py-4 text-gray-900 dark:text-white font-medium">{{ $tenant->name }}</td>
                            <td class="px-6 py-4 text-gray-500" dir="ltr">{{ $tenant->domain }}</td>
                            <td class="px-6 py-4">
                                @if($tenant->subscription)
                                    <span class="px-2.5 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">
                                        {{ $tenant->subscription->name }}
                                    </span>
                                @else
                                    <span class="text-gray-400">لا يوجد اشتراك</span>
                                @endif
                            </td>
                            <td class="px-6 py-4" dir="ltr">
                                {{ $tenant->subscription_expires_at?->format('Y-m-d') ?? '-' }}
                            </td>
                            <td class="px-6 py-4">
                                @if($tenant->hasActiveSubscription())
                                    <span class="px-2.5 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">نشط</span>
                                @else
                                    <span class="px-2.5 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">منتهي</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('super-admin.tenants.edit', $tenant) }}" class="text-brand-600 hover:text-brand-800 font-medium ml-3">تعديل</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">لا توجد جمعيات مسجلة.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(isset($tenants) && method_exists($tenants, 'links'))
            <div class="p-4 border-t border-gray-100 dark:border-gray-800">
                {{ $tenants->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
