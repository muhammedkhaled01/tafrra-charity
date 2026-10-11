<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-heading font-bold text-3xl text-brand-900 dark:text-white">
                    الخطابات والعقود
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">إنشاء وتصدير وإدارة الخطابات والعقود الخاصة بالجمعية.</p>
            </div>
            <a href="{{ route('documents.create') }}" class="inline-flex items-center gap-2 bg-brand-800 hover:bg-brand-700 text-white px-5 py-2.5 rounded-xl transition-colors shadow-lg shadow-brand-900/20 text-sm font-medium">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                إنشاء خطاب جديد
            </a>
        </div>
    </x-slot>

    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden">
        @if($documents->isNotEmpty())
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-400 uppercase bg-gray-50/50 dark:bg-gray-900/50">
                        <tr>
                            <th scope="col" class="px-6 py-4 font-medium text-gray-500">عنوان الخطاب</th>
                            <th scope="col" class="px-6 py-4 font-medium text-gray-500">رقم الصادر</th>
                            <th scope="col" class="px-6 py-4 font-medium text-gray-500">تاريخ الخطاب</th>
                            <th scope="col" class="px-6 py-4 font-medium text-gray-500 text-left">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        @foreach($documents as $doc)
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/50 transition-colors">
                                <td class="px-6 py-4 text-gray-900 dark:text-white font-medium">{{ $doc->title }}</td>
                                <td class="px-6 py-4">{{ $doc->reference_number ?? '---' }}</td>
                                <td class="px-6 py-4">{{ $doc->document_date ? $doc->document_date->format('Y/m/d') : '---' }}</td>
                                <td class="px-6 py-4 text-left">
                                    <div class="flex items-center justify-end gap-2">
                                        <!-- View PDF -->
                                        <a href="{{ route('documents.pdf', $doc) }}" target="_blank" class="p-2 text-red-600 bg-red-50 rounded-lg hover:bg-red-100 transition-colors" title="عرض كـ PDF">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                        </a>
                                        <!-- Edit -->
                                        <a href="{{ route('documents.edit', $doc) }}" class="p-2 text-brand-600 bg-brand-50 rounded-lg hover:bg-brand-100 transition-colors" title="تعديل">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                        </a>
                                        <!-- Delete -->
                                        <form action="{{ route('documents.destroy', $doc) }}" method="POST" class="inline-block" onsubmit="confirmDelete(event, this, 'هذا الخطاب');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-red-600 bg-red-50 rounded-lg hover:bg-red-100 transition-colors" title="حذف">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($documents->hasPages())
                <div class="p-4 border-t border-gray-100 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-900/30">
                    {{ $documents->links() }}
                </div>
            @endif
        @else
            <!-- Empty State -->
            <div class="flex flex-col items-center justify-center py-20 px-4 text-center">
                <div class="w-16 h-16 bg-brand-50 rounded-2xl flex items-center justify-center text-brand-600 mb-6 shadow-sm">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <h4 class="text-xl font-heading font-bold text-brand-900 dark:text-white mb-2">لا توجد خطابات</h4>
                <p class="text-gray-500 text-sm max-w-md mb-6">ابدأ بإنشاء أول خطاب أو عقد للجمعية.</p>
                <a href="{{ route('documents.create') }}" class="px-6 py-2.5 bg-brand-800 text-white rounded-xl hover:bg-brand-700 font-medium text-sm">إنشاء خطاب</a>
            </div>
        @endif
    </div>
</x-app-layout>
