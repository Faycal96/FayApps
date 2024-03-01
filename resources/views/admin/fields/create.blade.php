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
            <select class="form-control" id="type" name="type" onchange="toggleOptions(this.value)">
                <option value="text">Texte</option>
                <option value="textarea">Zone de texte</option>
                <option value="date">Date</option>
                <option value="email">Email</option>
                <option value="select">Sélection</option>
                <option value="radio">Bouton Radio</option>
                <option value="checkbox">Case à cocher</option>
                <option value="time">Heure</option>
                <option value="file">Fichier</option>
               
                <option value="number">Nombre</option>
                <option value="range">Plage</option>
       
            </select>
              <!-- Champ pour saisir les options, caché par défaut -->
        <div class="mb-3" style="display: none;" id="optionsField">
            <label for="options" class="form-label">Options (séparées par une virgule)</label>
            <input type="text" class="form-control" id="options" name="options">
        </div>
            
        </div>
        <button type="submit" class="btn btn-primary">Ajouter</button>
    </form>
</div>
<script>
    function toggleOptions(type) {
        const optionsField = document.getElementById('optionsField');
        if (type === 'select' || type === 'radio') {
            optionsField.style.display = 'block';
        } else {
            optionsField.style.display = 'none';
        }
    }
</script>
@endsection
