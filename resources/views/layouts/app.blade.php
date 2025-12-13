<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SRMS') }} | لوحة التحكم</title>

    {{-- الخطوط والأيقونات --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .font-sans,
        body {
            font-family: 'Cairo', sans-serif, 'figtree';
        }
    </style>
</head>

<body class="font-sans antialiased bg-gray-900 text-white">

    <div class="flex h-screen overflow-hidden">

        {{-- 1. الشريط الجانبي --}}
        @include('layouts.sections.sidebar')

        {{-- 2. حاوية المحتوى الرئيسية: Flex Column --}}
        <div class="flex-1 flex flex-col overflow-y-auto">

            {{-- **HEADER & NAVIGATION BLOCK** --}}
            {{-- وضع كل شريط علوي في حاوية واحدة لضمان أن يكونا أعلى المحتوى --}}
            <header class="bg-gray-800 shadow-xl z-10 sticky top-0">

                {{-- 2.1. شريط تنقل Breeze (عادةً يكون الداشبورد العلوي) --}}
                @include('layouts.navigation')

                {{-- 2.2. شريط الرأس المخصص (للعناوين الكبيرة مثل "لوحة تحكم المدير") --}}
                @include('layouts.sections.header')

            </header>

            {{-- المحتوى الرئيسي: يملأ المساحة المتبقية --}}
            <main class="flex-1">
                @yield('restaurant_dashboard_content')
            </main>

        </div>
    </div>

    @stack('scripts')
</body>

</html>
