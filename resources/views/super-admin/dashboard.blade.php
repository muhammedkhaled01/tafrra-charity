<x-app-layout>
    <x-slot name="header">
        <h2 class="font-heading font-bold text-3xl text-gray-900 dark:text-white leading-tight">
            نظرة عامة على المنصة
        </h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">لوحة تحكم الإدارة العليا</p>
    </x-slot>

    <!-- KPIs -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        @php
            $kpiTitles = [
                'total_charities' => 'إجمالي الجمعيات',
                'active_charities' => 'الجمعيات النشطة',
                'total_beneficiaries' => 'إجمالي المستفيدين',
                'new_beneficiaries' => 'مستفيدين جدد (الشهر)',
                'revenue_this_month' => 'إيرادات هذا الشهر',
                'revenue_change' => 'نسبة نمو الإيرادات',
                'expiring_soon' => 'اشتراكات تنتهي قريباً',
                'total_users' => 'إجمالي المستخدمين',
                'total_projects' => 'إجمالي المشاريع',
                'beneficiaries_change' => 'نمو المستفيدين',
                'mrr' => 'الإيرادات الشهرية المتكررة (MRR)'
            ];
        @endphp
        @foreach($kpis as $key => $kpi)
            <div class="glass-card rounded-2xl p-6 flex flex-col relative overflow-hidden group hover:-translate-y-1 transition-transform duration-300">
                <div class="absolute -right-6 -top-6 w-24 h-24 bg-brand-500/10 rounded-full blur-2xl group-hover:bg-brand-500/20 transition-all"></div>
                <span class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">{{ $kpiTitles[$key] ?? str_replace('_', ' ', $key) }}</span>
                <span class="text-3xl font-heading font-bold text-gray-900 dark:text-white" dir="ltr">
                    {{ is_numeric($kpi) && (str_contains($key, 'revenue') || str_contains($key, 'mrr')) ? number_format($kpi, 2) . ' ريال' : (is_numeric($kpi) ? number_format($kpi) : $kpi) }}
                </span>
            </div>
        @endforeach
    </div>

    <!-- Charts Row 1 -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <div class="glass-card rounded-2xl p-6">
            <h3 class="text-lg font-heading font-semibold text-gray-900 dark:text-white mb-4">نمو الإيرادات</h3>
            <div id="chart-revenue" class="h-72 w-full" dir="ltr"></div>
        </div>
        <div class="glass-card rounded-2xl p-6">
            <h3 class="text-lg font-heading font-semibold text-gray-900 dark:text-white mb-4">نمو الكيانات (الجمعيات والمستفيدين)</h3>
            <div id="chart-growth" class="h-72 w-full" dir="ltr"></div>
        </div>
    </div>

    <!-- Charts Row 2 -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <div class="glass-card rounded-2xl p-6">
            <h3 class="text-lg font-heading font-semibold text-gray-900 dark:text-white mb-4">الباقات المشترك بها</h3>
            <div id="chart-plans" class="h-64 w-full" dir="ltr"></div>
        </div>
        <div class="glass-card rounded-2xl p-6">
            <h3 class="text-lg font-heading font-semibold text-gray-900 dark:text-white mb-4">الجمعيات حسب المدينة</h3>
            <div id="chart-cities" class="h-64 w-full" dir="ltr"></div>
        </div>
        <div class="glass-card rounded-2xl p-6">
            <h3 class="text-lg font-heading font-semibold text-gray-900 dark:text-white mb-4">أفضل الجمعيات أداءً</h3>
            <div id="chart-top-charities" class="h-64 w-full" dir="ltr"></div>
        </div>
    </div>

    <!-- Recent Payments Table -->
    <div class="glass-card rounded-2xl overflow-hidden">
        <div class="p-6 border-b border-gray-100 dark:border-gray-800 flex justify-between items-center">
            <h3 class="text-lg font-heading font-semibold text-gray-900 dark:text-white">أحدث المدفوعات</h3>
            <a href="{{ route('super-admin.payments.index') }}" class="text-sm text-brand-600 dark:text-brand-400 font-medium hover:underline">عرض الكل</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50/50 dark:bg-gray-800/50 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-medium">الجمعية</th>
                        <th scope="col" class="px-6 py-4 font-medium">المبلغ</th>
                        <th scope="col" class="px-6 py-4 font-medium">الحالة</th>
                        <th scope="col" class="px-6 py-4 font-medium">التاريخ</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse($recentPayments as $payment)
                        <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/50 transition-colors">
                            <td class="px-6 py-4 text-gray-900 dark:text-white font-medium">{{ $payment->tenant->name }}</td>
                            <td class="px-6 py-4" dir="ltr">{{ number_format($payment->amount, 2) }} ريال</td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 text-xs font-medium rounded-full {{ $payment->status->value === 'paid' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400' }}">
                                    {{ $payment->status->value === 'paid' ? 'مدفوع' : 'معلق' }}
                                </span>
                            </td>
                            <td class="px-6 py-4" dir="ltr">{{ $payment->created_at->format('M d, Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-gray-500">لا توجد مدفوعات حديثة.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const isDark = document.documentElement.classList.contains('dark') || 
                           window.matchMedia('(prefers-color-scheme: dark)').matches;
            
            const chartOptions = {
                chart: { 
                    fontFamily: 'Cairo, Inter, sans-serif',
                    toolbar: { show: false },
                    background: 'transparent'
                },
                theme: { mode: isDark ? 'dark' : 'light' },
                colors: ['#0c8aeb', '#e7a42b', '#10b981', '#f59e0b', '#ef4444', '#ec4899']
            };

            // Safely parse data
            const revenueData = @json($revenue ?? []);
            if (revenueData.length > 0) {
                new ApexCharts(document.querySelector("#chart-revenue"), {
                    ...chartOptions,
                    series: [{ name: 'الإيرادات', data: revenueData.map(item => item.total || 0) }],
                    chart: { type: 'area', height: 280, ...chartOptions.chart },
                    stroke: { curve: 'smooth', width: 2 },
                    fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.4, opacityTo: 0.05, stops: [0, 90, 100] } },
                    xaxis: { categories: revenueData.map(item => item.month || '') },
                    dataLabels: { enabled: false }
                }).render();
            }

            const beneficiariesData = @json($beneficiaryGrowth ?? []);
            const charitiesData = @json($charityGrowth ?? []);
            if (beneficiariesData.length > 0 || charitiesData.length > 0) {
                new ApexCharts(document.querySelector("#chart-growth"), {
                    ...chartOptions,
                    series: [
                        { name: 'المستفيدين', data: beneficiariesData.map(item => item.count || 0) },
                        { name: 'الجمعيات', data: charitiesData.map(item => item.count || 0) }
                    ],
                    chart: { type: 'line', height: 280, ...chartOptions.chart },
                    stroke: { curve: 'smooth', width: 2 },
                    xaxis: { categories: beneficiariesData.map(item => item.month || '') },
                }).render();
            }

            const plansData = @json($plans ?? []);
            if (plansData.length > 0) {
                new ApexCharts(document.querySelector("#chart-plans"), {
                    ...chartOptions,
                    series: plansData.map(item => item.count || 0),
                    labels: plansData.map(item => item.name || 'غير محدد'),
                    chart: { type: 'donut', height: 250, ...chartOptions.chart },
                    plotOptions: { pie: { donut: { size: '70%' } } },
                    legend: { position: 'bottom' }
                }).render();
            }

            const citiesData = @json($cities ?? []);
            if (citiesData.length > 0) {
                new ApexCharts(document.querySelector("#chart-cities"), {
                    ...chartOptions,
                    series: [{ name: 'الجمعيات', data: citiesData.map(item => item.count || 0) }],
                    xaxis: { categories: citiesData.map(item => item.city || 'أخرى') },
                    chart: { type: 'bar', height: 250, ...chartOptions.chart },
                    plotOptions: { bar: { borderRadius: 4, horizontal: true } },
                    dataLabels: { enabled: false }
                }).render();
            }

            const topCharitiesData = @json($topCharities ?? []);
            if (topCharitiesData.length > 0) {
                new ApexCharts(document.querySelector("#chart-top-charities"), {
                    ...chartOptions,
                    series: [{ name: 'المستفيدين', data: topCharitiesData.map(item => item.beneficiaries_count || 0) }],
                    xaxis: { categories: topCharitiesData.map(item => item.name || '') },
                    chart: { type: 'bar', height: 250, ...chartOptions.chart },
                    plotOptions: { bar: { borderRadius: 4, distributed: true } },
                    dataLabels: { enabled: false },
                    legend: { show: false }
                }).render();
            }
        });
    </script>
    @endpush
</x-app-layout>
