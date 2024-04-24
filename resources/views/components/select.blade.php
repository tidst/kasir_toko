@props(['name', 'value', 'options'])
@php
    $val = old($name, isset($value) ? $value : '');
@endphp
<select name="{{ $name }}" class="form-control @error($name) is-invalid @enderror">
    @isset($options)
        @foreach ($options as $option)
            <option value="{{ $option[0] }}"{{ $val == $option[0] ? ' selected' : '' }}>{{ $option[1] }}</option>
        @endforeach
    @endisset
</select>
@error($name)
    <div class="invalid-feedback">
        {{ $message }}
    </div>
@enderror
