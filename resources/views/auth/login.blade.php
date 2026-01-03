<x-guest-layout>
    <style>
        /* كارد تسجيل الدخول الزجاجي */
        .login-card {
            background: rgba(13, 15, 17, 0.85);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 30px;
            width: 100%;
            max-width: 450px;
            padding: 40px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        /* تنسيق الحقول */
        .input-field {
            background: rgba(255, 255, 255, 0.03) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            color: white !important;
            border-radius: 15px !important;
            transition: all 0.3s ease;
        }

        .input-field:focus {
            border-color: #06b6d4 !important;
            background: rgba(6, 182, 212, 0.05) !important;
            box-shadow: 0 0 15px rgba(6, 182, 212, 0.2) !important;
        }

        /* زر الإرسال */
        .btn-submit {
            background: #0891b2;
            color: white;
            font-weight: 900;
            border-radius: 15px;
            padding: 15px;
            transition: all 0.3s ease;
            box-shadow: 0 10px 20px -5px rgba(8, 145, 178, 0.4);
        }

        .btn-submit:hover {
            background: #06b6d4;
            transform: translateY(-2px);
            box-shadow: 0 15px 25px -5px rgba(8, 145, 178, 0.6);
        }

        /* مبدل اللغات */
        .lang-switcher a {
            transition: all 0.3s ease;
        }
    </style>

    <div class="flex flex-col items-center w-full max-w-[450px]">
        <div class="login-card w-full">
            <div class="text-center mb-8">
                <div
                    class="inline-flex items-center justify-center w-16 h-16 bg-cyan-600 rounded-2xl mb-4 shadow-lg rotate-3">
                    <i class="fas fa-utensils text-2xl text-white"></i>
                </div>
                <h1 class="text-3xl font-black text-white tracking-tight text-center">@lang('Restaurant Management System')</h1>
                <p class="text-gray-400 text-sm mt-2 font-bold opacity-70 text-center">@lang('Login to your account')</p>
            </div>

            <x-auth-session-status class="mb-4 text-cyan-400 text-center font-bold" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <div dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
                    <x-input-label for="email" :value="__('Email')"
                        class="text-gray-400 text-xs font-bold uppercase mb-2 mr-1 ml-1" />
                    <x-text-input id="email" class="input-field block w-full p-4" type="email" name="email"
                        :value="old('email')" required autofocus placeholder="name@restaurant.com" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500 text-xs" />
                </div>

                <div dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
                    <div class="flex justify-between items-center mb-2 mr-1 ml-1">
                        <x-input-label for="password" :value="__('Password')"
                            class="text-gray-400 text-xs font-bold uppercase" />
                    </div>
                    <x-text-input id="password" class="input-field block w-full p-4" type="password" name="password"
                        required autocomplete="current-password" placeholder="••••••••" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500 text-xs" />
                </div>

                <div class="flex items-center justify-between" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
                    <label for="remember_me" class="inline-flex items-center cursor-pointer">
                        <input id="remember_me" type="checkbox"
                            class="rounded border-gray-800 bg-gray-900 text-cyan-600 focus:ring-cyan-500"
                            name="remember">
                        <span class="ms-2 me-2 text-xs text-gray-500 font-bold uppercase">@lang('Remember me')</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a class="text-xs text-cyan-600 hover:text-cyan-400 transition-colors font-bold"
                            href="{{ route('password.request') }}">@lang('Forgot your password?')</a>
                    @endif
                </div>

                <button type="submit" class="btn-submit w-full flex items-center justify-center gap-2">
                    <span>@lang('Login')</span>
                    <i class="fas fa-sign-in-alt text-sm"></i>
                </button>
            </form>

            <div class="mt-10 text-center border-t border-white/5 pt-6">
                <p class="text-[10px] text-gray-600 font-bold uppercase tracking-[0.3em]">@lang('RMS').&copy;
                    {{ date('Y') }}</p>
            </div>
        </div>

        <div
            class="mt-8 flex justify-center gap-6 text-xs font-bold tracking-[0.2em] uppercase opacity-40 hover:opacity-100 transition-opacity lang-switcher">
            @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                <a rel="alternate" hreflang="{{ $localeCode }}"
                    href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}"
                    class="text-white hover:text-cyan-400 border-b-2 border-transparent hover:border-cyan-400 pb-1">
                    {{ $properties['native'] }}
                </a>
            @endforeach
        </div>
    </div>
</x-guest-layout>
