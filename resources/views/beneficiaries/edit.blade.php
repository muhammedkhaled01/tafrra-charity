<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center mb-6">
            <div class="text-right w-full md:w-auto">
                <a href="{{ route('beneficiaries.index') }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-brand-600 mb-2 transition-colors">
                    <svg class="w-4 h-4 rtl:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    العودة
                </a>
                <h2 class="font-heading font-bold text-3xl text-brand-800 dark:text-white leading-tight mb-2">
                    تعديل بيانات المستفيد
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">تحديث معلومات المستفيد. الحقول المشار إليها بنجمة مطلوبة.</p>
            </div>
        </div>
    </x-slot>

    <form action="{{ route('beneficiaries.update', $beneficiary) }}" method="POST" class="max-w-5xl mx-auto space-y-6 pb-12">
        @csrf
        @method('PUT')

        <!-- Personal Data -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-visible p-6 md:p-8">
            <h3 class="text-lg font-heading font-bold text-brand-800 dark:text-white mb-6 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                البيانات الشخصية
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- First Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">الاسم الأول <span class="text-red-500">*</span></label>
                    <input type="text" name="first_name" value="{{ old('first_name', $beneficiary->first_name) }}" required
                           class="w-full rounded-xl border border-gray-300 bg-gray-50 focus:bg-white focus:border-brand-500 focus:ring-brand-500 py-2.5 px-4 text-sm shadow-sm">
                    @error('first_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <!-- Father Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">اسم الأب</label>
                    <input type="text" name="father_name" value="{{ old('father_name', $beneficiary->father_name) }}"
                           class="w-full rounded-xl border border-gray-300 bg-gray-50 focus:bg-white focus:border-brand-500 focus:ring-brand-500 py-2.5 px-4 text-sm shadow-sm">
                    @error('father_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <!-- Grandfather Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">اسم الجد</label>
                    <input type="text" name="grandfather_name" value="{{ old('grandfather_name', $beneficiary->grandfather_name) }}"
                           class="w-full rounded-xl border border-gray-300 bg-gray-50 focus:bg-white focus:border-brand-500 focus:ring-brand-500 py-2.5 px-4 text-sm shadow-sm">
                    @error('grandfather_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <!-- Family Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">اسم العائلة <span class="text-red-500">*</span></label>
                    <input type="text" name="family_name" value="{{ old('family_name', $beneficiary->family_name) }}" required
                           class="w-full rounded-xl border border-gray-300 bg-gray-50 focus:bg-white focus:border-brand-500 focus:ring-brand-500 py-2.5 px-4 text-sm shadow-sm">
                    @error('family_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <!-- National ID -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">رقم الهوية <span class="text-red-500">*</span></label>
                    <input type="text" name="national_id" value="{{ old('national_id', $beneficiary->national_id) }}" required dir="ltr"
                           class="w-full rounded-xl border border-gray-300 bg-gray-50 focus:bg-white focus:border-brand-500 focus:ring-brand-500 py-2.5 px-4 text-sm shadow-sm">
                    @error('national_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <!-- Phone -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">رقم الجوال <span class="text-red-500">*</span></label>
                    <input type="text" name="phone" value="{{ old('phone', $beneficiary->phone) }}" required dir="ltr"
                           class="w-full rounded-xl border border-gray-300 bg-gray-50 focus:bg-white focus:border-brand-500 focus:ring-brand-500 py-2.5 px-4 text-sm shadow-sm">
                    @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <!-- Date of Birth -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">تاريخ الميلاد (هجري) <span class="text-red-500">*</span></label>
                    <div id="hijri_datepicker_container" class="w-full"></div>
                    <input type="hidden" name="dob" id="dob_input" value="{{ old('dob', $beneficiary->dob) }}">
                    @error('dob') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <!-- Age (Auto calculated) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">العمر (تحسب تلقائيا)</label>
                    <input type="text" id="age_input" readonly disabled
                           class="w-full rounded-xl bg-gray-50 dark:bg-gray-800 text-gray-500 py-2.5 px-4 text-sm shadow-sm cursor-not-allowed">
                </div>
                <!-- Marital Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">الحالة الاجتماعية <span class="text-red-500">*</span></label>
                    <select name="marital_status" required class="w-full rounded-xl border border-gray-300 bg-gray-50 focus:bg-white focus:border-brand-500 focus:ring-brand-500 py-2.5 px-4 text-sm shadow-sm">
                        <option value="" disabled>اختر الحالة...</option>
                        <option value="أعزب" @selected(old('marital_status', $beneficiary->marital_status) == 'أعزب')>أعزب</option>
                        <option value="متزوج" @selected(old('marital_status', $beneficiary->marital_status) == 'متزوج')>متزوج</option>
                        <option value="مطلق" @selected(old('marital_status', $beneficiary->marital_status) == 'مطلق')>مطلق</option>
                        <option value="أرمل" @selected(old('marital_status', $beneficiary->marital_status) == 'أرمل')>أرمل</option>
                    </select>
                    @error('marital_status') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <!-- Address and Family -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-visible p-6 md:p-8">
            <h3 class="text-lg font-heading font-bold text-brand-800 dark:text-white mb-6 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                العنوان وبيانات الأسرة
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- City -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">المدينة <span class="text-red-500">*</span></label>
                    <select name="city" required class="w-full rounded-xl border border-gray-300 bg-gray-50 focus:bg-white focus:border-brand-500 focus:ring-brand-500 py-2.5 px-4 text-sm shadow-sm">
                        <option value="" disabled>اختر المدينة...</option>
                        @php
                            $citiesList = ['الرياض', 'جدة', 'مكة المكرمة', 'المدينة المنورة', 'الدمام', 'الطائف', 'تبوك', 'بريدة', 'خميس مشيط', 'الهفوف', 'المبرز', 'حفر الباطن', 'حائل', 'نجران', 'الجبيل', 'أبها', 'ينبع', 'الخُبر', 'عرعر', 'سكاكا', 'جازان', 'القريات', 'الظهران', 'القطيف', 'الباحة'];
                        @endphp
                        @foreach($citiesList as $cityOption)
                            <option value="{{ $cityOption }}" @selected(old('city', $beneficiary->city) == $cityOption)>{{ $cityOption }}</option>
                        @endforeach
                    </select>
                    @error('city') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <!-- Neighborhood -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">الحي</label>
                    <input type="text" name="neighborhood" value="{{ old('neighborhood', $beneficiary->neighborhood) }}"
                           class="w-full rounded-xl border border-gray-300 bg-gray-50 focus:bg-white focus:border-brand-500 focus:ring-brand-500 py-2.5 px-4 text-sm shadow-sm">
                    @error('neighborhood') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <!-- Family Members -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">عدد أفراد الأسرة (شامل المستفيد) <span class="text-red-500">*</span></label>
                    <input type="number" name="family_members" value="{{ old('family_members', $beneficiary->family_members) }}" min="1" required
                           class="w-full rounded-xl border border-gray-300 bg-gray-50 focus:bg-white focus:border-brand-500 focus:ring-brand-500 py-2.5 px-4 text-sm shadow-sm">
                    @error('family_members') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <!-- Status & Notes -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-visible p-6 md:p-8">
            <h3 class="text-lg font-heading font-bold text-brand-800 dark:text-white mb-6 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                الحالة والملاحظات
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Case Type / Category -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">نوع الحالة <span class="text-red-500">*</span></label>
                    <select name="category" required class="w-full rounded-xl border border-gray-300 bg-gray-50 focus:bg-white focus:border-brand-500 focus:ring-brand-500 py-2.5 px-4 text-sm shadow-sm">
                        <option value="" disabled>اختر نوع الحالة...</option>
                        @foreach(\App\Enums\BeneficiaryCategory::cases() as $category)
                            <option value="{{ $category->value }}" @selected(old('category', $beneficiary->category?->value) == $category->value)>{{ $category->label() }}</option>
                        @endforeach
                    </select>
                    @error('category') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">حالة المستفيد <span class="text-red-500">*</span></label>
                    <select name="status" required class="w-full rounded-xl border border-gray-300 bg-gray-50 focus:bg-white focus:border-brand-500 focus:ring-brand-500 py-2.5 px-4 text-sm shadow-sm">
                        @foreach(\App\Enums\BeneficiaryStatus::cases() as $status)
                            <option value="{{ $status->value }}" @selected(old('status', $beneficiary->status->value) == $status->value)>{{ $status->label() }}</option>
                        @endforeach
                    </select>
                    @error('status') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Notes -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">ملاحظات</label>
                <textarea name="notes" rows="3" placeholder="أي معلومات إضافية تساعد في متابعة الحالة..."
                          class="w-full rounded-xl border border-gray-300 bg-gray-50 focus:bg-white focus:border-brand-500 focus:ring-brand-500 py-3 px-4 text-sm shadow-sm">{{ old('notes', $beneficiary->notes) }}</textarea>
                @error('notes') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <!-- Goals -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">الأهداف</label>
                <textarea name="goals" rows="3" placeholder="أهداف هذه الحالة والمطلوب تحقيقه..."
                          class="w-full rounded-xl border border-gray-300 bg-gray-50 focus:bg-white focus:border-brand-500 focus:ring-brand-500 py-3 px-4 text-sm shadow-sm">{{ old('goals', $beneficiary->goals) }}</textarea>
                @error('goals') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <!-- Footer Actions -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm p-6 flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex gap-3 w-full md:w-auto">
                <button type="submit" class="flex-1 md:flex-none inline-flex justify-center items-center gap-2 bg-brand-800 hover:bg-brand-700 text-white px-8 py-3 rounded-xl transition-colors shadow-lg shadow-brand-900/20 font-bold text-sm">
                    تحديث البيانات
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/></svg>
                </button>
                <a href="{{ route('beneficiaries.index') }}" class="flex-1 md:flex-none inline-flex justify-center items-center px-8 py-3 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors font-medium text-sm">
                    إلغاء
                </a>
            </div>
        </div>
    </form>

    @push('scripts')
    <script src="https://unpkg.com/@rushdi94/gregorian-hijri-datepicker/dist/gregorian-hijri.umd.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dobInput = document.getElementById('dob_input');
            const ageInput = document.getElementById('age_input');

            if (typeof GregorianHijriLib !== 'undefined') {
                const { GregorianHijriDatePicker } = GregorianHijriLib;
                
                const picker = new GregorianHijriDatePicker({
                    container: '#hijri_datepicker_container',
                    calendarSupport: 'hijri',
                    format: 'YYYY-MM-DD',
                    primaryColor: '#059669', // Brand green
                    onSelect: function(value, formatted) {
                        if (value && value.hijri) {
                            dobInput.value = formatted;
                            
                            const hijriYear = value.hijri.year;
                            const currentYear = new Date().getFullYear();
                            const currentHijriYear = Math.floor((currentYear - 622) + ((currentYear - 622) / 32));
                            
                            const age = currentHijriYear - hijriYear;
                            ageInput.value = age > 0 ? age + ' سنة' : 'أقل من سنة';
                        }
                    }
                });

                // Set old value if exists
                if (dobInput.value && dobInput.value.match(/^\d{4}-\d{2}-\d{2}$/)) {
                    const parts = dobInput.value.split('-');
                    picker.setValue({
                        year: parseInt(parts[0], 10),
                        month: parseInt(parts[1], 10),
                        day: parseInt(parts[2], 10)
                    });
                }
            }
        });
    </script>
    @endpush
</x-app-layout>

