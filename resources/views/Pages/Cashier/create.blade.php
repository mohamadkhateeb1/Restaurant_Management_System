<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>نقطة البيع - SRMS</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&display=swap" rel="stylesheet">

    <style>
        :root {
            --dark-bg: #0d0f11;
            --card-bg: #1a1d20;
            --accent: #00d2ff;
            --gold: #d4af37;
            --border: rgba(255, 255, 255, 0.05);
        }

        body,
        html {
            height: 100%;
            margin: 0;
            background-color: var(--dark-bg);
            color: #ffffff;
            font-family: 'Cairo', sans-serif;
            overflow: hidden;
        }

        .pos-container {
            display: flex;
            height: 100vh;
        }

        /* قسم المنتجات */
        .products-section {
            flex: 1;
            display: flex;
            flex-direction: column;
            background: #0d0f11;
            border-left: 1px solid var(--border);
        }

        .category-bar {
            padding: 15px;
            display: flex;
            gap: 10px;
            overflow-x: auto;
            background: #141619;
            border-bottom: 1px solid var(--border);
        }

        .cat-btn {
            padding: 8px 20px;
            border-radius: 50px;
            background: #1c1f22;
            color: #aaa;
            text-decoration: none;
            border: 1px solid var(--border);
            white-space: nowrap;
            transition: 0.3s;
        }

        .cat-btn.active {
            background: var(--accent);
            color: #000;
            font-weight: bold;
            border-color: var(--accent);
        }

        .products-scroll {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
        }

        .product-item {
            background: var(--card-bg);
            border-radius: 15px;
            padding: 15px;
            text-align: center;
            cursor: pointer;
            transition: 0.2s;
            border: 1px solid var(--border);
            height: 100%;
        }

        .product-item:hover {
            border-color: var(--accent);
            background: #22262a;
            transform: translateY(-3px);
        }

        /* قسم السلة */
        .cart-section {
            width: 400px;
            background: #141619;
            display: flex;
            flex-direction: column;
        }

        .cart-header {
            padding: 20px;
            background: #1a1d20;
            border-bottom: 1px solid var(--border);
        }

        .cart-items-scroll {
            flex: 1;
            padding: 15px;
            overflow-y: auto;
        }

        .cart-card {
            background: #1c1f22;
            border-radius: 12px;
            padding: 12px;
            margin-bottom: 10px;
            border-right: 4px solid var(--accent);
        }

        .checkout-area {
            padding: 20px;
            background: #1a1d20;
            border-top: 1px solid var(--border);
        }

        .total-amount {
            font-size: 2.2rem;
            color: var(--accent);
            font-weight: 900;
        }

        .btn-preview-pos {
            background: rgba(212, 175, 55, 0.1);
            color: var(--gold);
            border: 1px solid var(--gold);
            width: 100%;
            padding: 12px;
            border-radius: 12px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .btn-checkout-pos {
            background: var(--accent);
            color: #000;
            border: none;
            width: 100%;
            padding: 15px;
            border-radius: 12px;
            font-weight: 900;
            font-size: 1.2rem;
        }

        /* ستايل الفاتورة للطباعة */
        @media print {
            body * {
                visibility: hidden;
            }

            #posPrintSection,
            #posPrintSection * {
                visibility: visible;
            }

            #posPrintSection {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                color: black !important;
                background: white !important;
            }
        }

        .pdf-export-container {
            background: white !important;
            color: black !important;
            padding: 20px;
            direction: rtl;
        }
    </style>
</head>

<body>

    <div class="pos-container">
        <div class="products-section">
            <div class="p-3 d-flex justify-content-between align-items-center bg-dark">
                <h5 class="m-0 fw-black text-info">نقطة البيع <small class="text-muted fw-normal ms-2">| الطلبات
                        السفرية</small></h5>
                <a href="{{ route('Pages.cashier.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill">إلغاء
                    والعودة</a>
            </div>

            <div class="category-bar">
                <a href="{{ route('Pages.cashier.create') }}"
                    class="cat-btn {{ !request('category_id') ? 'active' : '' }}">الكل</a>
                @foreach ($categories as $cat)
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
                                <button type="submit" class="product-item border-0 w-100 text-white shadow-sm">
                                    <span class="fw-bold d-block">{{ $item->item_name }}</span>
                                    <div class="mt-2 fw-black text-info">{{ number_format($item->price, 0) }} ل.س</div>
                                </button>
                            </form>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5 text-muted">لا توجد أصناف متوفرة حالياً</div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="cart-section">
            <div class="cart-header d-flex justify-content-between align-items-center">
                <h6 class="m-0 fw-bold"><i class="fas fa-shopping-basket me-2"></i> سلة الطلبات</h6>
                @if (!empty($cart))
                    <form action="{{ route('Pages.cashier.clearCart') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-sm text-danger small p-0 fw-bold">تفريغ السلة</button>
                    </form>
                @endif
            </div>

            <div class="cart-items-scroll">
                @forelse($cart as $id => $item)
                    <div class="cart-card">
                        <div class="d-flex justify-content-between align-items-start mb-1">
                            <span class="fw-bold small">{{ $item['name'] }}</span>
                            <form action="{{ route('Pages.cashier.removeFromCart', $id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm text-danger p-0"><i
                                        class="fas fa-times-circle"></i></button>
                            </form>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">{{ $item['qty'] }} ×
                                {{ number_format($item['price']) }}</small>
                            <span class="fw-bold text-accent">{{ number_format($item['price'] * $item['qty']) }}</span>
                        </div>
                    </div>
                @empty
                    <div class="text-center mt-5 text-muted opacity-50">
                        <i class="fas fa-cart-plus fa-3x mb-3"></i>
                        <p>ابدأ بإضافة الأصناف</p>
                    </div>
                @endforelse
            </div>

            <div class="checkout-area">
                <form id="posMainForm" action="{{ route('Pages.cashier.storeTakeaway') }}" method="POST">
                    @csrf
                    <div class="total-row d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted fw-bold">الإجمالي النهائي</span>
                        <div class="total-amount">{{ number_format($total, 0) }}</div>
                    </div>

                    <input type="text" name="customer_name" id="customer_name_input"
                        class="form-control mb-3 bg-dark border-secondary text-white rounded-3 shadow-none"
                        placeholder="اسم الزبون (اختياري)">

                    <button type="button" class="btn-preview-pos fw-bold"
                        @if (empty($cart)) disabled @endif onclick="openPosPreview()">
                        <i class="fas fa-eye me-2"></i> معاينة وطباعة
                    </button>

                    <button type="submit" class="btn-checkout-pos fw-black shadow"
                        @if (empty($cart)) disabled @endif>
                        تأكيد وقبض الفاتورة
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="posPreviewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark border-secondary">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-black text-info">مراجعة الفاتورة 🧾</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div id="posPrintSection" class="modal-body p-4 text-center text-white">
                    <div class="receipt-header border-bottom border-secondary pb-3 mb-3">
                        <h4 class="fw-black mb-1">فاتورة طلب سفري</h4>
                        <p class="small text-muted mb-0">نظام إدارة المطعم الذكي - SRMS</p>
                        <p class="small text-muted mb-0" id="pdf_customer_name"></p>
                    </div>

                    <table class="table table-dark table-sm border-0 text-end">
                        <thead>
                            <tr class="small text-muted border-bottom border-secondary">
                                <th>الصنف</th>
                                <th class="text-center">الكمية</th>
                                <th class="text-start">الإجمالي</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cart as $item)
                                <tr>
                                    <td class="py-2">{{ $item['name'] }}</td>
                                    <td class="text-center">{{ $item['qty'] }}</td>
                                    <td class="text-start fw-bold text-info">
                                        {{ number_format($item['price'] * $item['qty']) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4 pt-3 border-top border-secondary border-dashed">
                        <div class="d-flex justify-content-between h4 fw-black">
                            <span>المبلغ المستحق:</span>
                            <span class="text-info">{{ number_format($total) }} ل.س</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 gap-2 justify-content-center">
                    <button type="button" class="btn btn-secondary rounded-pill px-3"
                        data-bs-dismiss="modal">تعديل</button>

                    <button type="button" class="btn btn-danger rounded-pill px-3 fw-bold"
                        onclick="downloadPosPDF()">
                        <i class="fas fa-file-pdf me-2"></i> تصدير PDF
                    </button>

                    <button type="button" class="btn btn-info rounded-pill px-3 fw-bold" onclick="printPos()">
                        <i class="fas fa-print me-2"></i> طباعة
                    </button>

                    <button type="button" class="btn btn-success rounded-pill px-4 fw-black"
                        onclick="submitPosForm()">
                        تأكيد وقبض
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

    <script>
        function openPosPreview() {
            const name = document.getElementById('customer_name_input').value;
            document.getElementById('pdf_customer_name').innerText = name ? "الزبون: " + name : "";

            var myModal = new bootstrap.Modal(document.getElementById('posPreviewModal'));
            myModal.show();
        }

        function printPos() {
            window.print();
        }

        function submitPosForm() {
            document.getElementById('posMainForm').submit();
        }

        function downloadPosPDF() {
            const element = document.getElementById('posPrintSection');
            const customerName = document.getElementById('customer_name_input').value || 'زبون_سفري';
            const opt = {
                margin: 0.5,
                filename: `فاتورة_سفري_${customerName}.pdf`,
                image: {
                    type: 'jpeg',
                    quality: 0.98
                },
                html2canvas: {
                    scale: 2,
                    useCORS: true,
                    letterRendering: true,
                    backgroundColor: '#ffffff'
                },
                jsPDF: {
                    unit: 'in',
                    format: 'letter',
                    orientation: 'portrait'
                }
            };
            const originalClass = element.className;
            element.classList.add('pdf-export-container');
            html2pdf().set(opt).from(element).save().then(() => {
                element.className = originalClass;
            });
        }
    </script>
</body>

</html>
