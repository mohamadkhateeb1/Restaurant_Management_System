@extends('layouts.app')

@section('content')
    <style>
        .detail-card {
            background: rgba(22, 24, 26, 0.95);
            border: 1px solid rgba(212, 175, 55, 0.2);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.6);
        }

        .text-gold {
            color: #d4af37 !important;
        }

        .bg-gold-light {
            background: rgba(212, 175, 55, 0.1);
        }

        .stat-pill {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            transition: 0.3s;
        }

        .stat-pill:hover {
            background: rgba(255, 255, 255, 0.08);
            transform: translateY(-5px);
        }
    </style>

    <div class="container py-5" dir="rtl">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <h2 class="text-white fw-bold mb-1">تفاصيل مبيعات اليوم</h2>
                <p class="text-gold mb-0"><i class="fas fa-calendar-alt me-2"></i> {{ $date }}</p>
            </div>
            <div class="d-flex gap-2">
                <button onclick="exportDailyDetailedPDF()" class="btn btn-danger rounded-pill px-4 shadow">
                    <i class="fas fa-file-pdf me-2"></i> استخراج PDF
                </button>
                <a href="{{ route('Pages.reports.index') }}" class="btn btn-outline-light rounded-pill px-4">
                    <i class="fas fa-undo me-2"></i> عودة للتقارير
                </a>
            </div>
        </div>

        <div class="row g-4 mb-5">
            <div class="col-md-6">
                <div class="stat-pill p-4 text-center">
                    <span class="text-muted d-block small mb-2 text-uppercase">إجمالي مبيعات اليوم</span>
                    <h2 class="text-gold fw-black mb-0">{{ number_format($totalAmount, 0) }} ل.س</h2>
                </div>
            </div>
            <div class="col-md-6">
                <div class="stat-pill p-4 text-center">
                    <span class="text-muted d-block small mb-2 text-uppercase">عدد الطلبات المنفذة</span>
                    <h2 class="text-white fw-black mb-0">{{ $orders_count }} فاتورة</h2>
                </div>
            </div>
        </div>

        <div class="detail-card p-4">
            <div class="table-responsive">
                <table class="table table-dark table-hover align-middle text-center mb-0 border-0">
                    <thead class="bg-gold-light text-gold">
                        <tr>
                            <th class="py-3 border-0">رقم الفاتورة</th>
                            <th class="py-3 border-0">نوع الخدمة</th>
                            <th class="py-3 border-0">المسؤول</th>
                            <th class="py-3 border-0">القيمة</th>
                            <th class="py-3 border-0">التوقيت</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoices as $inv)
                            <tr>
                                <td class="fw-bold">#{{ $inv->invoice_number }}</td>
                                <td>
                                    <span
                                        class="badge {{ $inv->dine_in_order_id ? 'bg-info' : 'bg-warning text-dark' }} rounded-pill px-3">
                                        {{ $inv->dine_in_order_id ? 'صالة' : 'سفري' }}
                                    </span>
                                </td>
                                <td>{{ $inv->employee->name ?? '---' }}</td>
                                <td class="text-gold fw-bold">{{ number_format($inv->amount_paid, 0) }} ل.س</td>
                                <td class="text-muted small">{{ $inv->created_at->format('H:i:s') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
        function exportDailyDetailedPDF() {
            const reportHTML = `
        <div dir="rtl" style="font-family: Arial, sans-serif; padding: 15mm; background: white; color: black;">
            <div style="text-align: center; border-bottom: 5px double #d4af37; padding-bottom: 15px; margin-bottom: 30px;">
                <h1 style="color: #d4af37; margin: 0; font-size: 28px;">SRMS PREMIUM SYSTEM</h1>
                <p style="margin: 5px 0; font-size: 18px; font-weight: bold;">تقرير مبيعات يوم: ${"{{ $date }}"}</p>
            </div>
            <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
                <thead>
                    <tr style="background: #f2f2f2;">
                        <th style="border: 1px solid #000; padding: 10px; width: 30%;">رقم الفاتورة</th>
                        <th style="border: 1px solid #000; padding: 10px; width: 20%;">النوع</th>
                        <th style="border: 1px solid #000; padding: 10px; width: 30%;">المبلغ</th>
                        <th style="border: 1px solid #000; padding: 10px; width: 20%;">الوقت</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoices as $inv)
                    <tr style="page-break-inside: avoid;">
                        <td style="border: 1px solid #000; padding: 8px; text-align: center;">#{{ $inv->invoice_number }}</td>
                        <td style="border: 1px solid #000; padding: 8px; text-align: center;">{{ $inv->dine_in_order_id ? 'صالة' : 'سفري' }}</td>
                        <td style="border: 1px solid #000; padding: 8px; text-align: center; font-weight: bold;">{{ number_format($inv->amount_paid, 0) }}</td>
                        <td style="border: 1px solid #000; padding: 8px; text-align: center;">{{ $inv->created_at->format('H:i') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div style="margin-top: 30px; padding: 20px; border: 2px solid #000; background: #fffdf5; text-align: left; display: flex; justify-content: space-between;">
                <strong>إجمالي إيراد اليوم:</strong>
                <strong style="font-size: 20px;">${"{{ number_format($totalAmount, 0) }}"} ل.س</strong>
            </div>
        </div>
    `;

            const opt = {
                margin: [0, 0, 0, 0],
                filename: 'Daily_Sales_Details_{{ $date }}.pdf',
                image: {
                    type: 'jpeg',
                    quality: 1
                },
                pagebreak: {
                    mode: ['avoid-all', 'css', 'legacy']
                },
                html2canvas: {
                    scale: 2,
                    useCORS: true,
                    letterRendering: false,
                    backgroundColor: '#ffffff'
                },
                jsPDF: {
                    unit: 'mm',
                    format: 'a4',
                    orientation: 'portrait'
                }
            };
            html2pdf().set(opt).from(reportHTML).save();
        }
    </script>
@endsection
