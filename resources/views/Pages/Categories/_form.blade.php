{{-- حقل الاسم --}}
<x-form-categories.input name="name" label="اسم التصنيف" :value="$category->name ?? null"  />

{{-- حقل السعر (الجديد) --}}

{{-- حقل الوصف --}}
<x-form-categories.input name="description" label="وصف التصنيف" :value="$category->description ?? null" />

{{-- حقل الصورة --}}
<x-form-categories.input type="file" name="image" label="صورة التصنيف" />

{{-- حقل الحالة --}}
<div class="form-group mb-3">
    <label for="status" class="form-label text-white">حالة التصنيف</label>
    <select name="status" id="status" class="form-control bg-secondary text-white border-secondary @error('status') is-invalid @enderror">
        <option value="active" {{ (old('status', $category->status ?? '') == 'active') ? 'selected' : '' }}>نشط</option>
        <option value="inactive" {{ (old('status', $category->status ?? '') == 'inactive') ? 'selected' : '' }}>غير نشط</option>
    </select>

    @error('status')
        <div class="invalid-feedback d-block">
            {{ $message }}
        </div>
    @enderror
</div>