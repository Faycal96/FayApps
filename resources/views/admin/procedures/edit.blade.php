{{-- resources/views/admin/procedures/edit.blade.php --}}
@extends('layouts.backend')

@section('content')
<h1>Éditer la procédure : {{ $procedure->name }}</h1>
<form action="{{ route('procedures.update', $procedure->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="name">Nom:</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ $procedure->name }}" required>
    </div>
    <div class="form-group">
        <label for="status">Statut:</label>
        <select class="form-control" id="status" name="status">
            <option value="1" {{ $procedure->status ? 'selected' : '' }}>Actif</option>
            <option value="0" {{ !$procedure->status ? 'selected' : '' }}>Inactif</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Mettre à jour</button>
</form>
@endsection
