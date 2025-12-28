<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - SRMS</title>

    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/dashboard/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">

    <style>
        * {
            font-family: 'Cairo', sans-serif;
        }

        body {
            direction: rtl;
            text-align: right;
        }

        .main-sidebar {
            right: 0 !important;
            left: auto !important;
        }

        .content-wrapper,
        .main-header,
        .main-footer {
            margin-right: 250px !important;
            margin-left: 0 !important;
        }

        .sidebar-collapse .content-wrapper,
        .sidebar-collapse .main-header {
            margin-right: 0 !important;
        }

        .dropdown-menu-left {
            left: 0 !important;
            right: auto !important;
            text-align: right;
        }

        .shadow-text {
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
        }
    </style>
    @stack('styles')
</head>

<body class="hold-transition layout-fixed text-sm sidebar-right dark-mode">
    <div class="wrapper">
        @include('layouts.sections.header')
        @include('layouts.sections.sidebar')

        <div class="content-wrapper">
            <section class="content pt-3">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </section>
        </div>
    </div>

    <script src="{{ asset('assets/dashboard/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/dist/js/adminlte.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.flash-alert, .alert');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    alert.style.transition = "opacity 0.8s ease";
                    alert.style.opacity = "0";
                    setTimeout(() => alert.remove(), 800);
                }, 2000);
            });
        });
    </script>
    @yield('scripts')
</body>

</html>
