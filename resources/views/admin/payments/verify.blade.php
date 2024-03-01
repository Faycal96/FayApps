@extends('layouts.backend')

@section('content')
<div class="container">
    <h2>Vérifier le Paiement</h2>
    {{-- Formulaire pour vérifier un paiement --}}
    <form action="{{ route('applications.payments.verify', ['procedure' => $procedureInstance->id, 'application' => $applicationInstance->id, 'payment' => $paymentInstance->id]) }}" method="POST">
        @csrf
        {{-- Champ pour l'OTP --}}
        <div class="mb-3">
            <label for="otp" class="form-label">Code OTP</label>
            <input type="text" class="form-control" id="otp" name="otp" required>
        </div>

        {{-- Bouton pour soumettre le formulaire --}}
        <button type="submit" class="btn btn-primary">Vérifier le Paiement</button>
    </form>
</div>
@endsection
