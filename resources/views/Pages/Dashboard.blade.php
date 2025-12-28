@extends('Layouts.app')

@section('title', 'لوحة التحكم ')
@section('content')

    <style>
        :root {
            --neon-blue: #00d2ff;
            --neon-green: #00ff88;
            --neon-orange: #ff9f43;
            --dark-bg: #090b0d;
            --card-bg: rgba(23, 26, 30, 0.85);
            --glass-border: rgba(255, 255, 255, 0.08);
        }

        body {
            background-color: var(--dark-bg);
            background-image: radial-gradient(circle at top right, rgba(0, 210, 255, 0.03), transparent),
                radial-gradient(circle at bottom left, rgba(0, 255, 136, 0.03), transparent);
            font-family: 'Cairo', sans-serif;
            color: #e0e0e0;
        }

        .fw-black {
            font-weight: 900 !important;
        }

        .glass-panel {
            backdrop-filter: blur(20px);
            background: var(--card-bg);
            border: 1px solid var(--glass-border);
            border-radius: 24px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.4);
        }

        .kpi-card {
            height: 150px;
            border-radius: 22px;
            display: flex;
            align-items: center;
            padding: 25px;
            color: white;
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .kpi-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.6);
        }

        .bg-sales {
            background: linear-gradient(135deg, #11998e, #38ef7d);
        }

        .bg-tables {
            background: linear-gradient(135deg, #00c6ff, #0072ff);
        }

        .bg-preparing {
            background: linear-gradient(135deg, #ee0979, #ff6a00);
            animation: pulse-red 2.5s infinite;
        }

        .bg-staff {
            background: linear-gradient(135deg, #6a11cb, #2575fc);
        }

        @keyframes pulse-red {
            0% {
                box-shadow: 0 0 0 0 rgba(238, 9, 121, 0.4);
            }

            70% {
                box-shadow: 0 0 0 20px rgba(238, 9, 121, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(238, 9, 121, 0);
            }
        }

        .table-dot {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            font-weight: 800;
            margin: 6px;
            transition: 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: default;
        }

        .status-available {
            background: rgba(0, 255, 136, 0.05);
            border: 2px solid var(--neon-green);
            color: var(--neon-green);
            box-shadow: inset 0 0 10px rgba(0, 255, 136, 0.1);
        }

        .status-occupied {
            background: rgba(255, 71, 87, 0.05);
            border: 2px solid #ff4757;
            color: #ff4757;
            box-shadow: inset 0 0 10px rgba(255, 71, 87, 0.1);
        }

        .table-dot:hover {
            transform: scale(1.1);
            z-index: 5;
        }

        .user-profile-tag {
            background: rgba(255, 255, 255, 0.03);
            padding: 8px 20px;
            border-radius: 50px;
            border: 1px solid var(--glass-border);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-avatar-small {
            width: 32px;
            height: 32px;
            background: var(--neon-blue);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #000;
            font-weight: bold;
        }

        .chart-container {
            position: relative;
            height: 320px;
            width: 100%;
        }

        .item-row {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.05);
            transition: 0.3s;
        }

        .item-row:hover {
            background: rgba(255, 255, 255, 0.05);
            border-color: var(--neon-blue);
        }
    </style>

    <div class="container-fluid py-4" dir="rtl">
        <div class="d-flex justify-content-between align-items-start mb-5 flex-wrap gap-4">
            <div>
                <h1 class="fw-black mb-1 text-white tracking-tight">@lang('Dashboard')</h1>
                <div class="user-profile-tag mt-2">
                    <div class="user-avatar-small"><i class="fas fa-user"></i></div>
                    <span class="text-white-50 small fw-bold">@lang('Welcome back'), <span
                            class="text-white">{{ Auth::user()->name }}</span></span>
                    <span
                        class="badge bg-success bg-opacity-25 text-success border border-success border-opacity-25 rounded-pill px-3">@lang('Online')</span>
                </div>
            </div>
            <div class="header-clock p-4 glass-panel text-center px-5" style="border-right: 4px solid var(--neon-blue);">
                <h3 class="mb-0 fw-black text-neon-blue font-monospace" id="liveClock" style="letter-spacing: 2px;">00:00:00
                </h3>
                <span class="text-muted small fw-bold mt-1 d-block" id="liveDate">--------</span>
            </div>
        </div>

        <div class="row mb-5">
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="kpi-card bg-sales shadow-lg">
                    <div class="w-100">
                        <span class="small fw-bold text-uppercase opacity-75">@lang('Today\'s net sales')</span>
                        <h2 class="fw-black my-2">{{ number_format($todaySales, 0) }} <small
                                style="font-size: 0.5em">ل.س</small></h2>
                        <div class="progress" style="height: 5px; background: rgba(255,255,255,0.2); border-radius: 10px;">
                            <div class="progress-bar bg-white shadow-sm" style="width: 80%"></div>
                        </div>
                    </div>
                    <i class="fas fa-coins position-absolute opacity-25"
                        style="font-size: 5rem; left: -15px; bottom: -10px;"></i>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <div class="kpi-card bg-tables">
                    <div class="w-100">
                        <span class="small fw-bold text-uppercase opacity-75">@lang('Open Tables Now')</span>
                        <h2 class="fw-black mb-0">{{ $openTablesCount }} <small
                                style="font-size: 0.5em">@lang('Table')</small></h2>
                    </div>
                    <i class="fas fa-utensils position-absolute opacity-25"
                        style="font-size: 5rem; left: -15px; bottom: -10px;"></i>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <div class="kpi-card bg-preparing">
                    <div class="w-100">
                        <span class="small fw-bold text-uppercase opacity-75">@lang('Orders under preparation')</span>
                        <h2 class="fw-black mb-0">{{ $preparingOrders }} <small
                                style="font-size: 0.5em">@lang('Order')</small></h2>
                    </div>
                    <i class="fas fa-fire position-absolute opacity-25"
                        style="font-size: 5rem; left: -15px; bottom: -10px;"></i>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <div class="kpi-card bg-staff">
                    <div class="w-100">
                        <span class="small fw-bold text-uppercase opacity-75">@lang('Total Employees')</span>
                        <h2 class="fw-black mb-0">{{ $activeEmployeesCount }} <small
                                style="font-size: 0.5em">@lang('Employee')</small></h2>
                    </div>
                    <i class="fas fa-user-shield position-absolute opacity-25"
                        style="font-size: 5rem; left: -15px; bottom: -10px;"></i>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 mb-4">
                <div class="card glass-panel p-4 h-100">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="text-white fw-bold m-0"><i
                                class="fas fa-chart-line text-neon-blue me-3"></i>@lang('Sales Growth')</h5>
                        <span class="badge bg-dark text-neon-blue border border-info border-opacity-25 px-3 py-2 small">
                            @lang('Last 7 Days')
                        </span>
                    </div>
                    <div class="chart-container">
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 mb-4">
                <div class="card glass-panel p-4 h-100">
                    <h5 class="text-white fw-bold mb-4 text-start"><i
                            class="fas fa-border-all text-warning me-2"></i>@lang('Immediate hall occupancy')</h5>
                    <div class="d-flex flex-wrap justify-content-start align-content-start overflow-auto pe-2"
                        style="max-height: 250px;">
                        @foreach ($tablesMap as $table)
                            <div class="table-dot {{ $table->status == 'available' ? 'status-available' : 'status-occupied' }}"
                                title="طاولة رقم {{ $table->table_number }}">
                                {{ $table->table_number }}
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-4 pt-4 border-top border-white border-opacity-10 d-flex justify-content-around">
                        <span class="small text-neon-green fw-bold"><i
                                class="fas fa-circle me-1 small"></i>@lang('Available')</span>
                        <span class="small text-danger fw-bold"><i
                                class="fas fa-circle me-1 small"></i>@lang('Occupied')</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-lg-4 mb-4">
                <div class="card glass-panel p-4 h-100">
                    <h5 class="text-white fw-bold mb-4"><i class="fas fa-medal text-warning me-2"></i>@lang('Top Selling Items')
                    </h5>
                    @foreach ($topItems as $item)
                        <div class="d-flex justify-content-between align-items-center p-3 rounded-4 mb-2 item-row">
                            <span class="text-white-50 fw-bold">{{ $item->item_name }}</span>
                            <span class="badge bg-neon-blue text-dark fw-black rounded-pill">{{ $item->total }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="col-lg-4 mb-4">
                <div class="card glass-panel p-4 h-100">
                    <h5 class="text-white fw-bold mb-4 text-start"><i
                            class="fas fa-chart-pie text-neon-green me-2"></i>@lang('Orders Distribution')</h5>
                    <div class="chart-container d-flex align-items-center justify-content-center">
                        <canvas id="ordersPieChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 mb-4">
                <div class="card glass-panel p-4 h-100">
                    <h5 class="text-white fw-bold mb-4 text-start"><i
                            class="fas fa-users-cog text-neon-blue me-2"></i>@lang('Management and Supervisors')</h5>
                    @foreach ($employees as $emp)
                        <div class="d-flex align-items-center mb-3 p-3 rounded-4 item-row">
                            <div class="rounded-circle shadow-sm me-3 d-flex align-items-center justify-content-center"
                                style="width: 42px; height: 42px; background: linear-gradient(45deg, var(--neon-blue), #0072ff);">
                                <i class="fas fa-user-shield text-white small"></i>
                            </div>
                            <div class="ms-3">
                                <h6 class="text-white fw-bold mb-0">{{ $emp->name }}</h6>
                                <small class="text-muted">مشرف نظام</small>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function updateClock() {
                const now = new Date();
                const timeOptions = {
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit',
                    hour12: true
                };
                const dateOptions = {
                    weekday: 'long',
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric'
                };

                if (document.getElementById('liveClock'))
                    document.getElementById('liveClock').textContent = now.toLocaleTimeString('ar-SA', timeOptions);
                if (document.getElementById('liveDate'))
                    document.getElementById('liveDate').textContent = now.toLocaleDateString('ar-SA', dateOptions);
            }
            setInterval(updateClock, 1000);
            updateClock();

            Chart.defaults.color = 'rgba(255, 255, 255, 0.5)';
            Chart.defaults.font.family = "'Cairo', sans-serif";

            const salesCtx = document.getElementById('salesChart');
            if (salesCtx) {
                new Chart(salesCtx, {
                    type: 'line',
                    data: {
                        labels: {!! json_encode($salesData->pluck('date')) !!},
                        datasets: [{
                            label: 'المبيعات',
                            data: {!! json_encode($salesData->pluck('total')) !!},
                            borderColor: '#00d2ff',
                            backgroundColor: 'rgba(0, 210, 255, 0.08)',
                            fill: true,
                            tension: 0.45,
                            borderWidth: 4,
                            pointRadius: 5,
                            pointBackgroundColor: '#fff',
                            pointBorderColor: '#00d2ff',
                            pointBorderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: 'rgba(255,255,255,0.05)',
                                    drawBorder: false
                                },
                                ticks: {
                                    font: {
                                        size: 11
                                    }
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    font: {
                                        size: 11
                                    }
                                }
                            }
                        }
                    }
                });
            }

            const pieCtx = document.getElementById('ordersPieChart');
            if (pieCtx) {
                new Chart(pieCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['صالة', 'سفري'],
                        datasets: [{
                            data: [{{ $dineInCount }}, {{ $takeawayCount }}],
                            backgroundColor: ['#00ff88', '#ffc107'],
                            hoverOffset: 12,
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '80%',
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    padding: 25,
                                    usePointStyle: true,
                                    color: '#fff'
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>
@endsection
