<x-app-layout>
    <x-slot name="header">
        <h2 class="font-heading font-bold text-3xl text-gray-900 dark:text-white leading-tight">
            إعدادات الموقع (SEO)
        </h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">تخصيص الهوية البصرية ومعلومات محركات البحث.</p>
    </x-slot>

    <div class="max-w-4xl">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="p-6 border-b border-gray-100 dark:border-gray-800">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center">
                    <svg class="w-5 h-5 ml-2 text-brand-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    الإعدادات العامة
                </h3>
            </div>
            
            <form action="{{ route('super-admin.settings.seo.update') }}" method="POST" class="p-6 md:p-8">
                @csrf
                
                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-50/50 text-green-700 text-sm rounded-xl border border-green-100 flex items-center">
                        <svg class="w-5 h-5 ml-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        {{ session('success') }}
                    </div>
                @endif
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div class="md:col-span-2">
                        <label for="site_name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">اسم المنصة</label>
                        <input type="text" name="site_name" id="site_name" value="{{ old('site_name', $settings->site_name) }}" required
                            class="w-full py-3 px-4 rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-brand-500 focus:ring-brand-500 transition placeholder-gray-400 dark:placeholder-gray-500">
                        @error('site_name') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="site_description" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">وصف المنصة (Description)</label>
                        <textarea name="site_description" id="site_description" rows="3" required
                            class="w-full py-3 px-4 rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-brand-500 focus:ring-brand-500 transition placeholder-gray-400 dark:placeholder-gray-500">{{ old('site_description', $settings->site_description) }}</textarea>
                        <p class="mt-2 text-xs text-gray-500">هذا الوصف سيظهر في نتائج محركات البحث مثل جوجل.</p>
                        @error('site_description') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="site_keywords" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">الكلمات المفتاحية (Keywords)</label>
                        <input type="text" name="site_keywords" id="site_keywords" value="{{ old('site_keywords', $settings->site_keywords) }}" required
                            class="w-full py-3 px-4 rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-brand-500 focus:ring-brand-500 transition placeholder-gray-400 dark:placeholder-gray-500"
                            placeholder="مثال: خيرية, تبرعات, كفالة أيتام, مشاريع دعوية">
                        @error('site_keywords') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>
                </div>
                
                <hr class="border-gray-100 dark:border-gray-700 mb-8">
                
                <h4 class="text-base font-bold text-gray-900 dark:text-white mb-6">بيانات التواصل والروابط</h4>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div>
                        <label for="support_email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">البريد الإلكتروني للدعم</label>
                        <input type="email" name="support_email" id="support_email" value="{{ old('support_email', $settings->support_email) }}" required dir="ltr"
                            class="w-full py-3 px-4 rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-brand-500 focus:ring-brand-500 text-left transition placeholder-gray-400 dark:placeholder-gray-500">
                        @error('support_email') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label for="support_phone" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">رقم هاتف المنصة</label>
                        <input type="text" name="support_phone" id="support_phone" value="{{ old('support_phone', $settings->support_phone) }}" required dir="ltr"
                            class="w-full py-3 px-4 rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-brand-500 focus:ring-brand-500 text-left transition placeholder-gray-400 dark:placeholder-gray-500">
                        @error('support_phone') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label for="twitter_url" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">رابط تويتر (X)</label>
                        <input type="url" name="twitter_url" id="twitter_url" value="{{ old('twitter_url', $settings->twitter_url) }}" dir="ltr"
                            class="w-full py-3 px-4 rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-brand-500 focus:ring-brand-500 text-left transition placeholder-gray-400 dark:placeholder-gray-500"
                            placeholder="https://x.com/...">
                        @error('twitter_url') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label for="facebook_url" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">رابط فيسبوك</label>
                        <input type="url" name="facebook_url" id="facebook_url" value="{{ old('facebook_url', $settings->facebook_url) }}" dir="ltr"
                            class="w-full py-3 px-4 rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-brand-500 focus:ring-brand-500 text-left transition placeholder-gray-400 dark:placeholder-gray-500"
                            placeholder="https://facebook.com/...">
                        @error('facebook_url') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>
                </div>
                
                <hr class="border-gray-100 dark:border-gray-700 mb-8 mt-8">
                
                <h4 class="text-base font-bold text-gray-900 dark:text-white mb-6 flex items-center">
                    <svg class="w-5 h-5 ml-2 text-brand-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                    بيانات التحويل البنكي (للاشتراكات)
                </h4>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div>
                        <label for="bank_name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">اسم البنك</label>
                        <input type="text" name="bank_name" id="bank_name" value="{{ old('bank_name', $settings->bank_name) }}"
                            class="w-full py-3 px-4 rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-brand-500 focus:ring-brand-500 transition placeholder-gray-400 dark:placeholder-gray-500">
                        @error('bank_name') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label for="bank_account_name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">اسم الحساب (Account Name)</label>
                        <input type="text" name="bank_account_name" id="bank_account_name" value="{{ old('bank_account_name', $settings->bank_account_name) }}"
                            class="w-full py-3 px-4 rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-brand-500 focus:ring-brand-500 transition placeholder-gray-400 dark:placeholder-gray-500">
                        @error('bank_account_name') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="bank_iban" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">رقم الآيبان (IBAN)</label>
                        <input type="text" name="bank_iban" id="bank_iban" value="{{ old('bank_iban', $settings->bank_iban) }}" dir="ltr"
                            class="w-full py-3 px-4 rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-brand-500 focus:ring-brand-500 text-left transition placeholder-gray-400 dark:placeholder-gray-500"
                            placeholder="SA00 0000 0000 0000 0000 0000">
                        @error('bank_iban') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-8">
                    <button type="submit" class="px-8 py-3 bg-brand-600 text-white rounded-xl hover:bg-brand-700 transition font-medium shadow-lg shadow-brand-500/30 flex items-center">
                        <svg class="w-5 h-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        حفظ الإعدادات
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
