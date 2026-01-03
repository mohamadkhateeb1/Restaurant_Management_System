@extends('layouts.app')

@section('content')
    <div class="container py-4 py-md-5 px-3 px-md-4" dir="rtl">

        {{-- HEADER --}}
        <div class="row mb-4 align-items-center animate-fade">
            <div class="col-md-7 mb-3 mb-md-0">
                <div class="d-flex align-items-center gap-3">
                    <div class="header-indicator d-none d-sm-block"></div>
                    <h5 class="fw-bold text-gold mb-0">INVENTORY DASHBOARD</h5>
                </div>
            </div>

            @can('create', App\Models\Inventory::class)
                <div class="col-md-5 text-start text-md-end">
                    <a href="{{ route('Pages.inventory.create') }}" class="btn btn-neon-glow rounded-pill px-4 w-auto">
                        <i class="fas fa-plus-circle me-2"></i> إضافة مادة
                    </a>
                </div>
            @endcan
        </div>

        {{-- STATS --}}
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3 animate-up" style="animation-delay:.1s">
                <div class="stat-card">
                    <div class="stat-title text-truncate">إجمالي المواد</div>
                    <div class="stat-value">{{ $items->count() }}</div>
                </div>
            </div>
            <div class="col-6 col-md-3 animate-up" style="animation-delay:.2s">
                <div class="stat-card warning">
                    <div class="stat-title text-truncate">نقص حاد</div>
                    <div class="stat-value">
                        {{ $items->where('quantity', '<=', 'min_quantity')->count() }}
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3 animate-up" style="animation-delay:.3s">
                <div class="stat-card success">
                    <div class="stat-title text-truncate">متوفر</div>
                    <div class="stat-value">
                        {{ $items->where('quantity', '>', 'min_quantity')->count() }}
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3 animate-up" style="animation-delay:.4s">
                <div class="stat-card gold">
                    <div class="stat-title text-truncate">أصناف منيو</div>
                    <div class="stat-value">
                        {{ $items->where('item_type', 'menu_item')->count() }}
                    </div>
                </div>
            </div>
        </div>

        {{-- FILTER --}}
        <form action="{{ route('Pages.inventory.index') }}" method="GET" class="filter-capsule animate-fade flex-wrap">
            <select name="item_type" class="flex-grow-1">
                <option value="">كل التصنيفات</option>
                <option value="raw_material">مواد خام</option>
                <option value="menu_item">منيو</option>
            </select>

            <select name="category_id" class="flex-grow-1">
                <option value="">كل الأقسام</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>

            <button type="submit" class="btn btn-gold px-4 flex-grow-1 flex-md-grow-0">
                <i class="fas fa-filter me-1"></i> تصفية
            </button>
        </form>

        {{-- LIST HEADER --}}
        <div class="list-header d-none d-lg-grid animate-fade">
            <div>المادة</div>
            <div>القسم</div>
            <div>الكمية</div>
            <div>المالية</div>
            <div>الحالة</div>
            <div>العمليات</div>
        </div>

        {{-- ITEMS --}}
        @foreach ($items as $item)
            <div class="inventory-card animate-row">
                <div class="grid-layout">

                    <div class="grid-item item-main">
                        <div class="icon d-none d-sm-block">{{ $item->item_type == 'menu_item' ? '🍽️' : '📦' }}</div>
                        <div class="text-truncate">
                            <strong class="d-block text-truncate">{{ $item->name }}</strong>
                            <span class="sku">ID: {{ $item->sku }}</span>
                        </div>
                    </div>

                    <div class="grid-item d-none d-lg-block">{{ $item->category->name ?? 'عام' }}</div>

                    <div class="grid-item item-quantity {{ $item->quantity <= $item->min_quantity ? 'danger' : 'ok' }}">
                        <span class="d-lg-none text-muted small ms-1">الكمية:</span>
                        {{ $item->quantity }} <small>{{ $item->unit }}</small>
                    </div>

                    <div class="grid-item d-none d-lg-block">
                        <div class="small">تكلفة: {{ number_format($item->cost_per_unit) }}</div>
                        @if ($item->item)
                            <div class="gold-text small">بيع: {{ number_format($item->item->price) }}</div>
                        @endif
                    </div>

                    <div class="grid-item item-status">
                        @if ($item->quantity <= $item->min_quantity)
                            <span class="badge danger w-100">نقص</span>
                        @else
                            <span class="badge success w-100">متوفر</span>
                        @endif
                    </div>

                    <div class="grid-item actions">
                        <a href="{{ route('Pages.inventory.show', $item->id) }}" class="btn-action">👁️</a>
                        <a href="{{ route('Pages.inventory.edit', $item->id) }}" class="btn-action">✏️</a>
                    </div>

                </div>
            </div>
        @endforeach

    </div>

    {{-- STYLE --}}
    <style>
        :root {
            --bg: #0b0d10;
            --card: #121621;
            --gold: #d4af37;
            --danger: #ff4d4d;
            --success: #2ecc71;
        }

        body {
            background: var(--bg);
            color: #fff;
            font-family: 'Cairo', sans-serif;
            overflow-x: hidden;
        }

        /* ANIMATIONS */
        @keyframes fade {
            from {
                opacity: 0
            }

            to {
                opacity: 1
            }
        }

        @keyframes up {
            from {
                opacity: 0;
                transform: translateY(30px)
            }

            to {
                opacity: 1;
                transform: none
            }
        }

        .animate-fade {
            animation: fade .8s ease both
        }

        .animate-up {
            animation: up .8s ease both
        }

        .animate-row {
            animation: up .6s ease both
        }

        /* COMPONENTS */
        .header-indicator {
            width: 6px;
            height: 32px;
            background: var(--gold);
            border-radius: 10px
        }

        .stat-card {
            background: var(--card);
            padding: 15px;
            border-radius: 18px;
            border: 1px solid rgba(255, 255, 255, 0.05);
            transition: .4s;
            height: 100%;
        }

        .stat-title {
            color: #aaa;
            font-size: .75rem;
            margin-bottom: 5px;
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: 900;
        }

        @media (min-width: 768px) {
            .stat-card {
                padding: 20px;
            }

            .stat-value {
                font-size: 2rem;
            }
        }

        .warning .stat-value {
            color: var(--danger)
        }

        .success .stat-value {
            color: var(--success)
        }

        .gold .stat-value {
            color: var(--gold)
        }

        .filter-capsule {
            display: flex;
            gap: 10px;
            background: var(--card);
            padding: 12px;
            border-radius: 18px;
            margin-bottom: 20px;
        }

        .filter-capsule select {
            background: #000;
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #fff;
            padding: 8px 12px;
            border-radius: 12px;
            outline: none;
        }

        /* GRID SYSTEM */
        .list-header {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr 1fr 1fr;
            padding: 0 15px 10px 15px;
            color: #888;
            font-size: 0.85rem;
        }

        .inventory-card {
            background: var(--card);
            border-radius: 18px;
            margin-bottom: 12px;
            border: 1px solid transparent;
            transition: .3s;
        }

        .inventory-card:hover {
            border-color: var(--gold);
            transform: scale(1.005);
        }

        .grid-layout {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            /* Mobile: Item, Qty, Status/Actions */
            padding: 15px;
            align-items: center;
            gap: 10px;
        }

        @media (min-width: 992px) {
            .grid-layout {
                grid-template-columns: 2fr 1fr 1fr 1fr 1fr 1fr;
                gap: 0;
            }
        }

        .item-main {
            display: flex;
            align-items: center;
            gap: 10px;
            overflow: hidden;
        }

        .icon {
            font-size: 22px;
            flex-shrink: 0;
        }

        .sku {
            font-size: .65rem;
            color: #777;
        }

        .grid-item.danger {
            color: var(--danger);
            font-weight: bold;
        }

        .grid-item.ok {
            color: var(--success);
        }

        .badge {
            padding: 6px 12px;
            border-radius: 10px;
            font-size: .7rem;
            font-weight: bold;
            border: none;
        }

        .badge.danger {
            background: rgba(255, 77, 77, 0.15);
            color: var(--danger);
        }

        .badge.success {
            background: rgba(46, 204, 113, 0.15);
            color: var(--success);
        }

        .btn-action {
            display: inline-block;
            padding: 5px;
            text-decoration: none;
            transition: 0.2s;
        }

        .btn-action:hover {
            transform: scale(1.2);
        }

        .gold-text {
            color: var(--gold)
        }

        .btn-neon-glow {
            background: var(--gold);
            color: #000;
            font-weight: bold;
            box-shadow: 0 0 15px rgba(212, 175, 55, 0.3);
            border: none;
        }

        /* Mobile specific adjustments */
        @media (max-width: 991px) {
            .item-status {
                grid-column: span 1;
            }

            .actions {
                text-align: left;
            }

            .item-quantity {
                text-align: center;
            }
        }

        @media (max-width: 576px) {
            .grid-layout {
                grid-template-columns: 1.5fr 1fr;
            }

            .item-status {
                display: none;
            }

            /* Hide status badge on very small screens to save space */
            .actions {
                grid-row: span 1;
            }
        }
    </style>
@endsection
