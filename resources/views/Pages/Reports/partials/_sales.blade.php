{{-- 1. نموذج الفلترة (يظهر في الموقع فقط) --}}
<div class="glass-card mb-4 d-print-none">
    <form action="{{ route('Pages.reports.index') }}" method="GET" class="row g-3 align-items-end">
        <input type="hidden" name="tab" value="sales">

        <div class="col-md-4">
            <label class="text-gold small mb-2 fw-bold">من تاريخ</label>
            <input type="date" name="sales_from" value="{{ request('sales_from') }}"
                class="form-control bg-black text-white border-secondary rounded-pill shadow-none">
        </div>

        <div class="col-md-4">
            <label class="text-gold small mb-2 fw-bold">إلى تاريخ</label>
            <input type="date" name="sales_to" value="{{ request('sales_to') }}"
                class="form-control bg-black text-white border-secondary rounded-pill shadow-none">
        </div>

        <div class="col-md-4">
            <button type="submit" class="btn btn-gold w-100 rounded-pill fw-bold py-2">
                <i class="fas fa-filter me-2"></i> تطبيق الفلترة
            </button>
        </div>
    </form>
</div>

{{-- 2. أزرار التحكم --}}
<div class="d-flex justify-content-between align-items-center mb-4 px-3 d-print-none">
    <h4 class="text-white fw-bold"><i class="fas fa-chart-line text-gold me-2"></i> مبيعات النظام المفلترة</h4>
    <button onclick="exportMainSalesSummaryPDF()" class="btn btn-danger rounded-pill px-4 fw-bold shadow-lg">
        <i class="fas fa-file-pdf me-2"></i> استخراج التقرير العام
    </button>
</div>

{{-- 3. جدول العرض في الموقع --}}
<div class="glass-card mb-5 d-print-none">
    <div class="table-responsive">
        <table class="table table-dark table-hover text-center align-middle mb-0 border-0">
            <thead>
                <tr class="text-gold">
                    <th class="py-3">تاريخ العمليات</th>
                    <th class="py-3">عدد الطلبات</th>
                    <th class="py-3">إجمالي الإيراد</th>
                    <th class="py-3">الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dailySalesData as $data)
                    <tr>
                        <td class="fw-bold">{{ $data->sales_date }}</td>
                        <td><span class="badge bg-secondary rounded-pill px-3">{{ $data->orders_count }} طلب</span></td>
                        <td class="text-gold fw-black">{{ number_format($data->total_amount, 0) }} ل.س</td>
                        <td>
                            <a href="{{ route('Pages.reports.show', $data->sales_date) }}"
                                class="btn btn-sm btn-outline-gold rounded-pill px-4">
                                <i class="fas fa-eye me-1"></i> عرض الفواتير
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- 4. سكريبت الطباعة المطور --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<script>
    function exportMainSalesSummaryPDF() {
        const reportElement = document.createElement('div');

        // بناء محتوى الجدول برمجياً لتجنب مشاكل Blade داخل JS
        let tableRows = '';
        @foreach ($dailySalesData as $data)
            tableRows += `
                <tr style="border: 1px solid #000;">
                    <td style="border: 1px solid #000; padding: 10px; text-align: center; direction: ltr;">{{ $data->sales_date }}</td>
                    <td style="border: 1px solid #000; padding: 10px; text-align: center;">{{ $data->orders_count }} طلب</td>
                    <td style="border: 1px solid #000; padding: 10px; text-align: center; font-weight: bold;">{{ number_format($data->total_amount, 0) }} ل.س</td>
                </tr>
            `;
        @endforeach

        reportElement.innerHTML = `
            <div dir="rtl" style="font-family: Arial, sans-serif; padding: 15mm; background: white; color: black;">
                <div style="text-align: center; border-bottom: 5px double #d4af37; padding-bottom: 10px; margin-bottom: 25px;">
                    <h1 style="color: #d4af37; margin: 0; font-size: 28px;">SRMS PREMIUM</h1>
                    <h2 style="color: #333; font-size: 18px;">تقرير ملخص المبيعات اليومية الرسمي</h2>
                    <p style="font-size: 12px; color: #666;">الفترة: ${"{{ request('sales_from') ?? 'من البداية' }}"} إلى ${"{{ request('sales_to') ?? date('Y-m-d') }}"}</p>
                </div>
                
                <table style="width: 100%; border-collapse: collapse; margin-top: 20px; table-layout: fixed;">
                    <thead>
                        <tr style="background-color: #f2f2f2;">
                            <th style="border: 1px solid #000; padding: 12px; width: 40%; text-align: center;">التاريخ</th>
                            <th style="border: 1px solid #000; padding: 12px; width: 25%; text-align: center;">عدد الطلبات</th>
                            <th style="border: 1px solid #000; padding: 12px; width: 35%; text-align: center;">الإجمالي اليومي</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${tableRows}
                    </tbody>
                </table>

                <div style="margin-top: 30px; padding: 15px; border: 2px solid #d4af37; background: #fffdf5; display: flex; justify-content: space-between; align-items: center;">
                    <span style="font-size: 16px; font-weight: bold;">إجمالي مبيعات الفترة المفلترة:</span>
                    <span style="font-size: 20px; font-weight: 900;">{{ number_format($totalSalesAmount, 0) }} ل.س</span>
                </div>

                <div style="margin-top: 50px; text-align: center; font-size: 10px; color: #aaa; border-top: 1px solid #eee; padding-top: 10px;">
                    تم استخراج هذا التقرير آلياً - تاريخ الاستخراج: ${new Date().toLocaleString('ar-EG')}
                </div>
            </div>
        `;

        const opt = {
            margin: [0, 0, 0, 0],
            filename: 'SRMS_Report_' + new Date().getTime() + '.pdf',
            image: {
                type: 'jpeg',
                quality: 0.98
            },
            html2canvas: {
                scale: 2,
                letterRendering: true,
                useCORS: true
            },
            jsPDF: {
                unit: 'mm',
                format: 'a4',
                orientation: 'portrait'
            },
            pagebreak: {
                mode: ['avoid-all', 'css', 'legacy']
            }
        };

        html2pdf().set(opt).from(reportElement).save();
    }
</script>
