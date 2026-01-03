<div class="glass-card mb-4 d-print-none p-4"
    style="background: var(--card-bg) !important; border: 1px solid var(--glass-border) !important; border-radius: 20px !important;">
    <form action="{{ route('Pages.reports.index') }}" method="GET" class="row g-3 align-items-end">
        <input type="hidden" name="tab" value="sales">

        <div class="col-md-4">
            <label class="text-gold small mb-2 fw-light text-uppercase" style="letter-spacing: 1px;">من تاريخ</label>
            <input type="date" name="sales_from" value="{{ request('sales_from') }}"
                class="form-control bg-black text-white border-0 rounded-pill shadow-none py-2 px-4"
                style="background-color: #0c0c0c !important;">
        </div>

        <div class="col-md-4">
            <label class="text-gold small mb-2 fw-light text-uppercase" style="letter-spacing: 1px;">إلى تاريخ</label>
            <input type="date" name="sales_to" value="{{ request('sales_to') }}"
                class="form-control bg-black text-white border-0 rounded-pill shadow-none py-2 px-4"
                style="background-color: #0c0c0c !important;">
        </div>

        <div class="col-md-4">
            <button type="submit" class="btn btn-luxury-gold w-100 rounded-pill py-2 fw-bold">
                <i class="fas fa-filter me-2 small"></i> تطبيق الفلترة
            </button>
        </div>
    </form>
</div>

<div class="d-flex justify-content-between align-items-center mb-4 px-2 d-print-none">
    <div class="d-flex align-items-center gap-3">
        <div style="width: 4px; height: 24px; background: var(--gold-primary); border-radius: 10px;"></div>
        <h4 class="text-white fw-light mb-0">مبيعات النظام المفلترة</h4>
    </div>
    <button onclick="exportMainSalesSummaryPDF()" class="btn btn-outline-danger rounded-pill px-4 fw-bold shadow-sm"
        style="border-color: rgba(220, 53, 69, 0.3);">
        <i class="fas fa-file-pdf me-2"></i> استخراج التقرير العام
    </button>
</div>

<div class="glass-card mb-5 d-print-none"
    style="background: var(--card-bg) !important; border: 1px solid var(--glass-border) !important; border-radius: 20px !important; overflow: hidden;">
    <div class="table-responsive">
        <table class="table table-dark table-hover text-center align-middle mb-0 border-0">
            <thead>
                <tr style="background: rgba(255, 255, 255, 0.02);">
                    <th class="py-4 text-gold fw-light text-uppercase"
                        style="letter-spacing: 1px; border: none !important;">تاريخ العمليات</th>
                    <th class="py-4 text-gold fw-light text-uppercase"
                        style="letter-spacing: 1px; border: none !important;">عدد الطلبات</th>
                    <th class="py-4 text-gold fw-light text-uppercase"
                        style="letter-spacing: 1px; border: none !important;">إجمالي الإيراد</th>
                    <th class="py-4 text-gold fw-light text-uppercase"
                        style="letter-spacing: 1px; border: none !important;">الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dailySalesData as $data)
                    <tr style="border-bottom: 1px solid rgba(255, 255, 255, 0.01) !important;">
                        <td class="fw-light text-white">{{ $data->sales_date }}</td>
                        <td>
                            <span
                                class="badge bg-dark text-white-50 border border-secondary border-opacity-25 rounded-pill px-3 fw-light">
                                {{ $data->orders_count }} طلب
                            </span>
                        </td>
                        <td>
                            <span class="text-gold fw-light fs-5">{{ number_format($data->total_amount, 0) }}</span>
                            <small class="text-gold opacity-50 ms-1 extra-small">ل.س</small>
                        </td>
                        <td>
                            <a href="{{ route('Pages.reports.show', $data->sales_date) }}"
                                class="btn btn-sm btn-outline-gold rounded-pill px-4 py-1 small">
                                <i class="fas fa-eye me-1 small"></i> تفاصيل
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<style>
    .btn-luxury-gold {
        background: linear-gradient(145deg, var(--gold-primary), var(--gold-secondary)) !important;
        color: #000 !important;
        border: none !important;
        box-shadow: 0 5px 15px rgba(197, 160, 89, 0.2);
    }

    .btn-outline-gold {
        border: 1px solid var(--gold-secondary) !important;
        color: var(--gold-primary) !important;
        background: transparent;
    }

    .btn-outline-gold:hover {
        background: rgba(197, 160, 89, 0.1);
        color: #fff !important;
    }
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<script>
    function exportMainSalesSummaryPDF() {
        const reportElement = document.createElement('div');

        let tableRows = '';
        @foreach ($dailySalesData as $data)
            tableRows += `
                <tr>
                    <td style="border: 1px solid #ddd; padding: 12px; text-align: center; direction: ltr;">{{ $data->sales_date }}</td>
                    <td style="border: 1px solid #ddd; padding: 12px; text-align: center;">{{ $data->orders_count }} طلب</td>
                    <td style="border: 1px solid #ddd; padding: 12px; text-align: center; font-weight: bold; color: #000;">{{ number_format($data->total_amount, 0) }} ل.س</td>
                </tr>
            `;
        @endforeach

        reportElement.innerHTML = `
            <div dir="rtl" style="font-family: Arial, sans-serif; padding: 15mm; background: white; color: black;">
                <div style="text-align: center; border-bottom: 3px solid #c5a059; padding-bottom: 20px; margin-bottom: 30px;">
                    <h1 style="color: #8e6d3d; margin: 0; font-size: 32px; letter-spacing: 2px;">SRMS PREMIUM</h1>
                    <h2 style="color: #000; font-size: 20px; font-weight: bold; margin-top: 10px;">تقرير ملخص المبيعات اليومية الرسمي</h2>
                    <p style="font-size: 14px; color: #666; margin-top: 5px;">الفترة: ${"{{ request('sales_from') ?? 'من البداية' }}"} إلى ${"{{ request('sales_to') ?? date('Y-m-d') }}"}</p>
                    <div style="width: 60px; height: 2px; background: #c5a059; margin: 15px auto;"></div>
                </div>
                
                <table style="width: 100%; border-collapse: collapse; margin-top: 20px; border: 1px solid #ddd;">
                    <thead>
                        <tr style="background-color: #f9f6f0; color: #8e6d3d;">
                            <th style="border: 1px solid #ddd; padding: 15px; width: 40%; text-align: center;">التاريخ</th>
                            <th style="border: 1px solid #ddd; padding: 15px; width: 25%; text-align: center;">عدد الطلبات</th>
                            <th style="border: 1px solid #ddd; padding: 15px; width: 35%; text-align: center;">الإجمالي اليومي</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${tableRows}
                    </tbody>
                </table>

                <div style="margin-top: 40px; padding: 20px; border-radius: 10px; background: #fdfaf5; border: 1px solid #c5a059; display: flex; justify-content: space-between; align-items: center;">
                    <span style="font-size: 18px; color: #8e6d3d; font-weight: bold;">إجمالي مبيعات الفترة المفلترة:</span>
                    <span style="font-size: 24px; font-weight: 900; color: #000;">{{ number_format($totalSalesAmount, 0) }} ل.س</span>
                </div>

                <div style="margin-top: 60px; text-align: center; font-size: 11px; color: #aaa; border-top: 1px solid #eee; padding-top: 15px;">
                    صادر عن نظام SRMS - تاريخ الاستخراج: ${new Date().toLocaleString('ar-EG')}
                </div>
            </div>
        `;

        const opt = {
            margin: [0, 0, 0, 0],
            filename: 'Sales_Report_{{ date('Ymd_His') }}.pdf',
            image: {
                type: 'jpeg',
                quality: 1
            },
            html2canvas: {
                scale: 2,
                useCORS: true,
                backgroundColor: '#ffffff'
            },
            jsPDF: {
                unit: 'mm',
                format: 'a4',
                orientation: 'portrait'
            }
        };

        html2pdf().set(opt).from(reportElement).save();
    }
</script>
