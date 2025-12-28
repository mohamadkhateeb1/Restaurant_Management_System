@extends('layouts.app')
@section('content')
    <div class="container py-5 px-4" dir="rtl">
        <div class="row mb-5 align-items-center animate-fade-in">
            <div class="col-md-7 text-right">
                <div class="d-flex align-items-center mb-2 justify-content-start">
                    <div class="header-indicator me-3"></div>
                    <h6 class="text-neon-blue fw-bold mb-0 text-uppercase tracking-wider">لوحة تحكم المستودعات</h6>
                </div>
                <h2 class="fw-black text-white display-5 mb-0">المخزن <span class="text-glow">المركزي</span></h2>
            </div>
            @can('create', App\Models\Inventory::class)
                <div class="col-md-5 d-flex justify-content-md-end gap-3 mt-4 mt-md-0">
                    <a href="{{ route('Pages.inventory.create') }}" class="btn btn-neon-glow rounded-pill px-4 fw-bold">
                        <i class="fas fa-plus-circle me-2"></i> إضافة مادة جديدة
                    </a>
                </div>
            @endcan
        </div>
        <div class="row mb-4 animate-slide-down">
            <div class="col-12">
                <form id="filterForm" action="{{ route('Pages.inventory.index') }}" method="GET"
                    class="filter-capsule-dark p-2 shadow-lg">
                    <div class="row g-2 align-items-center">
                        <div class="col-md-4 px-3">
                            <select name="item_type" class="form-select-dark w-100">
                                <option value="">كافة تصنيفات المواد</option>
                                <option value="raw_material" {{ request('item_type') == 'raw_material' ? 'selected' : '' }}>
                                    مواد خام داخلية</option>
                                <option value="menu_item" {{ request('item_type') == 'menu_item' ? 'selected' : '' }}>أطباق
                                    قائمة الطعام</option>
                            </select>
                        </div>
                        <div class="col-md-4 px-3 border-start-dark">
                            <select name="category_id" class="form-select-dark w-100">
                                <option value="">كل الأقسام الإدارية</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}"
                                        {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 d-flex gap-2 ps-2">
                            <button type="submit" class="btn btn-primary-neon flex-grow-1 rounded-pill fw-bold">
                                <i class="fas fa-filter me-2"></i> تطبيق التصفية
                            </button>
                            <button type="button" id="resetFilters" class="btn btn-outline-danger-neon rounded-pill px-4">
                                <i class="fas fa-undo-alt"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <x-flash_message />
        <div class="inventory-list-container animate-slide-up">
            <div class="list-header d-none d-lg-grid">
                <div class="header-item text-right pr-5">تعريف المادة</div>
                <div class="header-item">القسم</div>
                <div class="header-item">الرصيد المتاح</div>
                <div class="header-item">البيانات المالية</div>
                <div class="header-item">الحالة</div>
                <div class="header-item">العمليات</div>
            </div>

            @forelse($items as $item)
                <div class="inventory-item-card mb-3">
                    <div class="item-grid-layout">
                        <div class="grid-col main-info d-flex align-items-center">
                            <div class="item-image-wrapper">
                                @if ($item->image)
                                    <img src="{{ asset('storage/' . $item->image) }}" class="item-img-preview shadow-sm"
                                        alt="{{ $item->name }}">
                                @else
                                    <div
                                        class="icon-orb-placeholder {{ $item->item_type == 'menu_item' ? 'border-neon-blue' : 'border-neon-gray' }}">
                                        <i
                                            class="fas {{ $item->item_type == 'menu_item' ? 'fa-utensils' : 'fa-seedling' }}"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="text-start ms-3">
                                <div class="text-white fw-bold fs-5 mb-1">{{ $item->name }}</div>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="sku-tag-premium">ID: {{ $item->sku }}</span>
                                    <span
                                        class="badge-type-small {{ $item->item_type == 'menu_item' ? 'text-primary' : 'text-muted' }}">
                                        {{ $item->item_type == 'menu_item' ? 'Menu' : 'Stock' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="grid-col">
                            <span class="category-badge-dark">{{ $item->category->name ?? 'عام' }}</span>
                        </div>

                        <div class="grid-col">
                            <div
                                class="stock-amount {{ $item->quantity <= $item->min_quantity ? 'glow-red' : 'glow-cyan' }}">
                                <span class="number">{{ number_format($item->quantity, 1) }}</span>
                                <span class="label">{{ $item->unit }}</span>
                            </div>
                        </div>

                        <div class="grid-col text-start">
                            <div class="price-info">
                                <div class="cost-val"><small>التكلفة:</small> {{ number_format($item->cost_per_unit, 0) }}
                                </div>
                                @if ($item->item)
                                    <div class="sale-val text-success-neon"><small>بيع:</small>
                                        {{ number_format($item->item->price, 0) }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="grid-col">
                            @if ($item->quantity <= $item->min_quantity)
                                <div class="status-dot-wrap text-danger small">
                                    <span class="dot pulse-red"></span> نقص حاد
                                </div>
                            @else
                                <div class="status-dot-wrap text-success small">
                                    <span class="dot static-green"></span> متوفر
                                </div>
                            @endif
                        </div>

                        <div class="grid-col actions">
                            <div class="btn-group-premium">
                                @can('view', App\Models\Inventory::class)
                                    <a href="{{ route('Pages.inventory.show', $item->id) }}" class="p-btn view"
                                        title="مشاهدة"><i class="fas fa-eye"></i></a>
                                @endcan
                                @can('update', App\Models\Inventory::class)
                                    <a href="{{ route('Pages.inventory.edit', $item->id) }}" class="p-btn edit"
                                        title="تعديل"><i class="fas fa-edit"></i></a>
                                @endcan
                                @can('delete', App\Models\Inventory::class)
                                    <form action="{{ route('Pages.inventory.destroy', $item->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="p-btn delete" onclick="return confirm('حذف المادة؟')"><i
                                                class="fas fa-trash"></i></button>
                                    </form>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="empty-inventory text-center py-5">
                    <i class="fas fa-box-open fa-4x text-muted mb-3 opacity-25"></i>
                    <h4 class="text-muted">المستودع خالٍ من هذه الفئة حالياً</h4>
                </div>
            @endforelse
        </div>
    </div>

    <script>
        document.getElementById('resetFilters').addEventListener('click', function() {
            window.location.href = "{{ route('Pages.inventory.index') }}";
        });
    </script>

    <style>
        :root {
            --dark-carbon: #0d0f11;
            --item-bg: #14171a;
            --neon-blue: #00d2ff;
            --neon-danger: #ff3e3e;
            --neon-success: #00ff88;
            --border-color: rgba(255, 255, 255, 0.05);
        }

        body {
            background-color: var(--dark-carbon);
            font-family: 'Cairo', sans-serif;
            color: #e1e1e1;
        }

        /* الهيدر */
        .header-indicator {
            width: 6px;
            height: 35px;
            background: var(--neon-blue);
            border-radius: 10px;
            box-shadow: 0 0 15px var(--neon-blue);
        }

        .text-glow {
            text-shadow: 0 0 20px rgba(255, 255, 255, 0.2);
        }

        /* الفلترة */
        .filter-capsule-dark {
            background: var(--item-bg);
            border-radius: 18px;
            border: 1px solid var(--border-color);
        }

        .form-select-dark {
            background: transparent !important;
            border: none;
            color: #fff !important;
            font-weight: 600;
            cursor: pointer;
        }

        .border-start-dark {
            border-right: 1px solid var(--border-color) !important;
        }

        .btn-primary-neon {
            background: var(--neon-blue);
            color: #000;
            border: none;
            transition: 0.3s;
        }

        .btn-outline-danger-neon {
            border: 1px solid var(--neon-danger);
            color: var(--neon-danger);
            background: transparent;
        }

        /* تنسيق الصور والـ SKU */
        .item-image-wrapper {
            width: 55px;
            height: 55px;
            position: relative;
            flex-shrink: 0;
        }

        .item-img-preview {
            width: 100%;
            height: 100%;
            border-radius: 14px;
            object-fit: cover;
            border: 2px solid rgba(255, 255, 255, 0.1);
        }

        .sku-tag-premium {
            background: #000;
            color: var(--neon-blue);
            font-family: 'Courier New', Courier, monospace;
            font-size: 0.7rem;
            padding: 2px 8px;
            border-radius: 6px;
            border: 1px solid rgba(0, 210, 255, 0.2);
            font-weight: bold;
        }

        .badge-type-small {
            font-size: 0.65rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 800;
            opacity: 0.6;
        }

        .inventory-list-container {
            margin-top: 20px;
        }

        .list-header {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1.5fr 1fr 1fr;
            padding: 15px 25px;
            color: #666;
            font-weight: 800;
            font-size: 0.8rem;
        }

        .inventory-item-card {
            background: var(--item-bg);
            border-radius: 20px;
            border: 1px solid var(--border-color);
            transition: 0.4s;
        }

        .inventory-item-card:hover {
            transform: translateY(-5px);
            border-color: rgba(0, 210, 255, 0.3);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        }

        .item-grid-layout {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1.5fr 1fr 1fr;
            align-items: center;
            padding: 12px 25px;
        }

        /* الألوان والنيون */
        .text-success-neon {
            color: var(--neon-success);
        }

        .stock-amount .number {
            font-size: 1.4rem;
            font-weight: 900;
        }

        .glow-cyan {
            color: #00f2ff;
            text-shadow: 0 0 10px rgba(0, 242, 255, 0.2);
        }

        .glow-red {
            color: var(--neon-danger);
            text-shadow: 0 0 10px rgba(255, 62, 62, 0.2);
        }

        .dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            display: inline-block;
            margin-left: 5px;
        }

        .pulse-red {
            background: var(--neon-danger);
            animation: pulse 1.5s infinite;
            box-shadow: 0 0 8px var(--neon-danger);
        }

        .static-green {
            background: var(--neon-success);
            box-shadow: 0 0 8px var(--neon-success);
        }

        .p-btn {
            width: 38px;
            height: 38px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #000;
            border: 1px solid #222;
            transition: 0.3s;
            color: #fff;
            text-decoration: none;
        }

        .p-btn:hover {
            background: #111;
            transform: scale(1.1);
        }

        @keyframes pulse {
            0% {
                opacity: 1;
            }

            50% {
                opacity: 0.3;
            }

            100% {
                opacity: 1;
            }
        }

        @media (max-width: 992px) {
            .item-grid-layout {
                grid-template-columns: 1fr 1fr;
                gap: 20px;
            }

            .grid-col.actions {
                grid-column: span 2;
            }
        }
    </style>
@endsection
