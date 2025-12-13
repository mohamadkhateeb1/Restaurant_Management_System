@props(['disabled' => false])

<input @disabled($disabled)
    {{ $attributes->merge([
        'class' => '
                bg-gray-700 
                border-gray-500 
                text-gray-100 
                placeholder-gray-400 
                focus:border-sky-400 
                focus:ring-sky-400 
                rounded-md 
                shadow-inner
            ',
    ]) }}>
