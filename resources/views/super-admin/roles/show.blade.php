<x-app-layout>
    <x-slot name="header">
        <h2 class="font-heading font-bold text-2xl text-gray-900 dark:text-white leading-tight flex items-center gap-2">
            <span class="text-brand-600 dark:text-brand-400">إدارة الصلاحية:</span>
            {{ $role->label ?? $role->name }}
        </h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">تخصيص وإسناد دور ({{ $role->label ?? $role->name }}) للمستخدمين بكل سهولة</p>
    </x-slot>

    <div class="max-w-6xl mx-auto mb-6 flex justify-end items-center">
        <a href="{{ route('super-admin.roles.index') }}" class="px-4 py-2 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-700 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700 transition flex items-center shadow-sm">
            <svg class="w-4 h-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            العودة للقائمة
        </a>
    </div>

    <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Form to add user -->
        <div class="lg:col-span-1">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden sticky top-8">
                <div class="p-6 border-b border-gray-100 dark:border-gray-800">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">إنشاء مستخدم وإسناد الدور له</h3>
                </div>
                <form action="{{ route('super-admin.roles.users.store', $role) }}" method="POST" class="p-6">
                    @csrf
                    
                    @if(session('success'))
                        <div class="mb-4 p-3 bg-green-50 text-green-700 text-sm rounded-lg">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="mb-4 p-3 bg-red-50 text-red-700 text-sm rounded-lg">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="mb-5">
                        <label for="name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">اسم المستخدم</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                            class="w-full py-3.5 px-4 rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-brand-500 focus:ring-brand-500 transition placeholder-gray-400 dark:placeholder-gray-500 text-base"
                            placeholder="الاسم الكامل">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label for="email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">البريد الإلكتروني</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </div>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" required dir="ltr"
                                class="w-full py-3.5 pl-4 pr-12 rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-brand-500 focus:ring-brand-500 text-left transition placeholder-gray-400 dark:placeholder-gray-500 text-base"
                                placeholder="user@example.com">
                        </div>
                        @error('email')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label for="password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">كلمة المرور</label>
                        <input type="password" name="password" id="password" required dir="ltr"
                            class="w-full py-3.5 px-4 rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-brand-500 focus:ring-brand-500 text-left transition placeholder-gray-400 dark:placeholder-gray-500 text-base"
                            placeholder="********">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    @if($role->scope === 'charity')
                    <div class="mb-5">
                        <label for="tenant_id" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">الجمعية التابع لها</label>
                        <select name="tenant_id" id="tenant_id" required class="w-full py-3.5 px-4 rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-brand-500 focus:ring-brand-500 transition text-base">
                            <option value="">اختر الجمعية...</option>
                            @foreach($tenants as $tenant)
                                <option value="{{ $tenant->id }}" @selected(old('tenant_id') == $tenant->id)>{{ $tenant->name }}</option>
                            @endforeach
                        </select>
                        @error('tenant_id')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    @endif
                    
                    <p class="mt-2 mb-4 text-xs text-gray-500">
                        سيتم منح هذا المستخدم صلاحيات <strong>{{ $role->label ?? $role->name }}</strong> فور إنشائه.
                    </p>

                    <button type="submit" class="w-full py-3 bg-brand-600 text-white rounded-xl hover:bg-brand-700 transition font-medium shadow-lg shadow-brand-500/30 flex justify-center items-center">
                        <svg class="w-5 h-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        إنشاء المستخدم
                    </button>
                </form>
            </div>
        </div>

        <!-- Users List -->
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="p-6 border-b border-gray-100 dark:border-gray-800 flex justify-between items-center bg-gray-50/30 dark:bg-gray-800/30">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">المستخدمون الحاليون ({{ $role->users->count() }})</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-right">
                        <thead class="bg-gray-50 dark:bg-gray-900/50 border-b border-gray-100 dark:border-gray-800">
                            <tr>
                                <th class="px-6 py-4 text-xs font-semibold text-gray-500 dark:text-gray-400">الاسم</th>
                                <th class="px-6 py-4 text-xs font-semibold text-gray-500 dark:text-gray-400">البريد الإلكتروني</th>
                                <th class="px-6 py-4 text-xs font-semibold text-gray-500 dark:text-gray-400">الارتباط</th>
                                <th class="px-6 py-4 text-xs font-semibold text-gray-500 dark:text-gray-400">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                            @forelse($role->users as $user)
                                <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center font-bold text-gray-600 dark:text-gray-300 text-xs">
                                                {{ mb_substr($user->name, 0, 1) }}
                                            </div>
                                            <span class="text-sm font-bold text-gray-900 dark:text-white">{{ $user->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500" dir="ltr">{{ $user->email }}</td>
                                    <td class="px-6 py-4">
                                        @if($user->tenant_id)
                                            <span class="text-xs text-amber-600 bg-amber-50 px-2 py-1 rounded">جمعية: {{ $user->tenant->name ?? 'غير معروف' }}</span>
                                        @else
                                            <span class="text-xs text-blue-600 bg-blue-50 px-2 py-1 rounded">إدارة المنصة</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <form action="{{ route('super-admin.roles.users.destroy', [$role, $user]) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من سحب هذا الدور من المستخدم؟');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700 transition text-sm font-medium">
                                                إزالة الدور
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-gray-500">لا يوجد مستخدمين مسند إليهم هذا الدور.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
