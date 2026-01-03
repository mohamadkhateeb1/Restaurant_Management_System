<div class="row g-4 text-end" dir="rtl">
    <div class="col-md-6">
        <label class="form-label fw-bold text-muted small mb-2">@lang('Category')</label>
        <select name="category_id" class="form-select-dark w-100 shadow-sm">
            <option value="" disabled selected>@lang('Select Category')</option>
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
        <label class="form-label fw-bold text-muted small mb-2">@lang('Item Name')</label>
        <input type="text" name="name" class="form-control-dark w-100"
            value="{{ old('name', $item->name ?? '') }}" placeholder="@lang('Enter Item Name')">
        @error('name')
            <div class="text-danger-neon small mt-1">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label fw-bold text-success-neon small mb-2">@lang('Item Price')</label>
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
    </div>
    <div class="col-md-4">
        <label class="form-label fw-bold text-muted small mb-2">@lang('Initial Quantity')</label>
        <input type="number" step="0.01" name="quantity" class="form-control-dark w-100"
            value="{{ old('quantity', $item->quantity ?? 0) }}">
    </div>
    <div class="col-md-4">
        <label class="form-label fw-bold text-muted small mb-2">@lang('Stock Alert')</label>
        <input type="number" step="0.01" name="min_quantity" class="form-control-dark w-100"
            value="{{ old('min_quantity', $item->min_quantity ?? 0) }}">
    </div>
    <div class="col-md-4">
        <label class="form-label fw-bold text-muted small mb-2">@lang('Unit of Measurement')</label>
        <select name="unit" class="form-select-dark w-100 shadow-sm">
            @foreach (['قطعة', 'كجم', 'لتر', 'صندوق', 'كيس', 'وجبة'] as $unit)
                <option value="{{ $unit }}" {{ old('unit', $item->unit ?? '') == $unit ? 'selected' : '' }}>
                    {{ $unit }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4">
        <label class="form-label fw-bold text-muted small mb-2">@lang('Cost Per Unit')</label>
        <input type="number" step="0.01" name="cost_per_unit" class="form-control-dark w-100"
            value="{{ old('cost_per_unit', $item->cost_per_unit ?? '') }}" placeholder="0.00">
    </div>
    <div class="col-md-4">
        <label class="form-label fw-bold text-muted small mb-2">@lang('Preferred Supplier')</label>
        <input type="text" name="supplier" class="form-control-dark w-100"
            value="{{ old('supplier', $item->supplier ?? '') }}" placeholder="@lang('Supplier Name')">
    </div>
    <div class="col-md-4">
        <label class="form-label fw-bold text-info-neon small mb-2">@lang('Item SKU')</label>
        <input type="text" name="sku" class="form-control-dark border-info-neon w-100"
            value="{{ old('sku', $item->sku ?? '') }}" placeholder="@lang('e.g., INV-1001')">
        @error('sku')
            <div class="text-danger-neon small mt-1">{{ $message }}</div>
        @enderror
    </div>
</div>
<style>
    .text-info-neon {
        color: #00d2ff;
    }

    .border-info-neon {
        border-color: rgba(0, 210, 255, 0.2) !important;
    }

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
