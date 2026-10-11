<x-app-layout>
    <x-slot name="header">
        <h2 class="font-heading font-bold text-3xl text-gray-900 dark:text-white leading-tight">
            تعديل باقة الاشتراك
        </h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">تحديث تفاصيل الباقة: {{ $subscription->name }}</p>
    </x-slot>

    <div class="max-w-4xl">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
            <form action="{{ route('super-admin.subscriptions.update', $subscription) }}" method="POST" class="p-6 md:p-8">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div class="md:col-span-2">
                        <label for="name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">اسم الباقة</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $subscription->name) }}" required
                            class="w-full py-3 px-4 rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-brand-500 focus:ring-brand-500 transition placeholder-gray-400">
                        @error('name') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="price" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">سعر الاشتراك (شهرياً)</label>
                        <div class="relative">
                            <input type="number" step="0.01" min="0" name="price" id="price" value="{{ old('price', $subscription->price) }}" required dir="ltr"
                                class="w-full py-3 px-4 rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-brand-500 focus:ring-brand-500 text-left transition placeholder-gray-400">
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                <span class="text-gray-500 dark:text-gray-400 font-medium text-sm">ريال سعودي</span>
                            </div>
                        </div>
                        @error('price') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="max_beneficiaries" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">الحد الأقصى للمستفيدين</label>
                        <input type="number" min="-1" name="max_beneficiaries" id="max_beneficiaries" value="{{ old('max_beneficiaries', $subscription->max_beneficiaries) }}" required dir="ltr"
                            class="w-full py-3 px-4 rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-brand-500 focus:ring-brand-500 text-left transition placeholder-gray-400">
                        <p class="mt-1 text-xs text-gray-500">اكتب <span class="font-bold text-gray-700">-1</span> لعدد لا محدود.</p>
                        @error('max_beneficiaries') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-4">مميزات الباقة (الخصائص المتاحة للجمعيات المشتركة)</label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach(\App\Enums\SubscriptionFeature::cases() as $feature)
                                <label class="flex items-start p-3 border border-gray-200 dark:border-gray-700 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-800 cursor-pointer transition">
                                    <div class="flex items-center h-5">
                                        <input type="checkbox" name="features[]" value="{{ $feature->value }}" 
                                            class="w-4 h-4 text-brand-600 border-gray-300 rounded focus:ring-brand-500 dark:focus:ring-brand-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                            @checked(is_array(old('features')) ? in_array($feature->value, old('features')) : (is_array($subscription->features) && isset($subscription->features[$feature->value]) && $subscription->features[$feature->value] === true))>
                                    </div>
                                    <div class="mr-3 text-sm">
                                        <span class="font-medium text-gray-900 dark:text-gray-300">{{ $feature->label() }}</span>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                        @error('features') <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-8 pt-6 border-t border-gray-100 dark:border-gray-700">
                    <a href="{{ route('super-admin.subscriptions.index') }}" class="px-6 py-3 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-600 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700 transition font-medium">
                        إلغاء
                    </a>
                    <button type="submit" class="px-8 py-3 bg-brand-600 text-white rounded-xl hover:bg-brand-700 transition font-medium shadow-lg shadow-brand-500/30 flex items-center">
                        <svg class="w-5 h-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        حفظ التعديلات
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
