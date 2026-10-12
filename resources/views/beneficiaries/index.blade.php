<x-app-layout>
    <x-slot name="header">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
                <div>
                    <h2 class="font-heading font-bold text-3xl text-brand-800 dark:text-white leading-tight mb-1">
                        المستفيدون
                    </h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">إدارة ملفات المستفيدين واستيرادها ومتابعة بياناتهم بسهولة.</p>
                </div>
                <div class="flex flex-wrap items-center gap-3 w-full md:w-auto">
                    <!-- Download Template -->
                    <a href="{{ route('beneficiaries.template') }}" 
                       class="group inline-flex items-center gap-2 bg-white dark:bg-gray-800 hover:bg-blue-50/60 dark:hover:bg-blue-950/20 text-gray-700 dark:text-gray-200 hover:text-blue-700 dark:hover:text-blue-400 px-4 py-2.5 rounded-2xl border border-gray-200/90 dark:border-gray-700 hover:border-blue-300 dark:hover:border-blue-600/50 text-sm font-semibold transition-all duration-200 shadow-xs hover:shadow" 
                       title="تحميل ملف إكسيل فارغ لتعبئة بيانات المستفيدين">
                        <span class="w-6 h-6 rounded-lg bg-blue-50 dark:bg-blue-900/40 text-blue-600 dark:text-blue-400 flex items-center justify-center transition-transform group-hover:scale-110">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        </span>
                        <span>تحميل النموذج</span>
                    </a>

                    <!-- Import Excel Modal Trigger -->
                    <button type="button" 
                            id="openImportModalBtn"
                            onclick="window.dispatchEvent(new CustomEvent('open-beneficiaries-modal'))"
                            @click="$dispatch('open-beneficiaries-modal')" 
                            class="group inline-flex items-center gap-2 bg-white dark:bg-gray-800 hover:bg-emerald-50/60 dark:hover:bg-emerald-950/20 text-gray-700 dark:text-gray-200 hover:text-emerald-700 dark:hover:text-emerald-400 px-4 py-2.5 rounded-2xl border border-gray-200/90 dark:border-gray-700 hover:border-emerald-300 dark:hover:border-emerald-600/50 text-sm font-semibold transition-all duration-200 shadow-xs hover:shadow">
                        <span class="w-6 h-6 rounded-lg bg-emerald-50 dark:bg-emerald-900/40 text-emerald-600 dark:text-emerald-400 flex items-center justify-center transition-transform group-hover:scale-110">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                        </span>
                        <span>استيراد إكسيل</span>
                    </button>

                    <!-- Add New (Primary CTA) -->
                    <a href="{{ route('beneficiaries.create') }}" 
                       class="inline-flex items-center gap-2 bg-brand-800 hover:bg-brand-700 text-white px-5 py-2.5 rounded-2xl transition-all duration-200 shadow-md shadow-brand-900/20 hover:shadow-lg text-sm font-bold hover:-translate-y-0.5 active:translate-y-0"
                       style="background-color: #1d624c; color: #ffffff;">
                        <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                        <span class="text-white">إضافة مستفيد</span>
                    </a>
                </div>
            </div>
        </x-slot>

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
                    <div class="flex items-center gap-2">
                        <button type="submit" class="hidden md:inline-flex items-center justify-center px-5 py-2.5 bg-brand-800 hover:bg-brand-900 text-white rounded-xl font-bold text-sm shadow-xs transition-all duration-200">تطبيق</button>
                        @if(request()->anyFilled(['search', 'city', 'marital_status']))
                            <a href="{{ route('beneficiaries.index') }}" class="inline-flex items-center justify-center px-4 py-2.5 bg-gray-100 hover:bg-rose-50 text-gray-600 hover:text-rose-600 rounded-xl font-semibold text-sm transition-all duration-200">مسح</a>
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
            <!-- Table Footer: Export Actions & Pagination -->
            <div class="p-4 sm:px-6 border-t border-gray-100 dark:border-gray-700/80 bg-gray-50/70 dark:bg-gray-900/40 flex flex-col md:flex-row items-center justify-between gap-4">
                <!-- Export Section (Right in RTL) -->
                <div class="flex flex-wrap items-center gap-3 w-full md:w-auto">
                    @if(auth()->user()->hasFeature('exports'))
                        <div class="flex items-center gap-1.5 text-xs font-bold text-gray-500 dark:text-gray-400 ml-1">
                            <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            <span>تصدير السجلات:</span>
                        </div>

                        <!-- Modern Export Excel Button -->
                        <a id="exportExcelBtn" href="{{ route('exports.beneficiaries', array_merge(request()->query(), ['format' => 'excel'])) }}" 
                           class="group inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs font-bold text-emerald-800 dark:text-emerald-300 bg-white dark:bg-gray-800 hover:bg-emerald-50 dark:hover:bg-emerald-950/40 border border-emerald-200/80 dark:border-emerald-800/60 shadow-xs hover:shadow transition-all duration-200"
                           title="تصدير بيانات المستفيدين إلى ملف إكسيل">
                            <span class="w-5 h-5 rounded-lg bg-emerald-600 text-white flex items-center justify-center shadow-xs group-hover:scale-105 transition-transform">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </span>
                            <span>تصدير إكسيل</span>
                        </a>

                        <!-- Modern Export PDF Button -->
                        <a id="exportPdfBtn" href="{{ route('exports.beneficiaries', array_merge(request()->query(), ['format' => 'pdf'])) }}" 
                           class="group inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs font-bold text-rose-800 dark:text-rose-300 bg-white dark:bg-gray-800 hover:bg-rose-50 dark:hover:bg-rose-950/40 border border-rose-200/80 dark:border-rose-800/60 shadow-xs hover:shadow transition-all duration-200"
                           title="تصدير بيانات المستفيدين إلى ملف PDF">
                            <span class="w-5 h-5 rounded-lg bg-rose-600 text-white flex items-center justify-center shadow-xs group-hover:scale-105 transition-transform">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                            </span>
                            <span>تصدير PDF</span>
                        </a>

                        <!-- Selection Count Badge -->
                        <span id="selectedCountBadge" class="hidden items-center gap-1.5 px-3 py-1.5 rounded-xl bg-brand-50 dark:bg-brand-950/50 text-brand-800 dark:text-brand-300 text-xs font-semibold border border-brand-200/60 dark:border-brand-800/60">
                            <svg class="w-3.5 h-3.5 text-brand-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span>محدد: <strong id="selectedCountNum" class="font-bold">0</strong> مستفيد (سيتم تصديرهم فقط)</span>
                        </span>
                    @endif
                </div>

                <!-- Pagination Section (Left in RTL) -->
                @if($beneficiaries->hasPages())
                    <div class="w-full md:w-auto flex justify-center md:justify-end">
                        {{ $beneficiaries->links() }}
                    </div>
                @else
                    <div class="text-xs text-gray-500 dark:text-gray-400 font-medium">
                        إجمالي النتائج: <strong class="text-gray-800 dark:text-gray-200">{{ $beneficiaries->total() }}</strong> مستفيد
                    </div>
                @endif
            </div>
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

    <!-- Import Modal -->
    <div 
        x-data="{ importModalOpen: false, selectedFileName: '', isSubmitting: false }"
        @open-beneficiaries-modal.window="importModalOpen = true; isSubmitting = false"
        @keydown.escape.window="importModalOpen = false"
        x-show="importModalOpen" 
        x-cloak
        class="fixed inset-0 z-50 overflow-y-auto"
        aria-labelledby="modal-title" 
        role="dialog" 
        aria-modal="true"
    >
        <!-- Background overlay (pure backdrop, behind the modal) -->
        <div 
            x-show="importModalOpen" 
            x-transition:enter="ease-out duration-300" 
            x-transition:enter-start="opacity-0" 
            x-transition:enter-end="opacity-100" 
            x-transition:leave="ease-in duration-200" 
            x-transition:leave-start="opacity-100" 
            x-transition:leave-end="opacity-0" 
            @click="importModalOpen = false" 
            class="fixed inset-0 bg-gray-950/60 backdrop-blur-xs transition-opacity z-10" 
            aria-hidden="true"
        ></div>

        <!-- Modal Dialog Wrapper (Above backdrop) -->
        <div class="fixed inset-0 z-20 overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-6">
                <!-- Modal Panel -->
                <div 
                    x-show="importModalOpen" 
                    x-transition:enter="ease-out duration-300" 
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                    x-transition:leave="ease-in duration-200" 
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                    class="relative w-full max-w-xl rounded-3xl bg-white dark:bg-gray-800 text-right shadow-2xl border border-gray-100 dark:border-gray-700 overflow-hidden transform transition-all z-30"
                    @click.stop
                >
                    <form action="{{ route('beneficiaries.import') }}" method="POST" enctype="multipart/form-data" @submit="isSubmitting = true">
                        @csrf
                        
                        <!-- Header -->
                        <div class="px-6 py-5 bg-gradient-to-r from-emerald-500/10 to-brand-500/10 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-2xl bg-emerald-500 text-white flex items-center justify-center shadow-lg shadow-emerald-500/30">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900 dark:text-white" id="modal-title">استيراد المستفيدين من إكسيل</h3>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">إضافة دفعات المستفيدين دفعة واحدة بكل سهولة</p>
                                </div>
                            </div>
                            <button type="button" @click="importModalOpen = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 rounded-xl p-1.5 transition">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>

                        <!-- Body -->
                        <div class="p-6 space-y-5">
                            <!-- Step 1: Download Template Notice -->
                            <div class="p-4 rounded-2xl bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 flex items-start gap-3">
                                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <div class="text-xs text-blue-800 dark:text-blue-300 leading-relaxed">
                                    <span class="font-bold block mb-1">الخطوة الأولى: تحميل النموذج المعتمد</span>
                                    حمّل نموذج الإكسيل الجاهز واملأ به بيانات المستفيدين ثم ارفعه هنا.
                                    <div class="mt-2">
                                        <a href="{{ route('beneficiaries.template') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-blue-700 dark:text-blue-200 bg-white dark:bg-gray-800 px-3 py-1.5 rounded-lg border border-blue-300 hover:bg-blue-100 transition shadow-sm">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                            اضغط هنا لتحميل نموذج الإكسيل الفارغ (.xlsx)
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Step 2: Upload File Area -->
                            <div>
                                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                                    الخطوة الثانية: اختيار ملف الإكسيل المكتمل
                                </label>
                                <div class="relative border-2 border-dashed border-gray-300 dark:border-gray-600 hover:border-emerald-500 rounded-2xl p-6 text-center transition bg-gray-50/50 dark:bg-gray-900/50 hover:bg-emerald-50/20 group">
                                    <!-- Full-cover native file input for 100% reliable click & drag-drop -->
                                    <input 
                                        type="file" 
                                        name="file" 
                                        id="beneficiaryFileInput"
                                        accept=".xlsx,.xls,.csv" 
                                        required 
                                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                        @change="if ($event.target.files.length) { selectedFileName = $event.target.files[0].name; }"
                                    >
                                    
                                    <div class="flex flex-col items-center justify-center relative z-10 pointer-events-none">
                                        <div class="w-14 h-14 rounded-2xl flex items-center justify-center mb-3 transition-all"
                                             :class="selectedFileName ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-600/30' : 'bg-emerald-100 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400'">
                                            <template x-if="!selectedFileName">
                                                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                                </svg>
                                            </template>
                                            <template x-if="selectedFileName">
                                                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                                </svg>
                                            </template>
                                        </div>
                                        
                                        <p class="text-sm font-bold text-gray-800 dark:text-gray-100" 
                                           x-text="selectedFileName ? selectedFileName : 'انقر هنا لاختيار الملف أو اسحبه وأفلته هنا'"></p>
                                        
                                        <p class="text-xs text-gray-400 mt-1" 
                                           x-text="selectedFileName ? 'تم اختيار الملف بنجاح - يمكنك الضغط بالأسفل لبدء الاستيراد' : 'يدعم ملفات بصيغة Excel (.xlsx, .xls) أو CSV بحد أقصى 10MB'"></p>
                                    </div>
                                </div>
                            </div>

                            <!-- Columns Information Accordion / Guide -->
                            <div class="rounded-2xl border border-gray-100 dark:border-gray-700 p-4 bg-gray-50/50 dark:bg-gray-900/40 text-xs text-gray-600 dark:text-gray-400 space-y-2">
                                <span class="font-bold text-gray-900 dark:text-white block">الأعمدة المدعومة في النموذج:</span>
                                <div class="flex flex-wrap gap-1.5">
                                    <span class="px-2 py-0.5 rounded-md bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 font-medium text-emerald-700 dark:text-emerald-400">رقم الهوية *</span>
                                    <span class="px-2 py-0.5 rounded-md bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 font-medium">الاسم الكامل *</span>
                                    <span class="px-2 py-0.5 rounded-md bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 font-medium text-emerald-700 dark:text-emerald-400">رقم الجوال *</span>
                                    <span class="px-2 py-0.5 rounded-md bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 font-medium">تاريخ الميلاد *</span>
                                    <span class="px-2 py-0.5 rounded-md bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700">الجنس</span>
                                    <span class="px-2 py-0.5 rounded-md bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700">الحالة الاجتماعية</span>
                                    <span class="px-2 py-0.5 rounded-md bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700">المدينة</span>
                                    <span class="px-2 py-0.5 rounded-md bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700">أفراد الأسرة</span>
                                    <span class="px-2 py-0.5 rounded-md bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700">الدخل الشهري</span>
                                    <span class="px-2 py-0.5 rounded-md bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700">الفئة</span>
                                    <span class="px-2 py-0.5 rounded-md bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700">الحالة</span>
                                </div>
                                <p class="text-[11px] text-gray-500 mt-1 leading-normal">* إذا كان رقم الهوية موجوداً مسبقاً في جمعيتك، سيقوم النظام بتحديث بيانات المستفيد تلقائياً دون تكراره.</p>
                            </div>
                        </div>

                        <!-- Footer -->
                        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-900/50 border-t border-gray-100 dark:border-gray-700 flex justify-end gap-3">
                            <button type="button" @click="importModalOpen = false" class="px-5 py-2.5 rounded-2xl border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 font-semibold hover:bg-gray-100 dark:hover:bg-gray-750 transition-all text-sm">
                                إلغاء
                            </button>
                            <button type="submit" :disabled="isSubmitting" 
                                    class="inline-flex items-center gap-2 bg-brand-800 hover:bg-brand-700 text-white px-6 py-2.5 rounded-2xl font-bold transition-all shadow-md shadow-brand-900/20 hover:shadow-lg text-sm disabled:opacity-50"
                                    style="background-color: #1d624c; color: #ffffff;">
                                <span x-show="!isSubmitting">بدء الاستيراد والإضافة</span>
                                <span x-show="isSubmitting" class="inline-flex items-center gap-2">
                                    <svg class="animate-spin w-4 h-4 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    <span class="text-white">جاري الاستيراد...</span>
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const openImportModalBtn = document.getElementById('openImportModalBtn');
            const selectAll = document.getElementById('selectAll');
            const checkboxes = document.querySelectorAll('.beneficiary-checkbox');
            const exportExcelBtn = document.getElementById('exportExcelBtn');
            const exportPdfBtn = document.getElementById('exportPdfBtn');

            if (openImportModalBtn) {
                openImportModalBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    window.dispatchEvent(new CustomEvent('open-beneficiaries-modal'));
                });
            }

            // Original hrefs
            const excelBaseHref = exportExcelBtn ? exportExcelBtn.href : '';
            const pdfBaseHref = exportPdfBtn ? exportPdfBtn.href : '';

            function updateExportLinks() {
                if (!exportExcelBtn || !exportPdfBtn) return;
                
                const selectedCheckboxes = Array.from(checkboxes).filter(cb => cb.checked);
                const selectedIds = selectedCheckboxes.map(cb => cb.value).join(',');
                const selectedBadge = document.getElementById('selectedCountBadge');
                const selectedNum = document.getElementById('selectedCountNum');

                if (selectedCheckboxes.length > 0) {
                    if (selectedBadge) {
                        selectedBadge.classList.remove('hidden');
                        selectedBadge.classList.add('inline-flex');
                    }
                    if (selectedNum) {
                        selectedNum.textContent = selectedCheckboxes.length;
                    }
                } else {
                    if (selectedBadge) {
                        selectedBadge.classList.add('hidden');
                        selectedBadge.classList.remove('inline-flex');
                    }
                }

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
