<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>أرشيف الفواتير - نظام الملكي</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            .printable-area,
            .printable-area * {
                visibility: visible;
                color: #000 !important;
            }

            .printable-area {
                position: absolute;
                left: 0;
                top: 0;
                width: 80mm;
                background: #fff !important;
                padding: 10px;
            }

            .no-print {
                display: none !important;
            }

            @page {
                margin: 0;
            }
        }

        :root {
            --main-bg: #0f111a;
            --card-bg: #1a1d29;
            --accent-cyan: #00d2ff;
            --gold-soft: #ffc107;
            --border-dim: #2d3245;
        }

        body {
            background-color: var(--main-bg);
            color: #e6e8ed;
            font-family: 'Cairo', sans-serif;
            background-image: radial-gradient(circle at top right, #161b33 0%, #0f111a 100%);
        }

        .invoice-container {
            background: var(--card-bg);
            border: 1px solid var(--border-dim);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        }

        .table {
            color: #e6e8ed;
            margin-bottom: 0;
            border-color: var(--border-dim);
        }

        .table thead th {
            background: #242938;
            color: var(--accent-cyan);
            padding: 18px;
            font-weight: 700;
            border-bottom: 2px solid var(--border-dim);
        }

        .table tbody td {
            padding: 15px;
            vertical-align: middle;
            border-bottom: 1px solid var(--border-dim);
        }

        .view-link {
            width: 42px;
            height: 42px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(0, 210, 255, 0.1);
            color: var(--accent-cyan);
            border: 1px solid rgba(0, 210, 255, 0.2);
            border-radius: 12px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .view-link:hover {
            background: var(--accent-cyan);
            color: #000;
            box-shadow: 0 0 20px rgba(0, 210, 255, 0.4);
            transform: translateY(-3px);
        }

        .pagination svg {
            width: 20px !important;
            height: 20px !important;
            display: inline-block;
        }

        .pagination .page-link {
            background-color: var(--card-bg);
            border-color: var(--border-dim);
            color: var(--accent-cyan);
        }

        .action-btn {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            transition: 0.3s;
        }

        .btn-pdf {
            background: #dc3545;
        }

        .btn-print {
            background: #198754;
        }

        .action-btn:hover {
            opacity: 0.8;
            transform: translateY(-3px);
        }
    </style>
</head>

<body>
    <div class="container-fluid py-5 px-4">
        <div class="row mb-4 align-items-center">
            <div class="col-md-6">
                <h2 class="fw-bold mb-0 text-info">أرشيف الفواتير</h2>
                <p class="text-muted mb-0 small">عرض وتدقيق العمليات المالية السابقة</p>
            </div>
            <div class="col-md-6 text-md-end mt-3 mt-md-0">
                <form action="" method="GET" class="d-flex gap-2 justify-content-md-end">
                    <input type="date" name="date" class="form-control bg-dark border-secondary text-white w-auto"
                        value="{{ request('date') ?? date('Y-m-d') }}">
                    <button type="submit" class="btn btn-info px-4 fw-bold shadow">تصفية</button>
                    <a href="{{ route('Pages.cashier.index') }}" class="btn btn-outline-light px-4 fw-bold">رجوع</a>
                </form>
            </div>
        </div>

        <div class="invoice-container">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th class="ps-4"># الرقم</th>
                            <th>التوقيت</th>
                            <th>الطاولة / النوع</th>
                            <th>الموظف</th>
                            <th>المبلغ الصافي</th>
                            <th class="text-center">العمليات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($invoices as $invoice)
                            <tr>
                                <td class="ps-4 fw-bold">#{{ $invoice->invoice_number }}</td>
                                <td class="small text-muted">{{ $invoice->created_at->format('h:i A') }}</td>
                                <td>
                                    @if ($invoice->dineInOrder)
                                        <span
                                            class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-3 py-2">
                                            طاولة {{ $invoice->dineInOrder->table->table_number }}
                                        </span>
                                    @else
                                        <span
                                            class="badge bg-secondary bg-opacity-10 text-white border border-secondary px-3 py-2">
                                            سفري (POS)
                                        </span>
                                    @endif
                                </td>
                                <td>{{ $invoice->employee->name ?? '---' }}</td>
                                <td class="fw-bold text-warning">{{ number_format($invoice->amount_paid) }} ل.س</td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('Pages.invoice.show', $invoice->id) }}" class="view-link"
                                            title="عرض التفاصيل">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="#" class="action-btn btn-pdf" title="تحميل PDF">
                                            <i class="fas fa-file-pdf"></i>
                                        </a>
                                        <button onclick="window.print()" class="action-btn btn-print" title="طباعة">
                                            <i class="fas fa-print"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 opacity-50">لا توجد سجلات مالية لهذا اليوم
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>

</html>
