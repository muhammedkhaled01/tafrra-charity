<x-app-layout>
    <x-slot name="header">
        <h2 class="font-heading font-bold text-3xl text-gray-900 dark:text-white leading-tight">
            إضافة مستفيد جديد
        </h2>
    </x-slot>

    <div class="glass-card rounded-2xl p-6 mb-8 max-w-4xl mx-auto">
        <form action="{{ route('beneficiaries.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">الاسم الرباعي</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                        class="mt-2 block w-full rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm py-2.5 px-4">
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- National ID -->
                <div>
                    <label for="national_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">الهوية الوطنية</label>
                    <input type="text" name="national_id" id="national_id" value="{{ old('national_id') }}" required
                        class="mt-2 block w-full rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm py-2.5 px-4" dir="ltr">
                    @error('national_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Phone -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">رقم الهاتف</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone') }}" required
                        class="mt-2 block w-full rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm py-2.5 px-4" dir="ltr">
                    @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- City -->
                <div>
                    <label for="city" class="block text-sm font-medium text-gray-700 dark:text-gray-300">المدينة</label>
                    <select name="city" id="city" required class="mt-2 block w-full rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm py-2.5 px-4">
                        <option value="">اختر المدينة</option>
                        @foreach(config('cities') as $city)
                            <option value="{{ $city }}" {{ old('city') == $city ? 'selected' : '' }}>{{ $city }}</option>
                        @endforeach
                    </select>
                    @error('city') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Gender -->
                <div>
                    <label for="gender" class="block text-sm font-medium text-gray-700 dark:text-gray-300">الجنس</label>
                    <select name="gender" id="gender" required class="mt-2 block w-full rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm py-2.5 px-4">
                        <option value="">اختر الجنس</option>
                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>ذكر</option>
                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>أنثى</option>
                    </select>
                    @error('gender') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Category -->
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-300">الفئة</label>
                    <select name="category" id="category" required class="mt-2 block w-full rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm py-2.5 px-4">
                        <option value="">اختر الفئة</option>
                        @foreach(\App\Enums\BeneficiaryCategory::cases() as $cat)
                            <option value="{{ $cat->value }}" {{ old('category') == $cat->value ? 'selected' : '' }}>{{ $cat->label() }}</option>
                        @endforeach
                    </select>
                    @error('category') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Family Members -->
                <div>
                    <label for="family_members" class="block text-sm font-medium text-gray-700 dark:text-gray-300">أفراد الأسرة</label>
                    <input type="number" name="family_members" id="family_members" value="{{ old('family_members', 1) }}" min="1" required
                        class="mt-2 block w-full rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm py-2.5 px-4">
                    @error('family_members') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Monthly Income -->
                <div>
                    <label for="monthly_income" class="block text-sm font-medium text-gray-700 dark:text-gray-300">الدخل الشهري (ريال)</label>
                    <input type="number" step="0.01" name="monthly_income" id="monthly_income" value="{{ old('monthly_income', 0) }}" min="0" required
                        class="mt-2 block w-full rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm py-2.5 px-4">
                    @error('monthly_income') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                
                <!-- DOB -->
                <div>
                    <label for="dob" class="block text-sm font-medium text-gray-700 dark:text-gray-300">تاريخ الميلاد</label>
                    <input type="date" name="dob" id="dob" value="{{ old('dob') }}" required
                        class="mt-2 block w-full rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm py-2.5 px-4" dir="ltr">
                    @error('dob') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-gray-100 dark:border-gray-800">
                <a href="{{ route('beneficiaries.index') }}" class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors font-medium text-sm">إلغاء</a>
                <button type="submit" class="px-4 py-2 bg-brand-600 hover:bg-brand-500 text-white rounded-xl shadow-lg shadow-brand-500/30 transition-all font-medium text-sm">حفظ المستفيد</button>
            </div>
        </form>
    </div>

    @push('styles')
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
    <style>
        .ts-control { border-radius: 0.75rem !important; border-color: #d1d5db !important; padding: 0.625rem 1rem !important; box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05) !important; font-family: 'Inter', 'Cairo', sans-serif; }
        .dark .ts-control { background-color: #1f2937 !important; border-color: #374151 !important; color: white !important; }
        .dark .ts-dropdown { background-color: #1f2937 !important; border-color: #374151 !important; color: white !important; }
        .dark .ts-dropdown .option { color: white !important; }
        .dark .ts-dropdown .option:hover, .dark .ts-dropdown .option.active { background-color: #374151 !important; color: white !important; }
        .ts-wrapper.single .ts-control:after { right: auto; left: 15px; } /* RTL Fix for dropdown arrow */
        .ts-control > input { display: inline-block !important; } /* Fix input display */
    </style>
    @endpush

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            new TomSelect("#city", {
                create: false,
                placeholder: 'ابحث عن المدينة...',
            });
        });
    </script>
    @endpush
</x-app-layout>
