@props([
    'name',
    'placeholder' => null,
    'value' => null,
    'label' => null,
    'type' => 'text',
    'required' => false,
    'class' => '',
])
<div class="form-group">
    @if ($label)
        <label for="{{ $name }}" class="form-label text-white">{{ $label }}</label>
    @endif

    <input type="{{ $type }}" name="{{ $name }}" id="{{ $name }}"
        class="form-control bg-secondary text-white border-secondary  {{ $class }} @error($name) is-invalid @enderror"
        placeholder="{{ $placeholder }}" 
        
        {{-- **التعديل هنا:** استخدام old($name, $value) لضمان عرض القيمة الممررة (مثل $role->role_name) --}}
        value="{{ old($name, $value) }}" 
        
        @if ($required) required @endif
        {{ $attributes->except(['label', 'value', 'type', 'name', 'placeholder', 'class', 'required']) }}>

    @error($name)
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>