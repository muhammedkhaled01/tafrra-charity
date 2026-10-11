<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="font-heading font-bold text-3xl text-brand-900 dark:text-white leading-tight">
                    سندات القبض والصرف
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">إدارة المعاملات المالية، التبرعات، والمصروفات.</p>
            </div>
            
            <div class="flex items-center gap-3">
                <a href="{{ route('transactions.create') }}" class="inline-flex items-center justify-center px-4 py-2 bg-brand-600 hover:bg-brand-700 text-white rounded-xl font-semibold text-sm transition-all shadow-lg shadow-brand-500/30">
                    <svg class="w-5 h-5 ml-2 -mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    تسجيل سند جديد
                </a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-right">
                    <thead class="bg-gray-50/50 dark:bg-gray-900/50 border-b border-gray-100 dark:border-gray-800">
                        <tr>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 dark:text-gray-400">رقم السند</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 dark:text-gray-400">النوع</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 dark:text-gray-400">المبلغ</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 dark:text-gray-400">التاريخ</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 dark:text-gray-400">الطرف المعني</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 dark:text-gray-400">طريقة الدفع</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        @forelse($transactions as $transaction)
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-900/50 transition-colors">
                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400" dir="ltr">{{ $transaction->receipt_number ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm font-medium">
                                    @if($transaction->type === 'income')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400">سند قبض (إيراد)</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400">سند صرف (مصروف)</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm font-bold {{ $transaction->type === 'income' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}" dir="ltr">
                                    {{ $transaction->type === 'income' ? '+' : '-' }}{{ number_format($transaction->amount, 2) }} ر.س
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400" dir="ltr">{{ $transaction->transaction_date?->format('Y-m-d') }}</td>
                                <td class="px-6 py-4 text-sm font-medium">
                                    @if($transaction->donor)
                                        <span class="text-brand-600 dark:text-brand-400">الداعم: {{ $transaction->donor->name }}</span>
                                    @elseif($transaction->beneficiary)
                                        <span class="text-blue-600 dark:text-blue-400">المستفيد: {{ $transaction->beneficiary->name }}</span>
                                    @else
                                        <span class="text-gray-500 dark:text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                    @php
                                        $methods = [
                                            'cash' => 'نقدي',
                                            'bank_transfer' => 'تحويل بنكي',
                                            'check' => 'شيك',
                                            'other' => 'أخرى'
                                        ];
                                    @endphp
                                    {{ $methods[$transaction->payment_method] ?? $transaction->payment_method ?? '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 dark:bg-gray-800 mb-4">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    </div>
                                    <h3 class="text-sm font-medium text-gray-900 dark:text-white mb-1">لا توجد سندات مالية</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">قم بتسجيل أول سند مالي (قبض أو صرف) لتبدأ بتتبع المعاملات.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($transactions->hasPages())
                <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-800">
                    {{ $transactions->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
