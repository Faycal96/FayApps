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
                        @case('number')
                        <input type="number" name="field_{{ $field->id }}" class="form-control">
                        @break
                    @case('file')
                        <input type="file" name="field_{{ $field->id }}" class="form-control">
                        @break
                @endswitch
            </div>
        @endforeach
        <button type="submit" class="btn btn-primary">Soumettre</button>
    </form>
</div>
@endsection

