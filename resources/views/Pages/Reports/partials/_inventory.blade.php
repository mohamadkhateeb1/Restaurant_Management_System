<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<div class="d-flex justify-content-between align-items-center mb-4 px-3 d-print-none">
    <h4 class="text-white fw-black mb-0">| إدارة جرد المخزون</h4>
    <button onclick="exportInventoryOfficialReport()" class="btn btn-danger rounded-pill px-4 fw-bold shadow-lg">
        <i class="fas fa-file-pdf me-2"></i> استخراج تقرير الجرد الرسمي
    </button>
</div>

<div class="glass-card mb-5 d-print-none">
    <div class="table-responsive">
        <table class="table table-dark text-center align-middle mb-0">
            <thead>
                <tr class="text-gold">
                    <th>المادة</th>
                    <th>الكمية</th>
                    <th>حد الأمان</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($inventoryItems ?? [] as $item)
                    <tr>
                        <td>{{ $item->name }}</td>
                        <td class="{{ $item->quantity <= $item->min_quantity ? 'text-danger fw-bold' : '' }}">
                            {{ $item->quantity }} {{ $item->unit }}
                        </td>
                        <td>{{ $item->min_quantity }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    function exportInventoryOfficialReport() {
        const reportTemplate = `
        <div style="direction: rtl; font-family: 'Arial', sans-serif; padding: 10mm; background: white; color: black; min-height: 100%;">
            <div style="text-align: center; border-bottom: 5px double #d4af37; padding-bottom: 15px; margin-bottom: 25px;">
                <h1 style="margin: 0; color: #d4af37; font-size: 26px;">SRMS PREMIUM SYSTEM</h1>
                <h2 style="margin: 5px 0; font-size: 18px; color: #000;">تقرير جرد المخزون والمواد الرسمي</h2>
            </div>

            <div style="display: flex; justify-content: space-between; margin-bottom: 20px; font-size: 13px; border-bottom: 1px solid #eee; padding-bottom: 8px;">
                <span>تاريخ الجرد: <strong>${new Date().toLocaleString('ar-EG')}</strong></span>
                <span>المسؤول: <strong>{{ auth()->user()->name }}</strong></span>
            </div>

            <table style="width: 100%; border-collapse: collapse; table-layout: fixed;">
                <thead>
                    <tr style="background-color: #f2f2f2;">
                        <th style="border: 1px solid #000; padding: 12px; width: 40%; text-align: center;">اسم المادة</th>
                        <th style="border: 1px solid #000; padding: 12px; width: 30%; text-align: center;">الكمية المتوفرة</th>
                        <th style="border: 1px solid #000; padding: 12px; width: 30%; text-align: center;">حد الأمان (الأدنى)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($inventoryItems ?? [] as $item)
                    <tr>
                        <td style="border: 1px solid #000; padding: 10px; text-align: center; font-weight: bold;">{{ $item->name }}</td>
                        <td style="border: 1px solid #000; padding: 10px; text-align: center; ${Number({{ $item->quantity }}) <= Number({{ $item->min_quantity }}) ? 'color: red; font-weight: bold;' : ''}">
                            {{ $item->quantity }} {{ $item->unit }}
                        </td>
                        <td style="border: 1px solid #000; padding: 10px; text-align: center; color: #666;">{{ $item->min_quantity }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div style="margin-top: 30px; padding: 15px; border: 2px solid #000; background-color: #fffdf5; display: flex; justify-content: space-between; align-items: center;">
                <span style="font-size: 16px; font-weight: bold;">إجمالي قيمة المخزون الحالي:</span>
                <span style="font-size: 20px; font-weight: 900;">${Number({{ $inventoryStats['stock_value'] ?? 0 }}).toLocaleString()} ل.س</span>
            </div>
        </div>
        `;

        const opt = {
            margin: [0, 0, 0, 0], 
            filename: 'Inventory_Official_Report_{{ date('Ymd') }}.pdf',
            image: {
                type: 'jpeg',
                quality: 1
            },
            html2canvas: {
                scale: 3,
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

        html2pdf().set(opt).from(reportTemplate).save();
    }
</script>
