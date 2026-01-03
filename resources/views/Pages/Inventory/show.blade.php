@extends('layouts.app')
@section('content')
    <div class="container py-5 px-4" dir="rtl">

        {{-- HEADER --}}
        <div class="row mb-5 align-items-center animate-fade">
            <div class="col-md-7">
                <div class="d-flex align-items-center gap-3 mb-2">
                    <div class="header-indicator"></div>
                    <h6 class="text-gold fw-bold mb-0 text-uppercase">@lang('Inventory Item Record Details')</h6>
                </div>
                <h2 class="fw-black text-white display-6">{{ $item->name }}</h2>
            </div>

            <div class="col-md-5 d-flex justify-content-md-end gap-3 mt-4 mt-md-0">
                <a href="{{ route('Pages.inventory.index') }}" class="btn btn-dark-minimal rounded-pill px-4">
                    <i class="fas fa-arrow-right me-2"></i> رجوع
                </a>
                <a href="{{ route('Pages.inventory.edit', $item->id) }}" class="btn btn-gold rounded-pill px-4 fw-bold">
                    <i class="fas fa-edit me-2"></i> تعديل
                </a>
            </div>
        </div>

        <div class="row g-4">

            {{-- LEFT CARD --}}
            <div class="col-lg-4 animate-up">
                <div class="card glass-card h-100">

                    <div class="card-body text-center p-4">
                        <span class="badge badge-type mb-3">
                            {{ $item->item_type == 'menu_item' ? 'طبق مبيعات' : 'مادة أساسية' }}
                        </span>

                        <div class="orb mx-auto mb-3">
                            <i class="fas {{ $item->item_type == 'menu_item' ? 'fa-utensils' : 'fa-seedling' }}"></i>
                        </div>

                        <h4 class="fw-bold">{{ $item->name }}</h4>
                        <small class="text-gold">SKU: {{ $item->sku }}</small>

                        <div class="info-list mt-4">
                            <div><span>القسم</span><strong>{{ $item->category->name }}</strong></div>
                            <div>
                                <span>الرصيد</span>
                                <strong class="{{ $item->quantity <= $item->min_quantity ? 'danger' : 'success' }}">
                                    {{ number_format($item->quantity, 1) }} {{ $item->unit }}
                                </strong>
                            </div>
                            <div><span>تكلفة الوحدة</span><strong>{{ number_format($item->cost_per_unit, 0) }} ل.س</strong>
                            </div>
                            @if ($item->item)
                                <div><span>سعر البيع</span><strong class="gold">{{ number_format($item->item->price, 0) }}
                                        ل.س</strong></div>
                            @endif
                            <div><span>المورد</span><strong>{{ $item->supplier ?? 'شراء مباشر' }}</strong></div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- RIGHT TABLE --}}
            <div class="col-lg-8 animate-up" style="animation-delay:.1s">
                <div class="card glass-card h-100">

                    <div class="card-header bg-transparent border-0 px-4 pt-4">
                        <h6 class="fw-bold mb-0">
                            <i class="fas fa-history text-gold me-2"></i> سجل الحركات
                        </h6>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table premium-table mb-0 text-center">
                                <thead>
                                    <tr>
                                        <th>التاريخ</th>
                                        <th>النوع</th>
                                        <th>الكمية</th>
                                        <th>المرجع</th>
                                        <th>الموظف</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($item->transactions as $transaction)
                                        <tr>
                                            <td>{{ $transaction->created_at->format('Y/m/d H:i') }}</td>
                                            <td>
                                                <span class="pill {{ $transaction->type }}">
                                                    {{ $transaction->type == 'in' ? 'وارد' : ($transaction->type == 'out' ? 'صادر' : 'تعديل') }}
                                                </span>
                                            </td>
                                            <td class="{{ $transaction->type == 'in' ? 'success' : 'danger' }}">
                                                {{ $transaction->type == 'in' ? '+' : '-' }}{{ number_format($transaction->quantity, 1) }}
                                            </td>
                                            <td class="text-muted">{{ $transaction->reference ?? 'يدوي' }}</td>
                                            <td>{{ $transaction->employee->name ?? 'النظام' }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="py-5 text-muted">لا يوجد حركات بعد</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    {{-- STYLE --}}
    <style>
        :root {
            --bg: #0b0d10;
            --card: #11151c;
            --gold: #d4af37;
            --danger: #ff4d4d;
            --success: #2ecc71;
        }

        body {
            background: var(--bg);
            color: #eee;
            font-family: Cairo
        }

        /* animations */
        @keyframes up {
            from {
                opacity: 0;
                transform: translateY(30px)
            }

            to {
                opacity: 1
            }
        }

        @keyframes fade {
            from {
                opacity: 0
            }

            to {
                opacity: 1
            }
        }

        .animate-up {
            animation: up .8s ease both
        }

        .animate-fade {
            animation: fade .6s ease both
        }

        /* cards */
        .glass-card {
            background: linear-gradient(145deg, #0f131b, #0b0d10);
            border-radius: 22px;
            border: 1px solid #222;
            box-shadow: 0 30px 60px rgba(0, 0, 0, .7);
        }

        /* header */
        .header-indicator {
            width: 6px;
            height: 36px;
            background: var(--gold);
            border-radius: 10px
        }

        .text-gold {
            color: var(--gold)
        }

        /* orb */
        .orb {
            width: 110px;
            height: 110px;
            border-radius: 30px;
            background: radial-gradient(circle, var(--gold), #7c6220);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 42px;
            color: #000;
            box-shadow: 0 0 30px rgba(212, 175, 55, .4)
        }

        /* info */
        .info-list div {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #222
        }

        .info-list span {
            color: #888;
            font-size: .8rem
        }

        .info-list strong {
            font-weight: 800
        }

        .success {
            color: var(--success)
        }

        .danger {
            color: var(--danger)
        }

        .gold {
            color: var(--gold)
        }

        /* table */
        .premium-table thead {
            background: #0f131b;
            color: #888
        }

        .premium-table tbody tr {
            transition: .3s
        }

        .premium-table tbody tr:hover {
            background: rgba(255, 255, 255, .03)
        }

        /* pills */
        .pill {
            padding: 4px 14px;
            border-radius: 20px;
            font-size: .7rem;
            font-weight: 800
        }

        .pill.in {
            background: rgba(46, 204, 113, .15);
            color: var(--success)
        }

        .pill.out {
            background: rgba(255, 77, 77, .15);
            color: var(--danger)
        }

        .pill.adjust {
            background: rgba(212, 175, 55, .15);
            color: var(--gold)
        }

        /* buttons */
        .btn-gold {
            background: var(--gold);
            color: #000;
            border: none;
            box-shadow: 0 0 20px rgba(212, 175, 55, .4)
        }

        .btn-dark-minimal {
            background: #111;
            border: 1px solid #333;
            color: #aaa
        }
    </style>
@endsection
