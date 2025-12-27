@extends('layouts.app')

@section('content')
    <div class="container py-5 px-4" dir="rtl">
        {{-- هيدر الصفحة --}}
        <div class="row mb-5 align-items-center animate-fade-in">
            <div class="col-md-7 text-right">
                <div class="d-flex align-items-center mb-2">
                    <div class="header-indicator me-3"></div>
                    <h6 class="text-neon-blue fw-bold mb-0 text-uppercase tracking-wider">تفاصيل السجل المخزني</h6>
                </div>
                <h2 class="fw-black text-white display-5 mb-0">{{ $item->name }}</h2>
            </div>
            <div class="col-md-5 d-flex justify-content-md-end gap-3 mt-4 mt-md-0">
                <a href="{{ route('Pages.inventory.index') }}" class="btn btn-dark-minimal rounded-pill px-4">
                    <i class="fas fa-arrow-right me-2"></i> العودة للمخزن
                </a>
                <a href="{{ route('Pages.inventory.edit', $item->id) }}"
                    class="btn btn-neon-blue rounded-pill px-4 fw-bold">
                    <i class="fas fa-edit me-2"></i> تعديل البيانات
                </a>
            </div>
        </div>

        <div class="row g-4">
            {{-- كرت معلومات المادة المطور --}}
            <div class="col-lg-4 animate-slide-up">
                <div class="card border-0 shadow-2xl rounded-5 overflow-hidden" style="background: #111315;">
                    <div class="card-header border-0 py-3 text-center" style="background: rgba(255,255,255,0.02);">
                        <span
                            class="badge rounded-pill {{ $item->item_type == 'menu_item' ? 'bg-primary' : 'bg-secondary' }} px-3 py-2 small opacity-75">
                            {{ $item->item_type == 'menu_item' ? 'طبق مبيعات' : 'مادة أساسية' }}
                        </span>
                    </div>
                    <div class="card-body p-4">
                        {{-- عرض صورة المادة أو الأيقونة --}}
                        <div class="text-center mb-4">
                            <div class="main-orb-wrapper mx-auto mb-3">
                                @if ($item->item && $item->item->image)
                                    <img src="{{ asset('storage/' . $item->item->image) }}" class="main-orb-img"
                                        alt="{{ $item->name }}">
                                @else
                                    <div
                                        class="main-orb-placeholder {{ $item->item_type == 'menu_item' ? 'border-neon-blue' : 'border-neon-gray' }}">
                                        <i
                                            class="fas {{ $item->item_type == 'menu_item' ? 'fa-utensils' : 'fa-seedling' }}"></i>
                                    </div>
                                @endif
                            </div>
                            <h4 class="fw-bold text-white mb-1">{{ $item->name }}</h4>
                            <code class="text-neon-blue small">SKU: {{ $item->sku }}</code>
                        </div>

                        <div class="info-grid mt-4">
                            <div
                                class="info-row d-flex justify-content-between py-3 border-bottom border-white border-opacity-5">
                                <span class="text-muted small fw-bold">القسم التنظيمي</span>
                                <span class="text-white small">{{ $item->category->name }}</span>
                            </div>
                            <div
                                class="info-row d-flex justify-content-between py-3 border-bottom border-white border-opacity-5">
                                <span class="text-muted small fw-bold">الرصيد الحالي</span>
                                <span
                                    class="stock-glow {{ $item->quantity <= $item->min_quantity ? 'text-danger' : 'text-success-neon' }} fw-black fs-5">
                                    {{ number_format($item->quantity, 1) }} <small
                                        class="fw-normal opacity-50">{{ $item->unit }}</small>
                                </span>
                            </div>
                            <div
                                class="info-row d-flex justify-content-between py-3 border-bottom border-white border-opacity-5">
                                <span class="text-muted small fw-bold">تكلفة الوحدة</span>
                                <span class="text-white small">{{ number_format($item->cost_per_unit, 0) }} ل.س</span>
                            </div>
                            @if ($item->item)
                                <div
                                    class="info-row d-flex justify-content-between py-3 border-bottom border-white border-opacity-5">
                                    <span class="text-success-neon small fw-bold">سعر المنيو</span>
                                    <span class="text-success-neon fw-bold fs-5">{{ number_format($item->item->price, 0) }}
                                        ل.س</span>
                                </div>
                            @endif
                            <div class="info-row d-flex justify-content-between py-3">
                                <span class="text-muted small fw-bold">المورد</span>
                                <span class="text-white small">{{ $item->supplier ?? 'شراء مباشر' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- سجل الحركات (التايم لاين) المظلم --}}
            <div class="col-lg-8 animate-slide-up" style="animation-delay: 0.1s;">
                <div class="card border-0 shadow-2xl rounded-5 overflow-hidden" style="background: #111315;">
                    <div class="card-header border-0 py-4 px-4 d-flex justify-content-between align-items-center"
                        style="background: rgba(255,255,255,0.02);">
                        <h5 class="mb-0 fw-bold text-white fs-6"><i class="fas fa-history me-2 text-neon-blue"></i> السجل
                            الحركي اللحظي</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-dark-premium mb-0 align-middle text-center">
                                <thead>
                                    <tr>
                                        <th class="py-3 text-muted small">التاريخ</th>
                                        <th class="py-3 text-muted small">نوع الحركة</th>
                                        <th class="py-3 text-muted small">الكمية</th>
                                        <th class="py-3 text-muted small">المرجع</th>
                                        <th class="py-3 text-muted small">المسؤول</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($item->transactions as $transaction)
                                        <tr class="premium-row">
                                            <td class="small opacity-75">
                                                {{ $transaction->created_at->format('Y/m/d H:i') }}</td>
                                            <td>
                                                @php
                                                    $styles = [
                                                        'in' => 'status-ok',
                                                        'out' => 'status-out',
                                                        'adjust' => 'bg-warning bg-opacity-10 text-warning',
                                                    ];
                                                    $labels = ['in' => 'وارد', 'out' => 'صادر', 'adjust' => 'تعديل'];
                                                @endphp
                                                <span class="status-indicator {{ $styles[$transaction->type] }} px-3 py-1">
                                                    {{ $labels[$transaction->type] }}
                                                </span>
                                            </td>
                                            <td
                                                class="fw-black {{ $transaction->type == 'in' ? 'text-success-neon' : 'text-danger' }}">
                                                {{ $transaction->type == 'in' ? '+' : '-' }}{{ number_format($transaction->quantity, 1) }}
                                            </td>
                                            <td class="small text-muted">{{ $transaction->reference ?? 'تعديل يدوي' }}</td>
                                            <td class="small">
                                                <div class="d-flex align-items-center justify-content-center">
                                                    <div class="avatar-sm me-2">
                                                        <i class="fas fa-user-shield opacity-50"></i>
                                                    </div>
                                                    {{ $transaction->employee->name ?? 'النظام' }}
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="py-5 text-muted opacity-50">لا توجد حركات مسجلة لهذه
                                                المادة حتى الآن</td>
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

    <style>
        :root {
            --dark-carbon: #0d0f11;
            --item-bg: #111315;
            --neon-blue: #00d2ff;
            --neon-success: #00ff88;
        }

        body {
            background-color: var(--dark-carbon);
            font-family: 'Cairo', sans-serif;
            color: #e1e1e1;
        }

        .shadow-2xl {
            box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.8);
        }

        .header-indicator {
            width: 6px;
            height: 35px;
            background: var(--neon-blue);
            border-radius: 10px;
            box-shadow: 0 0 15px var(--neon-blue);
        }

        .text-neon-blue {
            color: var(--neon-blue);
        }

        .text-success-neon {
            color: var(--neon-success);
        }

        /* الأورب المركزي للصورة */
        .main-orb-wrapper {
            width: 120px;
            height: 120px;
            position: relative;
        }

        .main-orb-img {
            width: 100%;
            height: 100%;
            border-radius: 30px;
            object-fit: cover;
            border: 3px solid rgba(255, 255, 255, 0.05);
        }

        .main-orb-placeholder {
            width: 100%;
            height: 100%;
            border-radius: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #000;
            font-size: 2.5rem;
            border: 3px solid;
        }

        /* الجدول المظلم */
        .table-dark-premium thead {
            background: rgba(255, 255, 255, 0.02);
            text-transform: uppercase;
            font-weight: 800;
        }

        .premium-row {
            border-bottom: 1px solid rgba(255, 255, 255, 0.02);
            transition: 0.3s;
        }

        .premium-row:hover {
            background: rgba(255, 255, 255, 0.01);
        }

        .status-indicator {
            border-radius: 50px;
            font-size: 0.7rem;
            font-weight: 800;
        }

        .status-ok {
            background: rgba(0, 255, 136, 0.1);
            color: var(--neon-success);
        }

        .status-out {
            background: rgba(255, 62, 62, 0.1);
            color: #ff3e3e;
        }

        .btn-dark-minimal {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #888;
            transition: 0.3s;
        }

        .btn-dark-minimal:hover {
            color: #fff;
            background: rgba(255, 255, 255, 0.08);
        }

        .btn-neon-blue {
            background: var(--neon-blue);
            color: #000;
            border: none;
            box-shadow: 0 0 15px rgba(0, 210, 255, 0.3);
        }

        /* أنيميشن */
        .animate-slide-up {
            animation: slideUp 0.8s cubic-bezier(0.2, 1, 0.3, 1) forwards;
        }

        @keyframes slideUp {
            from {
                transform: translateY(30px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
    </style>
@endsection
