<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تفاصيل الفاتورة #{{ $invoice->invoice_number }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body { background-color: #0f111a; color: #e6e8ed; font-family: 'Cairo', sans-serif; }
        .invoice-box { background: #1a1d29; border: 1px solid #2d3245; border-radius: 20px; padding: 30px; margin-top: 50px; }
        .item-row { border-bottom: 1px solid #2d3245; padding: 10px 0; }
        .total-box { background: #242938; padding: 20px; border-radius: 15px; border: 1px dashed #00d2ff; }

        @media print {
            @page { margin: 0; size: auto; }
            body { background: white !important; color: black !important; margin: 0; padding: 0; }
            .btn, .btn-outline-light, .text-info, .text-warning { color: black !important; }
            .invoice-box { border: none !important; box-shadow: none !important; margin: 0 !important; padding: 10mm !important; width: 100% !important; background: white !important; }
            .no-print { display: none !important; } 
            
            .invoice-box {
                max-width: 80mm; 
                margin: auto;
            }
            .item-row { border-bottom: 1px dashed #000 !important; }
            .total-box { background: white !important; border: 1px solid #000 !important; color: black !important; }
            .text-info, .text-muted { color: black !important; }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="invoice-box shadow-lg">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="fw-bold text-info">تفاصيل الفاتورة</h3>
                    <a href="{{ route('Pages.index') }}" class="btn btn-outline-light btn-sm no-print">رجوع للأرشيف</a>
                </div>

                <div class="text-center mb-4 d-none d-print-block">
                    <h4 class="fw-bold">مطعم المَلَكي</h4>
                    <p class="small">فاتورة مبيعات نظامية</p>
                    <hr style="border-top: 2px dashed #000;">
                </div>

                <div class="row mb-4">
                    <div class="col-6">
                        <p class="mb-1 text-muted">رقم الفاتورة:</p>
                        <h5 class="fw-bold">#{{ $invoice->invoice_number }}</h5>
                    </div>
                    <div class="col-6 text-end">
                        <p class="mb-1 text-muted">التاريخ:</p>
                        <h5 class="fw-bold small">{{ $invoice->created_at->format('Y-m-d | h:i A') }}</h5>
                    </div>
                </div>

                <div class="mb-4">
                    <h6 class="text-info border-bottom border-secondary pb-2 mb-3">الأصناف المطلوبة</h6>
                    @php 
                        $order = $invoice->dineInOrder ?? $invoice->takeawayOrder; 
                    @endphp
                    
                    @foreach($order->orderItems as $item)
                    <div class="item-row d-flex justify-content-between">
                        <span>{{ $item->item->item_name }} <b class="text-info">× {{ $item->quantity }}</b></span>
                        <span class="fw-bold">{{ number_format($item->price * $item->quantity) }} ل.س</span>
                    </div>
                    @endforeach
                </div>

                <div class="total-box d-flex justify-content-between align-items-center">
                    <h4 class="mb-0 fw-bold">الإجمالي النهائي</h4>
                    <h3 class="mb-0 fw-bold text-warning">{{ number_format($invoice->amount_paid) }} ل.س</h3>
                </div>

                <div class="text-center mt-4 d-none d-print-block">
                    <hr style="border-top: 1px dashed #000;">
                    <p class="small fw-bold">شكراً لزيارتكم</p>
                </div>

                <div class="mt-4 d-flex gap-2 no-print">
                    <button onclick="window.print()" class="btn btn-success flex-grow-1 py-3 fw-bold">
                        <i class="fas fa-print me-2"></i>طباعة الفاتورة
                    </button>
                    <a href="#" class="btn btn-danger flex-grow-1 py-3 fw-bold">
                        <i class="fas fa-file-pdf me-2"></i>تحميل PDF
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>