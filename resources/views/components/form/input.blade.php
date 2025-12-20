@props([
    'name',
    'placeholder' => null,
    'value' => null,
    'label' => null,
    'type' => 'text',
    'required' => false,
    'class' => '',
])

<div class="form-group mb-3">
    @if ($label)
        <label for="{{ $name }}" class="form-label text-info fw-bold mb-2" style="font-size: 0.9rem;">
            {{ $label }}
        </label>
    @endif

    <input type="{{ $type }}" 
           name="{{ $name }}" 
           id="{{ $name }}"
           class="form-control text-white border-secondary {{ $class }} @error($name) is-invalid @enderror"
           placeholder="{{ $placeholder }}" 
           value="{{ old($name, $value) }}" 
           style="background-color: #2b3035; border: 1px solid #495057; border-radius: 8px; padding: 10px;"
           @if ($required) required @endif
           {{ $attributes->except(['label', 'value', 'type', 'name', 'placeholder', 'class', 'required']) }}>

    @error($name)
        <div class="invalid-feedback" style="font-size: 0.8rem;">
            {{ $message }}
        </div>
    @enderror
</div>