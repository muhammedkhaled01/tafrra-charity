<x-app-layout>
    <x-slot name="header">
        <h2 class="font-heading font-bold text-3xl text-gray-900 dark:text-white leading-tight">
            إدارة الصلاحيات
        </h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">تحديد الأدوار وصلاحيات الوصول للنظام</p>
    </x-slot>

    <div class="mb-6 flex justify-between items-center">
        <h3 class="text-lg font-heading font-semibold text-gray-900 dark:text-white">الأدوار المتاحة</h3>
        <a href="{{ route('super-admin.roles.create') }}" class="px-4 py-2 bg-brand-600 text-white rounded-lg hover:bg-brand-700 transition shadow-lg shadow-brand-500/30 flex items-center">
            <svg class="w-5 h-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            إضافة دور جديد
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-50 text-green-700 rounded-lg dark:bg-green-900/30 dark:text-green-400">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 p-4 bg-red-50 text-red-700 rounded-lg dark:bg-red-900/30 dark:text-red-400">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden mb-8">
        <div class="overflow-x-auto">
            <table class="w-full text-right">
                <thead class="bg-gray-50 dark:bg-gray-900/50 border-b border-gray-100 dark:border-gray-800">
                    <tr>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 dark:text-gray-400">اسم الدور (المنصب)</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 dark:text-gray-400">الاسم البرمجي</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 dark:text-gray-400">نطاق الدور</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 dark:text-gray-400">عدد المستخدمين</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 dark:text-gray-400">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse($roles as $role)
                        <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-brand-50 text-brand-600 dark:bg-brand-900/30 dark:text-brand-400 flex items-center justify-center font-bold text-xs">
                                        {{ mb_substr($role->label ?? $role->name, 0, 1) }}
                                    </div>
                                    <span class="text-sm font-bold text-gray-900 dark:text-white">{{ $role->label ?? $role->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500" dir="ltr">{{ $role->name }}</td>
                            <td class="px-6 py-4">
                                @if($role->scope === 'platform')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400">
                                        إدارة المنصة
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400">
                                        الجمعيات
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm font-bold text-gray-900 dark:text-white" dir="ltr">
                                {{ number_format($role->users_count ?? 0) }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <a href="{{ route('super-admin.roles.show', $role) }}" class="text-gray-500 hover:text-blue-500 transition" title="إدارة المستخدمين">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                                    </a>
                                    <a href="{{ route('super-admin.roles.edit', $role) }}" class="text-gray-500 hover:text-brand-600 transition" title="تعديل">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                    @if(!in_array($role->name, \App\Enums\RoleName::values()) && ($role->users_count ?? 0) == 0)
                                        <form action="{{ route('super-admin.roles.destroy', $role) }}" method="POST" class="inline-block" onsubmit="return confirm('هل أنت متأكد من حذف هذا الدور؟');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-gray-500 hover:text-red-500 transition" title="حذف">
                                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                <h3 class="text-sm font-medium text-gray-900 dark:text-white mb-1">لا توجد أدوار مسجلة</h3>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
