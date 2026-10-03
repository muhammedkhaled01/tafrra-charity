<x-app-layout>
    <x-slot name="header">
        <h2 class="font-heading font-bold text-3xl text-gray-900 dark:text-white leading-tight">
            المدفوعات
        </h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">سجل المدفوعات والاشتراكات للجمعيات</p>
    </x-slot>

    <!-- Totals Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        @foreach($totals ?? [] as $status => $data)
            <div class="glass-card rounded-2xl p-6 flex flex-col relative overflow-hidden group hover:-translate-y-1 transition-transform duration-300">
                <span class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">
                    {{ $status === 'paid' ? 'المدفوعات الناجحة' : ($status === 'pending' ? 'المدفوعات المعلقة' : 'مدفوعات ملغاة') }}
                </span>
                <span class="text-3xl font-heading font-bold text-gray-900 dark:text-white" dir="ltr">
                    {{ number_format($data->amount ?? 0, 2) }} ريال
                </span>
                <span class="text-xs text-gray-400 mt-2">{{ $data->count ?? 0 }} عملية</span>
            </div>
        @endforeach
    </div>

    <!-- Payments Table -->
    <div class="glass-card rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50/50 dark:bg-gray-800/50 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-medium">رقم العملية</th>
                        <th scope="col" class="px-6 py-4 font-medium">الجمعية</th>
                        <th scope="col" class="px-6 py-4 font-medium">المبلغ</th>
                        <th scope="col" class="px-6 py-4 font-medium">تاريخ الدفع</th>
                        <th scope="col" class="px-6 py-4 font-medium">طريقة الدفع</th>
                        <th scope="col" class="px-6 py-4 font-medium">الحالة</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse($payments ?? [] as $payment)
                        <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/50 transition-colors">
                            <td class="px-6 py-4 text-gray-900 dark:text-white font-medium" dir="ltr">#{{ str_pad($payment->id, 5, '0', STR_PAD_LEFT) }}</td>
                            <td class="px-6 py-4 font-medium">{{ $payment->tenant->name ?? 'غير معروف' }}</td>
                            <td class="px-6 py-4" dir="ltr">{{ number_format($payment->amount, 2) }} ريال</td>
                            <td class="px-6 py-4" dir="ltr">{{ $payment->created_at->format('Y-m-d H:i') }}</td>
                            <td class="px-6 py-4 uppercase">{{ $payment->payment_method ?? 'Bank Transfer' }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 text-xs font-medium rounded-full {{ $payment->status->value === 'paid' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400' }}">
                                    {{ $payment->status->value === 'paid' ? 'مدفوع' : 'معلق' }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">لا توجد عمليات دفع مسجلة.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(isset($payments) && method_exists($payments, 'links'))
            <div class="p-4 border-t border-gray-100 dark:border-gray-800">
                {{ $payments->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
