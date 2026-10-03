<x-app-layout>
    <x-slot name="header">
        <h2 class="font-heading font-bold text-3xl text-gray-900 dark:text-white leading-tight">
            إضافة جمعية جديدة
        </h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">تسجيل جمعية خيرية جديدة في المنصة وإعداد حساب المشرف الخاص بها</p>
    </x-slot>

    <div class="glass-card rounded-2xl p-6 md:p-8 max-w-4xl">
        <form action="{{ route('super-admin.tenants.store') }}" method="POST">
            @csrf

            <!-- Tenant Details -->
            <div class="mb-8 border-b border-gray-100 dark:border-gray-800 pb-8">
                <h3 class="text-lg font-heading font-semibold text-gray-900 dark:text-white mb-6">بيانات الجمعية</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">اسم الجمعية</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                            class="mt-2 block w-full rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm transition-colors py-2.5 px-4">
                        @error('name') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700 dark:text-gray-300">المدينة</label>
                        <select name="city" id="city" required class="mt-2 block w-full rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm transition-colors py-2.5 px-4">
                            <option value="">اختر المدينة...</option>
                            @php
                                $saudiCities = ['الرياض', 'جدة', 'مكة المكرمة', 'المدينة المنورة', 'الدمام', 'الطائف', 'بريدة', 'تبوك', 'أبها', 'خميس مشيط', 'حائل', 'حفر الباطن', 'الجبيل', 'الخرج', 'جازان', 'نجران', 'ينبع', 'القنفذة', 'عرعر', 'سكاكا', 'القطيف', 'الظهران', 'الخبر', 'الباحة', 'بيشة', 'الزلفي', 'محايل عسير', 'العلا', 'ضباء', 'طريف', 'القريات'];
                                sort($saudiCities);
                            @endphp
                            @foreach($saudiCities as $c)
                                <option value="{{ $c }}" {{ old('city') === $c ? 'selected' : '' }}>{{ $c }}</option>
                            @endforeach
                        </select>
                        @error('city') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">رقم الهاتف</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone') }}" dir="ltr"
                            class="mt-2 block w-full rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm transition-colors py-2.5 px-4">
                    </div>
                    <div class="md:col-span-2">
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">البريد الإلكتروني للجمعية</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" dir="ltr"
                            class="mt-2 block w-full rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm transition-colors py-2.5 px-4">
                    </div>
                </div>
            </div>

            <!-- Subscription Details -->
            <div class="mb-8 border-b border-gray-100 dark:border-gray-800 pb-8">
                <h3 class="text-lg font-heading font-semibold text-gray-900 dark:text-white mb-6">تفاصيل الاشتراك المنفذ</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="subscription_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">الباقة</label>
                        <select name="subscription_id" id="subscription_id" required class="mt-2 block w-full rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm transition-colors py-2.5 px-4">
                            <option value="">اختر الباقة...</option>
                            @foreach($subscriptions as $sub)
                                <option value="{{ $sub->id }}" {{ old('subscription_id') == $sub->id ? 'selected' : '' }}>{{ $sub->name }} ({{ $sub->price }} ريال)</option>
                            @endforeach
                        </select>
                        @error('subscription_id') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="expires_in_months" class="block text-sm font-medium text-gray-700 dark:text-gray-300">مدة الاشتراك المبدئية (بالأشهر)</label>
                        <input type="number" name="expires_in_months" id="expires_in_months" value="{{ old('expires_in_months', 12) }}" min="1" required
                            class="mt-2 block w-full rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm transition-colors py-2.5 px-4">
                        @error('expires_in_months') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- Admin Account -->
            <div class="mb-8">
                <h3 class="text-lg font-heading font-semibold text-gray-900 dark:text-white mb-6">حساب المشرف الأول (Admin)</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="admin_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">اسم المشرف</label>
                        <input type="text" name="admin_name" id="admin_name" value="{{ old('admin_name') }}" required
                            class="mt-2 block w-full rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm transition-colors py-2.5 px-4">
                    </div>
                    <div>
                        <label for="admin_email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">البريد الإلكتروني للمشرف</label>
                        <input type="email" name="admin_email" id="admin_email" value="{{ old('admin_email') }}" required dir="ltr"
                            class="mt-2 block w-full rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm transition-colors py-2.5 px-4">
                    </div>
                    <div class="md:col-span-2">
                        <label for="admin_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">كلمة المرور</label>
                        <input type="password" name="admin_password" id="admin_password" required dir="ltr"
                            class="mt-2 block w-full rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm transition-colors py-2.5 px-4">
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-8">
                <a href="{{ route('super-admin.tenants.index') }}" class="px-6 py-2.5 text-gray-700 dark:text-gray-300 font-medium hover:bg-gray-100 dark:hover:bg-gray-800 rounded-xl transition-colors">
                    إلغاء
                </a>
                <button type="submit" class="px-6 py-2.5 bg-gradient-brand text-white font-medium rounded-xl shadow-lg shadow-brand-500/30 hover:shadow-brand-500/50 hover:-translate-y-0.5 transition-all">
                    حفظ وإنشاء الجمعية
                </button>
            </div>
        </form>
    </div>
    </div>

    @push('styles')
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
    <style>
        .ts-control { border-radius: 0.75rem !important; border-color: #d1d5db !important; padding: 0.625rem 1rem !important; box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05) !important; font-family: 'Inter', 'Cairo', sans-serif; }
        .dark .ts-control { background-color: #1f2937 !important; border-color: #374151 !important; color: white !important; }
        .dark .ts-dropdown { background-color: #1f2937 !important; border-color: #374151 !important; color: white !important; }
        .dark .ts-dropdown .option { color: white !important; }
        .dark .ts-dropdown .option:hover, .dark .ts-dropdown .option.active { background-color: #374151 !important; color: white !important; }
    </style>
    @endpush

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            new TomSelect("#city", {
                create: false,
                sortField: {
                    field: "text",
                    direction: "asc"
                },
                placeholder: 'ابحث عن المدينة...',
            });
        });
    </script>
    @endpush
</x-app-layout>
