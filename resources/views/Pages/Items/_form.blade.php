[<div class="row g-3 p-4 bg-dark text-white rounded shadow">

    <div class="col-md-6">
        <label class="form-label fw-bold">اسم الطبق</label>
        {{-- التعديل الجذري: نستخدم 'name' لاسم المدخل، و 'item_name' لقيمته من الداتابيز --}}
        <input type="text" name="name" value="{{ old('name', $item->item_name ?? '') }}"
            class="form-control bg-secondary text-white border-0">
        @error('name')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label fw-bold">القسم</label>
        <select name="category_id" class="form-select bg-secondary text-white border-0">
            <option value="">اختر القسم...</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}"
                    {{ old('category_id', $item->category_id ?? '') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach

        </select>
    </div>

    <div class="col-md-4">
        <label class="form-label fw-bold">السعر</label>
        <input type="number" step="0.01" name="price" value="{{ old('price', $item->price ?? '') }}"
            class="form-control bg-secondary text-white border-0">
        @error('price')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="col-md-4">
        <label class="form-label fw-bold">وقت التحضير (دقائق)</label>
        <input type="number" name="prepare_time" value="{{ old('prepare_time', $item->prepare_time ?? '') }}"
            class="form-control bg-secondary text-white border-0">
        @error('prepare_time')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="col-md-4">
        <label class="form-label fw-bold">الحالة</label>
        <select name="status" class="form-select bg-secondary text-white border-0">
            <option value="available" {{ old('status', $item->status ?? '') == 'available' ? 'selected' : '' }}>متوفر
            </option>
            <option value="unavailable" {{ old('status', $item->status ?? '') == 'unavailable' ? 'selected' : '' }}>
                غير متوفر</option>
        </select>
        @error('status')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="col-12">
        <label class="form-label fw-bold">صورة الطبق</label>
        <input type="file" name="image" class="form-control bg-secondary text-white border-0">

        {{-- عرض الصورة الحالية فوراً إذا كانت موجودة --}}
        @if (isset($item) && $item->image)
            <div class="mt-3 p-2 border border-secondary rounded d-inline-block">
                <p class="small text-muted mb-1 text-center">الصورة المخزنة حالياً:</p>
                <img src="{{ asset('storage/' . $item->image) }}" class="rounded shadow-sm"
                    style="width: 150px; height: 100px; object-fit: cover;">
                @error('image')
                    <div><small class="text-danger">{{ $message }}</small></div>
                @enderror
            </div>
        @endif


    </div>

    <div class="col-12">
        <label class="form-label fw-bold">الوصف</label>
        <textarea name="description" rows="3" class="form-control bg-secondary text-white border-0">{{ old('description', $item->description ?? '') }}</textarea>

    </div>
</div>
