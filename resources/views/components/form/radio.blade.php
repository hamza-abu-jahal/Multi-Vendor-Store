@props([
    'name' , 'options' , 'checked' => false ,'label' => false,
])

@if($label)
<label for="">{{ $label }}</label>
@endif


@foreach ($options as $value => $text)
    <div class="form-check">

        <input class="form-check-input" type="radio" name="{{$name}}"  value="{{$value}}"
        @checked(old($name , $checked) == $value ) class="form-control @error($name) is-invalid @enderror">

        <label class="form-check-label" >
        {{$text}}
        </label>

    </div>
@endforeach
