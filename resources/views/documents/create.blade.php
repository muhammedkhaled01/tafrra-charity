<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('documents.index') }}" class="p-2 bg-white dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-700 hover:bg-gray-50 transition-colors shadow-sm">
                <svg class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </a>
            <div>
                <h2 class="font-heading font-bold text-3xl text-brand-900 dark:text-white">
                    إنشاء خطاب أو عقد
                </h2>
            </div>
        </div>
    </x-slot>

    @push('styles')
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <style>
        /* Quill Toolbar Styling */
        .ql-toolbar.ql-snow {
            border: 1px solid #e5e7eb !important;
            border-radius: 0.75rem;
            background: #f9fafb;
            direction: ltr;
            margin-bottom: 2rem;
            padding: 0.75rem;
        }
        .dark .ql-toolbar.ql-snow {
            border-color: #374151 !important;
            background: #1f2937;
        }
        .dark .ql-stroke { stroke: #d1d5db; }
        .dark .ql-fill { fill: #d1d5db; }
        .dark .ql-picker { color: #d1d5db; }

        /* A4 Paper Styling */
        .paper-preview {
            background-color: white;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
            max-width: 210mm;
            margin: 0 auto;
            border-radius: 4px;
            padding: 10mm 15mm;
            border: 1px solid #d1d5db;
            direction: rtl;
        }
        .dark .paper-preview {
            background-color: #f9fafb;
            color: #111827;
        }

        /* Quill Container inside Paper */
        .ql-container.ql-snow {
            border: none !important;
        }
        .ql-editor {
            min-height: 300px;
            font-family: 'freeserif', 'sans-serif', 'Arial';
            font-size: 16pt;
            line-height: 1.6;
            padding: 0;
            color: #000;
            direction: rtl;
            text-align: right;
        }
        .ql-editor.ql-blank::before {
            color: #9ca3af;
            font-style: normal;
        }
    </style>
    @endpush

    <form action="{{ route('documents.store') }}" method="POST" class="max-w-4xl mx-auto space-y-6">
        @csrf

        <!-- Meta Data -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm p-6 md:p-8">
            <h3 class="text-lg font-heading font-bold text-brand-800 dark:text-white mb-6 border-b border-gray-100 dark:border-gray-700 pb-3">بيانات الترويسة (الرأس)</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Title -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">عنوان الخطاب / العقد (داخلي فقط للتمييز) <span class="text-red-500">*</span></label>
                    <input type="text" name="title" id="input-title" required value="{{ old('title') }}" class="w-full rounded-xl border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 focus:border-brand-500 focus:ring-brand-500 text-sm py-2.5">
                    @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Reference Number -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">الرقم (رقم الصادر)</label>
                    <input type="text" name="reference_number" id="input-reference" value="{{ old('reference_number') }}" class="w-full rounded-xl border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 focus:border-brand-500 focus:ring-brand-500 text-sm py-2.5">
                </div>

                <!-- Date -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">التاريخ (متغير - يظهر في الترويسة)</label>
                    <input type="date" name="document_date" id="input-date" value="{{ old('document_date', date('Y-m-d')) }}" class="w-full rounded-xl border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 focus:border-brand-500 focus:ring-brand-500 text-sm py-2.5 text-right">
                </div>

                <!-- Attachments -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">المشفوعات</label>
                    <input type="text" name="attachments_text" id="input-attachments" value="{{ old('attachments_text') }}" class="w-full rounded-xl border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 focus:border-brand-500 focus:ring-brand-500 text-sm py-2.5">
                </div>

                <!-- Subject -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">الموضوع</label>
                    <input type="text" name="subject" id="input-subject" value="{{ old('subject') }}" class="w-full rounded-xl border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 focus:border-brand-500 focus:ring-brand-500 text-sm py-2.5">
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm p-6 md:p-8">
            <div class="flex items-center justify-between mb-6 border-b border-gray-100 dark:border-gray-700 pb-3">
                <h3 class="text-lg font-heading font-bold text-brand-800 dark:text-white">محتوى الخطاب ومعاينة الطباعة</h3>
                <span class="px-3 py-1 bg-blue-50 text-blue-700 rounded-full text-xs font-medium border border-blue-100">يظهر كما سيتم طباعته</span>
            </div>
            
            <div class="editor-wrapper-for-toolbar relative overflow-hidden pb-10">
                <input type="hidden" name="content" id="content_input" value="{{ old('content') }}">
                
                <div class="paper-preview">
                    <!-- Live Header -->
                    <div class="flex justify-between items-start mb-8 pb-4 border-b border-gray-200 text-black">
                        <!-- Right side -->
                        <div class="text-right text-xs md:text-sm leading-relaxed w-1/3">
                            <p class="font-bold">المملكة العربية السعودية</p>
                            <p class="font-bold text-brand-800">{{ $tenant->name }}</p>
                            @if($tenant->license_number)
                                <p>رقم الترخيص / {{ $tenant->license_number }}</p>
                            @endif
                            <p class="text-[10px] md:text-xs text-gray-600 mt-1">تحت إشراف المركز الوطني لتنمية القطاع غير الربحي</p>
                        </div>
                        
                        <!-- Center Logo -->
                        <div class="w-1/3 flex justify-center">
                            @if($tenant->logo)
                                <img src="{{ asset('storage/' . $tenant->logo) }}" class="h-20 md:h-24 object-contain" alt="شعار الجمعية">
                            @endif
                        </div>
                        
                        <!-- Left side -->
                        <div class="w-1/3 text-xs md:text-sm flex justify-end text-gray-900">
                            <div dir="rtl" class="text-right whitespace-nowrap">
                                <div class="mb-1"><span class="font-bold inline-block min-w-[70px]">الرقم</span> : <span id="preview-reference" dir="auto">{{ old('reference_number') ?: '................' }}</span></div>
                                <div class="mb-1"><span class="font-bold inline-block min-w-[70px]">التاريخ</span> : <span id="preview-date" dir="auto">{{ old('document_date', date('Y/m/d')) ?: '................' }}</span></div>
                                <div class="mb-1"><span class="font-bold inline-block min-w-[70px]">المشفوعات</span> : <span id="preview-attachments" dir="auto">{{ old('attachments_text') ?: '................' }}</span></div>
                                <div class="mb-1"><span class="font-bold inline-block min-w-[70px]">الموضوع</span> : <span id="preview-subject" dir="auto">{{ old('subject') ?: '................' }}</span></div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Title -->
                    <div class="text-center font-bold text-xl mb-8 underline text-gray-900" id="preview-title" style="display: {{ old('title') ? 'block' : 'none' }}">
                        {{ old('title') }}
                    </div>

                    <div id="editor"></div>
                </div>
                @error('content') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
            </div>
        </div>

        <!-- Signatures Selection -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm p-6 md:p-8">
            <h3 class="text-lg font-heading font-bold text-brand-800 dark:text-white mb-6 border-b border-gray-100 dark:border-gray-700 pb-3">اعتمادات وتواقيع التذييل</h3>
            <p class="text-sm text-gray-500 mb-4">اختر التواقيع التي ترغب في إظهارها أسفل هذا الخطاب مع الختم الرسمي.</p>
            
            @if($tenant->signatures && is_array($tenant->signatures) && count($tenant->signatures) > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($tenant->signatures as $index => $sig)
                        <label class="flex items-start p-4 border border-gray-200 dark:border-gray-700 rounded-xl cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-900/50 transition-colors">
                            <div class="flex items-center h-5">
                                <input name="signatures[]" type="checkbox" value="{{ $index }}" class="w-4 h-4 text-brand-600 bg-gray-100 border-gray-300 rounded focus:ring-brand-500 focus:ring-2">
                            </div>
                            <div class="mr-3 text-sm">
                                <span class="font-medium text-gray-900 dark:text-white block">{{ $sig['name'] }}</span>
                                <span class="text-gray-500 dark:text-gray-400 block">{{ $sig['title'] }}</span>
                            </div>
                        </label>
                    @endforeach
                </div>
            @else
                <div class="p-4 bg-yellow-50 text-yellow-800 rounded-xl text-sm">
                    لم تقم بإضافة أي تواقيع للجمعية حتى الآن. <a href="{{ route('settings.edit') }}" class="underline font-bold">انتقل للإعدادات لإضافتها.</a>
                </div>
            @endif
        </div>

        <div class="flex justify-end">
            <button type="submit" class="px-6 py-3 bg-brand-600 text-white rounded-xl hover:bg-brand-700 font-medium shadow-lg shadow-brand-500/30">حفظ وإنشاء</button>
        </div>
    </form>

    @push('scripts')
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var quill = new Quill('#editor', {
                theme: 'snow',
                placeholder: 'اكتب نص الخطاب هنا...',
                modules: {
                    toolbar: [
                        [{ 'header': [1, 2, 3, 4, 5, 6, false] }, { 'size': ['small', false, 'large', 'huge'] }],
                        ['bold', 'italic', 'underline', 'strike'],
                        [{ 'color': [] }, { 'background': [] }],
                        [{ 'align': [] }],
                        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                        [{ 'indent': '-1'}, { 'indent': '+1' }, { 'direction': 'rtl' }],
                        ['clean']
                    ]
                }
            });
            
            // Move toolbar outside the paper preview
            var toolbar = document.querySelector('.ql-toolbar');
            var editorWrapper = document.querySelector('.editor-wrapper-for-toolbar');
            if(toolbar && editorWrapper) {
                editorWrapper.insertBefore(toolbar, editorWrapper.firstChild);
            }

            // Set old content if validation failed
            var oldContent = document.getElementById('content_input').value;
            if (oldContent) {
                quill.root.innerHTML = oldContent;
            } else {
                quill.format('direction', 'rtl');
                quill.format('align', 'right');
            }

            // Sync content on change
            quill.on('text-change', function() {
                var html = quill.root.innerHTML;
                if (html === '<p><br></p>' || html === '<p class="ql-align-right ql-direction-rtl"><br></p>') html = '';
                document.getElementById('content_input').value = html;
            });

            // Live Preview Sync
            function syncPreview(inputId, previewId, fallback = '................') {
                const input = document.getElementById(inputId);
                const preview = document.getElementById(previewId);
                if(input && preview) {
                    input.addEventListener('input', function() {
                        preview.textContent = this.value || fallback;
                    });
                }
            }

            syncPreview('input-reference', 'preview-reference');
            syncPreview('input-attachments', 'preview-attachments');
            syncPreview('input-subject', 'preview-subject');
            
            // Date formatting for preview
            const dateInput = document.getElementById('input-date');
            const datePreview = document.getElementById('preview-date');
            if(dateInput && datePreview) {
                dateInput.addEventListener('input', function() {
                    let val = this.value;
                    if(val) {
                        // format to yyyy/mm/dd
                        val = val.replace(/-/g, '/');
                    }
                    datePreview.textContent = val || '................';
                });
            }

            const titleInput = document.getElementById('input-title');
            const titlePreview = document.getElementById('preview-title');
            if(titleInput && titlePreview) {
                titleInput.addEventListener('input', function() {
                    titlePreview.textContent = this.value;
                    titlePreview.style.display = this.value ? 'block' : 'none';
                });
            }

            // Trigger initial sync to catch browser autofill/refreshed values
            ['input-reference', 'input-attachments', 'input-subject', 'input-date', 'input-title'].forEach(id => {
                const el = document.getElementById(id);
                if (el) el.dispatchEvent(new Event('input'));
            });
        });
    </script>
    @endpush
</x-app-layout>
