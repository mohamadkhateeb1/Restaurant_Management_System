<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مطبخ المطعم - إدارة الطلبات الاحترافية</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --dark-bg: #0a0a0a;
            --card-bg: #141414;
            --gold-primary: #c5a059;
            --gold-secondary: #8e6d3d;
            --glass-border: rgba(255, 255, 255, 0.03);
            --text-muted: #7a7a7a;
        }

        body {
            background-color: var(--dark-bg);
            color: #d1d1d1;
            font-family: 'Cairo', sans-serif;
        }

        .kitchen-title {
            background: var(--card-bg);
            padding: 25px;
            border-bottom: 1px solid var(--glass-border);
            margin-bottom: 40px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        }

        .order-card {
            background: var(--card-bg);
            border-radius: 20px;
            margin-bottom: 30px;
            border: 1px solid var(--glass-border);
            box-shadow: 15px 15px 35px rgba(0, 0, 0, 0.6);
            transition: transform 0.3s ease, border-color 0.3s ease;
            overflow: hidden;
            position: relative;
        }

        .order-card:hover {
            transform: translateY(-8px);
            border-color: var(--gold-secondary);
        }

        .status-indicator {
            position: absolute;
            top: 0;
            right: 0;
            left: 0;
            height: 4px;
        }

        .status-pending-line {
            background: var(--gold-secondary);
        }

        .status-preparing-line {
            background: #0dcaf0;
            opacity: 0.6;
        }

        .card-header-status {
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: rgba(255, 255, 255, 0.01);
            border-bottom: 1px solid var(--glass-border);
        }

        .time-badge {
            font-size: 0.75rem;
            color: var(--text-muted);
            display: block;
            margin-top: 4px;
        }

        .item-list-container {
            background: rgba(0, 0, 0, 0.2);
            padding: 15px;
            margin: 20px;
            border-radius: 15px;
            border: 1px solid rgba(255, 255, 255, 0.02);
        }

        .item-row {
            padding: 12px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.03);
        }

        .item-row:last-child {
            border-bottom: none;
        }

        .item-name {
            font-weight: 300;
            font-size: 1.1rem;
            color: #efefef;
        }

        .qty-badge {
            background: #1a1a1a;
            color: var(--gold-primary);
            border: 1px solid rgba(197, 160, 89, 0.2);
            padding: 4px 10px;
            border-radius: 8px;
            font-family: monospace;
            font-weight: bold;
        }

        .btn-action {
            border-radius: 0 0 20px 20px;
            padding: 15px;
            font-weight: bold;
            font-size: 1rem;
            border: none;
            transition: 0.3s;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-start {
            background: transparent;
            color: var(--gold-primary);
            border-top: 1px solid var(--glass-border);
        }

        .btn-start:hover {
            background: rgba(197, 160, 89, 0.05);
            color: #fff;
        }

        .btn-done {
            background: linear-gradient(145deg, var(--gold-primary), var(--gold-secondary));
            color: #000;
        }

        .btn-done:hover {
            filter: brightness(1.1);
            box-shadow: 0 5px 15px rgba(197, 160, 89, 0.3);
        }

        .empty-state {
            text-align: center;
            padding: 150px 20px;
            color: var(--text-muted);
        }

        .text-gold {
            color: var(--gold-primary) !important;
        }

        .fw-light {
            font-weight: 300 !important;
        }
    </style>
</head>

<body>

    <div class="kitchen-title text-center">
        <h2 class="fw-light mb-1">
            <i class="fas fa-fire-alt text-gold me-2"></i>
            شاشة التحكم في الإنتاج
        </h2>
        <small class="text-muted text-uppercase" style="letter-spacing: 2px;">نظام إدارة المطبخ الملكي</small>
    </div>

    <div class="container-fluid px-5">
        <div class="row">
            @forelse($orders as $order)
                <div class="col-md-6 col-lg-4 col-xl-3">
                    <div class="order-card">
                        <div
                            class="status-indicator {{ $order->status == 'pending' ? 'status-pending-line' : 'status-preparing-line' }}">
                        </div>

                        <div class="card-header-status">
                            <div>
                                <h5 class="mb-0 fw-bold">
                                    @if ($order->table_id)
                                        <i class="fas fa-chair text-gold me-1 small"></i> <span
                                            class="fw-light">طاولة</span>
                                        {{ $order->table->table_number }}
                                    @else
                                        <i class="fas fa-shopping-bag text-gold me-1 small"></i> <span
                                            class="fw-light">سفري</span>
                                    @endif
                                </h5>
                                <span class="time-badge">
                                    <i class="far fa-clock me-1"></i> منذ {{ $order->created_at->diffForHumans() }}
                                </span>
                            </div>
                            <span
                                class="badge rounded-pill border {{ $order->status == 'pending' ? 'border-warning text-warning' : 'border-info text-info' }} px-3 py-2 bg-transparent small fw-light">
                                {{ $order->status == 'pending' ? 'بانتظار البدء' : 'جاري التحضير' }}
                            </span>
                        </div>

                        <div class="item-list-container">
                            @foreach ($order->orderItems as $item)
                                <div class="item-row d-flex justify-content-between align-items-center">
                                    <span class="item-name">
                                        {{ $item->item->item_name }}
                                    </span>
                                    <span class="qty-badge">
                                        x{{ $item->quantity }}
                                    </span>
                                </div>
                            @endforeach
                        </div>

                        <form action="{{ route('Pages.kitchen.updateStatus') }}" method="POST">
                            @csrf
                            <input type="hidden" name="order_id" value="{{ $order->id }}">

                            @if ($order->status == 'pending')
                                <input type="hidden" name="status" value="preparing">
                                <button type="submit" class="btn-action btn-start w-100">
                                    <i class="fas fa-play me-2 small"></i> بدء التجهيز
                                </button>
                            @else
                                <input type="hidden" name="status" value="ready">
                                <button type="submit" class="btn-action btn-done w-100">
                                    <i class="fas fa-check-circle me-2"></i> اكتمل الطلب
                                </button>
                            @endif
                        </form>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="empty-state">
                        <i class="fas fa-concierge-bell fa-4x mb-4 opacity-25"></i>
                        <h3 class="fw-light text-white-50">لا توجد طلبات قيد الانتظار</h3>
                        <p class="small text-muted">المطبخ يعمل بكفاءة تامة حالياً</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <script>
        // تحديث تلقائي كل دقيقة
        setTimeout(function() {
            location.reload();
        }, 60000);
    </script>

</body>

</html>
