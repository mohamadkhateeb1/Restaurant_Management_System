<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>نقطة البيع الاحترافية - POS</title>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --dark-bg: #0a0a0b;
            --card-bg: #161618;
            --accent: #0dcaf0;
            --gold: #ffc107;
            --border: #2d2d2f;
        }

        body, html {
            height: 100%;
            margin: 0;
            background-color: var(--dark-bg);
            color: #ffffff;
            font-family: 'Cairo', sans-serif;
        }

        /* الحاوية الرئيسية */
        .pos-container {
            display: flex;
            height: 100vh;
            overflow: hidden; /* منع سكرول الصفحة الأم */
        }

        /* قسم المنتجات (يمين) */
        .products-section {
            flex: 1;
            display: flex;
            flex-direction: column;
            background: radial-gradient(circle at top right, #1a1a1c, #0a0a0b);
            border-left: 1px solid var(--border);
        }

        /* شريط الأقسام */
        .category-bar {
            padding: 15px 20px;
            background: rgba(0, 0, 0, 0.3);
            display: flex;
            gap: 10px;
            overflow-x: auto;
            white-space: nowrap;
            border-bottom: 1px solid var(--border);
        }

        .category-bar::-webkit-scrollbar { height: 4px; }
        .category-bar::-webkit-scrollbar-thumb { background: #333; border-radius: 10px; }

        .cat-btn {
            padding: 10px 25px;
            border-radius: 12px;
            background: var(--card-bg);
            color: #888;
            text-decoration: none;
            border: 1px solid var(--border);
            transition: 0.3s;
        }

        .cat-btn.active, .cat-btn:hover {
            background: var(--accent);
            color: #000;
            font-weight: bold;
            box-shadow: 0 0 15px rgba(13, 202, 240, 0.3);
        }

        /* شبكة المنتجات مع سكرول خاص */
        .products-scroll {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
        }

        .products-scroll::-webkit-scrollbar { width: 5px; }
        .products-scroll::-webkit-scrollbar-thumb { background: #333; }

        .product-item {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 15px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            transition: 0.3s;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .product-item:hover {
            border-color: var(--accent);
            transform: translateY(-5px);
            background: #1c1c1e;
        }

        .product-price {
            color: var(--accent);
            font-weight: bold;
            margin-top: 10px;
            background: rgba(13, 202, 240, 0.1);
            padding: 2px 10px;
            border-radius: 5px;
            display: inline-block;
        }

        /* قسم السلة (يسار) */
        .cart-section {
            width: 380px;
            background: #000000;
            display: flex;
            flex-direction: column;
            border-right: 1px solid var(--border);
        }

        .cart-header {
            padding: 20px;
            background: var(--card-bg);
            border-bottom: 1px solid var(--border);
            font-weight: bold;
            color: var(--accent);
        }

        .cart-items-scroll {
            flex: 1;
            padding: 15px;
            overflow-y: auto;
        }

        .cart-items-scroll::-webkit-scrollbar { width: 4px; }
        .cart-items-scroll::-webkit-scrollbar-thumb { background: #222; }

        .cart-card {
            background: #111;
            border-radius: 12px;
            padding: 12px;
            margin-bottom: 10px;
            border: 1px solid #222;
        }

        /* منطقة الدفع */
        .checkout-area {
            padding: 20px;
            background: #080808;
            border-top: 1px solid var(--border);
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .total-amount {
            font-size: 2rem;
            color: var(--gold);
            font-weight: bold;
        }

        .btn-checkout {
            background: var(--accent);
            color: #000;
            border: none;
            padding: 15px;
            width: 100%;
            border-radius: 12px;
            font-weight: bold;
            font-size: 1.1rem;
        }

        .btn-checkout:disabled { opacity: 0.3; }

        /* موبايل */
        @media (max-width: 992px) {
            .pos-container { flex-direction: column; overflow-y: auto; }
            .cart-section { width: 100%; height: auto; }
            .pos-container { height: auto; }
        }
    </style>
</head>
<body>

<div class="pos-container">
    
    <div class="products-section">
        <div class="p-3 d-flex justify-content-between align-items-center">
            <h5 class="m-0 fw-bold">نقطة البيع <small class="text-muted fw-normal ms-2">| السفري</small></h5>
            <a href="{{ route('Pages.cashier.index') }}" class="btn btn-sm btn-outline-secondary">العودة للتحصيل</a>
        </div>

        <div class="category-bar">
            <a href="{{ route('Pages.cashier.create') }}" class="cat-btn {{ !request('category_id') ? 'active' : '' }}">الكل</a>
            @foreach($categories as $cat)
                <a href="{{ route('Pages.cashier.create', ['category_id' => $cat->id]) }}" 
                   class="cat-btn {{ request('category_id') == $cat->id ? 'active' : '' }}">
                   {{ $cat->name }}
                </a>
            @endforeach
        </div>

        <div class="products-scroll">
            <div class="row g-3">
                @forelse($items as $item)
                <div class="col-6 col-md-4 col-xl-3">
                    <form action="{{ route('Pages.cashier.addToCart') }}" method="POST" class="h-100">
                        @csrf
                        <input type="hidden" name="id" value="{{ $item->id }}">
                        <button type="submit" class="product-item border-0 w-100 shadow-none text-white">
                            <span class="fw-bold d-block">{{ $item->item_name }}</span>
                            <div class="product-price">{{ number_format($item->price, 0) }} ل.س</div>
                        </button>
                    </form>
                </div>
                @empty
                <div class="col-12 text-center py-5 text-muted">لا يوجد أصناف في هذا القسم</div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="cart-section">
        <div class="cart-header d-flex justify-content-between align-items-center">
            <span>الطلب الحالي</span>
            @if(!empty($cart))
            <form action="{{ route('Pages.cashier.clearCart') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-sm btn-link text-danger text-decoration-none p-0">مسح الكل</button>
            </form>
            @endif
        </div>

        <div class="cart-items-scroll">
            @forelse($cart as $id => $item)
            <div class="cart-card">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <span class="fw-bold small">{{ $item['name'] }}</span>
                    <form action="{{ route('Pages.cashier.removeFromCart', $id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-sm text-danger p-0"><i class="fas fa-trash-alt"></i></button>
                    </form>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted">السعر: {{ number_format($item['price'], 0) }} × {{ $item['qty'] }}</small>
                    <span class="text-white fw-bold">{{ number_format($item['price'] * $item['qty'], 0) }}</span>
                </div>
            </div>
            @empty
            <div class="text-center mt-5 text-muted opacity-25">السلة فارغة</div>
            @endforelse
        </div>

        <div class="checkout-area">
            <form action="{{ route('Pages.cashier.storeTakeaway') }}" method="POST">
                @csrf
                <input type="text" name="customer_name" class="form-control mb-3 bg-dark border-secondary text-white shadow-none" placeholder="اسم الزبون (اختياري)">
                
                <div class="total-row">
                    <span class="text-muted">الإجمالي</span>
                    <div class="total-amount">{{ number_format($total, 0) }} <small class="fs-6">ل.س</small></div>
                </div>

                <button type="submit" class="btn-checkout fw-bold" @if(empty($cart)) disabled @endif>
                    تأكيد وقبض الفاتورة
                </button>
            </form>
        </div>
    </div>

</div>

</body>
</html>