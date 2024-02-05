@extends('layouts.backend')

@section('content')
<div class="container">

    </div>
    <div class="card">
        <div class="card-header bg-gray-dark text-white">
            <h3 class="card-title">Détail de l'offre</h3> {{-- Header personnalisé avec une plus grande police --}}
        </div>

        <div class="card-body bg-light">
            <div class="row">
                 <!-- Numéro Ordre de Mission et Lieu Départ -->
                 <div class="col-md-6 mb-3">
                    <i class="bi bi-file-earmark-text me-2"></i><strong>Code de la demande :</strong> {{ $demande->code_demande }}
                </div>
                <div class="col-md-6 mb-3">
                    <i class="bi bi-geo-alt me-2"></i><strong>Code de l'offre :</strong> ww
                </div>



                <!-- Lieu Arrivée et Date Départ -->


                <div class="col-md-6 mb-3">
                    <i class="bi bi-geo-alt me-2"></i><strong>Ville de Départ :</strong> {{ $demande->lieuDepart }}
                </div>
                <div class="col-md-6 mb-3">
                    <i class="bi bi-geo me-2"></i><strong>Ville d'arrivée :</strong> {{ $demande->lieuArrivee }}
                </div>

                <div class="col-md-6 mb-3">
                    <i class="bi bi-calendar-event me-2"></i><strong>Date de depart :</strong> {{ \Carbon\Carbon::parse($demande->dateDepart)->format('d/m/Y') }}
                </div>

                <!-- Date Arrivée et Durée -->
                <div class="col-md-6 mb-3">
                    <i class="bi bi-calendar-check me-2"></i><strong>Date de retour :</strong> {{ \Carbon\Carbon::parse($demande->dateArrivee)->format('d/m/Y') }}
                </div>


                <div class="col-md-6 mb-3">
                    <i class="bi bi-building me-2"></i><strong>Agence Accreditée :</strong> {{ $offreMinPrix->agence->nomAgence }} <!-- Assurez-vous que 'nom' est le bon champ dans votre table agences -->
                </div>

                <div class="col-md-6 mb-3">
                    <i class="bi bi-building me-2"></i><strong>Adresse de l'agence :</strong> {{ $offreMinPrix->agence->user->telephone }} <!-- Assurez-vous que 'nom' est le bon champ dans votre table agences -->
                </div>

                <div class="col-6 mb-3">
                    <i class="bi bi-textarea-t me-2"></i><strong>Observation de l'offre :</strong> {{ $offreMinPrix->description }}
                </div>

                <div class="col-md-6 mb-3">
                    <i class="bi bi-hourglass-split me-2"></i><strong>Valable jusqu'au:</strong> {{ \Carbon\Carbon::parse($offreMinPrix->dateFinValidite)->format('d M Y à H:i:s') }}
                </div>




                <!-- Prix affiché avec style personnalisé -->
                <p></p>
                <div class="col-8 mb-2 text-center">
                    <h3><i class="bi bi-currency-euro me-3"></i><strong>Prix :</strong> <span class="btn-info btn-sm">{{ $offreMinPrix->prixBillet ?? 'Non disponible' }}</span></h3>
                </div>
            </div>
        </div>


        <div class="card-footer bg-dark-primary">
            <!-- Bouton de validation -->
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#validateModal{{ $demande->id }}">
                <i class="bi bi-check-lg"></i> Valider
            </button>

            <!-- Modèle de validation -->
            <div class="modal fade" id="validateModal{{ $demande->id }}" tabindex="-1" aria-labelledby="validateModalLabel{{ $demande->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="validateModalLabel{{ $demande->id }}">Validation de la Demande</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('demandes.edit', $demande->id) }}" method="post">
                                @csrf
                                <div class="mb-3">
                                    <label for="motifValidation" class="form-label">Motif de validation</label>
                                    <textarea class="form-control" id="motifValidation" name="motifValidation" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-success">Confirmer la validation</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bouton de rejet -->
            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $demande->id }}">
                <i class="bi bi-x-lg"></i> Rejeter
            </button>

            <!-- Modèle de rejet -->
            <div class="modal fade" id="rejectModal{{ $demande->id }}" tabindex="-1" aria-labelledby="rejectModalLabel{{ $demande->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="rejectModalLabel{{ $demande->id }}">Rejet de la Demande</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('demandes.edit', $demande->id) }}" method="post">
                                @csrf
                                <div class="mb-3">
                                    <label for="motifRejet" class="form-label">Motif du rejet</label>
                                    <textarea class="form-control" id="motifRejet" name="motifRejet" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-danger">Confirmer le rejet</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bouton de retour -->
            <a href="{{ route('demandes.index') }}" class="btn btn-secondary"><i class="bi bi-box-arrow-in-left"></i> Retour</a>
        </div>
    </div>
</div>
@endsection

@section('css')
<style>
    .prix-style {
        font-size: 1.5em; /* Augmente la taille de la police */
        color: #007bff; /* Couleur bleue pour se démarquer */
    }
    .card-header h3.card-title {
        font-size: 1.75em; /* Augmente la taille de la police du titre */
    }
</style>
@endsection
