@extends('layouts.app')

@section('title', 'لوحة التحكم ')
@section('content')

    <style>
        :root {
            --neon-blue: #00d2ff;
            --neon-green: #00ff88;
            --neon-orange: #ff9f43;
            --dark-bg: #0d0f11;
            --card-bg: rgba(26, 29, 32, 0.8);
            --royal-gold: #d4af37;
        }

        body {
            background-color: var(--dark-bg);
            font-family: 'Cairo', sans-serif;
        }

        .fw-black {
            font-weight: 900 !important;
        }

        .glass-panel {
            backdrop-filter: blur(15px);
            background: var(--card-bg);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 25px;
        }

        .kpi-card {
            height: 140px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            padding: 25px;
            color: white;
            transition: 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            overflow: hidden;
        }

        .kpi-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.5);
        }

        .bg-sales {
            background: linear-gradient(135deg, #00b09b, #96c93d);
        }

        .bg-tables {
            background: linear-gradient(135deg, #2193b0, #6dd5ed);
        }

        .bg-preparing {
            background: linear-gradient(135deg, #f12711, #f5af19);
            animation: pulse-red 2s infinite;
        }

        .bg-staff {
            background: linear-gradient(135deg, #654ea3, #eaafc8);
        }

        @keyframes pulse-red {
            0% {
                box-shadow: 0 0 0 0 rgba(241, 39, 17, 0.4);
            }

            70% {
                box-shadow: 0 0 0 15px rgba(241, 39, 17, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(241, 39, 17, 0);
            }
        }

        .table-dot {
            width: 45px;
            height: 45px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: bold;
            margin: 5px;
            transition: 0.3s;
        }

        .status-available {
            background: rgba(0, 255, 136, 0.1);
            border: 1px solid var(--neon-green);
            color: var(--neon-green);
        }

        .status-occupied {
            background: rgba(255, 71, 87, 0.1);
            border: 1px solid #ff4757;
            color: #ff4757;
        }

        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--neon-blue);
            border-radius: 10px;
        }
    </style>

    <div class="container-fluid py-4" dir="rtl">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <div class="text-white">
                <h2 class="fw-black mb-1">@lang('Dashboard')</h2>
                <p class="text-muted small">@lang('Monitoring the restaurant\'s live performance and financial operations')</p>
            </div>
            <div class="header-clock p-3 glass-panel text-center px-5">
                <h4 class="mb-0 fw-black text-neon-blue font-monospace" id="liveClock"></h4>
                <span class="text-muted small fw-bold" id="liveDate"></span>
            </div>
        </div>


        <div class="row mb-5">
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="kpi-card bg-sales">
                    <div class="w-100">
                        <span class="small fw-bold opacity-75">@lang('Today\'s net sales')</span>
                        <h3 class="fw-black mb-2">{{ number_format($todaySales, 0) }} ل.س</h3>
                        <div class="progress" style="height: 4px; background: rgba(255,255,255,0.2);">
                            <div class="progress-bar bg-white" style="width: 65%"></div>
                        </div>
                    </div>
                    <i class="fas fa-wallet position-absolute opacity-25"
                        style="font-size: 4rem; left: -10px; bottom: -10px;"></i>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <div class="kpi-card bg-tables">
                    <div class="w-100">
                        <span class="small fw-bold opacity-75">@lang('Open Tables Now')</span>
                        <h3 class="fw-black mb-0">{{ $openTablesCount }} @lang('Table')</h3>
                    </div>
                    <i class="fas fa-chair position-absolute opacity-25"
                        style="font-size: 4rem; left: -10px; bottom: -10px;"></i>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <div class="kpi-card bg-preparing">
                    <div class="w-100">
                        <span class="small fw-bold opacity-75">@lang('Orders under preparation')</span>
                        <h3 class="fw-black mb-0">{{ $preparingOrders }} @lang('Order')</h3>
                    </div>
                    <i class="fas fa-fire position-absolute opacity-25"
                        style="font-size: 4rem; left: -10px; bottom: -10px;"></i>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <div class="kpi-card bg-staff text-dark">
                    <div class="w-100">
                        <span class="small fw-bold opacity-75 text-white">@lang('Total Employees')</span>
                        <h3 class="fw-black mb-0 text-white">{{ $activeEmployeesCount }} @lang('Employee')</h3>
                    </div>
                    <i class="fas fa-users-cog position-absolute opacity-25"
                        style="font-size: 4rem; left: -10px; bottom: -10px;"></i>
                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-lg-8 mb-4">
                <div class="card glass-panel p-4 h-100">
                    <h5 class="text-white fw-bold mb-4"><i class="fas fa-chart-bar text-neon-blue me-2"></i>@lang('Sales Growth')</h5>
                    <canvas id="salesChart" height="280"></canvas>
                </div>
            </div>

            <div class="col-lg-4 mb-4">
                <div class="card glass-panel p-4 h-100 text-center">
                    <h5 class="text-white fw-bold mb-4 text-start"><i class="fas fa-layer-group text-warning me-2"></i>@lang('Immediate hall occupancy')</h5>
                    <div class="d-flex flex-wrap justify-content-center">
                        @foreach ($tablesMap as $table)
                            <div class="table-dot {{ $table->status == 'available' ? 'status-available' : 'status-occupied' }}"
                                title="طاولة رقم {{ $table->table_number }}">
                                {{ $table->table_number }}
                            </div>
                        @endforeach
                    </div>
                    <div
                        class="mt-4 pt-3 border-top border-secondary border-opacity-25 d-flex justify-content-around small">
                        <span class="text-neon-green"><i class="fas fa-circle me-1"></i>@lang('Available')</span>
                        <span class="text-danger"><i class="fas fa-circle me-1"></i>@lang('Occupied')</span>
                    </div>
                    
                </div>
            </div>
        </div>
        

        <div class="row mt-4">

            {{-- الأكثر طلباً --}}
            <div class="col-lg-4 mb-4">
                <div class="card glass-panel p-4">
                    <h5 class="text-white fw-bold mb-4">@lang('Top Selling Items')</h5>
                    @foreach ($topItems as $item)
                        <div class="d-flex justify-content-between align-items-center mb-3 p-3 rounded-4"
                            style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05)">
                            <span class="text-white fw-bold">{{ $item->item_name }}</span>
                            <span class="badge bg-neon-green text-dark rounded-pill">{{ $item->total }} @lang('Order')
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="col-lg-4 mb-4 text-center">
                <div class="card glass-panel p-4 h-100">
                    <h5 class="text-white fw-bold mb-4 text-start">@lang('Orders Distribution')</h5>
                    <div class="h-100 d-flex align-items-center"><canvas id="ordersPieChart"></canvas></div>
                </div>
            </div>

            <div class="col-lg-4 mb-4">
                <div class="card glass-panel p-4">
                    <h5 class="text-white fw-bold mb-4 text-start">@lang('Restaurant Management')</h5>
                    @foreach ($employees as $emp)
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-neon-blue-card rounded-circle p-2 me-3"
                                style="width: 45px; height: 45px; display: grid; place-items: center;">
                                <i class="fas fa-user-shield text-white"></i>
                            </div>
                            <div>
                                <h6 class="text-white fw-bold mb-0">{{ $emp->name }}</h6>
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
                document.getElementById('liveClock').textContent = now.toLocaleTimeString('ar-SA');
                document.getElementById('liveDate').textContent = now.toLocaleDateString('ar-SA', {
                    weekday: 'long',
                    day: 'numeric',
                    month: 'long'
                });
            }
            setInterval(updateClock, 1000);
            updateClock();

            new Chart(document.getElementById('salesChart'), {
                type: 'line',
                data: {
                    labels: {!! json_encode($salesData->pluck('date')) !!},
                    datasets: [{
                        label: 'إجمالي الدخل',
                        data: {!! json_encode($salesData->pluck('total')) !!},
                        borderColor: '#00d2ff',
                        backgroundColor: 'rgba(0, 210, 255, 0.1)',
                        fill: true,
                        tension: 0.4,
                        borderWeight: 4
                    }]
                },
                options: {
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(255,255,255,0.05)'
                            }
                        }
                    }
                }
            });

            new Chart(document.getElementById('ordersPieChart'), {
                type: 'doughnut',
                data: {
                    labels: ['صالة', 'سفري'],
                    datasets: [{
                        data: [{{ $dineInCount }}, {{ $takeawayCount }}],
                        backgroundColor: ['#00ff88', '#ffc107'],
                        borderWidth: 0
                    }]
                },
                options: {
                    cutout: '80%'
                }
            });
        });
    </script>
@endsection
