@extends('layouts.backend')



@section('content')
<div class="container">
    <h2>Soumettre une Application pour "{{ $procedure->name }}"</h2>
    <form method="POST" action="{{ route('procedures.applications.store', $procedure) }}" enctype="multipart/form-data">
        @csrf
        @foreach ($procedure->fields as $field)
            <div class="mb-3">
                <label class="form-label">{{ $field->label }}</label>
                @switch($field->type)
                    @case('text')
                        <input type="text" name="field_{{ $field->id }}" class="form-control">
                        @break
                    @case('textarea')
                        <textarea name="field_{{ $field->id }}" class="form-control"></textarea>
                        @break
                    @case('date')
                        <input type="date" name="field_{{ $field->id }}" class="form-control">
                        @break
                        @case('email')
                        <input type="email" name="field_{{ $field->id }}" class="form-control">
                        @break
                        @case('select')
                        <select name="field_{{ $field->id }}" class="form-control">
                            @if($field->options)
                                @foreach(json_decode($field->options, true) as $option)
                                    <option value="{{ $option }}">{{ $option }}</option>
                                @endforeach
                            @endif
                        </select>
                        @break
                    @case('radio')
                        @if($field->options)
                            @foreach(json_decode($field->options, true) as $option)
                                <div>
                                    <input type="radio" name="field_{{ $field->id }}" value="{{ $option }}"> {{ $option }}
                                </div>
                            @endforeach
                        @endif
                        @break
                    @case('checkbox')
                        <input type="checkbox" name="field_{{ $field->id }}" value="1"> Cocher pour valider
                        @break
                    @case('time')
                        <input type="time" name="field_{{ $field->id }}" class="form-control">
                        @break
                    @case('file')
                        <input type="file" name="field_{{ $field->id }}" class="form-control">
                        @break
                    @case('number')
                        <input type="number" name="field_{{ $field->id }}" class="form-control">
                        @break
                    @case('range')
                        <input type="range" name="field_{{ $field->id }}" class="form-control">
                        @break
                    <!-- Ajoutez d'autres cas au besoin -->
                
                @endswitch
            </div>
            
        @endforeach
     
        <button type="submit" class="btn btn-primary">Soumettre</button>
    </form>
</div>
@endsection

