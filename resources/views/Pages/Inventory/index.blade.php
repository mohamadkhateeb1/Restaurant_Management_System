@extends('layouts.app')

@section('content')
    <div class="container py-5 px-4" dir="rtl">

        {{-- HEADER --}}
        <div class="row mb-4 align-items-center animate-fade">
            <div class="col-md-7">
                <div class="d-flex align-items-center gap-3">
                    <div class="header-indicator"></div>
                    <h5 class="fw-bold text-gold mb-0">INVENTORY DASHBOARD</h5>
                </div>
            </div>

            @can('create', App\Models\Inventory::class)
                <div class="col-md-5 text-end">
                    <a href="{{ route('Pages.inventory.create') }}" class="btn btn-neon-glow rounded-pill px-4">
                        <i class="fas fa-plus-circle me-2"></i> إضافة مادة
                    </a>
                </div>
            @endcan
        </div>

        {{-- STATS --}}
        <div class="row mb-4">
            <div class="col-md-3 animate-up" style="animation-delay:.1s">
                <div class="stat-card">
                    <div class="stat-title">إجمالي المواد</div>
                    <div class="stat-value">{{ $items->count() }}</div>
                </div>
            </div>
            <div class="col-md-3 animate-up" style="animation-delay:.2s">
                <div class="stat-card warning">
                    <div class="stat-title">نقص حاد</div>
                    <div class="stat-value">
                        {{ $items->where('quantity', '<=', 'min_quantity')->count() }}
                    </div>
                </div>
            </div>
            <div class="col-md-3 animate-up" style="animation-delay:.3s">
                <div class="stat-card success">
                    <div class="stat-title">متوفر</div>
                    <div class="stat-value">
                        {{ $items->where('quantity', '>', 'min_quantity')->count() }}
                    </div>
                </div>
            </div>
            <div class="col-md-3 animate-up" style="animation-delay:.4s">
                <div class="stat-card gold">
                    <div class="stat-title">أصناف منيو</div>
                    <div class="stat-value">
                        {{ $items->where('item_type', 'menu_item')->count() }}
                    </div>
                </div>
            </div>
        </div>

        {{-- FILTER --}}
        <form action="{{ route('Pages.inventory.index') }}" method="GET" class="filter-capsule animate-fade">
            <select name="item_type">
                <option value="">كل التصنيفات</option>
                <option value="raw_material">مواد خام</option>
                <option value="menu_item">منيو</option>
            </select>

            <select name="category_id">
                <option value="">كل الأقسام</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>

            <button class="btn btn-gold">
                <i class="fas fa-filter"></i> تصفية
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
                <div class="grid">

                    <div class="main">
                        <div class="icon">{{ $item->item_type == 'menu_item' ? '🍽️' : '📦' }}</div>
                        <div>
                            <strong>{{ $item->name }}</strong>
                            <div class="sku">ID: {{ $item->sku }}</div>
                        </div>
                    </div>

                    <div>{{ $item->category->name ?? 'عام' }}</div>

                    <div class="{{ $item->quantity <= $item->min_quantity ? 'danger' : 'ok' }}">
                        {{ $item->quantity }} {{ $item->unit }}
                    </div>

                    <div>
                        تكلفة: {{ $item->cost_per_unit }}
                        @if ($item->item)
                            <div class="gold-text">بيع: {{ $item->item->price }}</div>
                        @endif
                    </div>

                    <div>
                        @if ($item->quantity <= $item->min_quantity)
                            <span class="badge danger">نقص</span>
                        @else
                            <span class="badge success">متوفر</span>
                        @endif
                    </div>

                    <div class="actions">
                        <a href="{{ route('Pages.inventory.show', $item->id) }}">👁️</a>
                        <a href="{{ route('Pages.inventory.edit', $item->id) }}">✏️</a>
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
            font-family: Cairo
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

        /* HEADER */
        .header-indicator {
            width: 6px;
            height: 32px;
            background: var(--gold);
            border-radius: 10px
        }

        /* STATS */
        .stat-card {
            background: var(--card);
            padding: 20px;
            border-radius: 18px;
            border: 1px solid #222;
            transition: .4s;
        }

        .stat-card:hover {
            transform: translateY(-6px)
        }

        .stat-title {
            color: #aaa;
            font-size: .8rem
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 900
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

        /* FILTER */
        .filter-capsule {
            display: flex;
            gap: 15px;
            background: var(--card);
            padding: 15px;
            border-radius: 18px;
            margin-bottom: 20px;
        }

        .filter-capsule select {
            background: #000;
            border: none;
            color: #fff;
            padding: 8px 12px;
            border-radius: 12px;
        }

        /* LIST */
        .list-header {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr 1fr 1fr;
            padding: 10px;
            color: #888;
        }

        .inventory-card {
            background: var(--card);
            border-radius: 18px;
            margin-bottom: 12px;
            transition: .3s;
        }

        .inventory-card:hover {
            transform: scale(1.01)
        }

        .grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr 1fr 1fr;
            padding: 15px;
            align-items: center;
        }

        .main {
            display: flex;
            gap: 12px;
            align-items: center
        }

        .icon {
            font-size: 28px
        }

        .sku {
            font-size: .7rem;
            color: #aaa
        }

        .badge {
            padding: 4px 10px;
            border-radius: 12px;
            font-size: .75rem
        }

        .badge.danger {
            background: var(--danger)
        }

        .badge.success {
            background: var(--success)
        }

        .gold-text {
            color: var(--gold)
        }

        .actions a {
            margin: 0 6px;
            color: #fff;
            text-decoration: none
        }
    </style>
@endsection
