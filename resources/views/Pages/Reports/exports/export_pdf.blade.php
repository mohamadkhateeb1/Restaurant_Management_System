<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>{{ $reportTitle }}</title>
    <style>
        body {
            font-family: 'Cairo', sans-serif;
            direction: rtl;
            text-align: right;
            padding: 30px;
            color: #333;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #d4af37;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
        }

        th {
            background-color: #f8f9fa;
        }

        .total {
            background: #eee;
            font-weight: bold;
        }

        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body onload="window.print()">
    <div class="header">
        <h1>{{ $reportTitle }}</h1>
        <p>نظام SRMS - تاريخ الاستخراج: {{ date('Y-m-d H:i') }}</p>
    </div>

    @if ($activeTab == 'sales')
        <table>
            <thead>
                <tr>
                    <th>التاريخ</th>
                    <th>الطلبات</th>
                    <th>الإجمالي</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dailySalesData as $row)
                    <tr>
                        <td>{{ $row->date }}</td>
                        <td>{{ $row->count }}</td>
                        <td>{{ number_format($row->total) }} ل.س</td>
                    </tr>
                @endforeach
                <tr class="total">
                    <td colspan="2">المجموع الكلي</td>
                    <td>{{ number_format($totalSalesAmount) }} ل.س</td>
                </tr>
            </tbody>
        </table>
    @elseif($activeTab == 'invoices')
        <table>
            <thead>
                <tr>
                    <th>رقم الفاتورة</th>
                    <th>النوع</th>
                    <th>المبلغ</th>
                    <th>التاريخ</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoices as $inv)
                    <tr>
                        <td>{{ $inv->invoice_number }}</td>
                        <td>{{ $inv->dine_in_order_id ? 'صالة' : 'سفري' }}</td>
                        <td>{{ number_format($inv->amount_paid) }}</td>
                        <td>{{ $inv->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</body>

</html>
