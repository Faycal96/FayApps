@extends('layouts.backend')

@section('content')
<div class="container">
    <h2>Faire un Paiement</h2>
    {{-- Formulaire pour créer un paiement --}}
    <form action="{{ route('applications.payments.create', ['procedure' => $procedureInstance->id, 'application' => $applicationInstance->id]) }}" method="POST">
        @csrf
        {{-- Champ pour le numéro de téléphone --}}
        <div class="mb-3">
            <label for="phone" class="form-label">Numéro de téléphone</label>
            <input type="text" class="form-control" id="phone" name="phone" required>
        </div>

        {{-- Champ pour le montant --}}
        <div class="mb-3">
            <label for="amount" class="form-label">Montant</label>
            <input type="number" class="form-control" id="amount" name="amount" required>
        </div>

        {{-- Bouton soumettre --}}
        <button type="submit" class="btn btn-success">Initier le Paiement</button>
    </form>
</div>
@endsection
