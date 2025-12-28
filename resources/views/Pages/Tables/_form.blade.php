<div class="row g-4 text-white">
    <div class="col-md-6">
        <label class="form-label text-info fw-bold small">@lang('Table Number') (@lang('Must be a number'))</label>
        <input type="number" name="table_number"
            class="form-control bg-secondary bg-opacity-10 border-secondary text-white shadow-none"
            placeholder="@lang('For example: 1')" value="{{ old('table_number', $table->table_number ?? '') }}">
    </div>

    <div class="col-md-6">
        <label class="form-label text-info fw-bold small">@lang('Seating Capacity') (@lang('Number of people'))</label>
        <input type="number" name="seating_capacity"
            class="form-control bg-secondary bg-opacity-10 border-secondary text-white shadow-none"
            value="{{ old('seating_capacity', $table->seating_capacity ?? '4') }}" min="1">
    </div>

    <div class="col-md-6">
        <label class="form-label text-info fw-bold small">@lang('Location / Section')</label>
        <select name="location" class="form-select bg-secondary bg-opacity-10 border-secondary text-white shadow-none">
            @foreach (['الصالة الرئيسية', 'التراس الخارجي', 'قسم العائلات', 'قسم الـ VIP'] as $loc)
                <option value="{{ $loc }}"
                    {{ old('location', $table->location ?? '') == $loc ? 'selected' : '' }}>
                    {{ $loc }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-6">
        <label class="form-label text-info fw-bold small">@lang('Operational Status')</label>
        <select name="status" class="form-select bg-secondary bg-opacity-10 border-secondary text-white shadow-none">
            <option value="available" {{ old('status', $table->status ?? '') == 'available' ? 'selected' : '' }}>
                @lang('Available')</option>
            <option value="reserved" {{ old('status', $table->status ?? '') == 'reserved' ? 'selected' : '' }}>
                @lang('Reserved')</option>
            @if (isset($table))
                <option value="occupied" {{ old('status', $table->status ?? '') == 'occupied' ? 'selected' : '' }}>
                    @lang('Occupied')</option>
            @endif
        </select>
    </div>
</div>
