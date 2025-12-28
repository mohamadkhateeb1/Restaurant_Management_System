<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>شاشة النادل - SRMS</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&display=swap" rel="stylesheet">

    <style>
        :root {
            --royal-gold: #d4af37;
            --dark-ash: #121416;
            --card-bg: #1c1f22;
            --text-gray: #a0a0a0;
            --accent-blue: #00d2ff;
            --success-green: #2ecc71;
            --warning-orange: #f39c12;
        }

        body {
            background-color: var(--dark-ash);
            font-family: 'Cairo', sans-serif;
            color: #fff;
            height: 100vh;
            overflow: hidden;
            margin: 0;
        }

        .custom-scroll::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        .custom-scroll::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
        }

        .custom-scroll::-webkit-scrollbar-thumb {
            background: var(--royal-gold);
            border-radius: 10px;
        }

        .custom-scroll {
            scrollbar-width: thin;
            scrollbar-color: var(--royal-gold) rgba(255, 255, 255, 0.05);
        }

        .royal-header {
            background: rgba(28, 31, 34, 0.9);
            backdrop-filter: blur(10px);
            padding: 10px 30px;
            border-bottom: 1px solid rgba(212, 175, 55, 0.3);
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .table-indicator {
            background: linear-gradient(45deg, #1c1f22, #2c3136);
            padding: 5px 20px;
            border-radius: 50px;
            border: 1px solid var(--royal-gold);
        }

        .pos-container {
            display: flex;
            height: calc(100vh - 70px);
        }

        .items-side {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .tables-grid {
            height: 150px;
            padding: 20px;
            background: #0e1012;
            overflow-x: auto;
            overflow-y: hidden;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            white-space: nowrap;
        }

        .table-card-new {
            background: var(--card-bg);
            border-radius: 15px;
            padding: 10px;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.05);
            transition: 0.3s;
            text-decoration: none;
            display: inline-block;
            width: 100px;
            margin-left: 10px;
            vertical-align: top;
        }

        .table-card-new.active-table {
            border: 2px solid var(--royal-gold);
            box-shadow: 0 0 15px rgba(212, 175, 55, 0.2);
        }

        .menu-side {
            flex-grow: 1;
            padding: 20px;
            overflow-y: auto;
            background: radial-gradient(circle at top right, #1c1f22, #121416);
        }

        .product-item-btn {
            background: var(--card-bg);
            border-radius: 15px;
            padding: 15px;
            border: 1px solid rgba(255, 255, 255, 0.05);
            width: 100%;
            text-align: right;
            transition: 0.2s;
        }

        .product-item-btn:hover:not(.disabled) {
            border-color: var(--royal-gold);
            transform: translateY(-3px);
        }

        .bill-side {
            width: 380px;
            background: #16181a;
            border-right: 1px solid rgba(212, 175, 55, 0.2);
            display: flex;
            flex-direction: column;
            height: 100%;
            padding: 20px;
        }

        .bill-items-area {
            flex-grow: 1;
            overflow-y: auto;
            margin-bottom: 15px;
        }

        .draft-item {
            background: rgba(212, 175, 55, 0.05);
            border-radius: 12px;
            padding: 12px;
            margin-bottom: 10px;
            border-right: 3px solid var(--royal-gold);
        }

        .qty-btn {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            border: 1px solid rgba(212, 175, 55, 0.3);
            background: transparent;
            color: var(--royal-gold);
        }

        .btn-action-royal {
            border-radius: 12px;
            padding: 15px;
            font-weight: 700;
            width: 100%;
            border: none;
        }

        .btn-send {
            background: var(--royal-gold);
            color: #000;
        }

        .btn-bill {
            background: transparent;
            border: 1px solid var(--success-green);
            color: var(--success-green);
        }
    </style>
</head>

<body>

    <header class="royal-header">
        <div class="d-flex align-items-center">
            <i class="fas fa-crown text-gold me-2 fs-4"></i>
            <h5 class="fw-black mb-0">SRMS <span class="fw-light">PREMIUM</span></h5>
        </div>
        <div class="table-indicator">
            <small class="text-muted">طاولة:</small>
            <b class="text-white ms-1">{{ $selectedTable->table_number ?? '---' }}</b>
        </div>
    </header>

    <div class="pos-container">
        <div class="items-side">
            <div class="tables-grid custom-scroll">
                @foreach ($tables as $table)
                    <a href="?table_id={{ $table->id }}&category_id={{ request('category_id') }}"
                        class="table-card-new {{ request('table_id') == $table->id ? 'active-table' : '' }}">

                        @php
                            $activeOrder = $table
                                ->dineInOrders()
                                ->whereIn('status', ['pending', 'preparing', 'ready'])
                                ->first();
                        @endphp

                        @if ($activeOrder)
                            <div class="badge rounded-pill {{ $activeOrder->status == 'ready' ? 'bg-success' : 'bg-warning text-dark' }} mb-1"
                                style="font-size: 0.6rem;">
                                {{ $activeOrder->status == 'ready' ? 'جاهز' : 'يُطبخ' }}
                            </div>
                        @endif
                        <div class="fw-bold">#{{ $table->table_number }}</div>
                        <small class="{{ $table->status == 'available' ? 'text-success' : 'text-danger' }}"
                            style="font-size: 0.7rem;">
                            {{ $table->status == 'available' ? 'متاحة' : 'مشغولة' }}
                        </small>
                    </a>
                @endforeach
            </div>

            <div class="menu-side custom-scroll">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h6 class="fw-bold m-0 text-muted">قائمة الطعام</h6>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary rounded-pill px-3 dropdown-toggle text-white"
                            data-bs-toggle="dropdown">
                            {{ $categories->where('id', request('category_id'))->first()->name ?? 'كل الأقسام' }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-dark">
                            <li><a class="dropdown-item" href="?table_id={{ request('table_id') }}">الكل</a></li>
                            @foreach ($categories as $cat)
                                <li><a class="dropdown-item"
                                        href="?category_id={{ $cat->id }}&table_id={{ request('table_id') }}">{{ $cat->name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="row g-3">
                    @forelse($items as $item)
                        <div class="col-6 col-md-4 col-xl-3">
                            <form action="{{ route('Pages.waiter.addToDraft') }}" method="POST">
                                @csrf
                                <input type="hidden" name="table_id" value="{{ request('table_id') }}">
                                <input type="hidden" name="item_id" value="{{ $item->id }}">
                                <button type="submit"
                                    class="product-item-btn shadow-sm @if (!request('table_id')) disabled opacity-50 @endif">
                                    <div class="fw-bold small text-white mb-2">{{ $item->item_name }}</div>
                                    <div class="text-gold fw-bold">{{ number_format($item->price) }} <small
                                            style="font-size: 0.6rem;">ل.س</small></div>
                                </button>
                            </form>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5 opacity-25">لا توجد أصناف</div>
                    @endforelse
                </div>
            </div>
        </div>

        <aside class="bill-side">
            <div class="fw-bold mb-3 pb-2 border-bottom border-secondary small">تفاصيل الطلب الحالي</div>

            <div class="bill-items-area custom-scroll">
                @if ($currentOrder)
                    @foreach ($currentOrder->orderItems as $sent)
                        <div class="d-flex justify-content-between mb-2 small opacity-50 px-2">
                            <span>{{ $sent->item->item_name }} x{{ $sent->quantity }}</span>
                            <span>{{ number_format($sent->price * $sent->quantity) }}</span>
                        </div>
                    @endforeach
                @endif

                <div class="mt-3">
                    @php $draftTotal = 0; @endphp
                    @forelse($draft as $id => $details)
                        @php $draftTotal += ($details['price'] * $details['quantity']); @endphp
                        <div class="draft-item">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="small fw-bold">{{ $details['name'] }}</span>
                                <span
                                    class="text-gold small">{{ number_format($details['price'] * $details['quantity']) }}</span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <form action="{{ route('Pages.waiter.updateDraft') }}" method="POST"> @csrf
                                    <input type="hidden" name="table_id" value="{{ request('table_id') }}">
                                    <input type="hidden" name="item_id" value="{{ $id }}">
                                    <input type="hidden" name="action" value="decrease">
                                    <button class="qty-btn"><i class="fas fa-minus small"></i></button>
                                </form>
                                <span class="fw-bold">{{ $details['quantity'] }}</span>
                                <form action="{{ route('Pages.waiter.addToDraft') }}" method="POST"> @csrf
                                    <input type="hidden" name="table_id" value="{{ request('table_id') }}">
                                    <input type="hidden" name="item_id" value="{{ $id }}">
                                    <button class="qty-btn"><i class="fas fa-plus small"></i></button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5 opacity-25 small">السلة فارغة</div>
                    @endforelse
                </div>
            </div>

            <div class="bill-footer pt-3 border-top border-secondary">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted small">المجموع الإجمالي</span>
                    <span
                        class="h5 fw-black text-gold mb-0">{{ number_format(($currentOrder->total_amount ?? 0) + $draftTotal) }}</span>
                </div>

                @if (count($draft) > 0)
                    <form action="{{ route('Pages.waiter.storeOrder') }}" method="POST">
                        @csrf
                        <input type="hidden" name="table_id" value="{{ request('table_id') }}">
                        <button type="submit" class="btn-action-royal btn-send mb-2">إرسال للمطبخ</button>
                    </form>
                @endif

                @if ($currentOrder)
                    <form action="{{ route('Pages.waiter.requestBill', $currentOrder->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-action-royal btn-bill">طلب الحساب</button>
                    </form>
                @endif
            </div>
        </aside>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
