@extends('layouts.app')

@section('title', __('لوحة التحكم'))

@section('content')

    <style>
        :root {
            --gold: #d4af37;
            --gold-glow: rgba(212, 175, 55, 0.3);
            --dark-1: #0b0d10;
            --dark-2: #141821;
            --card-grad: linear-gradient(145deg, #1a1f2b, #0b0d10);
            --border-soft: rgba(255, 255, 255, 0.05);
        }

        .dashboard-wrapper {
            padding: 20px;
            background: var(--dark-1);
            min-height: 100vh;
        }

        .clock-wide {
            text-align: center;
            padding: 40px 20px;
            border-radius: 24px;
            background: radial-gradient(circle at center, #1c222d 0%, #0b0d10 100%);
            border: 1px solid var(--gold-glow);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5);
            margin-bottom: 30px;
        }

        #liveClock {
            font-size: clamp(2.5rem, 8vw, 4rem);
            letter-spacing: 4px;
            margin: 10px 0;
            text-shadow: 0 0 20px var(--gold-glow);
        }

        .kpi-card {
            height: 100%;
            padding: 25px;
            border-radius: 20px;
            background: var(--card-grad);
            border: 1px solid var(--border-soft);
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .kpi-card:hover {
            border-color: var(--gold);
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
        }

        .kpi-card i {
            position: absolute;
            right: -10px;
            bottom: -10px;
            font-size: 5rem;
            opacity: 0.1;
            color: var(--gold);
            transform: rotate(-15deg);
        }

        .glass-card {
            background: var(--card-grad);
            border: 1px solid var(--border-soft);
            border-radius: 22px;
            height: 100%;
            padding: 25px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .table-dot {
            width: clamp(40px, 4vw, 50px);
            height: clamp(40px, 4vw, 50px);
            border-radius: 12px;
            font-weight: 800;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 6px;
            font-size: 0.9rem;
            transition: 0.2s;
        }

        .status-available {
            border: 2px solid #10b981;
            color: #10b981;
            background: rgba(16, 185, 129, 0.1);
            box-shadow: 0 0 15px rgba(16, 185, 129, 0.1);
        }

        .status-occupied {
            border: 2px solid #f59e0b;
            color: #f59e0b;
            background: rgba(245, 158, 11, 0.1);
            box-shadow: 0 0 15px rgba(245, 158, 11, 0.1);
        }

        .item-row {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid var(--border-soft);
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: 0.3s;
        }

        .item-row:hover {
            background: rgba(212, 175, 55, 0.05);
            border-color: var(--gold-glow);
            padding-right: 20px;
        }

        .chart-container {
            position: relative;
            height: 350px;
            width: 100%;
        }

        .fw-black {
            font-weight: 900 !important;
        }

        .text-gold {
            color: var(--gold) !important;
        }

        @media (max-width: 768px) {
            .dashboard-wrapper {
                padding: 10px;
            }

            .clock-wide {
                padding: 25px 15px;
            }

            .kpi-card {
                padding: 20px;
            }

            .chart-container {
                height: 250px;
            }
        }
    </style>

    <div class="dashboard-wrapper">
        <div class="clock-wide">
            <h1 class="fw-black text-gold">@lang('Dashboard')</h1>
            <div class="text-white-50 small text-uppercase letter-spacing-2">
                @lang('Welcome back') <span class="text-white fw-bold">{{ Auth::user()->name }}</span>
            </div>
            <h2 id="liveClock" class="fw-black text-gold">00:00:00</h2>
            <div id="liveDate" class="text-white-50 fw-bold"></div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-6 col-xl-3">
                <div class="kpi-card">
                    <small class="text-white-50 text-uppercase letter-spacing-1">@lang("Today's net sales")</small>
                    <h3 class="fw-black text-gold mt-1 mb-0">{{ number_format($todaySales) }} <small
                            class="fs-6">$</small></h3>
                    <i class="fas fa-coins"></i>
                </div>
            </div>
            <div class="col-6 col-xl-3">
                <div class="kpi-card">
                    <small class="text-white-50 text-uppercase letter-spacing-1">@lang('Open Tables Now')</small>
                    <h3 class="fw-black text-gold mt-1 mb-0">{{ $openTablesCount }}</h3>
                    <i class="fas fa-utensils"></i>
                </div>
            </div>
            <div class="col-6 col-xl-3">
                <div class="kpi-card">
                    <small class="text-white-50 text-uppercase letter-spacing-1">@lang('Orders under preparation')</small>
                    <h3 class="fw-black text-gold mt-1 mb-0">{{ $preparingOrders }}</h3>
                    <i class="fas fa-fire"></i>
                </div>
            </div>
            <div class="col-6 col-xl-3">
                <div class="kpi-card">
                    <small class="text-white-50 text-uppercase letter-spacing-1">@lang('Total Employees')</small>
                    <h3 class="fw-black text-gold mt-1 mb-0">{{ $activeEmployeesCount }}</h3>
                    <i class="fas fa-user-shield"></i>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-lg-8">
                <div class="glass-card">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="fw-black text-gold m-0">@lang('Sales Growth')</h5>
                        <span
                            class="badge rounded-pill bg-dark border border-warning border-opacity-25 px-3">@lang('Last 7 Days')</span>
                    </div>
                    <div class="chart-container">
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="glass-card">
                    <h5 class="fw-black text-gold mb-4">@lang('Orders Distribution')</h5>
                    <div class="chart-container">
                        <canvas id="ordersPieChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="glass-card">
                    <h5 class="fw-black text-gold mb-4">@lang('Immediate hall occupancy')</h5>
                    <div class="d-flex flex-wrap justify-content-center">
                        @foreach ($tablesMap as $table)
                            <div
                                class="table-dot {{ $table->status == 'available' ? 'status-available' : 'status-occupied' }}">
                                {{ $table->table_number }}
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="glass-card">
                    <h5 class="fw-black text-gold mb-4">@lang('Top Selling Items')</h5>
                    @foreach ($topItems as $item)
                        <div class="item-row">
                            <span class="text-white">{{ $item->item_name }}</span>
                            <span class="fw-black text-gold fs-5">{{ $item->total }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="col-md-4">
                <div class="glass-card">
                    <h5 class="fw-black text-gold mb-4">@lang('Management and Supervisors')</h5>
                    @foreach ($employees as $emp)
                        <div class="item-row">
                            <div class="d-flex align-items-center">
                                <div class="bg-gold p-2 rounded-circle me-3" style="width:10px;height:10px"></div>
                                <span class="text-white">{{ $emp->name }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const liveClock = document.getElementById('liveClock');
            const liveDate = document.getElementById('liveDate');

            const now = () => {
                const d = new Date();
                liveClock.innerText = d.toLocaleTimeString('ar-SA');
                liveDate.innerText = d.toLocaleDateString('ar-SA', {
                    weekday: 'long',
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric'
                });
            }
            setInterval(now, 1000);
            now();

            Chart.defaults.color = 'rgba(212, 175, 55, 0.7)';
            Chart.defaults.font.family = 'Cairo';

            new Chart(document.getElementById('salesChart'), {
                type: 'line',
                data: {
                    labels: {!! json_encode($salesData->pluck('date')) !!},
                    datasets: [{
                        label: '@lang('Sales')',
                        data: {!! json_encode($salesData->pluck('total')) !!},
                        borderColor: '#d4af37',
                        backgroundColor: 'rgba(212, 175, 55, 0.1)',
                        fill: true,
                        tension: 0.4,
                        borderWidth: 3,
                        pointBackgroundColor: '#d4af37'
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            grid: {
                                color: 'rgba(255,255,255,0.05)'
                            },
                            border: {
                                display: false
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });

            new Chart(document.getElementById('ordersPieChart'), {
                type: 'doughnut',
                data: {
                    labels: ["{{ __('app.orders.dine_in') }}", "{{ __('app.orders.takeaway') }}"],
                    datasets: [{
                        data: [{{ $dineInCount }}, {{ $takeawayCount }}],
                        backgroundColor: ['#10b981', '#f59e0b'],
                        borderWidth: 0,
                        hoverOffset: 20
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    cutout: '75%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                font: {
                                    size: 14
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
@endsection
