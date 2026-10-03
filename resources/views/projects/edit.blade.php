<x-app-layout>
    <x-slot name="header">
        <h2 class="font-heading font-bold text-3xl text-gray-900 dark:text-white leading-tight">
            تعديل المشروع: {{ $project->title }}
        </h2>
    </x-slot>

    <div class="glass-card rounded-2xl p-6 mb-8 max-w-4xl mx-auto">
        <form action="{{ route('projects.update', $project) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Title -->
                <div class="md:col-span-2">
                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">اسم المشروع</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $project->title) }}" required
                        class="mt-2 block w-full rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm py-2.5 px-4">
                    @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Category -->
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-300">تصنيف المشروع</label>
                    <select name="category" id="category" required class="mt-2 block w-full rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm py-2.5 px-4">
                        <option value="">اختر التصنيف</option>
                        @foreach(\App\Enums\ProjectCategory::cases() as $cat)
                            <option value="{{ $cat->value }}" {{ old('category', $project->category?->value) == $cat->value ? 'selected' : '' }}>{{ $cat->label() }}</option>
                        @endforeach
                    </select>
                    @error('category') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">حالة المشروع</label>
                    <select name="status" id="status" required class="mt-2 block w-full rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm py-2.5 px-4">
                        <option value="planned" {{ old('status', $project->status?->value) == 'planned' ? 'selected' : '' }}>مخطط له</option>
                        <option value="active" {{ old('status', $project->status?->value) == 'active' ? 'selected' : '' }}>نشط</option>
                        <option value="completed" {{ old('status', $project->status?->value) == 'completed' ? 'selected' : '' }}>مكتمل</option>
                    </select>
                    @error('status') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Budget -->
                <div>
                    <label for="budget" class="block text-sm font-medium text-gray-700 dark:text-gray-300">الميزانية (ريال)</label>
                    <input type="number" step="0.01" name="budget" id="budget" value="{{ old('budget', $project->budget) }}" min="0" required
                        class="mt-2 block w-full rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm py-2.5 px-4">
                    @error('budget') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Start Date -->
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">تاريخ البداية</label>
                    <input type="date" name="start_date" id="start_date" value="{{ old('start_date', $project->start_date ? $project->start_date->format('Y-m-d') : '') }}" required
                        class="mt-2 block w-full rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm py-2.5 px-4" dir="ltr">
                    @error('start_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- End Date -->
                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">تاريخ النهاية المتوقع</label>
                    <input type="date" name="end_date" id="end_date" value="{{ old('end_date', $project->end_date ? $project->end_date->format('Y-m-d') : '') }}" required
                        class="mt-2 block w-full rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm py-2.5 px-4" dir="ltr">
                    @error('end_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Description -->
                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">وصف المشروع</label>
                    <textarea name="description" id="description" rows="4"
                        class="mt-2 block w-full rounded-xl border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm py-2.5 px-4">{{ old('description', $project->description) }}</textarea>
                    @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-gray-100 dark:border-gray-800">
                <a href="{{ route('projects.index') }}" class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors font-medium text-sm">إلغاء</a>
                <button type="submit" class="px-4 py-2 bg-brand-600 hover:bg-brand-500 text-white rounded-xl shadow-lg shadow-brand-500/30 transition-all font-medium text-sm">تحديث المشروع</button>
            </div>
        </form>
    </div>
</x-app-layout>
