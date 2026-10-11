<x-app-layout>
    <x-slot name="header">
        <h2 class="font-heading font-bold text-3xl text-gray-900 dark:text-white leading-tight">
            تعديل الدور: {{ $role->label ?? $role->name }}
        </h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">تحديث بيانات وصلاحيات الدور</p>
    </x-slot>

    <div class="max-w-3xl mx-auto mb-6 flex justify-end items-center">
        <a href="{{ route('super-admin.roles.index') }}" class="px-4 py-2 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition flex items-center shadow-sm">
            العودة للقائمة
        </a>
    </div>

    <div class="max-w-3xl mx-auto">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="p-6 border-b border-gray-100 dark:border-gray-800">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">تحديث بيانات الدور</h3>
            </div>
            
            <form action="{{ route('super-admin.roles.update', $role) }}" method="POST" class="p-6">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label for="label" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">اسم الدور (بالعربية)</label>
                        <input type="text" name="label" id="label" value="{{ old('label', $role->label) }}" required 
                            class="mt-1 w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-brand-500 focus:ring-brand-500 py-2.5 px-4 transition-colors"
                            placeholder="مثال: مسؤول مالي">
                        @error('label')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">الاسم البرمجي (باللغة الإنجليزية)</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $role->name) }}" required dir="ltr"
                            @if(in_array($role->name, \App\Enums\RoleName::values())) readonly @endif
                            class="mt-1 w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-brand-500 focus:ring-brand-500 text-left py-2.5 px-4 transition-colors @if(in_array($role->name, \App\Enums\RoleName::values())) bg-gray-100 dark:bg-gray-900 @endif"
                            placeholder="e.g., finance_admin">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                        @if(in_array($role->name, \App\Enums\RoleName::values()))
                            <p class="mt-1 text-xs text-amber-500">لا يمكن تعديل الاسم البرمجي للأدوار الأساسية في النظام.</p>
                        @else
                            <p class="mt-1 text-xs text-gray-500">يجب أن يكون باللغة الإنجليزية وبدون مسافات (استخدم الشرطة السفلية).</p>
                        @endif
                    </div>

                    <div>
                        <label for="scope" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">نطاق عمل الدور</label>
                        <select name="scope" id="scope" required 
                            @if(in_array($role->name, \App\Enums\RoleName::values())) disabled @endif
                            class="mt-1 w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-brand-500 focus:ring-brand-500 py-2.5 px-4 transition-colors @if(in_array($role->name, \App\Enums\RoleName::values())) bg-gray-100 dark:bg-gray-900 @endif">
                            <option value="platform" @selected(old('scope', $role->scope) == 'platform')>إدارة المنصة (Super Admin System)</option>
                            <option value="charity" @selected(old('scope', $role->scope) == 'charity')>الجمعيات الخيرية (Tenants System)</option>
                        </select>
                        @if(in_array($role->name, \App\Enums\RoleName::values()))
                            <input type="hidden" name="scope" value="{{ $role->scope }}">
                        @endif
                        @error('scope')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="pt-6 border-t border-gray-100 dark:border-gray-700">
                        <label class="block text-sm font-semibold text-gray-900 dark:text-white mb-4">صلاحيات الدور (Permissions)</label>
                        @if(isset($permissions) && $permissions->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($permissions as $permission)
                                    <label class="flex items-start p-3 border border-gray-200 dark:border-gray-700 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-800 cursor-pointer transition">
                                        <div class="flex items-center h-5">
                                            <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" 
                                                class="w-4 h-4 text-brand-600 border-gray-300 rounded focus:ring-brand-500 dark:focus:ring-brand-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                                @checked(is_array(old('permissions')) ? in_array($permission->name, old('permissions')) : in_array($permission->name, $rolePermissions))>
                                        </div>
                                        <div class="mr-3 text-sm">
                                            <span class="font-medium text-gray-900 dark:text-gray-300">{{ __('permissions.' . $permission->name) !== 'permissions.' . $permission->name ? __('permissions.' . $permission->name) : $permission->name }}</span>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        @else
                            <div class="p-4 bg-yellow-50 text-yellow-700 rounded-xl text-sm">
                                لم يتم إضافة أي صلاحيات في النظام بعد.
                            </div>
                        @endif
                    </div>
                </div>

                <div class="mt-8 flex justify-end gap-3 border-t border-gray-100 dark:border-gray-700 pt-6">
                    <a href="{{ route('super-admin.roles.index') }}" class="px-5 py-2.5 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition font-medium">
                        إلغاء
                    </a>
                    <button type="submit" class="px-5 py-2.5 bg-brand-600 text-white rounded-lg hover:bg-brand-700 transition font-medium shadow-lg shadow-brand-500/30">
                        حفظ التعديلات
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
