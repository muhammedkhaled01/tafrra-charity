<x-app-layout>
    <x-slot name="header">
        <h2 class="font-heading font-bold text-3xl text-gray-900 dark:text-white leading-tight">
            إضافة مستخدم جديد
        </h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">إنشاء حساب جديد لمستخدم في المنصة أو الجمعيات الخيرية.</p>
    </x-slot>

    <div class="max-w-4xl">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
            <form action="{{ route('super-admin.users.store') }}" method="POST" class="p-6 md:p-8">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">الاسم الكامل</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                            class="w-full py-3 px-4 rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-brand-500 focus:ring-brand-500 transition placeholder-gray-400">
                        @error('name') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">البريد الإلكتروني</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required dir="ltr"
                            class="w-full py-3 px-4 rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-brand-500 focus:ring-brand-500 text-left transition placeholder-gray-400">
                        @error('email') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">كلمة المرور</label>
                        <input type="password" name="password" id="password" required dir="ltr"
                            class="w-full py-3 px-4 rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-brand-500 focus:ring-brand-500 text-left transition placeholder-gray-400">
                        @error('password') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="tenant_id" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">الجمعية التابع لها</label>
                        <select name="tenant_id" id="tenant_id" class="w-full py-3 px-4 rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-brand-500 focus:ring-brand-500 transition">
                            <option value="">-- مستخدم في المنصة (لا يتبع جمعية) --</option>
                            @foreach($tenants as $tenant)
                                <option value="{{ $tenant->id }}" @selected(old('tenant_id') == $tenant->id)>{{ $tenant->name }}</option>
                            @endforeach
                        </select>
                        <p class="mt-1 text-xs text-gray-500">اختر الجمعية إذا كان المستخدم موظفاً فيها.</p>
                        @error('tenant_id') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>
                </div>
                
                <hr class="border-gray-100 dark:border-gray-700 mb-8">
                
                <h4 class="text-base font-bold text-gray-900 dark:text-white mb-6">الصلاحيات (Roles)</h4>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                    @foreach($roles as $role)
                        <label class="flex items-start p-3 border border-gray-200 dark:border-gray-700 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-800 cursor-pointer transition">
                            <div class="flex items-center h-5">
                                <input type="checkbox" name="roles[]" value="{{ $role->name }}" 
                                    class="w-4 h-4 text-brand-600 border-gray-300 rounded focus:ring-brand-500 dark:focus:ring-brand-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                    @checked(is_array(old('roles')) && in_array($role->name, old('roles')))>
                            </div>
                            <div class="mr-3 text-sm">
                                <span class="font-medium text-gray-900 dark:text-gray-300">{{ $role->label ?? $role->name }}</span>
                                <p class="text-xs text-gray-500 mt-0.5">نطاق: {{ $role->scope == 'platform' ? 'المنصة' : 'الجمعيات' }}</p>
                            </div>
                        </label>
                    @endforeach
                </div>

                <div class="flex justify-end gap-3 mt-8 pt-6 border-t border-gray-100 dark:border-gray-700">
                    <a href="{{ route('super-admin.users.index') }}" class="px-6 py-3 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-600 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700 transition font-medium">
                        إلغاء
                    </a>
                    <button type="submit" class="px-8 py-3 bg-brand-600 text-white rounded-xl hover:bg-brand-700 transition font-medium shadow-lg shadow-brand-500/30 flex items-center">
                        <svg class="w-5 h-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        حفظ وإنشاء
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
