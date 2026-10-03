<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-heading font-bold text-3xl text-gray-900 dark:text-white leading-tight">
                المستفيدين
            </h2>
            <a href="{{ route('beneficiaries.create') }}" class="inline-flex items-center justify-center px-4 py-2 bg-brand-600 hover:bg-brand-500 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 transition-all shadow-lg shadow-brand-500/30">
                إضافة مستفيد
            </a>
        </div>
    </x-slot>

    <div class="glass-card rounded-2xl overflow-hidden mb-8">
        <div class="p-6 border-b border-gray-100 dark:border-gray-800">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <h3 class="text-lg font-heading font-semibold text-gray-900 dark:text-white">قائمة المستفيدين المسجلين بالجمعية</h3>
                <form action="{{ route('beneficiaries.index') }}" method="GET" class="w-full md:w-auto flex items-center gap-3">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="بحث بالاسم، الهوية، الجوال..." 
                           class="w-full md:w-64 rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm py-2 px-3">
                    <button type="submit" class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors font-medium text-sm">بحث</button>
                    @if(request('search'))
                        <a href="{{ route('beneficiaries.index') }}" class="text-sm text-red-500 hover:text-red-700">إلغاء</a>
                    @endif
                </form>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50/50 dark:bg-gray-700/50 dark:text-gray-400 border-b border-gray-100 dark:border-gray-800">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-medium">الهوية الوطنية</th>
                        <th scope="col" class="px-6 py-4 font-medium">الاسم</th>
                        <th scope="col" class="px-6 py-4 font-medium">رقم الهاتف</th>
                        <th scope="col" class="px-6 py-4 font-medium">المدينة</th>
                        <th scope="col" class="px-6 py-4 font-medium">الفئة</th>
                        <th scope="col" class="px-6 py-4 font-medium">الحالة</th>
                        <th scope="col" class="px-6 py-4 font-medium text-left">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse($beneficiaries as $beneficiary)
                        <tr class="hover:bg-brand-50/30 dark:hover:bg-gray-700/30 transition-colors">
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-gray-100" dir="ltr">{{ $beneficiary->national_id ?? '---' }}</td>
                            <td class="px-6 py-4 text-gray-900 dark:text-white font-medium">{{ $beneficiary->name }}</td>
                            <td class="px-6 py-4 text-gray-500 dark:text-gray-400" dir="ltr">{{ $beneficiary->phone ?? '---' }}</td>
                            <td class="px-6 py-4 text-gray-500 dark:text-gray-400">{{ $beneficiary->city ?? 'غير محدد' }}</td>
                            <td class="px-6 py-4 text-gray-500 dark:text-gray-400">
                                {{ $beneficiary->category?->label() ?? 'غير محدد' }}
                            </td>
                            <td class="px-6 py-4">
                                @if($beneficiary->status->value === 'active')
                                    <span class="px-2.5 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">نشط</span>
                                @elseif($beneficiary->status->value === 'under_review')
                                    <span class="px-2.5 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400">قيد الدراسة</span>
                                @else
                                    <span class="px-2.5 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">موقوف</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-left">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('beneficiaries.show', $beneficiary) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">عرض</a>
                                    <a href="{{ route('beneficiaries.edit', $beneficiary) }}" class="text-brand-600 hover:text-brand-900 dark:text-brand-400 dark:hover:text-brand-300">تعديل</a>
                                    <form action="{{ route('beneficiaries.destroy', $beneficiary) }}" method="POST" class="inline-block" onsubmit="confirmDelete(event, this, 'هذا المستفيد');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">حذف</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-500">لا يوجد مستفيدين مسجلين حتى الآن.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($beneficiaries->hasPages())
            <div class="p-4 border-t border-gray-100 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-800/50">
                {{ $beneficiaries->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
