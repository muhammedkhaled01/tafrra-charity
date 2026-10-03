<x-app-layout>
    <x-slot name="header">
        <h2 class="font-heading font-bold text-3xl text-gray-900 dark:text-white leading-tight">
            إدارة الصلاحيات
        </h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">تحديد الأدوار وصلاحيات الوصول للنظام</p>
    </x-slot>

    <div class="mb-6 flex justify-between items-center">
        <h3 class="text-lg font-heading font-semibold text-gray-900 dark:text-white">الأدوار المتاحة</h3>
        <button class="px-4 py-2 bg-brand-600 text-white rounded-lg hover:bg-brand-700 transition shadow-lg shadow-brand-500/30">
            إضافة دور جديد
        </button>
    </div>

    <div class="glass-card rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50/50 dark:bg-gray-800/50 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-medium">اسم الدور (المنصب)</th>
                        <th scope="col" class="px-6 py-4 font-medium">عدد المستخدمين</th>
                        <th scope="col" class="px-6 py-4 font-medium">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/50 transition-colors">
                        <td class="px-6 py-4 text-gray-900 dark:text-white font-medium">مدير المنصة (Super Admin)</td>
                        <td class="px-6 py-4">2</td>
                        <td class="px-6 py-4">
                            <button class="text-brand-600 hover:text-brand-800 font-medium">تعديل الصلاحيات</button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/50 transition-colors">
                        <td class="px-6 py-4 text-gray-900 dark:text-white font-medium">مدير الجمعية (Charity Admin)</td>
                        <td class="px-6 py-4">28</td>
                        <td class="px-6 py-4">
                            <button class="text-brand-600 hover:text-brand-800 font-medium">تعديل الصلاحيات</button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/50 transition-colors">
                        <td class="px-6 py-4 text-gray-900 dark:text-white font-medium">موظف الدعم (Support)</td>
                        <td class="px-6 py-4">5</td>
                        <td class="px-6 py-4">
                            <button class="text-brand-600 hover:text-brand-800 font-medium">تعديل الصلاحيات</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
