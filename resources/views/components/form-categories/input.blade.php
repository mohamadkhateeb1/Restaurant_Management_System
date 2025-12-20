@props([
    'name',
    'placeholder' => null,
    'value' => null,
    'label' => null,
    'type' => 'text',
    'required' => false,
    'class' => '',
    'active' => false,
])

<div class="form-group mb-3">
    @if ($label)
        <label for="{{ $name }}" class="form-label text-white">{{ $label }}</label>
    @endif

    <input type="{{ $type }}" name="{{ $name }}" id="{{ $name }}"
        class="form-control bg-secondary text-white border-secondary {{ $class }} @error($name) is-invalid @enderror"
        placeholder="{{ $placeholder }}" value="{{ old($name, $value) }}"
        @if ($required) required @endif
        {{ $attributes->except(['label', 'value', 'type', 'name', 'placeholder', 'class', 'required']) }}>

    @error($name)
        <div class="invalid-feedback d-block">
            {{ $message }}
        </div>
    @enderror
</div>
