<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مركز التحصيل - RMS Premium</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&display=swap" rel="stylesheet">

    <style>
        :root {
            --main-bg: #0d0f11;
            --card-bg: #1a1d20;
            --neon-blue: #00d2ff;
            --gold: #d4af37;
        }

        body {
            background-color: var(--main-bg);
            color: #e6e8ed;
            font-family: 'Cairo', sans-serif;
            overflow-x: hidden;
        }

        .bill-card {
            background: var(--card-bg);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.05);
            transition: 0.3s;
            height: 100%;
        }

        .bill-card:hover {
            border-color: var(--neon-blue);
            transform: translateY(-5px);
        }

        .table-badge {
            background: linear-gradient(45deg, var(--gold), #aa8a2e);
            color: #000;
            padding: 8px 15px;
            border-radius: 10px;
            font-weight: 900;
        }

        .btn-logout {
            border: 1px solid rgba(220, 53, 69, 0.5);
            color: #dc3545;
            transition: 0.3s;
        }

        .btn-logout:hover {
            background: #dc3545;
            color: white;
            box-shadow: 0 0 15px rgba(220, 53, 69, 0.3);
        }

        .btn-preview {
            background: rgba(0, 210, 255, 0.1);
            color: var(--neon-blue);
            border: 1px solid var(--neon-blue);
            border-radius: 12px;
            font-weight: 700;
        }

        .btn-pay-direct {
            background: linear-gradient(45deg, #1d976c, #93f9b9);
            border: none;
            color: #000;
            font-weight: 900;
            border-radius: 12px;
        }

        .modal-content {
            background: var(--card-bg);
            border-radius: 25px;
            border: 1px solid var(--neon-blue);
            max-width: 95vw;
            margin: auto;
        }

        .receipt-table {
            color: #fff;
            width: 100%;
            border-collapse: collapse;
        }

        .receipt-table th,
        .receipt-table td {
            padding: 10px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        @media (max-width: 768px) {
            header .container {
                flex-direction: column;
                gap: 20px;
                text-align: center;
            }

            header .d-flex {
                flex-wrap: wrap;
                justify-content: center;
            }

            .bill-card h2 {
                font-size: 1.5rem;
            }

            .btn-preview,
            .btn-pay-direct {
                padding: 12px;
                font-size: 0.9rem;
            }
        }

        @media (max-width: 576px) {
            .container {
                padding-left: 15px;
                padding-right: 15px;
            }

            .table-badge {
                font-size: 0.8rem;
                padding: 5px 10px;
            }
        }

        @media print {
            body * {
                visibility: hidden !important;
            }

            .modal.show .modal-body,
            .modal.show .modal-body * {
                visibility: visible !important;
                color: black !important;
            }

            .modal.show .modal-body {
                position: absolute !important;
                left: 0;
                top: 0;
                width: 100%;
                background: white !important;
            }

            .receipt-table th,
            .receipt-table td {
                border: 1px solid #000 !important;
                color: black !important;
            }

            .d-print-none {
                display: none !important;
            }
        }

        .pdf-export-mode {
            background: white !important;
            color: black !important;
        }

        .pdf-export-mode * {
            color: black !important;
        }
    </style>
</head>

<body>

    <header class="p-4 border-bottom border-secondary border-opacity-10 mb-4 mb-md-5 d-print-none">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-3 gap-md-4">
                <h2 class="fw-black text-neon-blue mb-0 fs-4 fs-md-2">مركز التحصيل المالي</h2>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-logout rounded-pill px-3 fw-bold btn-sm">
                        <i class="fas fa-sign-out-alt me-1"></i> خروج
                    </button>
                </form>
            </div>

            <div class="d-flex gap-2">
                <form action="{{ route('Pages.cashier.undoTakeaway') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="btn btn-outline-danger rounded-pill px-3 px-md-4 fw-bold btn-sm btn-md-base">مرتجع
                        سفري</button>
                </form>
                <a href="{{ route('Pages.cashier.create') }}"
                    class="btn btn-outline-info rounded-pill px-3 px-md-4 fw-bold btn-sm btn-md-base">طلب سفري جديد</a>
            </div>
        </div>
    </header>

    <x-flash_message />

    <div class="container pb-5 d-print-none">
        <div class="row g-3 g-md-4">
            @forelse($pendingDineIn as $order)
                <div class="col-sm-6 col-lg-4">
                    <div class="bill-card p-3 p-md-4 shadow-lg text-center">
                        <div class="d-flex justify-content-between align-items-center mb-3 mb-md-4">
                            <span class="table-badge">طاولة {{ $order->table->table_number }}</span>
                            <small class="text-muted">#{{ substr($order->order_number, -4) }}</small>
                        </div>
                        <div class="py-3 mb-3 mb-md-4 rounded-4 bg-black bg-opacity-25">
                            <h2 class="fw-black text-white mb-0 fs-3 fs-md-2">{{ number_format($order->total_amount) }}
                                ل.س</h2>
                        </div>
                        <div class="d-grid gap-2">
                            <button class="btn btn-preview py-2 py-md-3 fw-bold" data-bs-toggle="modal"
                                data-bs-target="#invoiceModal{{ $order->id }}">معاينة وطباعة</button>
                            <form action="{{ route('Pages.cashier.payDineIn') }}" method="POST">
                                @csrf
                                <input type="hidden" name="order_id" value="{{ $order->id }}">
                                <button type="submit" class="btn btn-pay-direct w-100 py-2 py-md-3 fw-black"
                                    onclick="return confirm('تأكيد القبض؟')">قبض وإغلاق</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="invoiceModal{{ $order->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down">
                        <div class="modal-content shadow-lg">
                            <div class="modal-header border-0 pb-0 d-print-none">
                                <button type="button" class="btn-close btn-close-white"
                                    data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body p-3 p-md-4 text-center" id="printArea{{ $order->id }}">
                                <div class="receipt-header mb-3 border-bottom border-secondary border-dashed pb-2">
                                    <h4 class="fw-black text-info mb-1">فاتورة مبيعات</h4>
                                    <p class="mb-0 fw-bold">طاولة رقم: {{ $order->table->table_number }}</p>
                                    <small class="text-muted">RMS - {{ date('Y-m-d H:i') }}</small>
                                </div>
                                <div class="table-responsive">
                                    <table class="receipt-table text-end small">
                                        <thead>
                                            <tr style="border-bottom: 1px solid #444;">
                                                <th>الصنف</th>
                                                <th class="text-center">الكمية</th>
                                                <th class="text-start">الإجمالي</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($order->orderItems as $item)
                                                <tr>
                                                    <td>{{ $item->item->item_name }}</td>
                                                    <td class="text-center">x{{ $item->quantity }}</td>
                                                    <td class="text-start fw-bold" style="color: var(--neon-blue);">
                                                        {{ number_format($item->price * $item->quantity) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="mt-4 pt-3 border-top border-secondary border-dashed">
                                    <div class="d-flex justify-content-between align-items-center px-2">
                                        <span class="h5 mb-0 fw-bold">المجموع:</span>
                                        <h4 class="text-info mb-0" style="font-weight: 900;">
                                            {{ number_format($order->total_amount) }} ل.س</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer border-0 p-3 p-md-4 gap-2 justify-content-center d-print-none">
                                <button type="button" class="btn btn-secondary rounded-pill px-3"
                                    data-bs-dismiss="modal">إلغاء</button>
                                <button type="button" class="btn btn-danger rounded-pill px-3 fw-bold"
                                    onclick="downloadInvoicePDF('printArea{{ $order->id }}', 'فاتورة_طاولة_{{ $order->table->table_number }}')">
                                    <i class="fas fa-file-pdf me-2"></i> PDF
                                </button>
                                <button type="button" class="btn btn-info rounded-pill px-4 fw-bold shadow-sm"
                                    onclick="window.print()">
                                    <i class="fas fa-print me-2"></i> طباعة
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <h3 class="text-muted">لا توجد فواتير نشطة حالياً</h3>
                </div>
            @endforelse
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

    <script>
        function downloadInvoicePDF(areaId, fileName) {
            const element = document.getElementById(areaId);
            const opt = {
                margin: 0.5,
                filename: fileName + '.pdf',
                image: {
                    type: 'jpeg',
                    quality: 0.98
                },
                html2canvas: {
                    scale: 3,
                    useCORS: true,
                    backgroundColor: '#ffffff'
                },
                jsPDF: {
                    unit: 'in',
                    format: 'letter',
                    orientation: 'portrait'
                }
            };
            element.classList.add('pdf-export-mode');
            html2pdf().set(opt).from(element).save().then(() => {
                element.classList.remove('pdf-export-mode');
            });
        }
    </script>
</body>

</html>
