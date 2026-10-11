<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center w-full">
            <div>
                <h2 class="font-heading font-bold text-3xl text-gray-900 dark:text-white leading-tight">
                    إدارة باقات الاشتراك
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">تحديد الباقات المتاحة للجمعيات، وأسعارها وحدودها.</p>
            </div>
            <div>
                <a href="{{ route('super-admin.subscriptions.create') }}" class="px-5 py-2.5 bg-brand-600 text-white rounded-xl hover:bg-brand-700 transition font-medium shadow-lg shadow-brand-500/30 flex items-center">
                    <svg class="w-5 h-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    إضافة باقة جديدة
                </a>
            </div>
        </div>
    </x-slot>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50/50 text-green-700 text-sm rounded-xl border border-green-100 flex items-center">
            <svg class="w-5 h-5 ml-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-6 p-4 bg-red-50/50 text-red-700 text-sm rounded-xl border border-red-100 flex items-center">
            <svg class="w-5 h-5 ml-2 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($subscriptions as $subscription)
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden flex flex-col transition hover:shadow-md hover:border-brand-300 dark:hover:border-brand-700 relative">
                
                @if($subscription->tenants_count > 0)
                    <div class="absolute top-4 left-4 bg-green-100 dark:bg-green-900/40 text-green-700 dark:text-green-400 text-xs font-bold px-3 py-1 rounded-full flex items-center">
                        <div class="w-2 h-2 rounded-full bg-green-500 ml-1.5 animate-pulse"></div>
                        {{ $subscription->tenants_count }} جمعية مشتركة
                    </div>
                @endif

                <div class="p-6 md:p-8 flex-1">
                    <h3 class="text-2xl font-black text-gray-900 dark:text-white mb-2">{{ $subscription->name }}</h3>
                    
                    <div class="flex items-baseline mb-6">
                        <span class="text-4xl font-extrabold text-brand-600 dark:text-brand-400">{{ rtrim(rtrim(number_format($subscription->price, 2), '0'), '.') }}</span>
                        <span class="text-gray-500 dark:text-gray-400 font-medium mr-2">ريال / شهرياً</span>
                    </div>

                    <div class="mb-6 pb-6 border-b border-gray-100 dark:border-gray-700">
                        <div class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3 flex items-center">
                            <svg class="w-5 h-5 ml-1.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            الحد الأقصى للمستفيدين:
                            <span class="mr-2 px-2.5 py-0.5 rounded bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-white">
                                {{ $subscription->max_beneficiaries == -1 ? 'غير محدود' : number_format($subscription->max_beneficiaries) }}
                            </span>
                        </div>
                    </div>

                    <ul class="space-y-3 mb-8">
                        @foreach(\App\Enums\SubscriptionFeature::cases() as $feature)
                            @php
                                $isAvailable = is_array($subscription->features) && isset($subscription->features[$feature->value]) && $subscription->features[$feature->value] === true;
                            @endphp
                            <li class="flex items-start">
                                @if($isAvailable)
                                    <svg class="w-5 h-5 text-green-500 ml-2 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                @else
                                    <svg class="w-5 h-5 text-red-400 ml-2 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                                @endif
                                <span class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed {{ !$isAvailable ? 'line-through opacity-75' : '' }}">
                                    {{ $feature->label() }}
                                </span>
                            </li>
                        @endforeach
                    </ul>
                </div>
                
                <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-t border-gray-100 dark:border-gray-700 flex justify-end gap-2">
                    <a href="{{ route('super-admin.subscriptions.edit', $subscription) }}" class="px-4 py-2 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 text-sm font-medium border border-gray-200 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 transition flex items-center">
                        <svg class="w-4 h-4 ml-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        تعديل الباقة
                    </a>
                    
                    <form action="{{ route('super-admin.subscriptions.destroy', $subscription) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذه الباقة نهائياً؟');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-white dark:bg-gray-700 text-red-600 dark:text-red-400 text-sm font-medium border border-gray-200 dark:border-gray-600 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20 transition flex items-center">
                            <svg class="w-4 h-4 ml-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            حذف
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-1 md:col-span-2 lg:col-span-3 bg-white dark:bg-gray-800 rounded-2xl p-12 text-center border border-dashed border-gray-300 dark:border-gray-700">
                <svg class="w-16 h-16 mx-auto text-gray-300 dark:text-gray-600 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">لا توجد باقات حالياً</h3>
                <p class="text-gray-500 dark:text-gray-400 mb-6">لم تقم بإضافة أي باقة اشتراك للجمعيات بعد.</p>
                <a href="{{ route('super-admin.subscriptions.create') }}" class="inline-flex px-6 py-3 bg-brand-600 text-white rounded-xl hover:bg-brand-700 transition font-medium">
                    إضافة أول باقة
                </a>
            </div>
        @endforelse
    </div>
    
    @if($subscriptions->hasPages())
        <div class="mt-8">
            {{ $subscriptions->links() }}
        </div>
    @endif
</x-app-layout>
