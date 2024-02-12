@extends('layouts.backend')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header bg-gray-dark text-white">
            <h3 class="card-title">Détail de l'offre</h3>
        </div>

        <div class="card-body bg-light">
            <div class="row">
                <!-- Code de la demande -->
                <div class="col-md-6 mb-3">
                    <label class="form-label"><i class="bi bi-file-earmark-text me-2"></i><strong>Code de la demande :</strong></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
                        <input type="text" value="{{ $demande->code_demande }}" class="form-control" readonly>
                    </div>
                </div>
                <!-- Code de l'offre -->
                <div class="col-md-6 mb-3">
                    <label class="form-label"><i class="bi bi-geo-alt me-2"></i><strong>Code de l'offre :</strong></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
                        <input type="text" value="{{ $offreMinPrix->code_offre }}" class="form-control" readonly>
                    </div>
                </div>

                <!-- Ville de Départ -->
                <div class="col-md-6 mb-3">
                    <label class="form-label"><i class="bi bi-geo-alt me-2"></i><strong>Ville de Départ :</strong></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                        <input type="text" value="{{ $demande->lieuDepart }}" class="form-control" readonly>
                    </div>
                </div>
                <!-- Ville d'arrivée -->
                <div class="col-md-6 mb-3">
                    <label class="form-label"><i class="bi bi-geo me-2"></i><strong>Ville d'arrivée :</strong></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-map-marker"></i></span>
                        <input type="text" value="{{ $demande->lieuArrivee }}" class="form-control" readonly>
                    </div>
                </div>

                <!-- Date de départ -->
                <div class="col-md-6 mb-3">
                    <label class="form-label"><i class="bi bi-calendar-event me-2"></i><strong>Date de départ :</strong></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                        <input type="text" value="{{ \Carbon\Carbon::parse($demande->dateDepart)->format('d/m/Y') }}" class="form-control" readonly>
                    </div>
                </div>
                <!-- Date de retour -->
                <div class="col-md-6 mb-3">
                    <label class="form-label"><i class="bi bi-calendar-check me-2"></i><strong>Date de retour :</strong></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-calendar-check"></i></span>
                        <input type="text" value="{{ \Carbon\Carbon::parse($demande->dateArrivee)->format('d/m/Y') }}" class="form-control" readonly>
                    </div>
                </div>

                <!-- Agence Accréditée -->
                <div class="col-md-6 mb-3">
                    <label class="form-label"><i class="bi bi-building me-2"></i><strong>Agence Accréditée :</strong></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-building"></i></span>
                        <input type="text" value="{{ $offreMinPrix->agence->nomAgence }}" class="form-control" readonly>
                    </div>
                </div>
                <!-- Adresse de l'agence -->
                <div class="col-md-6 mb-3">
                    <label class="form-label"><i class="bi bi-building me-2"></i><strong>Adresse de l'agence :</strong></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-address-card"></i></span>
                        <input type="text" value="{{ $offreMinPrix->agence->user->email }}" class="form-control" readonly> <!-- Assurez-vous que 'adresse' est le bon champ dans votre table agences -->
                    </div>
                </div>
                <!-- Valable jusqu'au -->
                <div class="col-md-6 mb-3">
                    <label class="form-label"><i class="bi bi-hourglass-split me-2"></i><strong>Valable jusqu'au :</strong></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-hourglass-half"></i></span>
                        <input type="text" value="{{ \Carbon\Carbon::parse($offreMinPrix->dateFinValidite)->format('d/m/Y H:i') }}" class="form-control" readonly>
                    </div>
                </div>

                <!-- Observation de l'offre -->
                <div class="col-12 mb-3">
                    <label class="form-label"><i class="bi bi-textarea-t me-2"></i><strong>Observation de l'offre :</strong></label>
                    <textarea class="form-control" readonly>{{ $offreMinPrix->description }}</textarea>
                </div>
                  <!-- Observation de l'offre -->
                <div class="col-12 mb-3">
                    <label class="form-label"><i class="bi bi-textarea-t me-2"></i><strong>Description du besoin:</strong></label>
                    <textarea class="form-control" readonly>{{ $demande->description }}</textarea>
                </div>

                

                <!-- Prix -->
                <div class="col-12 mb-3 text-center">
                    <label class="form-label"><i class="bi bi-currency-euro me-2"></i><strong>Prix :</strong></label>
                    <h4 class="text-info">{{ $offreMinPrix->prixBillet }} €</h4>
                </div>
                <div class="card-footer bg-dark-primary">
                    <!-- Bouton de validation déclenche le modal -->
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#validateModal">
            <i class="bi bi-check-lg"></i> Valider
        </button>
        
        <!-- Modal de validation -->
        <div class="modal fade" id="validateModal" tabindex="-1" aria-labelledby="validateModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="validateModalLabel">Validation de l'offre</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('offres.valider', ['offre' => $offreMinPrix->id]) }}" method="POST">
            @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="motif" class="form-label">Motif de validation</label>
                                <textarea class="form-control" id="motif" name="motif" required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Valider</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
                  <!-- Bouton de rejet déclenche le modal -->
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
            <i class="bi bi-x-lg"></i> Rejeter
        </button>
        
        <!-- Modal de rejet -->
        <div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="rejectModalLabel">Rejet de l'offre</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('offres.rejeter', ['offre' => $offreMinPrix->id]) }}" method="POST">
                        @csrf
                        <!-- Si vous souhaitez changer la méthode HTTP utilisée par le formulaire (par ex., pour PATCH, PUT, DELETE), ajoutez @method('VOTRE_METHODE') -->
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="motifRejet" class="form-label">Motif du rejet</label>
                                <textarea class="form-control" id="motifRejet" name="motifRejet" required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger">Confirmer le rejet</button>
                        </div>
                    </form>
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