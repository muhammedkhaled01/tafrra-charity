<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-heading font-bold text-3xl text-brand-900 dark:text-white">
                إعدادات الجمعية
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">إدارة الشعار، الختم الرسمي، وتواقيع المؤسسين للخطابات والتقارير.</p>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto space-y-6">
        <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- General Settings -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm p-6 md:p-8">
                <h3 class="text-lg font-heading font-bold text-brand-800 dark:text-white mb-6 border-b border-gray-100 dark:border-gray-700 pb-3">البيانات الأساسية</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">رقم الترخيص</label>
                        <input type="text" name="license_number" value="{{ old('license_number', $tenant->license_number) }}" class="w-full rounded-xl border border-gray-300 shadow-sm dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-brand-500 focus:ring-brand-500 text-sm py-2.5 px-3">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <!-- Logo -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">شعار الجمعية</label>
                        @if($tenant->logo)
                            <div class="mb-3">
                                <img src="{{ asset('storage/' . $tenant->logo) }}" alt="Logo" class="h-20 object-contain rounded-lg border border-gray-100 p-2 bg-white">
                            </div>
                        @endif
                        <input type="file" name="logo" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100">
                    </div>

                    <!-- Stamp -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">الختم الرسمي</label>
                        @if($tenant->stamp)
                            <div class="mb-3">
                                <img src="{{ asset('storage/' . $tenant->stamp) }}" alt="Stamp" class="h-20 object-contain rounded-lg border border-gray-100 p-2 bg-white">
                            </div>
                        @endif
                        <input type="file" name="stamp" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100">
                    </div>
                </div>
            </div>

            <!-- Signatures -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm p-6 md:p-8" x-data="signaturesManager()">
                <div class="flex justify-between items-center mb-6 border-b border-gray-100 dark:border-gray-700 pb-3">
                    <h3 class="text-lg font-heading font-bold text-brand-800 dark:text-white">التواقيع والاعتمادات</h3>
                    <button type="button" @click="addSignature()" class="text-sm bg-brand-50 text-brand-600 px-3 py-1.5 rounded-lg hover:bg-brand-100 font-medium">+ إضافة توقيع جديد</button>
                </div>

                <div class="space-y-4">
                    <template x-for="(sig, index) in signatures" :key="index">
                        <div class="p-4 pt-10 border border-gray-100 dark:border-gray-700 rounded-xl bg-gray-50 dark:bg-gray-900/50 relative">
                            <button type="button" @click="removeSignature(index)" class="absolute top-3 left-4 text-red-500 hover:text-red-700 bg-red-50 p-1.5 rounded-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">الاسم</label>
                                    <input type="text" :name="`signatures[${index}][name]`" x-model="sig.name" required class="w-full rounded-lg border border-gray-300 shadow-sm dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-brand-500 focus:ring-brand-500 text-sm py-2 px-3">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">المسمى الوظيفي (مثال: رئيس المجلس)</label>
                                    <input type="text" :name="`signatures[${index}][title]`" x-model="sig.title" class="w-full rounded-lg border border-gray-300 shadow-sm dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-brand-500 focus:ring-brand-500 text-sm py-2 px-3">
                                </div>
                            </div>
                            
                            <div class="mt-4">
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">صورة التوقيع (شفافة PNG يفضل)</label>
                                <template x-if="sig.image">
                                    <div class="mb-2">
                                        <img :src="`{{ asset('storage') }}/${sig.image}`" class="h-12 object-contain bg-white rounded border border-gray-100 p-1">
                                    </div>
                                </template>
                                <input type="file" :name="`signatures[${index}][file]`" accept="image/*" class="text-sm">
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="px-6 py-2.5 bg-brand-600 text-white rounded-xl hover:bg-brand-700 font-medium shadow-lg shadow-brand-500/30">حفظ الإعدادات</button>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('signaturesManager', () => ({
                signatures: @json($tenant->signatures ?? []),
                
                init() {
                    if (this.signatures.length === 0) {
                        this.addSignature();
                    }
                },
                
                addSignature() {
                    this.signatures.push({ name: '', title: '', image: null });
                },
                
                removeSignature(index) {
                    this.signatures.splice(index, 1);
                }
            }));
        });
    </script>
    @endpush
</x-app-layout>
