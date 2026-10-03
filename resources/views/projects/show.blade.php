<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-heading font-bold text-3xl text-gray-900 dark:text-white leading-tight">
                تفاصيل المشروع: {{ $project->title }}
            </h2>
            <div class="flex gap-3">
                <a href="{{ route('projects.edit', $project) }}" class="inline-flex items-center justify-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-xl font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-50 dark:hover:bg-gray-700 transition-all">
                    تعديل المشروع
                </a>
            </div>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Project Details Card -->
        <div class="lg:col-span-1">
            <div class="glass-card rounded-2xl p-6 h-full">
                <h3 class="text-lg font-heading font-semibold text-gray-900 dark:text-white mb-6 border-b border-gray-100 dark:border-gray-800 pb-3">بيانات المشروع</h3>
                
                <dl class="space-y-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">التصنيف</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                            {{ $project->category?->label() ?? 'غير محدد' }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">الحالة</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                            @if($project->status->value === 'active') نشط
                            @elseif($project->status->value === 'planned') مخطط له
                            @else مكتمل @endif
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">الميزانية</dt>
                        <dd class="mt-1 text-lg font-bold text-brand-600 dark:text-brand-400">{{ number_format($project->budget, 2) }} ريال</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">الفترة الزمنية</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white" dir="ltr">
                            {{ $project->start_date ? $project->start_date->format('Y-m-d') : '---' }} 
                            <span class="mx-2 text-gray-400">إلى</span> 
                            {{ $project->end_date ? $project->end_date->format('Y-m-d') : '---' }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">نسبة الإنجاز الزمني</dt>
                        <dd class="mt-2">
                            <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                                <div class="bg-brand-600 h-2.5 rounded-full" style="width: {{ $project->progress() }}%"></div>
                            </div>
                            <span class="text-xs text-gray-500 mt-1 block">{{ $project->progress() }}%</span>
                        </dd>
                    </div>
                    <div class="pt-4 border-t border-gray-100 dark:border-gray-800">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">الوصف</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white leading-relaxed">
                            {{ $project->description ?: 'لا يوجد وصف مضاف لهذا المشروع.' }}
                        </dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Beneficiaries List Card -->
        <div class="lg:col-span-2">
            <div class="glass-card rounded-2xl overflow-hidden h-full flex flex-col">
                <div class="p-6 border-b border-gray-100 dark:border-gray-800 flex justify-between items-center">
                    <h3 class="text-lg font-heading font-semibold text-gray-900 dark:text-white">المستفيدين المشمولين بالمشروع ({{ $project->beneficiaries->count() }})</h3>
                    <button type="button" onclick="document.getElementById('addBeneficiariesModal').showModal()" class="inline-flex items-center justify-center px-4 py-2 bg-brand-600 hover:bg-brand-500 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 transition-all shadow-lg shadow-brand-500/30">
                        إضافة مستفيدين
                    </button>
                </div>
                <div class="overflow-x-auto flex-1">
                    <table class="w-full text-sm text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50/50 dark:bg-gray-700/50 dark:text-gray-400 border-b border-gray-100 dark:border-gray-800">
                            <tr>
                                <th scope="col" class="px-6 py-4 font-medium">الاسم</th>
                                <th scope="col" class="px-6 py-4 font-medium">حالة الدعم</th>
                                <th scope="col" class="px-6 py-4 font-medium">تاريخ الإضافة</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                            @forelse($project->beneficiaries as $beneficiary)
                                <tr class="hover:bg-brand-50/30 dark:hover:bg-gray-700/30 transition-colors">
                                    <td class="px-6 py-4 text-gray-900 dark:text-white font-medium">
                                        <a href="{{ route('beneficiaries.show', $beneficiary) }}" class="hover:text-brand-600 dark:hover:text-brand-400 hover:underline">
                                            {{ $beneficiary->name }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4">
                                        <form action="{{ route('projects.beneficiaries.update_status', [$project, $beneficiary]) }}" method="POST" class="flex items-center gap-2">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status" onchange="this.form.submit()" class="text-xs rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 py-1 px-2 pr-6">
                                                <option value="pending" {{ $beneficiary->pivot->status === 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
                                                <option value="approved" {{ $beneficiary->pivot->status === 'approved' ? 'selected' : '' }}>معتمد</option>
                                                <option value="rejected" {{ $beneficiary->pivot->status === 'rejected' ? 'selected' : '' }}>مرفوض</option>
                                            </select>
                                        </form>
                                    </td>
                                    <td class="px-6 py-4" dir="ltr">{{ $beneficiary->pivot->created_at->format('Y-m-d') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-8 text-center text-gray-500">لا يوجد مستفيدين مسجلين في هذا المشروع حتى الآن.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Beneficiaries Modal -->
    <dialog id="addBeneficiariesModal" class="bg-transparent m-0 p-0 w-full h-full max-w-none max-h-none fixed inset-0 z-50 backdrop:bg-gray-900/50 backdrop:backdrop-blur-sm">
        <div class="fixed inset-0 flex items-center justify-center p-4 pointer-events-none">
            <div class="bg-white dark:bg-gray-800 w-full max-w-lg rounded-2xl shadow-2xl p-6 pointer-events-auto">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-heading font-bold text-gray-900 dark:text-white">إضافة مستفيدين للمشروع</h3>
                    <button type="button" onclick="document.getElementById('addBeneficiariesModal').close()" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300 transition-colors">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                
                <form action="{{ route('projects.beneficiaries.attach', $project) }}" method="POST">
                    @csrf
                    <div class="mb-6">
                        <label for="beneficiaries" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">اختر المستفيدين</label>
                        <select name="beneficiaries[]" id="beneficiaries" multiple required class="w-full">
                            <option value="">ابحث عن مستفيد بالاسم أو الهوية...</option>
                            @foreach($allBeneficiaries as $ben)
                                <option value="{{ $ben->id }}">{{ $ben->name }} ({{ $ben->national_id }})</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-100 dark:border-gray-700">
                        <button type="button" onclick="document.getElementById('addBeneficiariesModal').close()" class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors font-medium text-sm">إلغاء</button>
                        <button type="submit" class="px-4 py-2 bg-brand-600 hover:bg-brand-500 text-white rounded-xl shadow-lg shadow-brand-500/30 transition-all font-medium text-sm">حفظ</button>
                    </div>
                </form>
            </div>
        </div>
    </dialog>

    @push('styles')
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
    <style>
        .ts-control { border-radius: 0.75rem !important; border-color: #d1d5db !important; padding: 0.625rem 1rem !important; box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05) !important; font-family: 'Inter', 'Cairo', sans-serif; }
        .dark .ts-control { background-color: #1f2937 !important; border-color: #374151 !important; color: white !important; }
        .dark .ts-dropdown { background-color: #1f2937 !important; border-color: #374151 !important; color: white !important; }
        .dark .ts-dropdown .option { color: white !important; }
        .dark .ts-dropdown .option:hover, .dark .ts-dropdown .option.active { background-color: #374151 !important; color: white !important; }
        .ts-wrapper.multi .ts-control > div { background-color: #e0f0fe !important; color: #006bc8 !important; border-radius: 0.5rem !important; padding: 0.25rem 0.5rem !important; border: none !important; margin: 0 0.25rem 0.25rem 0 !important; }
        .dark .ts-wrapper.multi .ts-control > div { background-color: #054a87 !important; color: #e0f0fe !important; }
    </style>
    @endpush

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            new TomSelect("#beneficiaries", {
                plugins: ['remove_button'],
                create: false,
                placeholder: 'ابحث عن مستفيد بالاسم أو الهوية...',
            });
        });
    </script>
    @endpush
</x-app-layout>
