<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="rtl">

<head>
    <meta charset="utf-8">
    <title>@yield('title') - SRMS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Bootstrap RTL -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css">

    <style>
        :root {
            --gold: #d4af37;
            --gold-soft: #f5e6b8;
            --gold-glow: rgba(212, 175, 55, .25);

            --dark-1: #0b0d10;
            --dark-2: #141821;

            --sidebar-width: 280px;
            --header-height: 72px;
        }

        * {
            font-family: 'Cairo', sans-serif;
        }

        body {
            background: linear-gradient(180deg, var(--dark-1), var(--dark-2));
            color: #eee;
            overflow-x: hidden;
        }

        /* ===== Layout ===== */
        .main-header {
            position: fixed;
            top: 0;
            right: var(--sidebar-width);
            height: var(--header-height);
            width: calc(100% - var(--sidebar-width));
            background: linear-gradient(135deg, #141821, #0b0d10);
            border-bottom: 1px solid var(--gold-glow);
            z-index: 1000;
        }

        .main-sidebar {
            position: fixed;
            top: 0;
            right: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: linear-gradient(180deg, #0b0d10, #141821);
            border-left: 1px solid var(--gold-glow);
        }

        .content-wrapper {
            margin-top: var(--header-height);
            margin-right: var(--sidebar-width);
            padding: 24px;
            min-height: calc(100vh - var(--header-height));
        }

        .text-gold {
            color: var(--gold);
        }

        .glass {
            background: linear-gradient(180deg, #0b0d10, #141821);
            border: 1px solid var(--gold-glow);
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, .55);
        }
    </style>

    @stack('styles')
</head>

<body>

    @include('layouts.sections.header')
    @include('layouts.sections.sidebar')

    <div class="content-wrapper">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>
