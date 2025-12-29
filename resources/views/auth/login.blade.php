<x-guest-layout>
    <div class="relative bg-gray-700 px-6 sm:px-10 pb-10">

        <div
            class="absolute top-0 right-0 left-0 h-40 bg-yellow-600 rounded-b-[50%] transform -translate-y-1/2 shadow-2xl">
        </div>

        <div class="text-center pt-10 relative z-10">
            <h1 class="text-3xl font-extrabold text-yellow-400 tracking-wider mb-3">
                تسجيل الدخول
            </h1>
            <p class="text-gray-400 text-sm mt-1">
                الوصول إلى نظام إدارة المطعم
            </p>
        </div>
    </div>

    <div class="p-6 sm:p-8 bg-gray-700">

        <x-auth-session-status class="mb-4 text-center text-green-400" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div dir="rtl" class="mb-5 space-y-1">
                <x-input-label for="email" value="البريد الإلكتروني" class="text-gray-300" />
                <x-text-input id="email"
                    class="block w-full bg-gray-600 border-gray-500 text-white placeholder-gray-400 focus:border-yellow-400 focus:ring-yellow-400 shadow-inner p-3"
                    type="email" name="email" :value="old('email')" autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400" />
            </div>

            <div dir="rtl" class="space-y-1">
                <x-input-label for="password" value="كلمة المرور" class="text-gray-300" />

                <x-text-input id="password"
                    class="block w-full bg-gray-600 border-gray-500 text-white placeholder-gray-400 focus:border-yellow-400 focus:ring-yellow-400 shadow-inner p-3"
                    type="password" name="password" autocomplete="current-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400" />
            </div>
            <div class="block mt-4" dir="rtl">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox"
                        class="rounded border-gray-500 text-yellow-600 shadow-sm focus:ring-yellow-500 bg-gray-600"
                        name="remember">
                    <span class="ms-2 text-sm text-gray-400">تذكرني</span>
                </label>
            </div>

            <div class="flex justify-end mt-2" dir="rtl">
                @if (Route::has('password.request'))
                    <a class="text-sm text-gray-400 hover:text-yellow-400 underline transition duration-150"
                        href="{{ route('password.request') }}">
                        نسيت كلمة المرور؟
                    </a>
                @endif
            </div>


            <div class="flex flex-col space-y-3 mt-6" dir="rtl">

                <button type="submit"
                    class="w-full inline-flex items-center justify-center px-8 py-3 bg-yellow-600 border border-transparent rounded-lg font-bold text-sm text-gray-900 shadow-xl tracking-wider hover:bg-yellow-500 focus:bg-yellow-700 active:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition ease-in-out duration-150 transform hover:scale-[1.01]">
                    تسجيل الدخول
                </button>

            </div>

        </form>
    </div>
</x-guest-layout>
