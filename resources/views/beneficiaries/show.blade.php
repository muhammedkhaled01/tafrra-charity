<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-heading font-bold text-3xl text-gray-900 dark:text-white leading-tight">
                تفاصيل المستفيد
            </h2>
            <div class="flex gap-3">
                <a href="{{ route('beneficiaries.edit', $beneficiary) }}" class="inline-flex items-center justify-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-xl font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-50 dark:hover:bg-gray-700 transition-all">
                    تعديل البيانات
                </a>
            </div>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Profile Summary Card -->
        <div class="md:col-span-1">
            <div class="glass-card rounded-2xl p-6 text-center">
                <div class="w-24 h-24 mx-auto bg-gradient-brand rounded-full flex items-center justify-center text-3xl font-bold mb-4 shadow-lg shadow-brand-500/30">
                    {{ mb_substr($beneficiary->name, 0, 1) }}
                </div>
                <h3 class="text-xl font-heading font-bold text-gray-900 dark:text-white mb-1">{{ $beneficiary->name }}</h3>
                <p class="text-gray-500 dark:text-gray-400 mb-4">{{ $beneficiary->city ?? 'مدينة غير محددة' }}</p>
                
                <div class="inline-block px-3 py-1 rounded-full text-sm font-medium
                    @if($beneficiary->status->value === 'active') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400
                    @elseif($beneficiary->status->value === 'under_review') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400
                    @else bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400 @endif
                ">
                    @if($beneficiary->status->value === 'active') نشط
                    @elseif($beneficiary->status->value === 'under_review') قيد الدراسة
                    @else موقوف @endif
                </div>
            </div>
        </div>

        <!-- Details Card -->
        <div class="md:col-span-2">
            <div class="glass-card rounded-2xl p-6 h-full">
                <h3 class="text-lg font-heading font-semibold text-gray-900 dark:text-white mb-6 border-b border-gray-100 dark:border-gray-800 pb-3">المعلومات الشخصية</h3>
                
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-6">
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">الهوية الوطنية</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white" dir="ltr">{{ $beneficiary->national_id }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">رقم الهاتف</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white" dir="ltr">{{ $beneficiary->phone }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">الجنس</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                            {{ $beneficiary->gender?->value === 'male' ? 'ذكر' : ($beneficiary->gender?->value === 'female' ? 'أنثى' : 'غير محدد') }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">الفئة</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                            {{ $beneficiary->category?->label() ?? 'غير محدد' }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">تاريخ الميلاد (العمر)</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                            {{ $beneficiary->dob ? $beneficiary->dob->format('Y-m-d') . ' (' . $beneficiary->age . ' سنة)' : 'غير محدد' }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">أفراد الأسرة</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $beneficiary->family_members }} فرد</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">الدخل الشهري</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ number_format($beneficiary->monthly_income, 2) }} ريال</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">تاريخ التسجيل</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white" dir="ltr">{{ $beneficiary->created_at->format('Y-m-d H:i') }}</dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
</x-app-layout>
