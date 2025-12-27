{{-- حقل الاسم --}}
<x-form-categories.input name="name" label="اسم القسم الإداري" :value="$category->name ?? null" placeholder="مثلاً: اللحوم، المنظفات، المشروبات..." />

{{-- حقل نوع القسم (التحكم في مكان الظهور - المبدأ الأساسي الجديد) --}}
<div class="form-group mb-4">
    <label for="is_menu_category" class="form-label text-white fw-bold">نطاق عمل القسم (مكان الظهور)</label>
    <select name="is_menu_category" id="is_menu_category" class="form-control bg-secondary text-white border-0 shadow-sm @error('is_menu_category') is-invalid @enderror">
        {{-- القيمة 1: للأصناف التي تباع (ستظهر في المنيو والمخزن) --}}
        <option value="1" {{ (old('is_menu_category', $category->is_menu_category ?? '') == '1') ? 'selected' : '' }}>
            قسم تجاري (يظهر في المنيو والمخزن)
        </option>
        {{-- القيمة 0: للمواد الخام والإدارية (تظهر في المخزن فقط) --}}
        <option value="0" {{ (old('is_menu_category', $category->is_menu_category ?? '') == '0') ? 'selected' : '' }}>
            قسم إداري/مخزني (لا يظهر في المنيو)
        </option>
    </select>
    <div class="alert alert-info py-2 mt-2 bg-transparent border-info text-info small" style="border-style: dashed;">
        <i class="fas fa-info-circle me-1"></i>
        اختر "قسم تجاري" للوجبات والمشروبات. اختر "إداري" للمواد الأولية كالزيوت والمواد التي لا تُباع مباشرة.
    </div>

    @error('is_menu_category')
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>

{{-- حقل الوصف --}}
<x-form-categories.input name="description" label="وصف القسم (اختياري)" :value="$category->description ?? null" />

{{-- حقل الصورة --}}
<x-form-categories.input type="file" name="image" label="أيقونة القسم بصرية" />

{{-- حقل الحالة --}}
<div class="form-group mb-3">
    <label for="status" class="form-label text-white fw-bold">حالة النشاط</label>
    <select name="status" id="status" class="form-control bg-secondary text-white border-0 shadow-sm @error('status') is-invalid @enderror">
        <option value="active" {{ (old('status', $category->status ?? '') == 'active') ? 'selected' : '' }}>نشط (مفعل في النظام)</option>
        <option value="inactive" {{ (old('status', $category->status ?? '') == 'inactive') ? 'selected' : '' }}>معطل (مخفي مؤقتاً)</option>
    </select>
</div>