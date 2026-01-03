<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RMS Premium | Welcome</title>

    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background-color: #090b0d;
            color: #fff;
            margin: 0;
        }

        .hero-bg {
            background: linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.8)),
                url('https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
        }

        .btn-glow {
            transition: all 0.3s ease;
        }

        .btn-glow:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.3);
        }
    </style>
</head>

<body class="antialiased">
    <div class="relative min-h-screen flex items-center justify-center hero-bg">

        <div class="relative z-10 text-center px-6">
            <div class="mb-12">
                <div class="flex justify-center mb-6">
                    <div
                        class="w-20 h-20 bg-cyan-600 rounded-3xl flex items-center justify-center shadow-2xl shadow-cyan-900/50 rotate-3">
                        <i class="fas fa-utensils text-3xl text-white"></i>
                    </div>
                </div>
                <span class="text-cyan-400 font-bold tracking-[0.3em] uppercase block mb-3 text-sm">@lang('Restaurant Management System')</span>
                <h1 class="text-5xl md:text-7xl font-black mb-6 tracking-tight">@lang('RMS')</h1>
                <p class="text-lg text-gray-400 max-w-2xl mx-auto leading-relaxed opacity-90">
                   @lang('The ultimate solution for managing your restaurant with ease and efficiency.')
                </p>
            </div>

            <div class="flex flex-wrap gap-4 justify-center items-center">
                @if (auth()->guard('employee')->check())

                    @php $user = auth()->guard('employee')->user(); @endphp


                    @if ($user->hasRole('Admin') || $user->super_admin)
                        <a href="{{ route('Pages.dashboard') }}"
                            class="btn-glow px-10 py-4 bg-cyan-600 hover:bg-cyan-500 text-white font-bold rounded-2xl">
                            <i class="fas fa-user-shield ml-2"></i> @lang('Admin Dashboard')
                        </a>
                    @endif

                    @if ($user->hasRole('Cashier'))
                        <a href="{{ route('Pages.cashier.index') }}"
                            class="btn-glow px-10 py-4 bg-emerald-600 hover:bg-emerald-500 text-white font-bold rounded-2xl">
                            <i class="fas fa-cash-register ml-2"></i>  @lang('Cashier Panel') 
                        </a>
                    @endif

                    @if ($user->hasRole('Waiter'))
                        <a href="{{ route('Pages.waiter.index') }}"
                            class="btn-glow px-10 py-4 bg-orange-500 hover:bg-orange-400 text-white font-bold rounded-2xl">
                            <i class="fas fa-concierge-bell ml-2"></i> @lang('Waiter Orders') 
                        </a>
                    @endif

                    @if ($user->hasRole('Kitchen'))
                        <a href="{{ route('Pages.kitchen.index') }}"
                            class="btn-glow px-10 py-4 bg-red-600 hover:bg-red-500 text-white font-bold rounded-2xl">
                            <i class="fas fa-fire ml-2"></i> @lang('Kitchen Orders')
                        </a>
                    @endif

                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit"
                            class="px-10 py-4 border border-red-500/40 text-red-500 hover:bg-red-500 hover:text-white font-bold rounded-2xl transition-all">
                            @lang('Logout')
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                        class="btn-glow px-16 py-5 bg-white text-black hover:bg-gray-200 font-black text-xl rounded-2xl shadow-2xl">
                       @lang('Login')
                    </a>
                @endif
            </div>

            <div
                class="mt-16 flex justify-center gap-8 text-xs font-bold tracking-[0.2em] uppercase opacity-40 hover:opacity-100 transition-opacity">
                @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                    <a rel="alternate" hreflang="{{ $localeCode }}"
                        href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}"
                        class="hover:text-cyan-400 border-b-2 border-transparent hover:border-cyan-400 pb-1">
                        {{ $properties['native'] }}
                    </a>
                @endforeach
            </div>
        </div>

        <div
            class="absolute bottom-8 w-full text-center text-gray-700 text-[10px] font-bold tracking-[0.4em] uppercase">
            @lang('RMS').&copy; {{ date('Y') }}
        </div>
    </div>
</body>

</html>
