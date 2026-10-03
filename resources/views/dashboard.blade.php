<x-app-layout>
    <x-slot name="header">
        <h2 class="font-heading font-bold text-3xl text-gray-900 dark:text-white leading-tight">
            لوحة التحكم
        </h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">أهلاً بك مرة أخرى، {{ auth()->user()->name }}</p>
    </x-slot>

    <!-- KPIs -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        @php
            $kpiLabels = [
                'beneficiaries_change' => 'التغير في المستفيدين',
                'new_this_month' => 'جديد هذا الشهر',
                'active_beneficiaries' => 'المستفيدون النشطون',
                'total_beneficiaries' => 'إجمالي المستفيدين',
                'approved_applications' => 'الطلبات المعتمدة',
                'total_budget' => 'الميزانية الإجمالية',
                'active_projects' => 'المشاريع النشطة',
                'total_projects' => 'إجمالي المشاريع',
                'usage_percent' => 'نسبة الاستخدام',
                'max_beneficiaries' => 'الحد الأقصى للمستفيدين',
                'team_members' => 'أعضاء الفريق',
                'pending_applications' => 'طلبات قيد الانتظار'
            ];
        @endphp
        @foreach($kpis as $key => $kpi)
            <div class="glass-card rounded-2xl p-6 flex flex-col relative overflow-hidden group hover:-translate-y-1 transition-all duration-300">
                <div class="absolute -right-6 -top-6 w-24 h-24 bg-gradient-to-br from-brand-400/20 to-orange-400/20 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-500"></div>
                <span class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2 z-10">{{ $kpiLabels[$key] ?? str_replace('_', ' ', $key) }}</span>
                <span class="text-3xl font-heading font-bold text-transparent bg-clip-text bg-gradient-to-l from-brand-600 to-orange-500 z-10">
                    {{ is_numeric($kpi) && str_contains($key, 'amount') ? number_format($kpi, 2) . ' ريال' : (is_numeric($kpi) ? number_format($kpi) : $kpi) }}
                    @if(str_contains($key, 'percent')) % @endif
                </span>
            </div>
        @endforeach
    </div>

    <!-- Charts Row 1 -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <div class="glass-card rounded-2xl p-6">
            <h3 class="text-lg font-heading font-semibold text-gray-900 dark:text-white mb-4">التسجيلات والاعتمادات</h3>
            <div id="chart-registrations" class="h-72 w-full" dir="ltr"></div>
        </div>
        <div class="glass-card rounded-2xl p-6">
            <h3 class="text-lg font-heading font-semibold text-gray-900 dark:text-white mb-4">حالة الطلبات</h3>
            <div id="chart-applications" class="h-72 w-full flex justify-center" dir="ltr"></div>
        </div>
    </div>

    <!-- Charts Row 2 -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <div class="glass-card rounded-2xl p-6">
            <h3 class="text-lg font-heading font-semibold text-gray-900 dark:text-white mb-4">التوزيع حسب الجنس</h3>
            <div id="chart-gender" class="h-64 w-full" dir="ltr"></div>
        </div>
        <div class="glass-card rounded-2xl p-6">
            <h3 class="text-lg font-heading font-semibold text-gray-900 dark:text-white mb-4">الفئات العمرية</h3>
            <div id="chart-age" class="h-64 w-full" dir="ltr"></div>
        </div>
        <div class="glass-card rounded-2xl p-6">
            <h3 class="text-lg font-heading font-semibold text-gray-900 dark:text-white mb-4">أهم تصنيفات المشاريع</h3>
            <div id="chart-categories" class="h-64 w-full" dir="ltr"></div>
        </div>
    </div>

    <!-- Recent Data Table -->
    <div class="glass-card rounded-2xl overflow-hidden">
        <div class="p-6 border-b border-gray-100 dark:border-gray-800 flex justify-between items-center">
            <h3 class="text-lg font-heading font-semibold text-gray-900 dark:text-white">أحدث المستفيدين المسجلين</h3>
            <a href="{{ route('beneficiaries.index') }}" class="text-sm text-brand-600 dark:text-brand-400 font-medium hover:text-brand-500 transition-colors">عرض الكل</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50/50 dark:bg-gray-700/50 dark:text-gray-400 border-b border-gray-100 dark:border-gray-800">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-medium">الاسم</th>
                        <th scope="col" class="px-6 py-4 font-medium">المدينة</th>
                        <th scope="col" class="px-6 py-4 font-medium">تاريخ التسجيل</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse($recentBeneficiaries as $beneficiary)
                        <tr class="hover:bg-brand-50/30 dark:hover:bg-gray-700/30 transition-colors">
                            <td class="px-6 py-4 text-gray-900 dark:text-white font-medium">{{ $beneficiary->name }}</td>
                            <td class="px-6 py-4">{{ $beneficiary->city ?? 'غير محدد' }}</td>
                            <td class="px-6 py-4" dir="ltr">{{ $beneficiary->created_at->format('Y-m-d') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-center text-gray-500">لا يوجد مستفيدين مسجلين حديثاً.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Check Dark Mode for ApexCharts theme
            const isDark = document.documentElement.classList.contains('dark') || 
                           window.matchMedia('(prefers-color-scheme: dark)').matches;
            
            const brandColors = ['#0ea5e9', '#f97316', '#10b981', '#8b5cf6', '#ec4899', '#f43f5e'];

            const chartOptions = {
                chart: { 
                    fontFamily: 'Cairo, sans-serif',
                    toolbar: { show: false },
                    background: 'transparent'
                },
                theme: { mode: isDark ? 'dark' : 'light' },
                colors: brandColors,
                stroke: { colors: ['transparent'], width: 2 }
            };

            // Registrations Line Chart
            const registrationsData = @json($registrations);
            const approvalsData = @json($approvals);
            
            const months = registrationsData.map(item => item.month);
            
            new ApexCharts(document.querySelector("#chart-registrations"), {
                ...chartOptions,
                series: [
                    { name: 'التسجيلات', data: registrationsData.map(item => item.count) },
                    { name: 'الاعتمادات', data: approvalsData.map(item => item.count) }
                ],
                chart: { type: 'area', height: 280, ...chartOptions.chart },
                stroke: { curve: 'smooth', width: 3 },
                fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.4, opacityTo: 0.05, stops: [0, 90, 100] } },
                xaxis: { categories: months },
                dataLabels: { enabled: false }
            }).render();

            // Application Status Donut Chart
            const appStatusData = @json($applications);
            const appLabelsMap = {
                'pending': 'قيد الانتظار',
                'approved': 'معتمد',
                'rejected': 'مرفوض'
            };
            new ApexCharts(document.querySelector("#chart-applications"), {
                ...chartOptions,
                series: appStatusData.map(item => item.count),
                labels: appStatusData.map(item => appLabelsMap[item.status] || item.status),
                chart: { type: 'donut', height: 280, ...chartOptions.chart },
                plotOptions: { pie: { donut: { size: '75%' } } },
                legend: { position: 'bottom', fontFamily: 'Cairo' }
            }).render();

            // Gender Distribution
            const genderData = @json($genders);
            const genderLabelsMap = {
                'male': 'ذكر',
                'female': 'أنثى'
            };
            new ApexCharts(document.querySelector("#chart-gender"), {
                ...chartOptions,
                series: genderData.map(item => item.count),
                labels: genderData.map(item => genderLabelsMap[item.gender] || 'غير محدد'),
                chart: { type: 'pie', height: 250, ...chartOptions.chart },
                legend: { position: 'bottom', fontFamily: 'Cairo' }
            }).render();

            // Age Groups
            const ageData = @json($ageGroups);
            new ApexCharts(document.querySelector("#chart-age"), {
                ...chartOptions,
                series: [{ name: 'العدد', data: ageData.map(item => item.count) }],
                xaxis: { categories: ageData.map(item => item.age_group) },
                chart: { type: 'bar', height: 250, ...chartOptions.chart },
                plotOptions: { bar: { borderRadius: 6, horizontal: false } },
                dataLabels: { enabled: false }
            }).render();

            // Categories
            const catData = @json($categories);
            const catLabelsMap = {
                'education': 'تعليم',
                'health': 'صحة',
                'housing': 'إسكان',
                'food': 'غذاء',
                'financial': 'مالي'
            };
            new ApexCharts(document.querySelector("#chart-categories"), {
                ...chartOptions,
                series: [{ name: 'المشاريع', data: catData.map(item => item.count) }],
                xaxis: { categories: catData.map(item => catLabelsMap[item.category] || item.category) },
                chart: { type: 'bar', height: 250, ...chartOptions.chart },
                plotOptions: { bar: { borderRadius: 6, distributed: true } },
                dataLabels: { enabled: false },
                legend: { show: false }
            }).render();
        });
    </script>
    @endpush
</x-app-layout>
