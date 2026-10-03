<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-heading font-bold text-3xl text-gray-900 dark:text-white leading-tight">
                المشاريع
            </h2>
            <a href="{{ route('projects.create') }}" class="inline-flex items-center justify-center px-4 py-2 bg-brand-600 hover:bg-brand-500 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 transition-all shadow-lg shadow-brand-500/30">
                إضافة مشروع
            </a>
        </div>
    </x-slot>

    <div class="glass-card rounded-2xl overflow-hidden mb-8">
        <div class="p-6 border-b border-gray-100 dark:border-gray-800 flex justify-between items-center">
            <h3 class="text-lg font-heading font-semibold text-gray-900 dark:text-white">قائمة مشاريع الجمعية</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50/50 dark:bg-gray-700/50 dark:text-gray-400 border-b border-gray-100 dark:border-gray-800">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-medium">اسم المشروع</th>
                        <th scope="col" class="px-6 py-4 font-medium">التصنيف</th>
                        <th scope="col" class="px-6 py-4 font-medium">الميزانية</th>
                        <th scope="col" class="px-6 py-4 font-medium">تاريخ البداية</th>
                        <th scope="col" class="px-6 py-4 font-medium">الحالة</th>
                        <th scope="col" class="px-6 py-4 font-medium text-left">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse($projects as $project)
                        <tr class="hover:bg-brand-50/30 dark:hover:bg-gray-700/30 transition-colors">
                            <td class="px-6 py-4 text-gray-900 dark:text-white font-medium">{{ $project->title }}</td>
                            <td class="px-6 py-4">
                                {{ $project->category?->label() ?? 'غير محدد' }}
                            </td>
                            <td class="px-6 py-4">{{ number_format($project->budget, 2) }} ريال</td>
                            <td class="px-6 py-4" dir="ltr">{{ $project->start_date ? $project->start_date->format('Y-m-d') : '---' }}</td>
                            <td class="px-6 py-4">
                                @if($project->status->value === 'active')
                                    <span class="px-2.5 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">نشط</span>
                                @elseif($project->status->value === 'planned')
                                    <span class="px-2.5 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">مخطط له</span>
                                @else
                                    <span class="px-2.5 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400">مكتمل</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-left">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('projects.show', $project) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">عرض</a>
                                    <a href="{{ route('projects.edit', $project) }}" class="text-brand-600 hover:text-brand-900 dark:text-brand-400 dark:hover:text-brand-300">تعديل</a>
                                    <form action="{{ route('projects.destroy', $project) }}" method="POST" class="inline-block" onsubmit="confirmDelete(event, this, 'هذا المشروع');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">حذف</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">لا يوجد مشاريع مسجلة حتى الآن.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($projects->hasPages())
            <div class="p-4 border-t border-gray-100 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-800/50">
                {{ $projects->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
