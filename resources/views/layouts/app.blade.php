<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - SRMS</title>

    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/dashboard/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="{{ asset('assets/dashboard/dist/css/adminlte.min.css') }}">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">

    <style>
        * {
            font-family: 'Cairo', sans-serif
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
        .sidebar-collapse .main-header,
        .sidebar-collapse .main-footer {
            margin-right: 0 !important;
        }

        .nav-icon {
            margin-left: 10px !important;
            margin-right: 0
        }

        .brand-link {
            text-align: center !important;
        }

        .nav-sidebar .nav-item .nav-link {
            text-align: right !important;
        }

        .nav-sidebar .nav-link p {
            display: inline-block;
        }

        .form-control,
        .form-select,
        .form-control::placeholder,
        .form-select::placeholder {
            text-align: right !important;
            direction: rtl !important;
        }

        input::placeholder,
        textarea::placeholder {
            text-align: right !important;
            direction: rtl !important;
        }

        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus,
        input:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0px 1000px #495057 inset !important;
            -webkit-text-fill-color: #ffffff !important;
            border-color: #495057 !important;
        }
    </style>
    @stack('styles')
    @yield('styles')
</head>

{{-- تم إزالة dark-mode الثابت --}}

<body class="hold-transition layout-fixed text-sm sidebar-right">

    <div class="wrapper">

        {{-- 1. Header  --}}
        @include('layouts.sections.header')

        {{-- 2. Sidebar  --}}
        @include('layouts.sections.sidebar')

        {{-- 3. Content Wrapper --}}
        {{-- تم إزالة bg-dark الثابت --}}
        <div class="content-wrapper">

            {{-- Content Header --}}
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-12">

                        </div>
                    </div>
                </div>
            </div>

            {{-- Main Content --}}
            <section class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </section>
        </div>

    </div>

    {{-- روابط JavaScript --}}
    <script src="{{ asset('assets/dashboard/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/dist/js/adminlte.js') }}"></script>

    @yield('scripts')

    {{-- كود JavaScript لتبديل السمة (Dark/Light Mode) --}}
    <script>
        $(document).ready(function() {
            // 1. تحديد العناصر الأساسية
            const body = $('body');
            const toggleButton = $('#theme-toggle');
            const themeIcon = $('#theme-icon');
            const darkModeClass = 'dark-mode';

            // 2. تطبيق الوضع المحفوظ عند تحميل الصفحة
            const currentTheme = localStorage.getItem('theme');

            function applyTheme(theme) {
                if (theme === 'light') {
                    body.removeClass(darkModeClass);
                    themeIcon.removeClass('fa-sun').addClass('fa-moon');
                } else {
                    body.addClass(darkModeClass);
                    themeIcon.removeClass('fa-moon').addClass('fa-sun');
                }

                if (typeof AdminLTE !== 'undefined' && AdminLTE.layout) {
                    AdminLTE.layout.fixIframeHeight();
                }
            }

            // تطبيق الوضع المحفوظ، الافتراضي هو 'dark'
            applyTheme(currentTheme || 'dark');

            // 3. وظيفة تبديل الوضع عند النقر على الزر
            toggleButton.on('click', function(e) {
                e.preventDefault();

                if (body.hasClass(darkModeClass)) {
                    applyTheme('light');
                    localStorage.setItem('theme', 'light');
                } else {
                    applyTheme('dark');
                    localStorage.setItem('theme', 'dark');
                }
            });
        });
    document.addEventListener('DOMContentLoaded', function() {
        // نبحث عن أي عنصر يحمل كلاس flash-alert (الذي وضعناه في الكومبونانت)
        // أو نبحث عن كلاس alert الافتراضي لبوتستراب
        const alerts = document.querySelectorAll('.flash-alert, .alert');

        alerts.forEach(function(alert) {
            // ننتظر ثانيتين (2000 مللي ثانية)
            setTimeout(function() {
                // إضافة تأثير تلاشي ناعم
                alert.style.transition = "opacity 0.8s ease, transform 0.8s ease";
                alert.style.opacity = "0";
                alert.style.transform = "translateY(-10px)";
                
                // حذف العنصر تماماً من الصفحة بعد انتهاء التلاشي
                setTimeout(function() {
                    alert.remove();
                }, 800);
            }, 2000);
        });
    });
    </script>
</body>

</html>
