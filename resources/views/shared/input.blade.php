@php
    $class ??= null;
    $type ??= 'text';
    $placeholder ??= null;
    $label ??= null;
    $name ??= '';
    $valeur ??= '';
    $required ??= false;
@endphp


<div class="form-group {{ $class }}">
    <label for="{{ $name }}" class="block text-sm font-medium text-gray-700">{{ $label }}</label>
    <input 
    {{ $required ? 'required' : '' }}
        class="border rounded px-4 py-2 w-2/3 mt-1 mb-1
        @if($errors->has($name)) border-red-500 @endif" 
        type="{{ $type }}" 
        name="{{ $name }}" 
        id="{{ $name }}" 
        value="{{ old($name, $valeur) }}" 
        placeholder="{{ $placeholder }}"
    >
    @if($errors->has($name))
        <p class="text-red-500 text-xs mt-1 mb-1">{{ $errors->first($name) }}</p>
    @endif
</div>

