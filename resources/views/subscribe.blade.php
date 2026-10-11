<!DOCTYPE html>
<html lang="ar" dir="rtl" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>الاشتراك في الباقة | منصة طفرة</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700;800;900&family=Cairo:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Cairo', 'Inter', sans-serif; }
        .font-heading { font-family: 'Cairo', 'Outfit', sans-serif; }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-gray-900 bg-gray-50 selection:bg-brand-500 selection:text-white">

    <div class="min-h-screen flex flex-col justify-center py-12 sm:px-6 lg:px-8">
        
        <div class="sm:mx-auto sm:w-full sm:max-w-md text-center">
            <a href="{{ route('home') }}" class="inline-block mb-4">
                <svg viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 mx-auto">
                    <rect x="15" y="20" width="70" height="20" rx="10" fill="url(#logoGradNav)"/>
                    <rect x="40" y="30" width="20" height="55" rx="10" fill="url(#logoGradNav)"/>
                    <circle cx="80" cy="20" r="12" fill="#e7a42b"/>
                    <defs>
                        <linearGradient id="logoGradNav" x1="15" y1="20" x2="85" y2="85" gradientUnits="userSpaceOnUse">
                            <stop stop-color="#006bc8"/>
                            <stop offset="1" stop-color="#36a6fa"/>
                        </linearGradient>
                    </defs>
                </svg>
            </a>
            <h2 class="mt-2 text-center text-3xl font-heading font-extrabold text-gray-900">
                الاشتراك في <span class="text-brand-600">{{ $subscription->name }}</span>
            </h2>
            <p class="mt-2 text-center text-gray-600">
                سعر الباقة: <strong class="text-gray-900">{{ number_format($subscription->price) }} ريال</strong>
            </p>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-2xl">
            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 p-6 rounded-xl shadow-sm mb-6 text-center">
                    <div class="flex items-center justify-center mb-2">
                        <svg class="w-10 h-10 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <p class="text-green-800 text-lg font-bold">{{ session('success') }}</p>
                    <a href="{{ route('home') }}" class="mt-4 inline-block text-brand-600 hover:underline">العودة للرئيسية</a>
                </div>
            @else

            <div class="bg-white py-8 px-4 shadow-xl shadow-gray-200/50 sm:rounded-3xl sm:px-10 border border-gray-100">
                
                <div class="bg-brand-50 border border-brand-100 rounded-xl p-6 mb-8 text-center">
                    <h3 class="text-lg font-bold text-brand-800 mb-2">معلومات التحويل البنكي</h3>
                    <p class="text-brand-600 mb-4 text-sm">الرجاء إتمام عملية التحويل البنكي على الحساب التالي ثم إرفاق الإيصال بالأسفل.</p>
                    
                    <div class="bg-white p-4 rounded-lg shadow-sm inline-block text-left w-full max-w-sm mx-auto dir-ltr border border-gray-100">
                        <div class="flex justify-between items-center mb-2 border-b border-gray-50 pb-2">
                            <span class="text-gray-500 text-xs uppercase font-bold">Bank</span>
                            <span class="text-gray-900 font-bold text-sm">{{ $settings->bank_name ?? 'البنك الأهلي السعودي (SNB)' }}</span>
                        </div>
                        <div class="flex justify-between items-center mb-2 border-b border-gray-50 pb-2">
                            <span class="text-gray-500 text-xs uppercase font-bold">Account Name</span>
                            <span class="text-gray-900 font-bold text-sm">{{ $settings->bank_account_name ?? 'مؤسسة طفرة لتقنية المعلومات' }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-500 text-xs uppercase font-bold">IBAN</span>
                            <span class="text-gray-900 font-bold text-sm">{{ $settings->bank_iban ?? 'SA00 1000 0000 0000 0000 0000' }}</span>
                        </div>
                    </div>
                </div>

                <form action="{{ route('subscribe.store', $subscription->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="charity_name" class="block text-sm font-medium text-gray-700">اسم الجمعية</label>
                            <div class="mt-1">
                                <input id="charity_name" name="charity_name" type="text" required value="{{ old('charity_name') }}" class="appearance-none block w-full px-3 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-brand-500 focus:border-brand-500 sm:text-sm">
                            </div>
                            @error('charity_name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="manager_name" class="block text-sm font-medium text-gray-700">اسم المدير / المندوب</label>
                            <div class="mt-1">
                                <input id="manager_name" name="manager_name" type="text" required value="{{ old('manager_name') }}" class="appearance-none block w-full px-3 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-brand-500 focus:border-brand-500 sm:text-sm">
                            </div>
                            @error('manager_name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">البريد الإلكتروني (للدخول لاحقاً)</label>
                            <div class="mt-1">
                                <input id="email" name="email" type="email" required value="{{ old('email') }}" class="appearance-none block w-full px-3 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-brand-500 focus:border-brand-500 sm:text-sm text-left" dir="ltr">
                            </div>
                            @error('email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700">رقم الجوال</label>
                            <div class="mt-1">
                                <input id="phone" name="phone" type="text" required value="{{ old('phone') }}" class="appearance-none block w-full px-3 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-brand-500 focus:border-brand-500 sm:text-sm text-left" dir="ltr">
                            </div>
                            @error('phone') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">كلمة المرور (للدخول لاحقاً)</label>
                            <div class="mt-1">
                                <input id="password" name="password" type="password" required class="appearance-none block w-full px-3 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-brand-500 focus:border-brand-500 sm:text-sm text-left" dir="ltr">
                            </div>
                            @error('password') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                        
                        <div class="col-span-1 md:col-span-2">
                            <label for="transfer_receipt" class="block text-sm font-medium text-gray-700">إيصال التحويل (صورة أو سكرين شوت)</label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg bg-gray-50 hover:bg-gray-100 transition-colors">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600 justify-center">
                                        <label for="transfer_receipt" class="relative cursor-pointer bg-white rounded-md font-medium text-brand-600 hover:text-brand-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-brand-500 px-2 py-1">
                                            <span>رفع صورة</span>
                                            <input id="transfer_receipt" name="transfer_receipt" type="file" class="sr-only" accept="image/*" required>
                                        </label>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG, GIF up to 5MB</p>
                                </div>
                            </div>
                            @error('transfer_receipt') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div>
                        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-lg font-bold text-white bg-brand-600 hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500 transition-colors">
                            تأكيد وإرسال الطلب
                        </button>
                    </div>
                </form>
            </div>
            @endif
        </div>
    </div>

</body>
</html>
