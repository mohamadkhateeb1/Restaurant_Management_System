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
        overflow: hidden;
    }

    .table-luxury {
        margin-bottom: 0;
    }

    .table-luxury thead tr {
        background: rgba(255, 255, 255, 0.02);
        border-bottom: 1px solid var(--glass-border);
    }

    .table-luxury th {
        color: var(--gold-primary) !important;
        font-weight: 300 !important;
        text-transform: uppercase;
        letter-spacing: 1px;
        padding: 20px !important;
        border: none !important;
    }

    .table-luxury td {
        padding: 18px !important;
        color: #d1d1d1;
        border-bottom: 1px solid rgba(255, 255, 255, 0.02) !important;
        font-weight: 300;
    }

    .btn-luxury-pdf {
        background: linear-gradient(145deg, var(--gold-primary), var(--gold-secondary)) !important;
        color: #000 !important;
        border: none !important;
        font-weight: 700 !important;
        transition: 0.3s;
        box-shadow: 0 5px 15px rgba(197, 160, 89, 0.2);
    }

    .btn-luxury-pdf:hover {
        transform: translateY(-2px);
        filter: brightness(1.1);
        box-shadow: 0 8px 20px rgba(197, 160, 89, 0.3);
    }

    .low-stock-alert {
        color: #ff4d4d !important;
        font-weight: 700 !important;
        background: rgba(255, 77, 77, 0.05);
        border-radius: 8px;
        padding: 4px 10px;
    }
</style>

<div class="d-flex justify-content-between align-items-center mb-4 px-2 d-print-none">
    <div class="d-flex align-items-center gap-3">
        <div style="width: 4px; height: 24px; background: var(--gold-primary); border-radius: 10px;"></div>
        <h4 class="text-white fw-light mb-0">إدارة جرد المخزون</h4>
    </div>
    <button onclick="exportInventoryOfficialReport()" class="btn btn-luxury-pdf rounded-pill px-4">
        <i class="fas fa-file-pdf me-2"></i> استخراج تقرير الجرد الرسمي
    </button>
</div>

<div class="glass-card mb-5 d-print-none">
    <div class="table-responsive">
        <table class="table table-dark table-luxury text-center align-middle">
            <thead>
                <tr>
                    <th>المادة</th>
                    <th>الكمية المتوفرة</th>
                    <th>حد الأمان</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($inventoryItems ?? [] as $item)
                    <tr>
                        <td class="fw-bold">{{ $item->name }}</td>
                        <td>
                            <span class="{{ $item->quantity <= $item->min_quantity ? 'low-stock-alert' : '' }}">
                                {{ $item->quantity }} {{ $item->unit }}
                            </span>
                        </td>
                        <td class="text-white">{{ $item->min_quantity }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    function exportInventoryOfficialReport() {
        const reportTemplate = `
        <div style="direction: rtl; font-family: 'Arial', sans-serif; padding: 15mm; background: white; color: black; min-height: 100%;">
            <div style="text-align: center; border-bottom: 3px solid #c5a059; padding-bottom: 20px; margin-bottom: 30px;">
                <h1 style="margin: 0; color: #8e6d3d; font-size: 28px; letter-spacing: 2px;">SRMS PREMIUM SYSTEM</h1>
                <h2 style="margin: 5px 0; font-size: 20px; color: #000; font-weight: bold;">تقرير جرد المخزون والمواد الرسمي</h2>
                <div style="width: 50px; height: 2px; background: #c5a059; margin: 10px auto;"></div>
            </div>

            <div style="display: flex; justify-content: space-between; margin-bottom: 25px; font-size: 14px; color: #444;">
                <span>تاريخ التقرير: <strong>${new Date().toLocaleString('ar-EG')}</strong></span>
                <span>المسؤول المعتمد: <strong>{{ auth()->user()->name }}</strong></span>
            </div>

            <table style="width: 100%; border-collapse: collapse; margin-bottom: 30px;">
                <thead>
                    <tr style="background-color: #f9f6f0; color: #8e6d3d;">
                        <th style="border: 1px solid #ddd; padding: 15px; width: 40%; text-align: center;">اسم المادة</th>
                        <th style="border: 1px solid #ddd; padding: 15px; width: 30%; text-align: center;">الكمية المتوفرة</th>
                        <th style="border: 1px solid #ddd; padding: 15px; width: 30%; text-align: center;">حد الأمان (الأدنى)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($inventoryItems ?? [] as $item)
                    <tr>
                        <td style="border: 1px solid #ddd; padding: 12px; text-align: center; font-weight: bold;">{{ $item->name }}</td>
                        <td style="border: 1px solid #ddd; padding: 12px; text-align: center; ${Number({{ $item->quantity }}) <= Number({{ $item->min_quantity }}) ? 'color: #d9534f; font-weight: bold; background: #fff5f5;' : ''}">
                            {{ $item->quantity }} {{ $item->unit }}
                        </td>
                        <td style="border: 1px solid #ddd; padding: 12px; text-align: center; color: #777;">{{ $item->min_quantity }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div style="margin-top: 40px; padding: 20px; border-radius: 10px; background: #fdfaf5; border: 1px solid #c5a059; display: flex; justify-content: space-between; align-items: center;">
                <span style="font-size: 16px; color: #8e6d3d; font-weight: bold;">إجمالي قيمة رأس المال في المخزن الحالي:</span>
                <span style="font-size: 22px; font-weight: bold; color: #000;">${Number({{ $inventoryStats['stock_value'] ?? 0 }}).toLocaleString()} ل.س</span>
            </div>

            <div style="margin-top: 50px; text-align: left; font-size: 12px; color: #aaa;">
                صادر عن نظام إدارة المطاعم الذكي - توقيع المسؤول: _________________
            </div>
        </div>
        `;

        const opt = {
            margin: [0, 0, 0, 0],
            filename: 'Inventory_Report_{{ date('Ymd_Hi') }}.pdf',
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

        html2pdf().set(opt).from(reportTemplate).save();
    }
</script>
