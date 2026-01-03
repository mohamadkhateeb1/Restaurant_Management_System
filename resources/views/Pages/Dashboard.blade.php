@extends('layouts.app')

@section('title', __('لوحة التحكم'))

@section('content')

    <style>
        :root {
            --gold: #d4af37;
            --gold-soft: rgba(212, 175, 55, .25);
            --dark-1: #0b0d10;
            --dark-2: #141821;
            --border-soft: rgba(255, 255, 255, .08);
        }

        /* ===== LAYOUT ===== */
        .container-fluid {
            padding: 0 !important
        }

        .dashboard-wrapper {
            padding: 24px;
            background: linear-gradient(180deg, var(--dark-1), var(--dark-2));
            min-height: 100%;
            animation: fadeIn .8s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px)
            }

            to {
                opacity: 1;
                transform: none
            }
        }

        /* ===== HEADER CLOCK ===== */
        .clock-wide {
            text-align: center;
            padding: 36px;
            border-radius: 26px;
            background: radial-gradient(circle at top, #1f2533, #0b0d10);
            border: 1px solid var(--gold-soft);
            box-shadow: 0 0 40px rgba(212, 175, 55, .15);
            margin-bottom: 30px;
        }

        #liveClock {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                text-shadow: 0 0 10px rgba(212, 175, 55, .4)
            }

            50% {
                text-shadow: 0 0 25px rgba(212, 175, 55, .9)
            }
        }

        /* ===== KPI ===== */
        .kpi-card {
            height: 140px;
            padding: 20px;
            border-radius: 20px;
            position: relative;
            border: 1px solid var(--gold-soft);
            background: linear-gradient(135deg, #141821, #0b0d10);
            transition: .35s ease;
        }

        .kpi-card:hover {
            transform: translateY(-6px)
        }

        .kpi-card i {
            position: absolute;
            left: 14px;
            bottom: 10px;
            font-size: 3.5rem;
            opacity: .15;
            color: var(--gold);
        }

        /* ===== GLASS CARD ===== */
        .glass-card {
            background: linear-gradient(180deg, #0b0d10, #141821);
            border: 1px solid var(--gold-soft);
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, .55);
            transition: .35s ease;
        }

        .glass-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 60px rgba(0, 0, 0, .7),
                0 0 25px rgba(212, 175, 55, .25);
        }

        /* ===== TABLE MAP ===== */
        .table-dot {
            width: 44px;
            height: 44px;
            border-radius: 14px;
            font-weight: 800;
            margin: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: .3s ease;
        }

        .table-dot:hover {
            transform: scale(1.15)
        }

        .status-available {
            border: 2px solid #3ddc97;
            color: #3ddc97;
            background: rgba(61, 220, 151, .12);
        }

        .status-occupied {
            border: 2px solid #f59e0b;
            color: #f59e0b;
            background: rgba(245, 158, 11, .12);
        }

        /* ===== LIST ===== */
        .item-row {
            background: rgba(255, 255, 255, .03);
            border: 1px solid var(--border-soft);
            border-radius: 14px;
            transition: .3s ease;
        }

        .item-row:hover {
            background: rgba(212, 175, 55, .08);
            transform: translateX(-4px);
        }

        .fw-black {
            font-weight: 900
        }

        .text-gold {
            color: var(--gold)
        }
    </style>

    <div class="dashboard-wrapper">

        {{-- HEADER --}}
        <div class="clock-wide">
            <h1 class="fw-black text-gold mb-2">Dashboard</h1>
            <div class="text-white-50 mb-3">
                @lang('Welcome back')
                <span class="text-white fw-bold">{{ Auth::user()->name }}</span>
            </div>
            <h2 id="liveClock" class="fw-black text-gold mb-1">00:00:00</h2>
            <div id="liveDate" class="text-white-50"></div>
        </div>

        {{-- KPI --}}
        <div class="row g-3 mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="kpi-card">
                    <small class="text-white-50">@lang("Today's net sales")</small>
                    <h3 class="fw-black text-gold mt-2">{{ number_format($todaySales) }} <small>$</small></h3>
                    <i class="fas fa-coins"></i>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="kpi-card">
                    <small class="text-white-50">@lang('Open Tables Now')</small>
                    <h3 class="fw-black text-gold mt-2">{{ $openTablesCount }}</h3>
                    <i class="fas fa-utensils"></i>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="kpi-card">
                    <small class="text-white-50">@lang('Orders under preparation')</small>
                    <h3 class="fw-black text-gold mt-2">{{ $preparingOrders }}</h3>
                    <i class="fas fa-fire"></i>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="kpi-card">
                    <small class="text-white-50">@lang('Total Employees')</small>
                    <h3 class="fw-black text-gold mt-2">{{ $activeEmployeesCount }}</h3>
                    <i class="fas fa-user-shield"></i>
                </div>
            </div>
        </div>

        {{-- CHARTS --}}
        <div class="row g-3 mb-4">
            <div class="col-lg-4">
                <div class="glass-card p-4 h-100">
                    <h5 class="fw-black text-gold mb-3">@lang('Orders Distribution')</h5>
                    <div style="height:280px">
                        <canvas id="ordersPieChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="glass-card p-4 h-100">
                    <h5 class="fw-black text-gold mb-3">@lang('Sales Growth')</h5>
                    <div style="height:300px">
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- BOTTOM --}}
        <div class="row g-3">
            <div class="col-lg-4">
                <div class="glass-card p-4 h-100">
                    <h5 class="fw-black text-gold mb-3">@lang('Immediate hall occupancy')</h5>
                    <div class="d-flex flex-wrap">
                        @foreach ($tablesMap as $table)
                            <div
                                class="table-dot {{ $table->status == 'available' ? 'status-available' : 'status-occupied' }}">
                                {{ $table->table_number }}
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="glass-card p-4 h-100">
                    <h5 class="fw-black text-gold mb-3">@lang('Top Selling Items')</h5>
                    @foreach ($topItems as $item)
                        <div class="item-row p-3 mb-2 d-flex justify-content-between">
                            <span>{{ $item->item_name }}</span>
                            <span class="fw-black text-gold">{{ $item->total }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="col-lg-4">
                <div class="glass-card p-4 h-100">
                    <h5 class="fw-black text-gold mb-3">@lang('Management and Supervisors')</h5>
                    @foreach ($employees as $emp)
                        <div class="item-row p-3 mb-2">{{ $emp->name }}</div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            const now = () => {
                const d = new Date();
                liveClock.innerText = d.toLocaleTimeString('ar-SA');
                liveDate.innerText = d.toLocaleDateString('ar-SA', {
                    weekday: 'long',
                    day: 'numeric',
                    month: 'long'
                });
            }
            setInterval(now, 1000);
            now();

            Chart.defaults.color = '#d4af37';

            new Chart(salesChart, {
                type: 'line',
                data: {
                    labels: {!! json_encode($salesData->pluck('date')) !!},
                    datasets: [{
                        data: {!! json_encode($salesData->pluck('total')) !!},
                        borderColor: '#d4af37',
                        backgroundColor: 'rgba(212,175,55,.15)',
                        fill: true,
                        tension: .4
                    }]
                },
                options: {
                    maintainAspectRatio: false
                }
            });

            new Chart(ordersPieChart, {
                type: 'doughnut',
                data: {
                    labels: [
                        "{{ __('orders.dine_in') }}",
                        "{{ __('orders.takeaway') }}"
                    ],
                    datasets: [{
                        data: [{{ $dineInCount }}, {{ $takeawayCount }}],
                        backgroundColor: ['#3ddc97', '#f59e0b'],
                        borderWidth: 3,
                        borderColor: '#0b0d10',
                        hoverOffset: 18
                    }]
                },
                options: {
                    cutout: '65%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                font: {
                                    weight: 'bold'
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>

@endsection
