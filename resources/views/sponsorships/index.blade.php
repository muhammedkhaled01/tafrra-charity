<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="font-heading font-bold text-3xl text-brand-900 dark:text-white">
                    إدارة الكفالات
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">إدارة وربط الداعمين بالأسر المستفيدة وتتبع حالة الكفالات.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('sponsorships.create') }}" class="inline-flex items-center justify-center px-4 py-2 bg-brand-600 hover:bg-brand-700 text-white text-sm font-medium rounded-xl transition-all shadow-lg shadow-brand-500/30">
                    <svg class="w-5 h-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    إضافة كفالة جديدة
                </a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto space-y-6">
        @if(session('success'))
            <div class="p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-right">
                    <thead class="bg-gray-50/50 dark:bg-gray-900/50 border-b border-gray-100 dark:border-gray-800">
                        <tr>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 dark:text-gray-400">الكافل / الداعم</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 dark:text-gray-400">المستفيد</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 dark:text-gray-400">المبلغ</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 dark:text-gray-400">تاريخ البدء</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 dark:text-gray-400">الحالة</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 dark:text-gray-400 w-24">إجراءات</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        @forelse($sponsorships as $sponsorship)
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-900/50 transition-colors">
                                <td class="px-6 py-4 text-sm font-bold">
                                    @if($sponsorship->donor)
                                        <a href="{{ route('donors.show', $sponsorship->donor) }}" class="text-brand-600 underline hover:text-brand-800 dark:text-brand-400 dark:hover:text-brand-300 transition-colors">
                                            {{ $sponsorship->donor->name }}
                                        </a>
                                    @else
                                        <span class="text-gray-500 dark:text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm font-bold">
                                    @if($sponsorship->beneficiary)
                                        <a href="{{ route('beneficiaries.show', $sponsorship->beneficiary) }}" class="text-brand-600 underline hover:text-brand-800 dark:text-brand-400 dark:hover:text-brand-300 transition-colors">
                                            {{ $sponsorship->beneficiary->name }}
                                        </a>
                                    @else
                                        <span class="text-gray-500 dark:text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-brand-600 dark:text-brand-400" dir="ltr">{{ number_format($sponsorship->amount, 2) }} ر.س</td>
                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400" dir="ltr">{{ $sponsorship->start_date ? $sponsorship->start_date->format('Y-m-d') : '-' }}</td>
                                <td class="px-6 py-4">
                                    @php
                                        $statusColors = [
                                            'active' => 'bg-green-100 text-green-700',
                                            'inactive' => 'bg-red-100 text-red-700',
                                            'completed' => 'bg-blue-100 text-blue-700',
                                            'cancelled' => 'bg-gray-100 text-gray-700',
                                        ];
                                        $statusLabels = [
                                            'active' => 'نشط',
                                            'inactive' => 'غير نشط',
                                            'completed' => 'مكتمل',
                                            'cancelled' => 'ملغي',
                                        ];
                                    @endphp
                                    <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $statusColors[$sponsorship->status] ?? 'bg-gray-100 text-gray-700' }}">
                                        {{ $statusLabels[$sponsorship->status] ?? $sponsorship->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('sponsorships.edit', $sponsorship) }}" class="p-2 text-gray-400 hover:text-brand-600 hover:bg-brand-50 rounded-lg transition-colors">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center text-gray-500 dark:text-gray-400">
                                        <svg class="w-12 h-12 mb-4 text-gray-300 dark:text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                                        </svg>
                                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-1">لا يوجد كفالات حالياً</h3>
                                        <p class="text-sm">ابدأ بربط الداعمين بالمستفيدين.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if(method_exists($sponsorships, 'hasPages') && $sponsorships->hasPages())
                <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-800">
                    {{ $sponsorships->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
