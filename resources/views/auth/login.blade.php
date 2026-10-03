<x-guest-layout>
    <div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8 relative overflow-hidden">
        
        <!-- Background Ornaments -->
        <div class="absolute inset-0 z-0 pointer-events-none">
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[800px] h-[500px] bg-brand-200/40 rounded-full blur-[100px] opacity-70"></div>
        </div>

        <div class="sm:mx-auto sm:w-full sm:max-w-md relative z-10">
            <div class="flex justify-center mb-6">
                <!-- Custom Tafrra Logo -->
                <div class="flex items-center gap-3">
                    <svg viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-10 h-10">
                        <rect x="15" y="20" width="70" height="20" rx="10" fill="url(#logoGradLogin)"/>
                        <rect x="40" y="30" width="20" height="55" rx="10" fill="url(#logoGradLogin)"/>
                        <circle cx="80" cy="20" r="12" fill="#e7a42b"/>
                        <defs>
                            <linearGradient id="logoGradLogin" x1="15" y1="20" x2="85" y2="85" gradientUnits="userSpaceOnUse">
                                <stop stop-color="#006bc8"/>
                                <stop offset="1" stop-color="#36a6fa"/>
                            </linearGradient>
                        </defs>
                    </svg>
                    <span class="font-heading font-extrabold text-3xl text-brand-700 tracking-tight">طفرة</span>
                </div>
            </div>
            <h2 class="mt-2 text-center text-2xl font-bold tracking-tight text-gray-900">
                تسجيل الدخول لحسابك
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                لإدارة الجمعيات والمستفيدين
            </p>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md relative z-10">
            <div class="bg-white py-8 px-4 shadow-xl shadow-brand-500/5 sm:rounded-2xl sm:px-10 border border-gray-100">
                <form class="space-y-6" action="{{ route('login.post') }}" method="POST">
                    @csrf
                    
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">البريد الإلكتروني</label>
                        <div class="mt-2">
                            <input id="email" name="email" type="email" autocomplete="email" required class="block w-full rounded-xl border-0 py-2.5 px-4 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-brand-600 sm:text-sm sm:leading-6 transition-all" dir="ltr" value="{{ old('email') }}">
                        </div>
                        @error('email')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">كلمة المرور</label>
                        <div class="mt-2">
                            <input id="password" name="password" type="password" autocomplete="current-password" required class="block w-full rounded-xl border-0 py-2.5 px-4 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-brand-600 sm:text-sm sm:leading-6 transition-all" dir="ltr">
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember" name="remember" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-brand-600 focus:ring-brand-600">
                            <label for="remember" class="mr-2 block text-sm text-gray-900">تذكرني</label>
                        </div>

                        <div class="text-sm">
                            <a href="#" class="font-medium text-brand-600 hover:text-brand-500 transition-colors">نسيت كلمة المرور؟</a>
                        </div>
                    </div>

                    <div>
                        <button type="submit" class="flex w-full justify-center rounded-xl bg-gradient-brand px-3 py-3 text-sm font-semibold text-white shadow-lg shadow-brand-500/30 hover:shadow-brand-500/50 hover:-translate-y-0.5 transition-all focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-600">
                            تسجيل الدخول
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
