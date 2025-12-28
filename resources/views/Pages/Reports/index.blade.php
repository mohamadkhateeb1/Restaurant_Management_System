@extends('layouts.app')

@section('content')
    <style>
        :root {
            --carbon-dark: #0a0b0c;
            --carbon-light: #16181a;
            --gold-primary: #d4af37;
            --gold-glow: rgba(212, 175, 55, 0.3);
            --border-color: #2d3035;
        }

        body {
            background-color: var(--carbon-dark);
            color: #e1e1e1;
            font-family: 'Cairo', sans-serif;
            background-image: radial-gradient(circle at 2px 2px, #1d1f21 1px, transparent 0);
            background-size: 40px 40px;
        }

        .reports-container {
            padding: 40px 20px;
            max-width: 1250px;
            margin: 0 auto;
        }

        .reports-tabs {
            display: flex;
            gap: 12px;
            background: var(--carbon-light);
            padding: 10px;
            border-radius: 20px;
            border: 1px solid var(--border-color);
            margin-bottom: 35px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.5);
        }

        .report-tab-link {
            padding: 14px 30px;
            color: #888;
            border-radius: 15px;
            text-decoration: none !important;
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 700;
            transition: all 0.3s ease;
            border: 1px solid transparent;
        }

        .report-tab-link:hover {
            color: var(--gold-primary);
            background: rgba(212, 175, 55, 0.05);
        }

        .report-tab-link.active {
            background: rgba(212, 175, 55, 0.1);
            color: var(--gold-primary);
            border-color: rgba(212, 175, 55, 0.4);
            box-shadow: 0 0 20px var(--gold-glow);
        }

        .report-content-wrapper {
            background: var(--carbon-light);
            border: 1px solid var(--border-color);
            border-radius: 30px;
            padding: 35px;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.7);
            position: relative;
            overflow: hidden;
            animation: slideUp 0.6s ease-out;
        }

        .report-content-wrapper::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, transparent, var(--gold-primary), transparent);
        }

        .btn-refresh {
            padding: 10px 25px;
            border-radius: 50px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: 0.3s;
            text-decoration: none !important;
            border: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(255, 255, 255, 0.05);
            color: #fff;
        }

        .btn-refresh:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    <div class="reports-container" dir="rtl">
        @php $activeTab = request('tab', 'sales'); @endphp

        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <h1 class="h2 fw-black mb-1" style="color: var(--gold-primary); text-shadow: 0 0 15px var(--gold-glow);">
                    @lang('Center of Digital Analytics')</h1>
                <p class="text-muted small mb-0">@lang('System SRMS - View Sales and Restaurant Inventory')</p>
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

        <div class="mb-4 px-2">
            <h5 class="text-white-50 fw-bold">
                <i class="fas fa-database me-2"></i>
                استعراض بيانات
                {{ $activeTab == 'sales' ? 'المبيعات' : ($activeTab == 'inventory' ? 'المخزن' : 'الفواتير') }}
            </h5>
        </div>
        <div class="report-content-wrapper">
            <div class="report-content">
                @include('Pages.Reports.partials._' . $activeTab)
            </div>
        </div>

        <div class="mt-5 text-center text-muted small">
            @lang('Restaurant Management System'). &copy; {{ date('Y') }} @lang('All rights reserved').
        </div>
    </div>
@endsection
