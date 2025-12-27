<div class="row g-4 text-end" dir="rtl">
    {{-- 1. القسم والاسم --}}
    <div class="col-md-6">
        <label class="form-label fw-bold text-muted small mb-2">القسم التنظيمي (Category)</label>
        <select name="category_id" class="form-select-dark w-100 shadow-sm">
            <option value="" disabled selected>اختر القسم...</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}"
                    {{ old('category_id', $item->category_id ?? '') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }} ({{ $category->is_menu_category ? 'بيع' : 'إداري' }})
                </option>
            @endforeach
        </select>
        @error('category_id')
            <div class="text-danger-neon small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label fw-bold text-muted small mb-2">اسم المادة</label>
        <input type="text" name="name" class="form-control-dark w-100"
            value="{{ old('name', $item->name ?? '') }}" placeholder="مثلاً: كبسة دجاج، زيت قلي...">
        @error('name')
            <div class="text-danger-neon small mt-1">{{ $message }}</div>
        @enderror
    </div>

    {{-- 2. السعر وصورة المادة --}}
    <div class="col-md-6">
        <label class="form-label fw-bold text-success-neon small mb-2">سعر البيع (للأطباق فقط)</label>
        <div class="input-group-dark">
            <input type="number" step="0.01" name="sales_price" class="form-control-dark border-success-neon"
                value="{{ old('sales_price', $item->item->price ?? '') }}" placeholder="0.00">
            <span class="input-group-text-dark bg-success-neon text-black fw-bold">ل.س</span>
        </div>
        @error('sales_price')
            <div class="text-danger-neon small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label fw-bold text-muted small mb-2">صورة المادة</label>
        <input type="file" name="image" class="form-control-dark w-100" accept="image/*">
        @if (isset($item) && $item->image)
            <div class="mt-2">
                <img src="{{ asset('storage/' . $item->image) }}" class="rounded-3 shadow-sm border border-secondary"
                    style="height: 50px; width: 50px; object-fit: cover;">
                <small class="text-muted ms-2">الصورة الحالية</small>
            </div>
        @endif
    </div>

    {{-- 3. الكميات والوحدات --}}
    <div class="col-md-4">
        <label class="form-label fw-bold text-muted small mb-2">الكمية الافتتاحية</label>
        <input type="number" step="0.01" name="quantity" class="form-control-dark w-100"
            value="{{ old('quantity', $item->quantity ?? 0) }}">
    </div>

    <div class="col-md-4">
        <label class="form-label fw-bold text-muted small mb-2">حد الأمان (Stock Alert)</label>
        <input type="number" step="0.01" name="min_quantity" class="form-control-dark w-100"
            value="{{ old('min_quantity', $item->min_quantity ?? 0) }}">
    </div>

    <div class="col-md-4">
        <label class="form-label fw-bold text-muted small mb-2">وحدة القياس</label>
        <select name="unit" class="form-select-dark w-100 shadow-sm">
            @foreach (['قطعة', 'كجم', 'لتر', 'صندوق', 'كيس', 'وجبة'] as $unit)
                <option value="{{ $unit }}" {{ old('unit', $item->unit ?? '') == $unit ? 'selected' : '' }}>
                    {{ $unit }}</option>
            @endforeach
        </select>
    </div>

    {{-- 4. التكاليف والمورد والـ SKU --}}
    <div class="col-md-4">
        <label class="form-label fw-bold text-muted small mb-2">تكلفة الشراء (للوحدة)</label>
        <input type="number" step="0.01" name="cost_per_unit" class="form-control-dark w-100"
            value="{{ old('cost_per_unit', $item->cost_per_unit ?? '') }}" placeholder="0.00">
    </div>

    <div class="col-md-4">
        <label class="form-label fw-bold text-muted small mb-2">المورد المفضل</label>
        <input type="text" name="supplier" class="form-control-dark w-100"
            value="{{ old('supplier', $item->supplier ?? '') }}" placeholder="اسم الشركة أو المورد">
    </div>

    <div class="col-md-4">
        <label class="form-label fw-bold text-info-neon small mb-2">كود المادة (SKU)</label>
        <input type="text" name="sku" class="form-control-dark border-info-neon w-100"
            value="{{ old('sku', $item->sku ?? '') }}" placeholder="مثلاً: INV-1001">
        @error('sku')
            <div class="text-danger-neon small mt-1">{{ $message }}</div>
        @enderror
    </div>
</div>

<style>
    /* إضافة لون النيون الأزرق للـ SKU */
    .text-info-neon {
        color: #00d2ff;
    }

    .border-info-neon {
        border-color: rgba(0, 210, 255, 0.2) !important;
    }

    /* التنسيقات الأصلية */
    .form-control-dark,
    .form-select-dark {
        background-color: #1a1d21 !important;
        border: 1px solid rgba(255, 255, 255, 0.05) !important;
        color: #ffffff !important;
        padding: 12px 15px;
        border-radius: 12px;
        transition: 0.3s;
    }

    .form-control-dark:focus,
    .form-select-dark:focus {
        border-color: #00d2ff !important;
        box-shadow: 0 0 10px rgba(0, 210, 255, 0.1) !important;
        outline: none;
    }

    /* ... باقي الستايلات الخاصة بك ... */
    .input-group-dark {
        display: flex;
        border-radius: 12px;
        overflow: hidden;
    }

    .input-group-dark .form-control-dark {
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
    }

    .input-group-text-dark {
        padding: 12px 15px;
        border: none;
        display: flex;
        align-items: center;
    }

    .text-success-neon {
        color: #00ff88;
    }

    .text-danger-neon {
        color: #ff3e3e;
    }

    .border-success-neon {
        border-color: rgba(0, 255, 136, 0.2) !important;
    }

    .bg-success-neon {
        background-color: #00ff88;
    }
</style>
