@props([
    'type' => 'text','name','value' => '' , 'label' => false
])


@if($label)
 <label for="">{{ $label }}</label>
@endif

<textarea name="{{$name}}" {{$attributes}} class="form-control @error($name) is-invalid @enderror">
{{ old($name , $value) }}
</textarea>
        @error($name)
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
