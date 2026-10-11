<x-app-layout>
    <x-slot name="header">
        <h2 class="font-heading font-bold text-3xl text-gray-900 dark:text-white leading-tight">
            نظرة عامة على المنصة
        </h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">لوحة تحكم الإدارة العليا</p>
    </x-slot>

    <!-- KPIs -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
        @php
            $kpiConfig = [
                'total_charities' => ['title' => 'إجمالي الجمعيات', 'icon' => '<svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>', 'color' => 'blue'],
                'active_charities' => ['title' => 'الجمعيات النشطة', 'icon' => '<svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>', 'color' => 'green'],
                'total_beneficiaries' => ['title' => 'إجمالي المستفيدين', 'icon' => '<svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>', 'color' => 'brand'],
                'new_beneficiaries' => ['title' => 'مستفيدين جدد (هذا الشهر)', 'icon' => '<svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>', 'color' => 'emerald'],
                'revenue_this_month' => ['title' => 'إيرادات هذا الشهر', 'icon' => '<svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>', 'color' => 'amber'],
                'revenue_change' => ['title' => 'نمو الإيرادات', 'icon' => '<svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>', 'color' => 'teal'],
                'expiring_soon' => ['title' => 'اشتراكات تنتهي قريباً', 'icon' => '<svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>', 'color' => 'red'],
                'total_users' => ['title' => 'إجمالي المستخدمين', 'icon' => '<svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>', 'color' => 'indigo'],
                'total_projects' => ['title' => 'إجمالي المشاريع', 'icon' => '<svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>', 'color' => 'fuchsia'],
                'beneficiaries_change' => ['title' => 'نمو المستفيدين', 'icon' => '<svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>', 'color' => 'emerald'],
                'mrr' => ['title' => 'الإيرادات المتكررة (MRR)', 'icon' => '<svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>', 'color' => 'purple']
            ];
            
            $colorClasses = [
                'blue' => 'bg-blue-50 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400 border-blue-100 dark:border-blue-800/30',
                'green' => 'bg-green-50 text-green-600 dark:bg-green-900/30 dark:text-green-400 border-green-100 dark:border-green-800/30',
                'brand' => 'bg-brand-50 text-brand-600 dark:bg-brand-900/30 dark:text-brand-400 border-brand-100 dark:border-brand-800/30',
                'emerald' => 'bg-emerald-50 text-emerald-600 dark:bg-emerald-900/30 dark:text-emerald-400 border-emerald-100 dark:border-emerald-800/30',
                'amber' => 'bg-amber-50 text-amber-600 dark:bg-amber-900/30 dark:text-amber-400 border-amber-100 dark:border-amber-800/30',
                'teal' => 'bg-teal-50 text-teal-600 dark:bg-teal-900/30 dark:text-teal-400 border-teal-100 dark:border-teal-800/30',
                'red' => 'bg-red-50 text-red-600 dark:bg-red-900/30 dark:text-red-400 border-red-100 dark:border-red-800/30',
                'indigo' => 'bg-indigo-50 text-indigo-600 dark:bg-indigo-900/30 dark:text-indigo-400 border-indigo-100 dark:border-indigo-800/30',
                'fuchsia' => 'bg-fuchsia-50 text-fuchsia-600 dark:bg-fuchsia-900/30 dark:text-fuchsia-400 border-fuchsia-100 dark:border-fuchsia-800/30',
                'purple' => 'bg-purple-50 text-purple-600 dark:bg-purple-900/30 dark:text-purple-400 border-purple-100 dark:border-purple-800/30',
            ];
        @endphp

        @foreach($kpis as $key => $kpi)
            @php
                $config = $kpiConfig[$key] ?? ['title' => str_replace('_', ' ', $key), 'icon' => '<svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>', 'color' => 'brand'];
                $iconClass = $colorClasses[$config['color']] ?? $colorClasses['brand'];
            @endphp
            <div class="glass-card rounded-2xl p-5 flex items-center gap-4 relative overflow-hidden group hover:-translate-y-1 transition-transform duration-300">
                <div class="w-12 h-12 flex-shrink-0 flex items-center justify-center rounded-xl border {{ $iconClass }}">
                    {!! $config['icon'] !!}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate mb-1" title="{{ $config['title'] }}">
                        {{ $config['title'] }}
                    </p>
                    <h4 class="text-2xl font-heading font-bold text-gray-900 dark:text-white" dir="ltr" style="text-align: right;">
                        @if(is_numeric($kpi) && (str_contains($key, 'revenue') || str_contains($key, 'mrr')))
                            {{ number_format($kpi, 2) }} <span class="text-sm font-normal text-gray-500">ر.س</span>
                        @elseif(is_numeric($kpi) && str_contains($key, 'change'))
                            <span class="{{ $kpi >= 0 ? 'text-green-600' : 'text-red-600' }}" dir="ltr">
                                {{ $kpi >= 0 ? '+' : '' }}{{ $kpi }}%
                            </span>
                        @elseif(is_numeric($kpi))
                            {{ number_format($kpi) }}
                        @else
                            {{ $kpi }}
                        @endif
                    </h4>
                </div>
                <!-- Soft Glow Effect -->
                <div class="absolute -right-6 -top-6 w-24 h-24 bg-[var(--brand-500)] opacity-0 group-hover:opacity-10 rounded-full blur-2xl transition-opacity duration-500 pointer-events-none"></div>
            </div>
        @endforeach
    </div>

    <!-- Charts Row 1 -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-heading font-bold text-gray-900 dark:text-white">نمو الإيرادات</h3>
                <span class="p-2 bg-brand-50 text-brand-600 dark:bg-brand-900/30 dark:text-brand-400 rounded-lg">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                </span>
            </div>
            <div id="chart-revenue" class="h-72 w-full" dir="ltr"></div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-heading font-bold text-gray-900 dark:text-white">نمو الكيانات (الجمعيات والمستفيدين)</h3>
                <span class="p-2 bg-purple-50 text-purple-600 dark:bg-purple-900/30 dark:text-purple-400 rounded-lg">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </span>
            </div>
            <div id="chart-growth" class="h-72 w-full" dir="ltr"></div>
        </div>
    </div>

    <!-- Charts Row 2 -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-heading font-bold text-gray-900 dark:text-white">توزيع الباقات</h3>
            </div>
            <div id="chart-plans" class="h-64 w-full" dir="ltr"></div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-heading font-bold text-gray-900 dark:text-white">الجمعيات حسب المدينة</h3>
            </div>
            <div id="chart-cities" class="h-64 w-full" dir="ltr"></div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-heading font-bold text-gray-900 dark:text-white">أفضل الجمعيات أداءً</h3>
            </div>
            <div id="chart-top-charities" class="h-64 w-full" dir="ltr"></div>
        </div>
    </div>

    <!-- Recent Payments Table -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden mb-8">
        <div class="p-6 border-b border-gray-100 dark:border-gray-800 flex justify-between items-center bg-gray-50/30 dark:bg-gray-800/30">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-brand-50 dark:bg-brand-900/30 rounded-lg text-brand-600 dark:text-brand-400">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h3 class="text-lg font-heading font-bold text-gray-900 dark:text-white">أحدث المدفوعات والاشتراكات</h3>
            </div>
            <a href="{{ route('super-admin.payments.index') }}" class="inline-flex items-center text-sm font-medium text-brand-600 hover:text-brand-700 dark:text-brand-400 dark:hover:text-brand-300">
                عرض السجل الكامل
                <svg class="w-4 h-4 mr-1 rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-right">
                <thead class="bg-gray-50 dark:bg-gray-900/50 border-b border-gray-100 dark:border-gray-800">
                    <tr>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 dark:text-gray-400">الجمعية المشتركة</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 dark:text-gray-400">المبلغ</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 dark:text-gray-400">الحالة</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 dark:text-gray-400">تاريخ الدفع</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse($recentPayments as $payment)
                        <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-brand-100 text-brand-600 dark:bg-brand-900/30 dark:text-brand-400 flex items-center justify-center font-bold text-xs">
                                        {{ mb_substr($payment->tenant->name, 0, 1) }}
                                    </div>
                                    <span class="text-sm font-bold text-gray-900 dark:text-white">{{ $payment->tenant->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm font-bold text-gray-900 dark:text-white" dir="ltr">
                                {{ number_format($payment->amount, 2) }} <span class="text-xs font-normal text-gray-500">ر.س</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $payment->status->value === 'paid' ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400' }}">
                                    @if($payment->status->value === 'paid')
                                        <svg class="w-3 h-3 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    @else
                                        <svg class="w-3 h-3 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    @endif
                                    {{ $payment->status->value === 'paid' ? 'مدفوع' : 'معلق' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400" dir="ltr">{{ $payment->created_at->format('M d, Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 dark:bg-gray-800 mb-4">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                </div>
                                <h3 class="text-sm font-medium text-gray-900 dark:text-white mb-1">لا توجد مدفوعات حديثة</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400">ستظهر هنا تفاصيل مدفوعات الجمعيات والاشتراكات فور حدوثها.</p>
                            </td>
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
                colors: ['#2563eb', '#10b981', '#f59e0b', '#ec4899', '#8b5cf6', '#14b8a6']
            };

            // Revenue Area Chart
            const revenueData = @json($revenue ?? []);
            if (revenueData.length > 0) {
                new ApexCharts(document.querySelector("#chart-revenue"), {
                    ...chartOptions,
                    series: [{ name: 'الإيرادات', data: revenueData.map(item => item.total || 0) }],
                    chart: { type: 'area', height: 280, ...chartOptions.chart },
                    stroke: { curve: 'smooth', width: 3 },
                    fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.4, opacityTo: 0.05, stops: [0, 90, 100] } },
                    xaxis: { categories: revenueData.map(item => item.month || '') },
                    dataLabels: { enabled: false },
                    tooltip: { theme: isDark ? 'dark' : 'light', y: { formatter: (value) => value + ' ر.س' } }
                }).render();
            } else {
                document.querySelector("#chart-revenue").innerHTML = '<div class="h-full flex items-center justify-center text-gray-400 text-sm">لا تتوفر بيانات لعرض المخطط</div>';
            }

            // Entities Growth Line Chart
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
                    stroke: { curve: 'smooth', width: 3 },
                    xaxis: { categories: beneficiariesData.map(item => item.month || '') },
                    tooltip: { theme: isDark ? 'dark' : 'light' }
                }).render();
            } else {
                document.querySelector("#chart-growth").innerHTML = '<div class="h-full flex items-center justify-center text-gray-400 text-sm">لا تتوفر بيانات لعرض المخطط</div>';
            }

            // Plans Donut Chart
            const plansData = @json($plans ?? []);
            if (plansData.labels && plansData.labels.length > 0) {
                new ApexCharts(document.querySelector("#chart-plans"), {
                    ...chartOptions,
                    series: plansData.values,
                    labels: plansData.labels,
                    chart: { type: 'donut', height: 260, ...chartOptions.chart },
                    plotOptions: { pie: { donut: { size: '70%', labels: { show: true, name: { show: true }, value: { show: true } } } } },
                    legend: { position: 'bottom', horizontalAlign: 'center', fontFamily: 'Cairo' },
                    dataLabels: { enabled: false },
                    stroke: { width: 0 }
                }).render();
            } else {
                document.querySelector("#chart-plans").innerHTML = '<div class="h-full flex items-center justify-center text-gray-400 text-sm">لا تتوفر بيانات لعرض المخطط</div>';
            }

            // Cities Bar Chart
            const citiesData = @json($cities ?? []);
            if (citiesData.labels && citiesData.labels.length > 0) {
                new ApexCharts(document.querySelector("#chart-cities"), {
                    ...chartOptions,
                    series: [{ name: 'الجمعيات', data: citiesData.values }],
                    xaxis: { categories: citiesData.labels },
                    chart: { type: 'bar', height: 260, ...chartOptions.chart },
                    plotOptions: { bar: { borderRadius: 4, horizontal: true, distributed: true } },
                    dataLabels: { enabled: false },
                    legend: { show: false },
                    tooltip: { theme: isDark ? 'dark' : 'light' }
                }).render();
            } else {
                document.querySelector("#chart-cities").innerHTML = '<div class="h-full flex items-center justify-center text-gray-400 text-sm">لا تتوفر بيانات لعرض المخطط</div>';
            }

            // Top Charities Bar Chart
            const topCharitiesData = @json($topCharities ?? []);
            if (topCharitiesData.length > 0) {
                new ApexCharts(document.querySelector("#chart-top-charities"), {
                    ...chartOptions,
                    series: [{ name: 'إجمالي المستفيدين', data: topCharitiesData.map(item => item.beneficiaries_count || 0) }],
                    xaxis: { categories: topCharitiesData.map(item => item.name || '') },
                    chart: { type: 'bar', height: 260, ...chartOptions.chart },
                    plotOptions: { bar: { borderRadius: 4, distributed: true } },
                    dataLabels: { enabled: false },
                    legend: { show: false },
                    tooltip: { theme: isDark ? 'dark' : 'light' }
                }).render();
            } else {
                document.querySelector("#chart-top-charities").innerHTML = '<div class="h-full flex items-center justify-center text-gray-400 text-sm">لا تتوفر بيانات لعرض المخطط</div>';
            }
        });
    </script>
    @endpush
</x-app-layout>
