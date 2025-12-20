<div class="row g-4 text-white">
    {{-- رقم الطاولة --}}
    <div class="col-md-6">
        <label class="form-label text-info fw-bold small">رقم الطاولة (يجب أن يكون رقماً)</label>
        <input type="number" name="table_number"
            class="form-control bg-secondary bg-opacity-10 border-secondary text-white shadow-none"
            placeholder="مثلاً: 1" value="{{ old('table_number', $table->table_number ?? '') }}" required>
    </div>

    {{-- سعة الجلوس --}}
    <div class="col-md-6">
        <label class="form-label text-info fw-bold small">سعة الجلوس (عدد الأشخاص)</label>
        <input type="number" name="seating_capacity"
            class="form-control bg-secondary bg-opacity-10 border-secondary text-white shadow-none"
            value="{{ old('seating_capacity', $table->seating_capacity ?? '4') }}" min="1" required>
    </div>

    {{-- الموقع --}}
    <div class="col-md-6">
        <label class="form-label text-info fw-bold small">موقع الطاولة</label>
        <select name="location" class="form-select bg-secondary bg-opacity-10 border-secondary text-white shadow-none">
            @foreach(['الصالة الرئيسية', 'التراس الخارجي', 'قسم العائلات', 'قسم الـ VIP'] as $loc)
                <option value="{{ $loc }}" {{ old('location', $table->location ?? '') == $loc ? 'selected' : '' }}>
                    {{ $loc }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- الحالة --}}
    <div class="col-md-6">
        <label class="form-label text-info fw-bold small">حالة الطاولة</label>
        <select name="status" class="form-select bg-secondary bg-opacity-10 border-secondary text-white shadow-none">
            <option value="available" {{ old('status', $table->status ?? '') == 'available' ? 'selected' : '' }}>متاحة</option>
            <option value="reserved" {{ old('status', $table->status ?? '') == 'reserved' ? 'selected' : '' }}>محجوزة</option>
            @if(isset($table))
                <option value="occupied" {{ old('status', $table->status ?? '') == 'occupied' ? 'selected' : '' }}>مشغولة</option>
            @endif
        </select>
    </div>
</div>