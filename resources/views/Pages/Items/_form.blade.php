<div class="row g-3 p-4 bg-dark text-white rounded shadow" dir="rtl">

    {{-- اسم الطبق --}}
    <div class="col-md-6 text-right">
        <label class="form-label fw-bold">اسم الطبق (سيظهر للزبائن)</label>
        <input type="text" name="name" value="{{ old('name', $item->item_name ?? '') }}"
            class="form-control bg-secondary text-white border-0 shadow-sm" placeholder="مثلاً: كبسة دجاج">
        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    {{-- القسم المفلتر (أقسام البيع فقط) --}}
    <div class="col-md-6 text-right">
        <label class="form-label fw-bold">القسم (قائمة البيع)</label>
        <select name="category_id" class="form-select bg-secondary text-white border-0 shadow-sm">
            <option value="">اختر القسم المناسب...</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}"
                    {{ old('category_id', $item->category_id ?? '') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        @error('category_id') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    {{-- السعر --}}
    <div class="col-md-4 text-right">
        <label class="form-label fw-bold text-success">سعر البيع المقترح</label>
        <div class="input-group">
            <input type="number" step="0.01" name="price" value="{{ old('price', $item->price ?? '') }}"
                class="form-control bg-secondary text-white border-0 shadow-sm">
            <span class="input-group-text bg-dark text-white border-0">ل.س</span>
        </div>
        @error('price') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    {{-- الحالة ووقت التحضير --}}
    <div class="col-md-4 text-right">
        <label class="form-label fw-bold">وقت التحضير المتوقع</label>
        <div class="input-group">
            <input type="number" name="prepare_time" value="{{ old('prepare_time', $item->prepare_time ?? '') }}"
                class="form-control bg-secondary text-white border-0 shadow-sm">
            <span class="input-group-text bg-dark text-white border-0">دقيقة</span>
        </div>
    </div>

    <div class="col-md-4 text-right">
        <label class="form-label fw-bold">حالة الظهور بالمنيو</label>
        <select name="status" class="form-select bg-secondary text-white border-0 shadow-sm">
            <option value="available" {{ old('status', $item->status ?? '') == 'available' ? 'selected' : '' }}>متوفر للعرض</option>
            <option value="unavailable" {{ old('status', $item->status ?? '') == 'unavailable' ? 'selected' : '' }}>مخفي حالياً</option>
        </select>
    </div>

    <hr class="border-secondary my-4">
    {{-- قسم المخزن: البيانات الجوهرية المزامنة --}}
    <h6 class="text-info fw-bold mb-3"><i class="fas fa-warehouse me-2"></i> بيانات المخزون المربوطة</h6>

    <div class="col-md-4 text-right">
        <label class="form-label fw-bold text-info small">الكمية الافتتاحية في المخزن</label>
        <input type="number" step="0.01" name="quantity" value="{{ old('quantity', $item->quantity ?? '0') }}"
            class="form-control bg-secondary text-white border-info-subtle border-1 shadow-sm">
    </div>

    <div class="col-md-4 text-right">
        <label class="form-label fw-bold text-info small">وحدة القياس</label>
        <select name="unit" class="form-select bg-secondary text-white border-info-subtle border-1">
            @foreach(['قطعة', 'كيلو', 'لتر', 'وجبة'] as $u)
                <option value="{{ $u }}" {{ old('unit', $item->unit ?? '') == $u ? 'selected' : '' }}>{{ $u }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-md-4 text-right">
        <label class="form-label fw-bold text-info small">حد التنبيه (Stock Alert)</label>
        <input type="number" step="0.01" name="min_quantity" value="{{ old('min_quantity', $item->min_quantity ?? '5') }}"
            class="form-control bg-secondary text-white border-info-subtle border-1 shadow-sm">
    </div>

    {{-- الصورة والوصف --}}
    <div class="col-12 mt-3 text-right">
        <label class="form-label fw-bold">صورة الطبق (للمنيو)</label>
        <input type="file" name="image" class="form-control bg-secondary text-white border-0 shadow-sm">
        @if (isset($item) && $item->image)
            <div class="mt-3">
                <img src="{{ asset('storage/' . $item->image) }}" class="rounded shadow border border-secondary"
                    style="width: 120px; height: 80px; object-fit: cover;">
                <small class="d-block text-muted mt-1">المعاينة الحالية</small>
            </div>
        @endif
    </div>

    <div class="col-12 text-right">
        <label class="form-label fw-bold">الوصف التجاري والمكونات</label>
        <textarea name="description" rows="3" class="form-control bg-secondary text-white border-0 shadow-sm" 
            placeholder="اكتب وصفاً جذاباً للطبق يظهر للزبائن في تطبيق الطلبات...">{{ old('description', $item->description ?? '') }}</textarea>
    </div>
</div>