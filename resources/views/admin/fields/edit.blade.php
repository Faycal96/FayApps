{{-- resources/views/fields/edit.blade.php --}}
@extends('layouts.backend')



@section('content')
<div class="container mt-4">
    <h1>Éditer "{{ $field->label }}"</h1>
    <form action="{{ route('procedures.fields.update', [$procedure->id, $field->id]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="label" class="form-label">Label</label>
            <input type="text" class="form-control" id="label" name="label" value="{{ $field->label }}" required>
        </div>
        <div class="mb-3">
            <label for="type" class="form-label">Type</label>
            <select class="form-control" id="type" name="type">
                <option value="text" {{ $field->type == 'text' ? 'selected' : '' }}>Texte</option>
                <option value="textarea" {{ $field->type == 'textarea' ? 'selected' : '' }}>Zone de texte</option>
                <option value="date" {{ $field->type == 'date' ? 'selected' : '' }}>Date</option>
                <!-- Ajoutez ou modifiez des options ici -->
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>
</div>
@endsection
