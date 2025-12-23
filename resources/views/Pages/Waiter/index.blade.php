<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>شاشة النادل الملكية - نظام الملكي المطور</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --main-bg: #fdfcf9;
            --primary-gold: #c5a059;
            --dark-charcoal: #1a1a1a;
            --kitchen-blue: #4a90e2;
            --cashier-green: #27ae60;
            --soft-gray: #f4f4f2;
            --ready-green: #2ecc71;
            --preparing-orange: #e67e22;
        }

        body {
            background-color: var(--main-bg);
            font-family: 'Cairo', sans-serif;
            height: 100vh;
            overflow: hidden;
            margin: 0;
        }

        .pos-container { display: flex; height: calc(100vh - 70px); }

        /* الهيدر */
        .royal-header {
            background: #fff;
            padding: 10px 30px;
            border-bottom: 2px solid var(--soft-gray);
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        /* تنسيق الطاولات */
        .tables-grid {
            height: 30%;
            padding: 20px;
            background: var(--soft-gray);
            overflow-y: auto;
            border-bottom: 2px solid #ddd;
        }

        .table-card-new {
            background: white;
            border-radius: 15px;
            padding: 12px;
            text-align: center;
            border: 2px solid transparent;
            transition: all 0.3s ease;
            position: relative;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            text-decoration: none;
            display: block;
            min-height: 90px;
        }

        .table-card-new.active-table {
            border: 2px solid var(--primary-gold);
            background: #fffdf9;
            transform: translateY(-5px);
        }

        .status-badge {
            position: absolute;
            top: -10px;
            left: 50%;
            transform: translateX(-50%);
            padding: 2px 10px;
            border-radius: 20px;
            font-size: 0.65rem;
            font-weight: bold;
            color: white;
        }

        /* المنيو */
        .menu-grid { flex: 1; padding: 20px; overflow-y: auto; }
        .custom-scroll::-webkit-scrollbar { width: 4px; }
        .custom-scroll::-webkit-scrollbar-thumb { background: #ccc; border-radius: 10px; }

        .product-item-btn {
            background: white; border-radius: 15px; padding: 15px;
            border: 1px solid #eee; transition: 0.2s; width: 100%; text-align: right;
        }
        .product-item-btn:hover { border-color: var(--primary-gold); transform: translateY(-3px); }

        /* السلة الجانبية */
        .bill-side { width: 400px; background: var(--dark-charcoal); color: white; display: flex; flex-direction: column; padding: 20px; }
        .bill-items-area { flex: 1; overflow-y: auto; }
        
        .draft-item { background: rgba(255,255,255,0.05); border-radius: 12px; padding: 12px; margin-bottom: 10px; border-right: 4px solid var(--primary-gold); }
        
        .qty-btn { width: 30px; height: 30px; border-radius: 8px; border: none; background: #343a40; color: #fff; }

        .btn-action { border: none; border-radius: 12px; padding: 15px; width: 100%; font-weight: 700; margin-top: 10px; color: #fff; }
    </style>
</head>
<body>

    <header class="royal-header shadow-sm">
        <h4 class="fw-bold mb-0 text-dark"><i class="fas fa-crown text-gold me-2"></i>نظام الملكي</h4>
        <div class="bg-light p-2 px-3 rounded-pill border small">الطاولة المختارة:
            <b class="text-primary">{{ $selectedTable->table_number ?? '---' }}</b>
        </div>
    </header>

    <div class="pos-container">
        <div class="items-side flex-grow-1 d-flex flex-column overflow-hidden">
            <div class="tables-grid custom-scroll">
                <div class="row g-3">
                    @foreach ($tables as $table)
                        <div class="col-4 col-md-2">
                            <a href="?table_id={{ $table->id }}&category_id={{ request('category_id') }}"
                                class="table-card-new {{ request('table_id') == $table->id ? 'active-table' : '' }}">
                                
                                @php $activeOrder = $table->dineInOrders()->whereIn('status', ['pending', 'preparing', 'ready'])->first(); @endphp
                                
                                @if($activeOrder)
                                    <span class="status-badge {{ $activeOrder->status == 'ready' ? 'bg-success' : 'bg-warning text-dark' }}">
                                        {{ $activeOrder->status == 'ready' ? 'جاهز' : 'يُطبخ' }}
                                    </span>
                                @endif

                                <div class="mt-2">
                                    <b class="text-dark fs-5">#{{ $table->table_number }}</b>
                                    <div class="small mt-1 {{ $table->status == 'available' ? 'text-muted' : 'text-danger fw-bold' }}">
                                        {{ $table->status == 'available' ? 'متاحة' : 'مشغولة' }}
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="menu-grid custom-scroll">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold m-0 text-secondary">قائمة المنيو</h5>
                    <div class="dropdown">
                        <button class="btn btn-white border dropdown-toggle rounded-pill px-4 shadow-sm" data-bs-toggle="dropdown">
                            <i class="fas fa-filter me-2 text-gold"></i>
                            {{ $categories->where('id', request('category_id'))->first()->name ?? 'جميع الأقسام' }}
                        </button>
                        <ul class="dropdown-menu shadow border-0">
                            <li><a class="dropdown-item" href="?table_id={{ request('table_id') }}">الكل</a></li>
                            @foreach ($categories as $cat)
                                <li><a class="dropdown-item" href="?category_id={{ $cat->id }}&table_id={{ request('table_id') }}">{{ $cat->name }}</a></li>
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
                                <button type="submit" class="product-item-btn shadow-sm @if(!request('table_id')) disabled @endif">
                                    <h6 class="fw-bold mb-1 text-dark">{{ $item->item_name }}</h6>
                                    <span class="text-gold fw-bold">{{ number_format($item->price) }} ل.س</span>
                                </button>
                            </form>
                        </div>
                    @empty
                        <div class="col-12 text-center mt-5 opacity-50">لا توجد أصناف في هذا القسم</div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="bill-side shadow-lg">
            <h5 class="fw-bold mb-4 border-bottom border-secondary pb-3">تفاصيل الفاتورة</h5>
            
            <div class="bill-items-area custom-scroll">
                @if ($currentOrder)
                    <div class="mb-4">
                        <small class="text-muted d-block mb-2 fw-bold text-uppercase">طلبات المطبخ</small>
                        @foreach ($currentOrder->orderItems as $sent)
                            <div class="d-flex justify-content-between mb-2 opacity-50 small">
                                <span>{{ $sent->item->item_name }} (x{{ $sent->quantity }})</span>
                                <span>{{ number_format($sent->price * $sent->quantity) }}</span>
                            </div>
                        @endforeach
                    </div>
                @endif

                <div class="draft-container">
                    <small class="text-gold d-block mb-2 fw-bold text-uppercase">إضافات جديدة</small>
                    @php $draftTotal = 0; @endphp
                    @forelse($draft as $id => $details)
                        @php $draftTotal += ($details['price'] * $details['quantity']); @endphp
                        <div class="draft-item">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="fw-bold small">{{ $details['name'] }}</span>
                                <span class="text-gold">{{ number_format($details['price'] * $details['quantity']) }}</span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <form action="{{ route('Pages.waiter.updateDraft') }}" method="POST"> @csrf
                                    <input type="hidden" name="table_id" value="{{ request('table_id') }}">
                                    <input type="hidden" name="item_id" value="{{ $id }}">
                                    <input type="hidden" name="action" value="decrease">
                                    <button class="qty-btn"><i class="fas fa-minus small"></i></button>
                                </form>
                                <span class="fw-bold px-2">{{ $details['quantity'] }}</span>
                                <form action="{{ route('Pages.waiter.addToDraft') }}" method="POST"> @csrf
                                    <input type="hidden" name="table_id" value="{{ request('table_id') }}">
                                    <input type="hidden" name="item_id" value="{{ $id }}">
                                    <button class="qty-btn"><i class="fas fa-plus small"></i></button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted text-center small py-4">السلة فارغة</p>
                    @endforelse
                </div>
            </div>

            <div class="footer mt-auto pt-3 border-top border-secondary">
                <div class="d-flex justify-content-between h4 fw-bold mb-4">
                    <span>الإجمالي</span>
                    <span class="text-gold">{{ number_format(($currentOrder->total_amount ?? 0) + $draftTotal) }}</span>
                </div>

                @if(count($draft) > 0)
                    <form action="{{ route('Pages.waiter.storeOrder') }}" method="POST">
                        @csrf
                        <input type="hidden" name="table_id" value="{{ request('table_id') }}">
                        <button type="submit" class="btn-action bg-primary w-100 py-3 shadow mb-2">
                            إرسال للمطبخ <i class="fas fa-fire ms-2"></i>
                        </button>
                    </form>
                @endif

                @if($currentOrder)
                    <form action="{{ route('Pages.waiter.requestBill', $currentOrder->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-action bg-success w-100 py-3 shadow">
                            طلب الحساب <i class="fas fa-file-invoice-dollar ms-2"></i>
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>