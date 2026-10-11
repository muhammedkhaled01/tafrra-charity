<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-heading font-bold text-3xl text-gray-900 dark:text-white leading-tight">
                تفاصيل الداعم / الكافل
            </h2>
            <div class="flex gap-3">
                <a href="{{ route('donors.edit', $donor) }}" class="inline-flex items-center justify-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-xl font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-50 dark:hover:bg-gray-700 transition-all">
                    تعديل البيانات
                </a>
            </div>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Right Column (Profile Summary & Notes) -->
        <div class="md:col-span-1 space-y-6">
            <!-- Profile Summary Card -->
            <div class="glass-card rounded-2xl p-6 text-center">
                <div class="w-24 h-24 mx-auto bg-gradient-brand rounded-full flex items-center justify-center text-3xl font-bold mb-4 shadow-lg shadow-brand-500/30">
                    {{ mb_substr($donor->name, 0, 1) }}
                </div>
                <h3 class="text-xl font-heading font-bold text-gray-900 dark:text-white mb-1">{{ $donor->name }}</h3>
                <p class="text-gray-500 dark:text-gray-400 mb-4">{{ $donor->donor_type?->label() ?? 'غير محدد' }}</p>
                
                <div class="inline-block px-3 py-1 rounded-full text-sm font-medium {{ $donor->status === 'active' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' }}">
                    {{ $donor->status === 'active' ? 'نشط' : 'غير نشط' }}
                </div>
            </div>

            @if($donor->notes)
            <!-- Notes Card -->
            <div class="glass-card rounded-2xl p-6">
                <h3 class="text-lg font-heading font-semibold text-gray-900 dark:text-white mb-4 border-b border-gray-100 dark:border-gray-800 pb-3">ملاحظات إضافية</h3>
                <p class="text-sm text-gray-900 dark:text-gray-300 bg-gray-50 dark:bg-gray-800/50 p-4 rounded-xl leading-relaxed">{{ $donor->notes }}</p>
            </div>
            @endif
        </div>

        <!-- Left Column (Details & Sponsorships) -->
        <div class="md:col-span-2 space-y-6">
            <!-- Details Card -->
            <div class="glass-card rounded-2xl p-6">
                <h3 class="text-lg font-heading font-semibold text-gray-900 dark:text-white mb-6 border-b border-gray-100 dark:border-gray-800 pb-3">المعلومات الشخصية والاتصال</h3>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
                    <div class="bg-gray-50 dark:bg-gray-800/50 p-4 rounded-xl border border-gray-100 dark:border-gray-700">
                        <span class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">رقم الهوية / السجل التجاري</span>
                        <span class="block font-bold text-gray-900 dark:text-white" dir="ltr" style="text-align: right;">{{ $donor->identity_number ?? '-' }}</span>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-800/50 p-4 rounded-xl border border-gray-100 dark:border-gray-700">
                        <span class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">رقم الهاتف</span>
                        <span class="block font-bold text-gray-900 dark:text-white" dir="ltr" style="text-align: right;">{{ $donor->phone ?? '-' }}</span>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-800/50 p-4 rounded-xl border border-gray-100 dark:border-gray-700">
                        <span class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">البريد الإلكتروني</span>
                        <span class="block font-bold text-gray-900 dark:text-white" dir="ltr" style="text-align: right;">{{ $donor->email ?? '-' }}</span>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-800/50 p-4 rounded-xl border border-gray-100 dark:border-gray-700">
                        <span class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">تاريخ التسجيل</span>
                        <span class="block font-bold text-gray-900 dark:text-white" dir="ltr" style="text-align: right;">{{ $donor->created_at->format('Y-m-d H:i') }}</span>
                    </div>
                    @if($donor->address)
                    <div class="bg-gray-50 dark:bg-gray-800/50 p-4 rounded-xl border border-gray-100 dark:border-gray-700 sm:col-span-2">
                        <span class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">العنوان</span>
                        <span class="block font-bold text-gray-900 dark:text-white">{{ $donor->address }}</span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Sponsorships Card -->
            <div class="glass-card rounded-2xl p-6">
                <div class="flex items-center justify-between mb-6 border-b border-gray-100 dark:border-gray-800 pb-3">
                    <h3 class="text-lg font-heading font-semibold text-gray-900 dark:text-white">الكفالات المرتبطة بهذا الداعم</h3>
                    <span class="bg-brand-100 text-brand-700 dark:bg-brand-900/30 dark:text-brand-400 py-1 px-3 rounded-full text-xs font-bold">{{ $donor->sponsorships->count() }}</span>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-right">
                        <thead class="bg-gray-50/50 dark:bg-gray-900/50 border-b border-gray-100 dark:border-gray-800">
                            <tr>
                                <th class="px-6 py-4 text-xs font-semibold text-gray-500 dark:text-gray-400">المستفيد</th>
                                <th class="px-6 py-4 text-xs font-semibold text-gray-500 dark:text-gray-400">المبلغ</th>
                                <th class="px-6 py-4 text-xs font-semibold text-gray-500 dark:text-gray-400">تاريخ البدء</th>
                                <th class="px-6 py-4 text-xs font-semibold text-gray-500 dark:text-gray-400">تاريخ الانتهاء</th>
                                <th class="px-6 py-4 text-xs font-semibold text-gray-500 dark:text-gray-400">الحالة</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                            @forelse($donor->sponsorships as $sponsorship)
                                <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-900/50 transition-colors">
                                    <td class="px-6 py-4 text-sm font-bold">
                                        @if($sponsorship->beneficiary)
                                            <a href="{{ route('beneficiaries.show', $sponsorship->beneficiary) }}" class="text-brand-600 underline hover:text-brand-800 dark:text-brand-400 dark:hover:text-brand-300 transition-colors">
                                                {{ $sponsorship->beneficiary->name }}
                                            </a>
                                        @else
                                            <span class="text-gray-500 dark:text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm font-bold text-brand-600 dark:text-brand-400" dir="ltr">{{ number_format($sponsorship->amount, 2) }} ر.س</td>
                                    <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400" dir="ltr">{{ $sponsorship->start_date ? $sponsorship->start_date->format('Y-m-d') : '-' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400" dir="ltr">{{ $sponsorship->end_date ? $sponsorship->end_date->format('Y-m-d') : '-' }}</td>
                                    <td class="px-6 py-4">
                                        @php
                                            $statusColors = [
                                                'active' => 'bg-green-100 text-green-700',
                                                'inactive' => 'bg-red-100 text-red-700',
                                                'completed' => 'bg-blue-100 text-blue-700',
                                                'cancelled' => 'bg-gray-100 text-gray-700',
                                            ];
                                            $statusLabels = [
                                                'active' => 'نشطة',
                                                'inactive' => 'غير نشطة',
                                                'completed' => 'مكتملة',
                                                'cancelled' => 'ملغاة',
                                            ];
                                        @endphp
                                        <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $statusColors[$sponsorship->status] ?? 'bg-gray-100 text-gray-700' }}">
                                            {{ $statusLabels[$sponsorship->status] ?? $sponsorship->status }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400 text-sm">
                                        لا يوجد كفالات مرتبطة بهذا الداعم حالياً.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
