{{-- resources/views/fields/create.blade.php --}}
@extends('layouts.backend')




@section('content')
<div class="container mt-4">
    <h1>Ajouter un Champ à "{{ $procedure->name }}"</h1>
    <form action="{{ route('procedures.fields.store', $procedure->id) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="label" class="form-label">Label</label>
            <input type="text" class="form-control" id="label" name="label" required>
        </div>
        <div class="mb-3">
            <label for="type" class="form-label">Type</label>
            <select class="form-control" id="type" name="type">
                <option value="text">Texte</option>
                <option value="textarea">Zone de texte</option>
                <option value="date">Date</option>
                <option value="number">Numéro</option>
                <option value="file">Fichier</option>
                <option value="email">Email</option>
                <option value="select">Menu déroulant</option>
                <option value="radio">Bouton radio</option>
                <option value="checkbox">Case à cocher</option>
                <option value="password">Mot de passe</option>
                <option value="tel">Téléphone</option>
                <option value="url">URL</option>
                <option value="time">Heure</option>
                <option value="range">Intervalle</option>
                <option value="color">Couleur</option>
                <!-- Ajoutez d'autres types selon les besoins -->
            </select>
            
        </div>
        <button type="submit" class="btn btn-primary">Ajouter</button>
    </form>
</div>
@endsection
