<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('sponsorships.index') }}" class="p-2 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 text-gray-500 hover:text-brand-600 transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
            </a>
            <div>
                <h2 class="font-heading font-bold text-3xl text-brand-900 dark:text-white">
                    إضافة كفالة جديدة
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">ربط كافل بمستفيد وإدخال بيانات الكفالة.</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <form action="{{ route('sponsorships.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 md:p-8">
                <h3 class="text-lg font-heading font-bold text-gray-900 dark:text-white mb-6 border-b border-gray-100 dark:border-gray-700 pb-3">تفاصيل الكفالة</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">الكافل / الداعم <span class="text-red-500">*</span></label>
                        <select name="donor_id" required class="w-full rounded-xl border border-gray-300 shadow-sm dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-brand-500 focus:ring-brand-500 py-2.5 px-3">
                            <option value="">اختر الكافل</option>
                            @foreach($donors as $donor)
                                <option value="{{ $donor->id }}" {{ old('donor_id') == $donor->id ? 'selected' : '' }}>{{ $donor->name }}</option>
                            @endforeach
                        </select>
                        @error('donor_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">المستفيد <span class="text-red-500">*</span></label>
                        <select name="beneficiary_id" required class="w-full rounded-xl border border-gray-300 shadow-sm dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-brand-500 focus:ring-brand-500 py-2.5 px-3">
                            <option value="">اختر المستفيد</option>
                            @foreach($beneficiaries as $beneficiary)
                                <option value="{{ $beneficiary->id }}" {{ old('beneficiary_id') == $beneficiary->id ? 'selected' : '' }}>{{ $beneficiary->name }}</option>
                            @endforeach
                        </select>
                        @error('beneficiary_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">مبلغ الكفالة <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <input type="number" step="0.01" name="amount" value="{{ old('amount') }}" required class="w-full rounded-xl border border-gray-300 shadow-sm dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-brand-500 focus:ring-brand-500 py-2.5 px-3 pr-12 text-left" dir="ltr">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">ر.س</span>
                            </div>
                        </div>
                        @error('amount')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">تاريخ البدء <span class="text-red-500">*</span></label>
                        <input type="date" name="start_date" value="{{ old('start_date', date('Y-m-d')) }}" required class="w-full rounded-xl border border-gray-300 shadow-sm dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-brand-500 focus:ring-brand-500 py-2.5 px-3">
                        @error('start_date')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">تاريخ الانتهاء (اختياري)</label>
                        <input type="date" name="end_date" value="{{ old('end_date') }}" class="w-full rounded-xl border border-gray-300 shadow-sm dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-brand-500 focus:ring-brand-500 py-2.5 px-3">
                        @error('end_date')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">حالة الكفالة <span class="text-red-500">*</span></label>
                        <select name="status" required class="w-full rounded-xl border border-gray-300 shadow-sm dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-brand-500 focus:ring-brand-500 py-2.5 px-3">
                            <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>نشطة</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>غير نشطة</option>
                            <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>مكتملة</option>
                            <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>ملغاة</option>
                        </select>
                        @error('status')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">ملاحظات إضافية</label>
                    <textarea name="notes" rows="3" class="w-full rounded-xl border border-gray-300 shadow-sm dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-brand-500 focus:ring-brand-500 py-2.5 px-3">{{ old('notes') }}</textarea>
                    @error('notes')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="flex items-center justify-end gap-4">
                <a href="{{ route('sponsorships.index') }}" class="px-6 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors shadow-sm">
                    إلغاء
                </a>
                <button type="submit" class="px-6 py-2.5 text-sm font-medium text-white bg-brand-600 rounded-xl hover:bg-brand-700 transition-colors shadow-lg shadow-brand-500/30">
                    حفظ البيانات
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
