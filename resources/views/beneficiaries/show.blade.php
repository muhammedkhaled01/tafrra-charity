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
        <!-- Right Column: Profile Summary & Notes -->
        <div class="md:col-span-1 space-y-6">
            <!-- Profile Summary Card -->
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

            @if($beneficiary->notes || $beneficiary->goals)
            <!-- Notes & Goals Card -->
            <div class="glass-card rounded-2xl p-6">
                <h3 class="text-lg font-heading font-semibold text-gray-900 dark:text-white mb-4 border-b border-gray-100 dark:border-gray-800 pb-3">ملاحظات وأهداف</h3>
                <div class="space-y-6">
                    @if($beneficiary->notes)
                    <div>
                        <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">الملاحظات</h4>
                        <p class="text-sm text-gray-900 dark:text-gray-300 bg-gray-50 dark:bg-gray-800/50 p-4 rounded-xl leading-relaxed">{{ $beneficiary->notes }}</p>
                    </div>
                    @endif
                    
                    @if($beneficiary->goals)
                    <div>
                        <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">الأهداف من الكفالة</h4>
                        <p class="text-sm text-gray-900 dark:text-gray-300 bg-gray-50 dark:bg-gray-800/50 p-4 rounded-xl leading-relaxed">{{ $beneficiary->goals }}</p>
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>

        <!-- Left Column: Details, Sponsorships, Projects -->
        <div class="md:col-span-2 space-y-6">
            <!-- Details Card -->
            <div class="glass-card rounded-2xl p-6">
                <h3 class="text-lg font-heading font-semibold text-gray-900 dark:text-white mb-6 border-b border-gray-100 dark:border-gray-800 pb-3">المعلومات الشخصية</h3>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mt-4">
                    <div class="bg-gray-50 dark:bg-gray-800/50 p-4 rounded-xl border border-gray-100 dark:border-gray-700">
                        <span class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">الهوية الوطنية</span>
                        <span class="block font-bold text-gray-900 dark:text-white" dir="ltr" style="text-align: right;">{{ $beneficiary->national_id }}</span>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-800/50 p-4 rounded-xl border border-gray-100 dark:border-gray-700">
                        <span class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">رقم الهاتف</span>
                        <span class="block font-bold text-gray-900 dark:text-white" dir="ltr" style="text-align: right;">{{ $beneficiary->phone }}</span>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-800/50 p-4 rounded-xl border border-gray-100 dark:border-gray-700">
                        <span class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">الجنس</span>
                        <span class="block font-bold text-gray-900 dark:text-white">{{ $beneficiary->gender?->value === 'male' ? 'ذكر' : ($beneficiary->gender?->value === 'female' ? 'أنثى' : 'غير محدد') }}</span>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-800/50 p-4 rounded-xl border border-gray-100 dark:border-gray-700">
                        <span class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">الفئة</span>
                        <span class="block font-bold text-gray-900 dark:text-white">{{ $beneficiary->category?->label() ?? 'غير محدد' }}</span>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-800/50 p-4 rounded-xl border border-gray-100 dark:border-gray-700">
                        <span class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">تاريخ الميلاد (العمر)</span>
                        <span class="block font-bold text-gray-900 dark:text-white">{{ $beneficiary->dob ? $beneficiary->dob . ' (' . $beneficiary->age . ' سنة)' : 'غير محدد' }}</span>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-800/50 p-4 rounded-xl border border-gray-100 dark:border-gray-700">
                        <span class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">أفراد الأسرة</span>
                        <span class="block font-bold text-gray-900 dark:text-white">{{ $beneficiary->family_members }} فرد</span>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-800/50 p-4 rounded-xl border border-gray-100 dark:border-gray-700">
                        <span class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">الدخل الشهري</span>
                        <span class="block font-bold text-gray-900 dark:text-white">{{ number_format($beneficiary->monthly_income, 2) }} ريال</span>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-800/50 p-4 rounded-xl border border-gray-100 dark:border-gray-700">
                        <span class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">تاريخ التسجيل</span>
                        <span class="block font-bold text-gray-900 dark:text-white" dir="ltr" style="text-align: right;">{{ $beneficiary->created_at->format('Y-m-d H:i') }}</span>
                    </div>
                </div>
            </div>

            <!-- Sponsorships -->
            @if(auth()->user()->hasFeature('sponsorships'))
            <div class="glass-card rounded-2xl p-6">
                <div class="flex items-center justify-between mb-6 border-b border-gray-100 dark:border-gray-800 pb-3">
                    <h3 class="text-lg font-heading font-semibold text-gray-900 dark:text-white">الكفالات المرتبطة</h3>
                    <span class="bg-brand-100 text-brand-700 dark:bg-brand-900/30 dark:text-brand-400 py-1 px-3 rounded-full text-xs font-bold">{{ $beneficiary->sponsorships->count() }}</span>
                </div>
                
                <div class="space-y-4">
                    @forelse($beneficiary->sponsorships as $sponsorship)
                        <div class="bg-gray-50 dark:bg-gray-800/50 p-4 rounded-xl border border-gray-100 dark:border-gray-700">
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <h4 class="font-bold text-gray-900 dark:text-white text-sm">
                                        <a href="{{ route('donors.show', $sponsorship->donor) }}" class="hover:text-brand-600 hover:underline">
                                            الكافل: {{ $sponsorship->donor->name }}
                                        </a>
                                    </h4>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">تاريخ البدء: <span dir="ltr">{{ $sponsorship->start_date ? $sponsorship->start_date->format('Y-m-d') : '-' }}</span></p>
                                </div>
                                <div class="text-left">
                                    <span class="block font-bold text-brand-600 dark:text-brand-400 text-sm" dir="ltr">{{ number_format($sponsorship->amount, 2) }} ر.س</span>
                                    @php
                                        $statusColors = ['active' => 'text-green-600', 'inactive' => 'text-red-600', 'completed' => 'text-blue-600', 'cancelled' => 'text-gray-600'];
                                        $statusLabels = ['active' => 'نشطة', 'inactive' => 'غير نشطة', 'completed' => 'مكتملة', 'cancelled' => 'ملغاة'];
                                    @endphp
                                    <span class="text-xs font-medium {{ $statusColors[$sponsorship->status] ?? 'text-gray-500' }}">{{ $statusLabels[$sponsorship->status] ?? $sponsorship->status }}</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-6 text-gray-500 dark:text-gray-400 text-sm">
                            لا يوجد كفالات مرتبطة بهذا المستفيد حالياً.
                        </div>
                    @endforelse
                </div>
            </div>
            @endif

            <!-- Projects -->
            @if(auth()->user()->hasFeature('projects'))
            <div class="glass-card rounded-2xl p-6">
                <div class="flex items-center justify-between mb-6 border-b border-gray-100 dark:border-gray-800 pb-3">
                    <h3 class="text-lg font-heading font-semibold text-gray-900 dark:text-white">المشاريع المرتبطة</h3>
                    <span class="bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 py-1 px-3 rounded-full text-xs font-bold">{{ $beneficiary->projects->count() }}</span>
                </div>
                
                <div class="space-y-4">
                    @forelse($beneficiary->projects as $project)
                        <div class="bg-gray-50 dark:bg-gray-800/50 p-4 rounded-xl border border-gray-100 dark:border-gray-700 flex justify-between items-center">
                            <div>
                                <h4 class="font-bold text-gray-900 dark:text-white text-sm">
                                    <a href="{{ route('projects.show', $project) }}" class="hover:text-blue-600 hover:underline">
                                        {{ $project->name }}
                                    </a>
                                </h4>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">تاريخ الانضمام: <span dir="ltr">{{ $project->pivot->created_at->format('Y-m-d') }}</span></p>
                            </div>
                            <div>
                                <span class="px-2 py-1 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-300 rounded text-xs">
                                    {{ $project->pivot->status === 'approved' ? 'معتمد' : ($project->pivot->status === 'rejected' ? 'مرفوض' : 'قيد المراجعة') }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-6 text-gray-500 dark:text-gray-400 text-sm">
                            هذا المستفيد غير مدرج في أي مشاريع حالياً.
                        </div>
                    @endforelse
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
