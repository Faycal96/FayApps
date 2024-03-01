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
    <div class="form-group">
        <label for="is_paid">Statut:</label>
        <select class="form-control" id="is_paid" name="is_paid">
            <option value="0" {{ $procedure->is_paid ? 'selected' : '' }}>Gratuit</option>
            <option value="1" {{ !$procedure->is_paid ? 'selected' : '' }}>Payant</option>
        </select>
    </div>
    <div class="form-group">
        <label for="description">Description:</label>
        <textarea class="form-control" id="description" name="description" required>{{ $procedure->description }}</textarea>
    </div>
    <div class="form-group">
        <label for="user_ids">Assigner à:</label>
        <select multiple class="form-control" id="user_ids" name="user_ids[]">
            @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Mettre à jour</button>
</form>
@endsection
