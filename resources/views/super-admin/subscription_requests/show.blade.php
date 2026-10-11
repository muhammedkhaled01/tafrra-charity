<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('super-admin.subscription-requests.index') }}" class="text-gray-500 hover:text-gray-900 dark:hover:text-white transition">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </a>
            <div>
                <h2 class="font-heading font-bold text-3xl text-gray-900 dark:text-white leading-tight">
                    تفاصيل طلب الاشتراك #{{ $subscriptionRequest->id }}
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">مراجعة بيانات الطلب وإيصال التحويل.</p>
            </div>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Request Details -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="p-6 border-b border-gray-100 dark:border-gray-800">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">معلومات الجمعية والمندوب</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <span class="block text-sm text-gray-500 dark:text-gray-400 mb-1">اسم الجمعية</span>
                            <span class="block text-lg font-bold text-gray-900 dark:text-white">{{ $subscriptionRequest->charity_name }}</span>
                        </div>
                        <div>
                            <span class="block text-sm text-gray-500 dark:text-gray-400 mb-1">اسم المدير / المندوب</span>
                            <span class="block text-lg font-bold text-gray-900 dark:text-white">{{ $subscriptionRequest->manager_name }}</span>
                        </div>
                        <div>
                            <span class="block text-sm text-gray-500 dark:text-gray-400 mb-1">البريد الإلكتروني</span>
                            <span class="block text-base text-gray-900 dark:text-white" dir="ltr">{{ $subscriptionRequest->email }}</span>
                        </div>
                        <div>
                            <span class="block text-sm text-gray-500 dark:text-gray-400 mb-1">رقم الجوال</span>
                            <span class="block text-base text-gray-900 dark:text-white" dir="ltr">{{ $subscriptionRequest->phone }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="p-6 border-b border-gray-100 dark:border-gray-800">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">إيصال التحويل المرفق</h3>
                </div>
                <div class="p-6">
                    <div class="rounded-xl border border-gray-200 overflow-hidden max-w-full">
                        <img src="{{ Storage::url($subscriptionRequest->transfer_receipt) }}" alt="Receipt" class="w-full h-auto object-contain max-h-[600px]">
                    </div>
                    <div class="mt-4 flex justify-end">
                        <a href="{{ Storage::url($subscriptionRequest->transfer_receipt) }}" target="_blank" class="inline-flex items-center text-brand-600 hover:text-brand-700 font-medium text-sm">
                            <svg class="w-4 h-4 ml-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            فتح الصورة في نافذة جديدة
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar / Actions -->
        <div class="space-y-6">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="p-6 border-b border-gray-100 dark:border-gray-800">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">تفاصيل الباقة المطلوبة</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex justify-between items-center py-2 border-b border-gray-50">
                        <span class="text-gray-500">الباقة</span>
                        <span class="font-bold text-gray-900">{{ $subscriptionRequest->subscription->name }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-50">
                        <span class="text-gray-500">السعر</span>
                        <span class="font-bold text-gray-900">{{ number_format($subscriptionRequest->subscription->price) }} ريال</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-50">
                        <span class="text-gray-500">تاريخ الطلب</span>
                        <span class="font-bold text-gray-900" dir="ltr">{{ $subscriptionRequest->created_at->format('Y-m-d H:i') }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2">
                        <span class="text-gray-500">حالة الطلب</span>
                        @if($subscriptionRequest->status === 'pending')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-50 text-yellow-800 border border-yellow-200">قيد المراجعة</span>
                        @elseif($subscriptionRequest->status === 'approved')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-800 border border-green-200">مقبول</span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-50 text-red-800 border border-red-200">مرفوض</span>
                        @endif
                    </div>
                </div>
            </div>

            @if($subscriptionRequest->status === 'pending')
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                    <div class="p-6 border-b border-gray-100 dark:border-gray-800">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">القرار (Action)</h3>
                    </div>
                    <div class="p-6 space-y-3">
                        <form action="{{ route('super-admin.subscription-requests.approve', $subscriptionRequest) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                                <svg class="w-5 h-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                قبول الطلب وإنشاء حساب
                            </button>
                        </form>
                        
                        <form action="{{ route('super-admin.subscription-requests.reject', $subscriptionRequest) }}" method="POST" onsubmit="confirmDelete(event, this, 'هذا الطلب بالرفض')">
                            @csrf
                            <button type="submit" class="w-full flex justify-center items-center py-3 px-4 border border-gray-300 rounded-xl shadow-sm text-sm font-bold text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500 transition-colors">
                                <svg class="w-5 h-5 ml-2 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                رفض الطلب
                            </button>
                        </form>
                        <p class="text-xs text-gray-500 mt-4 text-center">
                            عند قبول الطلب سيتم إنشاء حساب (Tenant) واسم مستخدم للجمعية بشكل تلقائي بصلاحيات الإدارة لتتمكن الجمعية من تسجيل الدخول.
                        </p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
