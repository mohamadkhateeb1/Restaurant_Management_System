<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مطبخ المطعم - إدارة الطلبات الاحترافية</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #121212;
            color: #e0e0e0;
            font-family: 'Cairo', sans-serif;
        }

        .kitchen-title {
            background: #1a1a1a;
            padding: 20px;
            border-bottom: 2px solid #333;
            margin-bottom: 30px;
        }

        .order-card {
            background: #1e1e1e;
            border-radius: 15px;
            margin-bottom: 25px;
            border: 1px solid #333;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            transition: transform 0.2s;
            overflow: hidden;
        }

        .order-card:hover {
            transform: translateY(-5px);
        }

        .card-header-status {
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #333;
        }

        .status-pending {
            border-top: 6px solid #ffc107;
        }

        .status-preparing {
            border-top: 6px solid #0dcaf0;
        }

        .time-badge {
            font-size: 0.8rem;
            color: #bbb;
        }

        .item-list-container {
            background: #252525;
            padding: 15px;
            margin: 15px;
            border-radius: 10px;
        }

        .item-row {
            padding: 8px 0;
            border-bottom: 1px solid #383838;
        }

        .item-row:last-child {
            border-bottom: none;
        }

        .btn-action {
            border-radius: 0 0 15px 15px;
            padding: 12px;
            font-weight: bold;
            font-size: 1.1rem;
            border: none;
            transition: 0.3s;
        }

        .btn-start {
            background-color: #0dcaf0;
            color: #000;
        }

        .btn-start:hover {
            background-color: #0bb5d9;
        }

        .btn-done {
            background-color: #198754;
            color: white;
        }

        .btn-done:hover {
            background-color: #157347;
        }

        .empty-state {
            text-align: center;
            padding: 100px;
            color: #555;
        }
    </style>
</head>

<body>

    <div class="kitchen-title text-center shadow">
        <h2 class="mb-0">
            <i class="fas fa-utensils text-danger me-2"></i>
            شاشة تحضير الطلبات النشطة
        </h2>
        <small class="text-muted">نظام إدارة المطبخ الموحد</small>
    </div>

    <div class="container-fluid px-4">
        <div class="row">
            @forelse($orders as $order)
                <div class="col-md-6 col-lg-4 col-xl-3">
                    <div class="order-card {{ $order->status == 'pending' ? 'status-pending' : 'status-preparing' }}">

                        <div class="card-header-status">
                            <div>
                                <h5 class="mb-0 fw-bold">
                                    @if ($order->table_id)
                                        <i class="fas fa-chair text-muted me-1"></i> طاولة
                                        {{ $order->table->table_number }}
                                    @else
                                        <i class="fas fa-shopping-bag text-warning me-1"></i> سفري
                                    @endif
                                </h5>
                                <span class="time-badge">
                                    <i class="far fa-clock"></i> منذ {{ $order->created_at->diffForHumans() }}
                                </span>
                            </div>
                            <span
                                class="badge {{ $order->status == 'pending' ? 'bg-warning text-dark' : 'bg-info text-dark' }} px-3 py-2">
                                {{ $order->status == 'pending' ? 'بانتظار البدء' : 'جاري التحضير' }}
                            </span>
                        </div>

                        <div class="item-list-container">
                            @foreach ($order->orderItems as $item)
                                <div class="item-row d-flex justify-content-between align-items-center">
                                    <span class="fs-5">
                                        <i class="fas fa-caret-left text-secondary me-1"></i>
                                        {{ $item->item->item_name }}
                                    </span>
                                    <span class="badge bg-dark border border-secondary text-info fs-6">
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
                                    <i class="fas fa-fire-alt me-2"></i> بدء الطهي الآن
                                </button>
                            @else
                                <input type="hidden" name="status" value="ready">
                                <button type="submit" class="btn-action btn-done w-100">
                                    <i class="fas fa-concierge-bell me-2"></i> الطلب جاهز للتسليم
                                </button>
                            @endif
                        </form>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <i class="fas fa-check-circle fa-5x mb-3 text-secondary"></i>
                    <h3>لا توجد طلبات جديدة حالياً</h3>
                    <p>المطبخ نظيف وجاهز للطلبات القادمة</p>
                </div>
            @endforelse
        </div>
    </div>

    <script>
        setTimeout(function() {
            location.reload();
        }, 60000);
    </script>

</body>

</html>
