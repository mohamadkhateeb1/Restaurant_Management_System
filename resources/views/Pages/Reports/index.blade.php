@extends('layouts.app')

@section('content')
    <style>
        :root {
            --dark-bg: #0a0a0a;
            /* أسود عميق مطفي */
            --card-bg: #141414;
            /* أسود فاتح قليلاً للكروت */
            --gold-primary: #c5a059;
            /* ذهبي نحاسي مطفي */
            --gold-secondary: #8e6d3d;
            /* ذهبي داكن */
            --glass-border: rgba(255, 255, 255, 0.03);
            --text-muted: #7a7a7a;
        }

        body {
            background-color: var(--dark-bg);
            color: #d1d1d1;
            font-family: 'Cairo', sans-serif;
            background-image: radial-gradient(circle at 2px 2px, #1a1a1a 1px, transparent 0);
            background-size: 30px 30px;
        }

        .reports-container {
            padding: 40px 20px;
            max-width: 1300px;
            margin: 0 auto;
        }

        /* تنسيق التبويبات (Tabs) */
        .reports-tabs {
            display: flex;
            gap: 15px;
            background: var(--card-bg);
            padding: 8px;
            border-radius: 100px;
            /* شكل كبسولة */
            border: 1px solid var(--glass-border);
            margin-bottom: 45px;
            box-shadow: 10px 10px 30px rgba(0, 0, 0, 0.5);
            width: fit-content;
            margin-left: auto;
            /* لضبط التوسيط في RTL */
            margin-right: auto;
        }

        .report-tab-link {
            padding: 12px 35px;
            color: var(--text-muted);
            border-radius: 100px;
            text-decoration: none !important;
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 300;
            /* خط رفيع */
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            font-size: 0.9rem;
            letter-spacing: 1px;
        }

        .report-tab-link:hover {
            color: #fff;
        }

        .report-tab-link.active {
            background: linear-gradient(145deg, var(--gold-primary), var(--gold-secondary));
            color: #000;
            /* نص أسود فوق الذهبي */
            font-weight: 700;
            box-shadow: 0 5px 15px rgba(197, 160, 89, 0.3);
        }

        /* حاوية المحتوى الرئيسي */
        .report-content-wrapper {
            background: var(--card-bg);
            border: 1px solid var(--glass-border);
            border-radius: 25px;
            padding: 40px;
            box-shadow: 20px 20px 60px rgba(0, 0, 0, 0.7);
            position: relative;
            animation: slideUp 0.8s ease;
        }

        /* زر التحديث الذهبي الخفيف */
        .btn-refresh {
            padding: 10px 25px;
            border-radius: 50px;
            font-weight: 400;
            font-size: 0.85rem;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: 0.3s;
            text-decoration: none !important;
            border: 1px solid rgba(197, 160, 89, 0.2);
            background: transparent;
            color: var(--gold-primary);
        }

        .btn-refresh:hover {
            background: rgba(197, 160, 89, 0.05);
            border-color: var(--gold-primary);
            transform: translateY(-2px);
            color: #fff;
        }

        .text-gold {
            color: var(--gold-primary) !important;
        }

        .fw-light {
            font-weight: 300 !important;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* لضبط المسافات في الجوال */
        @media (max-width: 768px) {
            .reports-tabs {
                flex-wrap: wrap;
                border-radius: 20px;
                justify-content: center;
            }

            .report-tab-link {
                width: 100%;
                justify-content: center;
            }
        }
    </style>

    <div class="reports-container" dir="rtl">
        @php $activeTab = request('tab', 'sales'); @endphp

        <div class="d-flex justify-content-between align-items-center mb-5 flex-wrap gap-4">
            <div>
                <h1 class="h2 fw-light mb-1 text-white">مركز <span class="text-gold">التحليلات الرقمية</span></h1>
                <p class="text-muted extra-small text-uppercase mb-0" style="letter-spacing: 2px;">
                    SRMS Professional Analytics & Global Reports
                </p>
            </div>

            <div class="header-actions">
                <a href="{{ route('Pages.reports.index', ['tab' => $activeTab]) }}" class="btn btn-refresh">
                    <i class="fas fa-sync-alt"></i> @lang('Refresh Data')
                </a>
            </div>
        </div>

        <nav class="reports-tabs">
            <a href="{{ route('Pages.reports.index', ['tab' => 'sales']) }}"
                class="report-tab-link {{ $activeTab == 'sales' ? 'active' : '' }}">
                <i class="fas fa-chart-line"></i> @lang('Sales Reports')
            </a>
            <a href="{{ route('Pages.reports.index', ['tab' => 'invoices']) }}"
                class="report-tab-link {{ $activeTab == 'invoices' ? 'active' : '' }}">
                <i class="fas fa-receipt"></i> @lang('Invoices Reports')
            </a>
            <a href="{{ route('Pages.reports.index', ['tab' => 'inventory']) }}"
                class="report-tab-link {{ $activeTab == 'inventory' ? 'active' : '' }}">
                <i class="fas fa-boxes"></i> @lang('Inventory Reports')
            </a>
        </nav>

        <div class="mb-4 px-2 d-flex align-items-center gap-3">
            <div style="width: 4px; height: 20px; background: var(--gold-primary); border-radius: 10px;"></div>
            <h6 class="text-white-50 fw-light mb-0 text-uppercase" style="letter-spacing: 1px;">
                @lang('view data'): <span class="text-white fw-bold">@lang($activeTab)</span>
            </h6>
        </div>

        <div class="report-content-wrapper">
            <div class="report-content">
                @include('Pages.Reports.partials._' . $activeTab)
            </div>
        </div>

        <div class="mt-5 text-center text-muted small extra-small text-uppercase" style="letter-spacing: 2px;">
            &copy; {{ date('Y') }} SRMS Premium <span class="text-gold mx-2">|</span> @lang('All rights reserved').
        </div>
    </div>
@endsection
