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
        <label for="is_paid">Paiement</label>
        <select class="form-control" id="is_paid" name="is_paid">
            <option value="0">Gratuit</option>
            <option value="1">Payant</option>
        </select>
    </div>
    <div class="form-group" id="amountField" style="display: none;">
        <label for="amount">Montant:</label>
        <input type="number" class="form-control" id="amount" name="amount" step="0.01">
    </div>
    <div class="form-group">
        <label for="description">Description:</label>
        <textarea class="form-control" id="description" name="description" required></textarea>
    </div>
    <div class="form-group">
        <label for="user_ids">Assigner à:</label>
        <select multiple class="form-control" id="user_ids" name="user_ids[]">
            @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }} - {{ $user->roles->first()->name ?? 'Aucun rôle' }}</option>
            @endforeach
        </select>
    </div>
    
    
    <div class="form-group">
        <label for="ministry_id">Ministère</label>
        <select class="form-control" id="ministry_id" name="ministry_id_disabled" disabled>
            @foreach($ministeres as $ministere)
                <option value="{{ $ministere->id }}" {{ $ministere->id == $userMinistryId ? 'selected' : '' }}>{{ $ministere->libelleLong }}</option>
            @endforeach
        </select>
        <!-- Champ caché pour soumettre la valeur -->
        <input type="hidden" name="ministry_id" value="{{ $userMinistryId }}">
    </div>
    
    

    <button type="submit" class="btn btn-primary">Créer</button>
</form>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const isPaidSelect = document.getElementById('is_paid');
        const amountField = document.getElementById('amountField');
    
        // Fonction pour afficher/masquer le champ montant
        function toggleAmountField() {
            if (isPaidSelect.value == "1") {
                amountField.style.display = '';
            } else {
                amountField.style.display = 'none';
            }
        }
    
        // Événement change sur le select is_paid
        isPaidSelect.addEventListener('change', toggleAmountField);
    
        // Appel initial pour définir l'état correct au chargement de la page
        toggleAmountField();
    });
    </script>
@endsection
