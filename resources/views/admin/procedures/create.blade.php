{{-- resources/views/admin/procedures/create.blade.php --}}
@extends('layouts.backend')

@section('content')
<h1>Ajouter une procédure</h1>
<form action="{{ route('procedures.store') }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="name">Nom:</label>
        <input type="text" class="form-control" id="name" name="name" required>
    </div>
    <div class="form-group">
        <label for="status">Statut:</label>
        <select class="form-control" id="status" name="status">
            <option value="1">Actif</option>
            <option value="0">Inactif</option>
        </select>
    </div>
    <div class="form-group">
        <label for="ministry_id">Ministère</label>
        <select class="form-control" id="ministry_id" name="ministry_id">
            @foreach($ministeres as $ministere)
                <option value="{{ $ministere->id }}">{{ $ministere->libelleLong }}</option>
            @endforeach
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Créer</button>
</form>
@endsection
