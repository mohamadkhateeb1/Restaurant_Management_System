@extends('layouts.app')

@section('title', 'لوحة التحكم - SRMS')
@section('content')

    <div class="container-fluid py-3" dir="rtl">
        {{-- الهيدر العلوي: ترحيب أنيق + ساعة حية --}}
        <div class="d-flex justify-content-between align-items-center mb-4 animated-title">
            <div class="text-white">
                <h2 class="fw-black mb-0">
                    <span class="text-neon-blue">أهلاً بك،</span> {{ auth()->user()->name ?? 'المدير' }} ✨
                </h2>
                <p class="text-muted small">نظرة عامة على نشاط المطعم اليوم</p>
            </div>
            <div class="header-clock p-3 rounded-4 bg-dark-card border border-secondary shadow-sm text-center">
                <h4 class="mb-0 fw-black text-neon-blue font-monospace" id="liveClock"></h4>
                <span class="text-muted small fw-bold" id="liveDate"></span>
            </div>
        </div>

        {{-- قسم التنبيهات --}}
        @if ($lowStockCount > 0)
            <div class="alert alert-glass-danger border-0 mb-4 animated-kpi shadow-sm d-flex align-items-center">
                <i class="fas fa-exclamation-triangle mr-2"></i>
                <div class="ms-2">
                    <strong>تنبيه المخزن:</strong> يوجد ({{ $lowStockCount }}) مواد وصلت للحد الأدنى.
                    <a href="{{ route('Pages.reports.index', ['tab' => 'inventory']) }}"
                        class="text-danger fw-bold ms-2">تأمين النواقص <i class="fas fa-external-link-alt small"></i></a>
                </div>
            </div>
        @endif

        {{-- 1. بطاقات الأداء المحدثة بألوان نيون عميقة --}}
        <div class="row mb-4 animated-kpi">
            {{-- المبيعات - أخضر نيون --}}
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="kpi-card bg-neon-green shadow">
                    <div class="kpi-content">
                        <span class="kpi-label">مبيعات اليوم</span>
                        <h3 class="kpi-value">{{ number_format($todaySales, 0) }} <small>ل.س</small></h3>
                    </div>
                    <div class="kpi-icon"><i class="fas fa-chart-line"></i></div>
                </div>
            </div>

            {{-- الطاولات - أزرق كهربائي --}}
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="kpi-card bg-neon-blue-card shadow">
                    <div class="kpi-content">
                        <span class="kpi-label">طاولات مفتوحة</span>
                        <h3 class="kpi-value">{{ $openTables }}</h3>
                    </div>
                    <div class="kpi-icon"><i class="fas fa-utensils"></i></div>
                </div>
            </div>

            {{-- التحضير - برتقالي متوهج --}}
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="kpi-card bg-neon-orange shadow">
                    <div class="kpi-content">
                        <span class="kpi-label">قيد التحضير</span>
                        <h3 class="kpi-value">{{ $preparingOrders }}</h3>
                    </div>
                    <div class="kpi-icon"><i class="fas fa-fire"></i></div>
                </div>
            </div>

            {{-- الفريق - بنفسجي ملكي --}}
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="kpi-card bg-neon-purple shadow">
                    <div class="kpi-content">
                        <span class="kpi-label">فريق العمل</span>
                        <h3 class="kpi-value">{{ $activeEmployeesCount }}</h3>
                    </div>
                    <div class="kpi-icon"><i class="fas fa-user-friends"></i></div>
                </div>
            </div>
        </div>

        {{-- 2. قسم الرسوم البيانية --}}
        <div class="row mb-4">
            <div class="col-lg-8 mb-4">
                <div class="card bg-dark-card shadow-lg border-0 rounded-4 animated-kpi">
                    <div class="card-header bg-transparent border-0 py-3 text-white">
                        <h5 class="fw-bold mb-0"><i class="fas fa-signal text-neon-blue me-2"></i>تحليل مبيعات الأسبوع</h5>
                    </div>
                    <div class="card-body"><canvas id="salesChart" height="300"></canvas></div>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="card bg-dark-card shadow-lg border-0 rounded-4 animated-kpi">
                    <div class="card-header bg-transparent border-0 py-3 text-white">
                        <h5 class="fw-bold mb-0"><i class="fas fa-pie-chart text-warning me-2"></i>توزيع الطلبات</h5>
                    </div>
                    <div class="card-body d-flex align-items-center justify-content-center"><canvas id="ordersPieChart"
                            height="300"></canvas></div>
                </div>
            </div>
        </div>

        {{-- 3. الجداول --}}
        <div class="row">
            <div class="col-lg-7 mb-4">
                <div class="card bg-dark-card border-0 rounded-4 shadow animated-kpi">
                    <div class="card-header bg-transparent border-0 py-3">
                        <h5 class="text-white fw-bold mb-0">👔 الطاقم الإداري</h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-dark table-hover mb-0 text-center">
                            <thead class="small text-muted text-uppercase">
                                <tr>
                                    <th>المدير</th>
                                    <th>المنصب</th>
                                    <th>تاريخ البدء</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employees as $emp)
                                    <tr>
                                        <td class="fw-bold text-white"><i class="fas fa-shield-alt text-neon-blue me-2"></i>
                                            {{ $emp->name }}</td>
                                        <td><span class="badge badge-info-soft">سوبر أدمن</span></td>
                                        <td class="small text-muted">{{ $emp->created_at->format('Y-m-d') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-5 mb-4">
                <div class="card bg-dark-card border-0 rounded-4 shadow animated-kpi">
                    <div class="card-header bg-transparent border-0 py-3">
                        <h5 class="text-white fw-bold mb-0">🏆 الأصناف الأكثر طلباً</h5>
                    </div>
                    <div class="card-body">
                        @foreach ($topItems as $item)
                            <div
                                class="d-flex justify-content-between align-items-center mb-3 p-2 rounded-3 bg-dark-soft border border-secondary border-opacity-10">
                                <span class="text-white fw-bold">{{ $item->item_name }}</span>
                                <span class="badge badge-warning rounded-pill px-3">{{ $item->total }} طلب</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        :root {
            --neon-blue: #00d2ff;
            --dark-bg: #0d0f11;
            --card-bg: #1a1d20;
        }

        body {
            background-color: var(--dark-bg);
            font-family: 'Cairo', sans-serif;
        }

        .bg-dark-card {
            background-color: var(--card-bg) !important;
        }

        .bg-dark-soft {
            background-color: rgba(255, 255, 255, 0.03);
        }

        .text-neon-blue {
            color: var(--neon-blue);
        }

        .fw-black {
            font-weight: 900 !important;
        }

        /* تصميم الكاردات الجديد */
        .kpi-card {
            position: relative;
            padding: 25px;
            border-radius: 20px;
            overflow: hidden;
            color: white;
            transition: 0.3s;
            border: 1px solid rgba(255, 255, 255, 0.05);
            height: 120px;
            display: flex;
            align-items: center;
        }

        .kpi-card:hover {
            transform: scale(1.03);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.5);
        }

        .kpi-content {
            position: relative;
            z-index: 2;
        }

        .kpi-label {
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            opacity: 0.9;
            display: block;
            margin-bottom: 5px;
        }

        .kpi-value {
            font-size: 1.7rem;
            font-weight: 900;
            margin: 0;
        }

        .kpi-icon {
            position: absolute;
            right: -10px;
            bottom: -10px;
            font-size: 5rem;
            opacity: 0.15;
            transform: rotate(-10deg);
            z-index: 1;
        }

        /* الألوان الجديدة */
        .bg-neon-green {
            background: linear-gradient(135deg, #00b09b, #96c93d);
        }

        .bg-neon-blue-card {
            background: linear-gradient(135deg, #2193b0, #6dd5ed);
        }

        .bg-neon-orange {
            background: linear-gradient(135deg, #f12711, #f5af19);
        }

        .bg-neon-purple {
            background: linear-gradient(135deg, #654ea3, #eaafc8);
        }

        .alert-glass-danger {
            background: rgba(235, 51, 73, 0.1);
            backdrop-filter: blur(10px);
            border-right: 5px solid #eb3349 !important;
            color: #ff6b6b;
        }

        .badge-info-soft {
            background: rgba(0, 210, 255, 0.1);
            color: var(--neon-blue);
            border: 1px solid rgba(0, 210, 255, 0.2);
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animated-title,
        .animated-kpi {
            animation: fadeInUp 0.7s ease-out both;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function updateClockAndDate() {
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
                document.getElementById('liveClock').textContent = now.toLocaleTimeString('ar-SA', timeOptions);
                document.getElementById('liveDate').textContent = now.toLocaleDateString('ar-SA', dateOptions);
            }
            setInterval(updateClockAndDate, 1000);
            updateClockAndDate();

            Chart.defaults.color = '#888';
            new Chart(document.getElementById('salesChart'), {
                type: 'bar',
                data: {
                    labels: {!! json_encode($salesData->pluck('date')) !!},
                    datasets: [{
                        label: 'المبيعات',
                        data: {!! json_encode($salesData->pluck('total')) !!},
                        backgroundColor: 'rgba(0, 210, 255, 0.6)',
                        borderRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
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
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '75%'
                }
            });
        });
    </script>
@endsection
