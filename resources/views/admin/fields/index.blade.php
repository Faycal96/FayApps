{{-- resources/views/fields/index.blade.php --}}
@extends('layouts.backend')



@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center">
        <h1>Liste des Champs pour "{{ $procedure->name }}"</h1>
        <a href="{{ route('procedures.fields.create', $procedure->id) }}" class="btn btn-primary">Ajouter un Champ</a>
    </div>
    <table class="table mt-2">
        <thead>
            <tr>
                <th>Label</th>
                <th>Type</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($fields as $field)
            <tr>
                <td>{{ $field->label }}</td>
                <td>{{ $field->type }}</td>
                <td>
                    <a href="{{ route('procedures.fields.edit', [$procedure->id, $field->id]) }}" class="btn btn-sm btn-warning">Éditer</a>
                    <form action="{{ route('procedures.fields.destroy', [$procedure->id, $field->id]) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
