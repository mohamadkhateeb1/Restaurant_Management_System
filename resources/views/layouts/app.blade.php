@section('title', 'Dashboard')
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- يتم دمج عنوان التطبيق مع عنوان الصفحة --}}
    <title>{{ config('app.name') }}</title>

    {{-- التضمينات الأساسية (Tailwind, Chart.js, Font Awesome, Cairo) --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Cairo', sans-serif;
        }
    </style>
    {{-- اذا يدي اكتب css --}}
    @stack('styles')
</head>

<body class="bg-gray-900 text-white">
    <div class="flex h-screen overflow-hidden">

        @include('layouts.sections.sidebar')

        {{-- 2. حاوية المحتوى الرئيسية (Flex Grow) --}}
        <div class="flex-1 flex flex-col overflow-y-auto">
            {{-- 2.1. رأس الصفحة (Header) --}}
            @include('layouts.sections.header')

            {{-- 2.2. المحتوى (Main Content Area) --}}
            <main class="p-4 md:p-8 flex-1">
                @yield('restaurant_dashboard_content')
            </main>
        </div>
    </div>

{{-- اذا بدي اكتب script --}}
    @stack('scripts')
</body>

</html>