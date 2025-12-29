<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<style>
    .glass-card {
        background: rgba(22, 24, 26, 0.7);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(212, 175, 55, 0.1);
        border-radius: 25px;
        padding: 25px;
    }

    .custom-table thead th {
        background: rgba(212, 175, 55, 0.05);
        color: #d4af37;
        font-weight: 800;
        border: none;
        padding: 20px;
    }

    #printableReportArea {
        display: none;
        background: white;
        color: black;
        width: 210mm;
        direction: rtl;
        font-family: 'Arial', sans-serif;
    }

    .report-table-official {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
    }

    .report-table-official th {
        background-color: #f8f9fa !important;
        border: 1px solid #000 !important;
        padding: 10px;
        font-size: 14px;
        color: #000;
        -webkit-print-color-adjust: exact;
    }

    .report-table-official td {
        border: 1px solid #000 !important;
        padding: 8px;
        text-align: center;
        font-size: 12px;
    }

    .report-table-official tr {
        page-break-inside: avoid !important;
    }
</style>

<div class="d-flex justify-content-between align-items-center mb-4 px-3 d-print-none">
    <h4 class="text-white fw-black mb-0">| سجل العمليات المالية</h4>
    <button onclick="exportOfficialReport()" class="btn btn-danger rounded-pill px-4 fw-bold shadow-lg">
        <i class="fas fa-file-pdf me-2"></i> استخراج التقرير الرسمي الشامل
    </button>
</div>

<div class="glass-card overflow-hidden d-print-none">
    <div class="table-responsive" style="max-height: 550px; overflow-y: auto;">
        <table class="table table-dark custom-table align-middle text-center mb-0">
            <thead>
                <tr>
                    <th>رقم الفاتورة</th>
                    <th>النوع</th>
                    <th>القيمة</th>
                    <th>التوقيت</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoices as $inv)
                    <tr>
                        <td class="text-white fw-bold font-monospace">#{{ $inv->invoice_number }}</td>
                        <td>{{ $inv->dine_in_order_id ? 'صالة' : 'سفري' }}</td>
                        <td class="text-gold fw-black">{{ number_format($inv->amount_paid, 0) }} ل.س</td>
                        <td class="text-muted small">{{ $inv->created_at->format('Y-m-d | H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- 4. القالب المخفي للتصدير (يدعم تعدد الصفحات) --}}
<div id="printableReportArea">
    <div style="padding: 10mm 15mm;">
        <div style="text-align: center; border-bottom: 5px double #d4af37; padding-bottom: 15px; margin-bottom: 20px;">
            <h1 style="margin: 0; color: #d4af37; font-size: 28px;">مطعم SRMS Premium</h1>
            <p style="margin: 5px 0; font-size: 16px; font-weight: bold; color: #333;">تقرير سجل الفواتير العام
                والعمليات المالية</p>
        </div>

        <table
            style="width: 100%; margin-bottom: 20px; font-size: 13px; border-bottom: 1px solid #eee; padding-bottom: 10px;">
            <tr>
                <td style="text-align: right;">تاريخ الاستخراج: <strong>{{ date('Y-m-d H:i') }}</strong></td>
                <td style="text-align: left;">المسؤول: <strong>{{ auth()->user()->name }}</strong></td>
            </tr>
        </table>

        <table class="report-table-official">
            <thead>
                <tr>
                    <th style="width: 35%;">رقم الفاتورة</th>
                    <th style="width: 15%;">نوع الخدمة</th>
                    <th style="width: 25%;">المبلغ المدفوع</th>
                    <th style="width: 25%;">التاريخ والوقت</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoices as $inv)
                    <tr>
                        <td style="direction: ltr;">#{{ $inv->invoice_number }}</td>
                        <td>{{ $inv->dine_in_order_id ? 'خدمة صالة' : 'طلب سفري' }}</td>
                        <td style="font-weight: bold;">{{ number_format($inv->amount_paid, 0) }} ل.س</td>
                        <td style="direction: ltr; font-size: 11px;">{{ $inv->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div
            style="margin-top: 25px; padding: 15px; border: 2px solid #000; background-color: #fffdf5; display: flex; justify-content: space-between; align-items: center; page-break-inside: avoid;">
            <span style="font-size: 16px; font-weight: bold;">إجمالي قيمة الفواتير المفلترة:</span>
            <span style="font-size: 20px; font-weight: 900;">{{ number_format($invoices->sum('amount_paid'), 0) }}
                ل.س</span>
        </div>

        <div
            style="margin-top: 40px; text-align: center; font-size: 10px; color: #777; border-top: 1px solid #eee; padding-top: 10px;">
            هذا التقرير مستخرج آلياً من نظام SRMS ولا يحتاج إلى توقيع.
        </div>
    </div>
</div>

<script>
    function exportOfficialReport() {
        const element = document.getElementById('printableReportArea');
        element.style.display = 'block'; // إظهار القالب مؤقتاً للتصدير

        const opt = {
            margin: [10, 5, 10, 5],
            filename: 'Official_Report_{{ date('Ymd_Hi') }}.pdf',
            image: {
                type: 'jpeg',
                quality: 1
            },
            pagebreak: {
                mode: ['avoid-all', 'css', 'legacy']
            }, // دعم تعدد الصفحات
            html2canvas: {
                scale: 2,
                useCORS: true,
                letterRendering: true,
                backgroundColor: '#ffffff'
            },
            jsPDF: {
                unit: 'mm',
                format: 'a4',
                orientation: 'portrait'
            }
        };

        html2pdf().set(opt).from(element).save().then(() => {
            element.style.display = 'none'; // إعادة الإخفاء
        });
    }
</script>
