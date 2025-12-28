@extends('layouts.app')

@section('content')
    <div class="container py-5 px-4" dir="rtl">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="text-white fw-black mb-0">
                <i class="fas fa-database text-neon-blue me-2"></i>سجل الفواتير للمطعم
            </h4>

            <div class="filter-group d-flex gap-2">
                <a href="{{ route('Pages.invoices.index') }}"
                    class="btn btn-sm rounded-pill px-4 {{ !request()->has('type') ? 'btn-neon-blue' : 'btn-outline-secondary' }}">
                    الكل
                </a>
                <a href="{{ route('Pages.invoices.index', ['type' => 'dine_in']) }}"
                    class="btn btn-sm rounded-pill px-4 {{ request('type') == 'dine_in' ? 'btn-success-neon' : 'btn-outline-secondary' }}">
                    <i class="fas fa-chair me-1"></i> صالة
                </a>
                <a href="{{ route('Pages.invoices.index', ['type' => 'takeaway']) }}"
                    class="btn btn-sm rounded-pill px-4 {{ request('type') == 'takeaway' ? 'btn-warning-neon' : 'btn-outline-secondary' }}">
                    <i class="fas fa-motorcycle me-1"></i> سفري
                </a>
            </div>
        </div>

        <div class="card border-0 shadow-2xl rounded-5 overflow-hidden" style="background: #111315;">
            <div class="table-responsive">
                <table class="table table-dark mb-0 align-middle text-center custom-table">
                    <thead>
                        <tr style="background: rgba(255,255,255,0.03);">
                            <th class="py-4 text-muted small fw-bold">رقم السجل (الفاتورة)</th>
                            <th class="py-4 text-muted small fw-bold">نوع العملية</th>
                            <th class="py-4 text-muted small fw-bold">التاريخ والوقت</th>
                            <th class="py-4 text-muted small fw-bold">الموظف المسؤول</th>
                            <th class="py-4 text-muted small fw-bold">القيمة المالية</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($records as $record)
                            <tr class="premium-row">
                                <td class="py-4">
                                    <span
                                        class="text-neon-blue fw-black font-monospace fs-5">#{{ $record->invoice_number }}</span>
                                </td>
                                <td class="py-4">
                                    <div
                                        class="badge-type-table {{ $record->dine_in_order_id ? 'text-success-neon' : 'text-warning-neon' }}">
                                        {!! $record->dine_in_order_id
                                            ? '<i class="fas fa-chair me-1"></i> صالة'
                                            : '<i class="fas fa-motorcycle me-1"></i> سفري' !!}
                                    </div>
                                </td>
                                <td class="py-4 text-white">
                                    <div class="small">{{ $record->created_at->format('Y-m-d') }}</div>
                                    <div class="text-muted extra-small font-monospace">
                                        {{ $record->created_at->format('H:i A') }}</div>
                                </td>
                                <td class="py-4">
                                    <span class="text-white fw-bold">{{ $record->employee->name ?? 'النظام' }}</span>
                                </td>
                                <td class="py-4">
                                    <span
                                        class="text-success-neon fw-black fs-4 font-monospace">{{ number_format($record->amount_paid, 0) }}</span>
                                    <small class="text-success-neon ms-1 small">ل.س</small>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-5 text-muted small italic">لا توجد بيانات مالية مسجلة بعد</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <style>
        :root {
            --neon-blue: #00d2ff;
            --neon-success: #00ff88;
            --neon-warning: #ffc107;
            --carbon-dark: #0d0f11;
        }

        body {
            background-color: var(--carbon-dark);
            font-family: 'Cairo', sans-serif;
        }

        .fw-black {
            font-weight: 900 !important;
        }

        .shadow-2xl {
            box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.9);
        }

        .badge-type-table {
            font-weight: 800;
            font-size: 0.85rem;
            padding: 5px 15px;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.03);
            display: inline-block;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .btn-neon-blue {
            background-color: var(--neon-blue);
            color: #000;
            font-weight: 800;
            border: none;
            box-shadow: 0 0 15px rgba(0, 210, 255, 0.3);
        }

        .btn-success-neon {
            background-color: var(--neon-success);
            color: #000;
            font-weight: 800;
            border: none;
            box-shadow: 0 0 15px rgba(0, 255, 136, 0.3);
        }

        .btn-warning-neon {
            background-color: var(--neon-warning);
            color: #000;
            font-weight: 800;
            border: none;
            box-shadow: 0 0 15px rgba(255, 193, 7, 0.3);
        }

        .btn-outline-secondary {
            border-color: rgba(255, 255, 255, 0.1);
            color: #888;
            transition: 0.3s;
        }

        .btn-outline-secondary:hover {
            border-color: var(--neon-blue);
            color: var(--neon-blue);
            background: transparent;
        }

        .text-success-neon {
            color: var(--neon-success);
        }

        .text-warning-neon {
            color: var(--neon-warning);
        }

        .text-neon-blue {
            color: var(--neon-blue);
        }

        .font-monospace {
            font-family: 'Courier New', Courier, monospace;
        }

        .premium-row {
            transition: 0.3s;
            border-bottom: 1px solid rgba(255, 255, 255, 0.02);
        }

        .premium-row:hover {
            background: rgba(255, 255, 255, 0.02);
        }
    </style>
@endsection
