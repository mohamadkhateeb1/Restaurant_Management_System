@props([
    'label',
    'name',
    'options' => [],
    'selected' => null,
    'required' => false,
    'class' => '',
])

{{-- دمج label مع text-white --}}
@if ($label)
    <label for="{{ $name }}" class="form-label text-white">{{ $label }}</label>
@endif

<select 
    {{-- إضافة text-end لضمان محاذاة النص لليمين --}}
    class="form-select bg-secondary text-white border-secondary text-end {{ $class }} @error($name) is-invalid @enderror"
    name="{{ $name }}" id="{{ $name }}" @if ($required) required @endif
>
    {{-- تصحيح: إضافة خيار افتراضي وواضح (اختر) --}}
    <option value="" disabled @if (is_null(old($name, $selected))) selected @endif>
        -- اختر قيمة --
    </option>

    @foreach ($options as $value => $item)
        <option value="{{ $value }}" {{ $value == old($name, $selected) ? 'selected' : '' }}>
            {{ $item }}
        </option>
    @endforeach

</select>

@error($name)
    <div class="invalid-feedback">
        {{ $message }}
    </div>
@enderror