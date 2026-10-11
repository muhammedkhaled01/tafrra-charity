<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center mb-6">
            <div class="text-center md:text-right w-full md:w-auto">
                <h2 class="font-heading font-bold text-3xl text-brand-800 dark:text-white leading-tight mb-2">
                    المستفيدون
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">إدارة ملفات المستفيدين ومتابعة بياناتهم بسهولة.</p>
            </div>
            <div class="flex items-center gap-3 hidden md:flex">
                @if(auth()->user()->hasFeature('exports'))
                <!-- Export Excel -->
                <a id="exportExcelBtn" href="{{ route('exports.beneficiaries', array_merge(request()->query(), ['format' => 'excel'])) }}" class="inline-flex items-center gap-2 bg-green-50 border border-green-100 hover:bg-green-100 text-green-700 px-4 py-2.5 rounded-xl transition-colors text-sm font-medium">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    إكسيل
                </a>
                <!-- Export PDF -->
                <a id="exportPdfBtn" href="{{ route('exports.beneficiaries', array_merge(request()->query(), ['format' => 'pdf'])) }}" class="inline-flex items-center gap-2 bg-red-50 border border-red-100 hover:bg-red-100 text-red-700 px-4 py-2.5 rounded-xl transition-colors text-sm font-medium">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                    PDF
                </a>
                @endif
                <!-- Add New -->
                <a href="{{ route('beneficiaries.create') }}" class="inline-flex items-center gap-2 bg-brand-800 hover:bg-brand-700 text-white px-5 py-2.5 rounded-xl transition-colors shadow-lg shadow-brand-900/20 text-sm font-medium">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    إضافة مستفيد
                </a>
            </div>
        </div>
    </x-slot>

    <!-- Mobile Add Button -->
    <div class="md:hidden mb-6">
        <a href="{{ route('beneficiaries.create') }}" class="w-full flex items-center justify-center gap-2 bg-brand-800 hover:bg-brand-700 text-white px-5 py-3 rounded-xl transition-colors shadow-lg shadow-brand-900/20 text-sm font-medium">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            إضافة مستفيد
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-3xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden mb-8">
        <!-- Search and Filters Section -->
        <div class="p-6 border-b border-gray-100 dark:border-gray-700 bg-white dark:bg-gray-800 relative z-10">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-2 text-brand-800 w-full md:w-auto">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/></svg>
                    <span class="font-medium text-sm">سجل المستفيدين</span>
                </div>
                
                <form action="{{ route('beneficiaries.index') }}" method="GET" class="w-full md:flex-1 flex flex-col md:flex-row items-center justify-end gap-3">
                    <div class="w-full md:w-48">
                        <select name="city" class="w-full rounded-xl border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-700 dark:text-gray-300 focus:border-brand-500 focus:ring-brand-500 text-sm py-2.5 px-3">
                            <option value="">جميع المدن</option>
                            @php
                                $citiesList = ['الرياض', 'جدة', 'مكة المكرمة', 'المدينة المنورة', 'الدمام', 'الطائف', 'تبوك', 'بريدة', 'خميس مشيط', 'الهفوف', 'المبرز', 'حفر الباطن', 'حائل', 'نجران', 'الجبيل', 'أبها', 'ينبع', 'الخُبر', 'عرعر', 'سكاكا', 'جازان', 'القريات', 'الظهران', 'القطيف', 'الباحة'];
                            @endphp
                            @foreach($citiesList as $cityOption)
                                <option value="{{ $cityOption }}" @selected(request('city') == $cityOption)>{{ $cityOption }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-full md:w-56">
                        <select name="marital_status" class="w-full rounded-xl border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-700 dark:text-gray-300 focus:border-brand-500 focus:ring-brand-500 text-sm py-2.5 px-3">
                            <option value="">جميع الحالات الاجتماعية</option>
                            <option value="أعزب" @selected(request('marital_status') == 'أعزب')>أعزب</option>
                            <option value="متزوج" @selected(request('marital_status') == 'متزوج')>متزوج</option>
                            <option value="مطلق" @selected(request('marital_status') == 'مطلق')>مطلق</option>
                            <option value="أرمل" @selected(request('marital_status') == 'أرمل')>أرمل</option>
                        </select>
                    </div>
                    <div class="w-full md:flex-1 relative">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="ابحث بالاسم، أو رقم الهوية، أو الجوال..." 
                               class="w-full rounded-xl border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white placeholder-gray-400 focus:border-brand-500 focus:ring-brand-500 text-sm py-2.5 pr-10 pl-4 shadow-sm transition-colors">
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="hidden md:block px-4 py-2.5 bg-brand-50 text-brand-800 rounded-xl hover:bg-brand-100 transition-colors font-medium text-sm">تطبيق</button>
                        @if(request()->anyFilled(['search', 'city', 'marital_status']))
                            <a href="{{ route('beneficiaries.index') }}" class="px-4 py-2.5 bg-red-50 text-red-600 rounded-xl hover:bg-red-100 transition-colors font-medium text-sm">مسح</a>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        @if($beneficiaries->isNotEmpty())
            <!-- Data Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-400 uppercase bg-gray-50/50 dark:bg-gray-900/50">
                        <tr>
                            <th scope="col" class="px-6 py-4 w-12">
                                <input type="checkbox" id="selectAll" class="rounded border-gray-300 text-brand-600 shadow-sm focus:ring-brand-500">
                            </th>
                            <th scope="col" class="px-6 py-4 font-medium text-gray-500">الهوية الوطنية</th>
                            <th scope="col" class="px-6 py-4 font-medium text-gray-500">الاسم</th>
                            <th scope="col" class="px-6 py-4 font-medium text-gray-500">رقم الهاتف</th>
                            <th scope="col" class="px-6 py-4 font-medium text-gray-500">المدينة</th>
                            <th scope="col" class="px-6 py-4 font-medium text-gray-500">نوع الحالة</th>
                            <th scope="col" class="px-6 py-4 font-medium text-gray-500">الحالة</th>
                            <th scope="col" class="px-6 py-4 font-medium text-gray-500 text-left">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        @foreach($beneficiaries as $beneficiary)
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/50 transition-colors">
                                <td class="px-6 py-4">
                                    <input type="checkbox" name="selected_ids[]" value="{{ $beneficiary->id }}" class="beneficiary-checkbox rounded border-gray-300 text-brand-600 shadow-sm focus:ring-brand-500">
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-gray-100" dir="ltr">{{ $beneficiary->national_id }}</td>
                                <td class="px-6 py-4 text-gray-900 dark:text-white font-medium">{{ $beneficiary->name }}</td>
                                <td class="px-6 py-4 text-gray-500 dark:text-gray-400" dir="ltr">{{ $beneficiary->phone }}</td>
                                <td class="px-6 py-4 text-gray-500 dark:text-gray-400">{{ $beneficiary->city }}</td>
                                <td class="px-6 py-4 text-gray-500 dark:text-gray-400">{{ $beneficiary->category?->label() ?? '---' }}</td>
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
                                    <div class="flex items-center justify-end gap-2">
                                        <!-- View -->
                                        <a href="{{ route('beneficiaries.show', $beneficiary) }}" class="p-2 text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors" title="عرض التفاصيل">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        </a>
                                        <!-- Edit -->
                                        <a href="{{ route('beneficiaries.edit', $beneficiary) }}" class="p-2 text-brand-600 bg-brand-50 rounded-lg hover:bg-brand-100 transition-colors" title="تعديل">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                        </a>
                                        <!-- Delete -->
                                        <form action="{{ route('beneficiaries.destroy', $beneficiary) }}" method="POST" class="inline-block" onsubmit="confirmDelete(event, this, 'هذا المستفيد');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-red-600 bg-red-50 rounded-lg hover:bg-red-100 transition-colors" title="حذف">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($beneficiaries->hasPages())
                <div class="p-4 border-t border-gray-100 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-900/30">
                    {{ $beneficiaries->links() }}
                </div>
            @endif
        @else
            <!-- Empty State -->
            <div class="flex flex-col items-center justify-center py-20 px-4 text-center">
                <div class="w-16 h-16 bg-brand-50 rounded-2xl flex items-center justify-center text-brand-600 mb-6 shadow-sm">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <h4 class="text-xl font-heading font-bold text-brand-900 dark:text-white mb-2">لا توجد سجلات مطابقة</h4>
                <p class="text-gray-500 text-sm max-w-md">ابدأ بإضافة مستفيد، أو عدّل خيارات البحث.</p>
            </div>
        @endif
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectAll = document.getElementById('selectAll');
            const checkboxes = document.querySelectorAll('.beneficiary-checkbox');
            const exportExcelBtn = document.getElementById('exportExcelBtn');
            const exportPdfBtn = document.getElementById('exportPdfBtn');

            // Original hrefs
            const excelBaseHref = exportExcelBtn ? exportExcelBtn.href : '';
            const pdfBaseHref = exportPdfBtn ? exportPdfBtn.href : '';

            function updateExportLinks() {
                if (!exportExcelBtn || !exportPdfBtn) return;
                
                const selectedIds = Array.from(checkboxes)
                    .filter(cb => cb.checked)
                    .map(cb => cb.value)
                    .join(',');

                if (selectedIds) {
                    const separatorExcel = excelBaseHref.includes('?') ? '&' : '?';
                    exportExcelBtn.href = excelBaseHref + separatorExcel + 'ids=' + selectedIds;
                    
                    const separatorPdf = pdfBaseHref.includes('?') ? '&' : '?';
                    exportPdfBtn.href = pdfBaseHref + separatorPdf + 'ids=' + selectedIds;
                } else {
                    exportExcelBtn.href = excelBaseHref;
                    exportPdfBtn.href = pdfBaseHref;
                }
            }

            if (selectAll) {
                selectAll.addEventListener('change', function() {
                    checkboxes.forEach(cb => cb.checked = selectAll.checked);
                    updateExportLinks();
                });
            }

            checkboxes.forEach(cb => {
                cb.addEventListener('change', function() {
                    updateExportLinks();
                    
                    // Update select all state
                    const allChecked = Array.from(checkboxes).every(c => c.checked);
                    const someChecked = Array.from(checkboxes).some(c => c.checked);
                    selectAll.checked = allChecked;
                    selectAll.indeterminate = someChecked && !allChecked;
                });
            });
        });
    </script>
    @endpush
</x-app-layout>
