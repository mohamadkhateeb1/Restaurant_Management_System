<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<style>
    :root {
        --gold-primary: #c5a059;
        --gold-secondary: #8e6d3d;
        --card-bg: #141414;
        --glass-border: rgba(255, 255, 255, 0.03);
    }

    .glass-card {
        background: var(--card-bg) !important;
        border: 1px solid var(--glass-border) !important;
        border-radius: 20px !important;
        box-shadow: 15px 15px 35px rgba(0, 0, 0, 0.6) !important;
    }

    /* تنسيق محرك الفلترة */
    .filter-capsule {
        background: rgba(255, 255, 255, 0.02);
        padding: 20px;
        border-radius: 20px;
        border: 1px solid var(--glass-border);
    }

    .custom-table thead th {
        color: var(--gold-primary) !important;
        font-weight: 300 !important;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        padding: 20px !important;
        border-bottom: 1px solid var(--glass-border) !important;
    }

    .custom-table td {
        padding: 18px !important;
        color: #d1d1d1;
        font-weight: 300;
        border-bottom: 1px solid rgba(255, 255, 255, 0.01) !important;
    }

    .btn-gold-action {
        background: linear-gradient(145deg, var(--gold-primary), var(--gold-secondary)) !important;
        color: #000 !important;
        border: none !important;
        font-weight: 700 !important;
        transition: 0.3s;
    }

    .btn-gold-action:hover {
        transform: translateY(-2px);
        filter: brightness(1.1);
        box-shadow: 0 5px 15px rgba(197, 160, 89, 0.3);
    }

    #printableReportArea {
        display: none;
        background: white;
        color: black;
        width: 210mm;
        direction: rtl;
        font-family: 'Arial', sans-serif;
    }

    .report-table-official th {
        background-color: #f9f6f0 !important;
        border: 1px solid #ddd !important;
        color: #8e6d3d !important;
        padding: 12px;
    }

    .report-table-official td {
        border: 1px solid #eee !important;
        padding: 10px;
    }
</style>

{{-- محرك الفلترة --}}
<div class="glass-card mb-4 d-print-none p-4">
    <form action="{{ route('Pages.reports.index') }}" method="GET" class="row g-3 align-items-end">
        <input type="hidden" name="tab" value="invoices">

        <div class="col-md-4">
            <label class="text-gold small mb-2 fw-light text-uppercase" style="letter-spacing: 1px;">نوع الخدمة</label>
            <select name="inv_type" class="form-select bg-black text-white border-0 rounded-pill shadow-none py-2 px-4"
                style="background-color: #0c0c0c !important;">
                <option value="">جميع الفواتير</option>
                <option value="dine_in" {{ request('inv_type') == 'dine_in' ? 'selected' : '' }}>خدمة صالة</option>
                <option value="takeaway" {{ request('inv_type') == 'takeaway' ? 'selected' : '' }}>طلب سفري</option>
            </select>
        </div>

        <div class="col-md-4">
            <label class="text-gold small mb-2 fw-light text-uppercase" style="letter-spacing: 1px;">تاريخ محدد</label>
            <input type="date" name="inv_from" value="{{ request('inv_from') }}"
                class="form-control bg-black text-white border-0 rounded-pill shadow-none py-2 px-4"
                style="background-color: #0c0c0c !important;">
        </div>

        <div class="col-md-4">
            <button type="submit" class="btn btn-gold-action w-100 rounded-pill py-2">
                <i class="fas fa-filter me-2 small"></i> تطبيق الفلترة
            </button>
        </div>
    </form>
</div>

<div class="d-flex justify-content-between align-items-center mb-4 px-2 d-print-none">
    <div class="d-flex align-items-center gap-3">
        <div style="width: 4px; height: 24px; background: var(--gold-primary); border-radius: 10px;"></div>
        <h4 class="text-white fw-light mb-0">{{ __('financial operations log') }}</h4>
    </div>

    <button onclick="exportOfficialReport()" class="btn btn-outline-danger rounded-pill px-4 fw-bold shadow-sm"
        style="border-color: rgba(220, 53, 69, 0.3);">
        <i class="fas fa-file-pdf me-2"></i>
        {{ __('export official report') }}
    </button>
</div>

{{-- الجدول الرئيسي --}}
<div class="glass-card overflow-hidden d-print-none">
    <div class="table-responsive" style="max-height: 550px;">
        <table class="table table-dark custom-table align-middle text-center mb-0">
            <thead>
                <tr>
                    <th>{{ __('invoice number') }}</th>
                    <th>{{ __('service type') }}</th>
                    <th>{{ __('amount paid') }}</th>
                    <th>{{ __('date time') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoices as $inv)
                    <tr>
                        <td class="text-gold fw-light font-monospace">#{{ $inv->invoice_number }}</td>
                        <td>
                            <span
                                class="opacity-75">{{ $inv->dine_in_order_id ? __('dine in') : __('takeaway') }}</span>
                        </td>
                        <td class="fw-bold text-white">
                            {{ number_format($inv->amount_paid, 0) }} <small
                                class="extra-small opacity-50">{{ __('currency') }}</small>
                        </td>
                        <td class="fw-bold text-white" style="direction:ltr;">
                            {{ $inv->created_at->format('Y-m-d | H:i') }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- التقرير المطبوع --}}
<div id="printableReportArea">
    <div style="padding: 15mm;">
        <div style="text-align:center;border-bottom:3px solid #c5a059;padding-bottom:20px;margin-bottom:30px;">
            <h1 style="margin:0;color:#8e6d3d;font-size:32px;letter-spacing:2px;">{{ __('restaurant name') }}</h1>
            <p style="margin:8px 0;font-size:18px;color:#333;font-weight:bold;">{{ __('general invoices report') }}</p>
            <div style="width: 60px; height: 2px; background: #c5a059; margin: 10px auto;"></div>
        </div>

        <table style="width:100%;margin-bottom:30px;font-size:14px;color:#555;">
            <tr>
                <td style="text-align:right;">تاريخ التصدير: <strong>{{ date('Y-m-d H:i') }}</strong></td>
                <td style="text-align:left;">المسؤول: <strong>{{ auth()->user()->name }}</strong></td>
            </tr>
        </table>

        <table class="report-table-official" style="width:100%; border-collapse:collapse;">
            <thead>
                <tr>
                    <th>{{ __('invoice number') }}</th>
                    <th>{{ __('service type') }}</th>
                    <th>{{ __('amount paid') }}</th>
                    <th>{{ __('date time') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoices as $inv)
                    <tr>
                        <td style="text-align:center;">#{{ $inv->invoice_number }}</td>
                        <td style="text-align:center;">
                            {{ $inv->dine_in_order_id ? __('dine in service') : __('takeaway order') }}</td>
                        <td style="text-align:center;font-weight:bold;">{{ number_format($inv->amount_paid, 0) }}
                            {{ __('currency') }}</td>
                        <td style="text-align:center;direction:ltr;">{{ $inv->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div
            style="margin-top:40px;padding:20px;border-radius:10px;background:#fdfaf5;border:1px solid #c5a059;display:flex;justify-content:space-between;align-items:center;">
            <span style="font-size:18px;font-weight:bold;color:#8e6d3d;">{{ __('total amount') }}:</span>
            <span
                style="font-size:24px;font-weight:900;color:#000;">{{ number_format($invoices->sum('amount_paid'), 0) }}
                {{ __('currency') }}</span>
        </div>
    </div>
</div>

<script>
    function exportOfficialReport() {
        const element = document.getElementById('printableReportArea');
        element.style.display = 'block';

        const opt = {
            margin: [0, 0, 0, 0],
            filename: 'Official_Financial_Report_{{ date('Ymd_Hi') }}.pdf',
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

        html2pdf().set(opt).from(element).save().then(() => {
            element.style.display = 'none';
        });
    }
</script>
