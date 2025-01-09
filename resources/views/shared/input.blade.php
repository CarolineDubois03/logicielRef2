@php
    $class ??= null;
    $type ??= 'text';
    $placeholder ??= null;
    $label ??= null;
    $name ??= '';
    $value ??= '';
    $required ??= false;
@endphp

<div class="form-group {{ $class }}">
    @if($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-gray-700">{{ $label }}</label>
    @endif

    <input 
        {{ $required ? 'required' : '' }}
        class="border rounded px-4 py-2 w-2/3 mt-1 mb-1 @if($errors->has($name)) border-red-500 @endif" 
        type="{{ $type }}" 
        name="{{ $name }}" 
        id="{{ $name }}" 
        value="{{ old($name, $value) }}" 
        placeholder="{{ $placeholder }}"
    >
    @if($errors->has($name))
        <p class="text-red-500 text-xs mt-1">{{ $errors->first($name) }}</p>
    @endif
</div>
