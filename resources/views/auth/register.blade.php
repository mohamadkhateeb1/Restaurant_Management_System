<x-guest-layout>

    {{-- الشريط العلوي الأنيق (Hero Header) --}}
    <div class="relative bg-gray-800 px-6 sm:px-10 py-5 sm:rounded-t-lg">
        <div class="text-center">
            <h1 class="text-3xl font-extrabold text-sky-400 tracking-wider">تسجيل حساب جديد</h1>
            <p class="text-gray-400 text-sm mt-1"> الرجاء إدخال بياناتك </p>
        </div>
    </div>
    <div class="p-6 sm:p-8 bg-gray-700">
        <form method="POST" action="{{ route('register') }}">
            @csrf
            {{-- حقل الاسم --}}
            <div dir="rtl" class="space-y-1">
                <x-input-label for="name" value="الاسم الكامل" class="text-white" />
                <x-text-input id="name"
                    class="block w-full bg-gray-600 border-gray-500 text-gray-100 placeholder-gray-400 focus:border-sky-400 focus:ring-sky-400 shadow-inner p-3"
                    type="text" name="name" :value="old('name')"  autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')"
                    class="mt-2 text-red-400 bg-red-900/30 border-r-4 border-red-500 p-2 rounded-sm mb-4" />
            </div>

            {{-- حقل البريد الإلكتروني --}}
            <div class="mt-4 space-y-1" dir="rtl">
                <x-input-label for="email" value="البريد الإلكتروني" class="text-white" />
                <x-text-input id="email"
                    class="block w-full bg-gray-600 border-gray-500 text-gray-100 placeholder-gray-400 focus:border-sky-400 focus:ring-sky-400 shadow-inner p-3"
                    type="email" name="email" :value="old('email')"  autocomplete="username" />
                <x-input-error :messages="$errors->get('email')"
                    class="mt-2 text-red-400 bg-red-900/30 border-r-4 border-red-500 p-2 rounded-sm mb-4" />
            </div>

            {{-- حقل كلمة المرور --}}
            <div class="mt-4 space-y-1" dir="rtl">
                <x-input-label for="password" value="كلمة المرور" class="text-white" />
                <x-text-input id="password"
                    class="block w-full bg-gray-600 border-gray-500 text-gray-100 placeholder-gray-400 focus:border-sky-400 focus:ring-sky-400 shadow-inner p-3"
                    type="password" name="password"  autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password')"
                    class="mt-2 text-red-400 bg-red-900/30 border-r-4 border-red-500 p-2 rounded-sm mb-4" />
            </div>

            {{-- حقل تأكيد كلمة المرور --}}
            <div class="mt-4 space-y-1" dir="rtl">
                <x-input-label for="password_confirmation" value="تأكيد كلمة المرور" class="text-white" />
                <x-text-input id="password_confirmation"
                    class="block w-full bg-gray-600 border-gray-500 text-gray-100 placeholder-gray-400 focus:border-sky-400 focus:ring-sky-400 shadow-inner p-3"
                    type="password" name="password_confirmation" autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password_confirmation')"
                    class="mt-2 text-red-400 bg-red-900/30 border-r-4 border-red-500 p-2 rounded-sm mb-4" />
            </div>
            {{-- رابط بحال كنت مسجل دخول --}}
            <div class="flex items-center justify-between mt-6" dir="rtl">
                <a class="underline text-sm text-gray-500 hover:text-sky-400 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500 transition duration-150"
                    href="{{ route('login') }}">
                    هل لديك حساب بالفعل؟
                </a>
                {{-- زر تسجيل --}}
                <button type="submit"
                    class="inline-flex items-center px-8 py-3 bg-sky-600 border border-transparent rounded-lg font-bold text-sm text-white shadow-xl tracking-wider hover:bg-sky-500 focus:bg-sky-700 active:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2 transition ease-in-out duration-150 transform hover:scale-[1.01]">
                    تسجيل
                </button>
            </div>
        </form>

    </div>
</x-guest-layout>
