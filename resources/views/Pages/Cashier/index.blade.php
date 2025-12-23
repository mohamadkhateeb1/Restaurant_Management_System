<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة التحصيل - نظام الكاشير الذكي</title>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --main-bg: #0f111a;
            --card-bg: #1a1d29;
            --accent-color: #00d2ff;
            --gold-color: #ffc107;
            --success-color: #21c35a;
            --border-color: #2d3245;
        }

        body { 
            background-color: var(--main-bg); 
            color: #e6e8ed; 
            font-family: 'Cairo', sans-serif; 
            min-height: 100vh;
            background-image: radial-gradient(circle at top right, #161b33 0%, #0f111a 100%);
        }

        .page-header {
            background: rgba(26, 29, 41, 0.7);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--border-color);
            padding: 20px 0;
            margin-bottom: 40px;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .bill-card { 
            background: var(--card-bg); 
            border: 1px solid var(--border-color); 
            border-radius: 20px; 
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .bill-card:hover {
            transform: translateY(-10px);
            border-color: var(--accent-color);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.5);
        }

        .bill-card::before {
            content: "";
            position: absolute;
            top: 0;
            right: 0;
            width: 5px;
            height: 100%;
            background: var(--gold-color);
        }

        .table-num { 
            background: linear-gradient(45deg, var(--gold-color), #ff9800);
            color: #000; 
            padding: 10px 20px; 
            border-radius: 12px; 
            font-weight: 800; 
            font-size: 1.1rem;
            box-shadow: 0 4px 15px rgba(255, 193, 7, 0.3);
        }

        .items-list {
            max-height: 180px;
            overflow-y: auto;
            margin: 20px 0;
            padding-left: 5px;
        }

        .item-row {
            background: rgba(255, 255, 255, 0.03);
            border-radius: 10px;
            padding: 8px 12px;
            margin-bottom: 8px;
            border: 1px solid transparent;
        }

        .total-section {
            background: rgba(0, 210, 255, 0.05);
            border-radius: 15px;
            padding: 15px;
            text-align: center;
            border: 1px dashed rgba(0, 210, 255, 0.2);
        }

        .total-amount {
            color: var(--gold-color);
            font-size: 2rem;
            text-shadow: 0 0 20px rgba(255, 193, 7, 0.2);
        }

        .btn-pay {
            background: linear-gradient(45deg, var(--success-color), #17a04a);
            border: none;
            border-radius: 12px;
            padding: 12px;
            font-weight: 700;
            transition: 0.3s;
        }

        .btn-preview {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-color);
            color: #fff;
            border-radius: 12px;
            padding: 10px;
            margin-bottom: 10px;
            transition: 0.3s;
            width: 100%;
        }

        .btn-preview:hover {
            background: rgba(0, 210, 255, 0.1);
            border-color: var(--accent-color);
        }

        .header-actions .btn {
            border-radius: 12px;
            padding: 10px 20px;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-pos {
            background: rgba(0, 210, 255, 0.1);
            border: 1px solid var(--accent-color);
            color: var(--accent-color);
        }

        .btn-history {
            background: rgba(255, 193, 7, 0.1);
            border: 1px solid var(--gold-color);
            color: var(--gold-color);
        }

        .btn-pos:hover { background: var(--accent-color); color: #000; }
        .btn-history:hover { background: var(--gold-color); color: #000; }

        .items-list::-webkit-scrollbar { width: 4px; }
        .items-list::-webkit-scrollbar-thumb { background: #3d425a; border-radius: 10px; }

        .empty-state {
            background: var(--card-bg);
            border-radius: 30px;
            padding: 60px;
            border: 2px dashed var(--border-color);
        }
    </style>
</head>
<body>

<header class="page-header">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h3 class="fw-bold mb-0">
                    <i class="fas fa-cash-register text-info me-2"></i> 
                    مركز التحصيل المالي
                </h3>
                <p class="text-muted small mb-0">متابعة وإغلاق فواتير الطاولات النشطة</p>
            </div>
            <div class="header-actions d-flex gap-2">
                <a href="{{ route('Pages.cashier.invoice') }}" class="btn btn-history">
                    <i class="fas fa-history me-1"></i> سجل الفواتير
                </a>
                <a href="{{ route('Pages.cashier.create') }}" class="btn btn-pos">
                    <i class="fas fa-plus-circle me-1"></i> طلب POS جديد
                </a>
            </div>
        </div>
    </div>
</header>

<div class="container pb-5">
    <div class="row g-4">
        @forelse($pendingDineIn as $order)
        <div class="col-md-6 col-lg-4">
            <div class="bill-card p-4 shadow-lg">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="table-num">طاولة {{ $order->table->table_number }}</span>
                    <div class="text-end">
                        <small class="text-muted d-block">رقم الطلب</small>
                        <span class="badge bg-dark border border-secondary text-info">#{{ substr($order->order_number, -4) }}</span>
                    </div>
                </div>
                
                <div class="items-list custom-scroll">
                    @foreach($order->orderItems as $item)
                        <div class="item-row d-flex justify-content-between align-items-center">
                            <span class="small text-muted">
                                <i class="fas fa-utensils me-2" style="font-size: 10px;"></i>
                                {{ $item->item->item_name }} 
                                <span class="text-info ms-1">×{{ $item->quantity }}</span>
                            </span>
                            <span class="fw-bold small">{{ number_format($item->price * $item->quantity) }}</span>
                        </div>
                    @endforeach
                </div>

                <div class="total-section mb-3">
                    <span class="text-muted small d-block mb-1">صافي المبلغ المستحق</span>
                    <h3 class="total-amount fw-bold mb-0">{{ number_format($order->total_amount) }} <small class="fs-6">ل.س</small></h3>
                </div>

                <button class="btn btn-preview" onclick="alert('فتح معاينة الفاتورة للطلب رقم {{ $order->order_number }}')">
                    <i class="fas fa-search-dollar me-2"></i> معاينة الفاتورة
                </button>

                <form action="{{ route('Pages.cashier.payDineIn') }}" method="POST">
                    @csrf
                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                    <button type="submit" class="btn btn-pay btn-success w-100 fw-bold shadow-sm" onclick="return confirm('تأكيد استلام المبلغ وإغلاق الطاولة؟')">
                        <i class="fas fa-check-double me-2"></i> تأكيد القبض والإغلاق
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <div class="empty-state shadow-lg text-center">
                <i class="fas fa-mug-hot fa-4x text-muted mb-4"></i>
                <h2 class="fw-bold">لا توجد طلبات معلقة</h2>
                <p class="text-muted">كل الطاولات في المطعم تمت محاسبتها بنجاح.</p>
                <a href="{{ route('Pages.cashier.create') }}" class="btn btn-pos px-5 py-3 fw-bold mt-3">
                    إنشاء فاتورة سريعة (POS)
                </a>
            </div>
        </div>
        @endforelse
    </div>
</div>

@if(session('success'))
<div class="position-fixed bottom-0 start-0 p-4" style="z-index: 1050">
    <div class="alert alert-success alert-dismissible fade show shadow-lg border-0 rounded-4 p-3" role="alert" style="background: var(--success-color); color: #000;">
        <div class="d-flex align-items-center">
            <i class="fas fa-check-circle fs-4 me-3"></i>
            <div>
                <strong>تمت العملية!</strong><br>
                {{ session('success') }}
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
</div>
@endif

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>