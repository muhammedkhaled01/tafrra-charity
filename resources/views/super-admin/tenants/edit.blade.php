<x-app-layout>
    <x-slot name="header">
        <h2 class="font-heading font-bold text-3xl text-gray-900 dark:text-white leading-tight">
            تعديل الجمعية
        </h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">تعديل بيانات وإعدادات الجمعية: {{ $tenant->name }}</p>
    </x-slot>

    <div class="glass-card rounded-2xl p-6 md:p-8 max-w-4xl">
        <form action="{{ route('super-admin.tenants.update', $tenant) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-8">
                <h3 class="text-lg font-heading font-semibold text-gray-900 dark:text-white mb-6">بيانات الجمعية</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">اسم الجمعية</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $tenant->name) }}" required
                            class="mt-2 block w-full rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm transition-colors py-2.5 px-4">
                        @error('name') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="domain" class="block text-sm font-medium text-gray-700 dark:text-gray-300">النطاق الفرعي (يُكتب بالإنجليزية)</label>
                        <div class="mt-2 flex rounded-xl shadow-sm" dir="ltr">
                            <input type="text" name="domain" id="domain" value="{{ old('domain', explode('.', $tenant->domain)[0] ?? '') }}" required
                                class="block w-full flex-1 rounded-l-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-brand-500 focus:ring-brand-500 sm:text-sm py-2.5 px-4">
                            <span class="inline-flex items-center rounded-r-xl border border-l-0 border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 px-3 text-gray-500 dark:text-gray-400 sm:text-sm">
                                .{{ str_replace('www.', '', parse_url(config('app.url', 'http://tafrra.com'), PHP_URL_HOST)) }}
                            </span>
                        </div>
                        @error('domain') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700 dark:text-gray-300">المدينة</label>
                        <input type="text" name="city" id="city" value="{{ old('city', $tenant->city) }}" required
                            class="mt-2 block w-full rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm transition-colors py-2.5 px-4">
                        @error('city') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">رقم الهاتف</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone', $tenant->phone) }}" dir="ltr"
                            class="mt-2 block w-full rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm transition-colors py-2.5 px-4">
                    </div>
                    <div class="md:col-span-2">
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">البريد الإلكتروني للجمعية</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $tenant->email) }}" dir="ltr"
                            class="mt-2 block w-full rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm transition-colors py-2.5 px-4">
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-8">
                <a href="{{ route('super-admin.tenants.index') }}" class="px-6 py-2.5 text-gray-700 dark:text-gray-300 font-medium hover:bg-gray-100 dark:hover:bg-gray-800 rounded-xl transition-colors">
                    إلغاء
                </a>
                <button type="submit" class="px-6 py-2.5 bg-gradient-brand text-white font-medium rounded-xl shadow-lg shadow-brand-500/30 hover:shadow-brand-500/50 hover:-translate-y-0.5 transition-all">
                    تحديث الجمعية
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
