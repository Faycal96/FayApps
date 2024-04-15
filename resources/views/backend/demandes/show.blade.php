@extends('layouts.backend')

@section('content')
    @canany(['create-demande-billet'])
        <div class="container-fluid">
            @if($offres->isEmpty())
                <div class="alert alert-warning" role="alert">
                    Il n'y a pas eu d'offres satisfaisantes pour cette demande, veuillez faire une autre demande.
                </div>
            @else
                <div class="card">
                    <div class="card-header bg-gray-dark text-white">
                        <h3 class="card-title">Toutes les offres pour cette demande</h3>
                    </div>
                    <div class="card-body bg-light">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Code Offre</th>
                                        <th>Agence</th>
                                        <th>Prix</th>
                                        <th>Statut</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($offres as $offre)
                                        <tr>
                                            <td>{{ $offre->code_offre }}</td>
                                            <td>{{ $offre->agence->nomAgence }}</td>
                                            <td>{{ $offre->prixBillet }} FCFA</td>
                                           
                                                @if ($offre->etats == "validée")
                                        <td> <span class="badge bg-success">Retenue</span></td>
                                    @elseif ($offre->etats == "rejetée")
                                        <td><span class="badge bg-danger">Non retenue</span></td>
                                        @else
                                        <td><span class="badge bg-warning">En attente</span></td>
                                    @endif
                                            
                                            <td>
                                            <button title="Voir Détails" type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                               data-bs-target="#detailDemandeModal{{ $offre->id }}">
                                                 <i class="bi bi-eye"></i>
                                            </button>
                                            <!-- Modal de détails de la demande -->
                                                <div class="modal fade" id="detailDemandeModal{{ $offre->id }}" tabindex="-1"
                                                    aria-labelledby="detailDemandeModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-gray-dark text-white">
                                                                <h5 class="modal-title" id="detailDemandeModalLabel{{ $offre->id }}">Détails de la Demande</h5>
                                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                                                    aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body bg-light">
                                                                <div class="card">
                                                                    
                                                                    <div class="card-body bg-light">
                                                                        <div class="row">
                                                                            <!-- Code de la demande -->
                                                                            <div class="col-md-6 mb-3">
                                                                                <label class="form-label"> <strong>Code de la demande :</strong></label>
                                                                                <div class="input-group">
                                                                                    <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
                                                                                    <input type="text" value="{{ $demande->code_demande }}" class="form-control" readonly>
                                                                                </div>
                                                                            </div>
                                                                            <!-- Code de l'offre -->
                                                                            <div class="col-md-6 mb-3">
                                                                                <label class="form-label"> <strong>Code de l'offre :</strong></label>
                                                                                <div class="input-group">
                                                                                    <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
                                                                                    <input type="text" value="{{ $offre->code_offre }}" class="form-control" readonly>
                                                                                </div>
                                                                            </div>
                                                                            <!-- Ville de Départ -->
                                                                            <div class="col-md-6 mb-3">
                                                                                <label class="form-label"> <strong>Ville de Départ :</strong></label>
                                                                                <div class="input-group">
                                                                                    <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                                                                    <input type="text" value="{{ $demande->lieuDepart }}" class="form-control" readonly>
                                                                                </div>
                                                                            </div>
                                                                            <!-- Ville d'arrivée -->
                                                                            <div class="col-md-6 mb-3">
                                                                                <label class="form-label"> <strong>Ville d'arrivée :</strong></label>
                                                                                <div class="input-group">
                                                                                    <span class="input-group-text"><i class="fas fa-map-marker"></i></span>
                                                                                    <input type="text" value="{{ $demande->lieuArrivee }}" class="form-control" readonly>
                                                                                </div>
                                                                            </div>
                                                                            <!-- Date de départ -->
                                                                            <div class="col-md-6 mb-3">
                                                                                <label class="form-label"> <strong>Date de départ :</strong></label>
                                                                                <div class="input-group">
                                                                                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                                                                    <input type="text" value="{{ \Carbon\Carbon::parse($demande->dateDepart)->format('d/m/Y') }}" class="form-control" readonly>
                                                                                </div>
                                                                            </div>
                                                                            <!-- Date de retour -->
                                                                            <div class="col-md-6 mb-3">
                                                                                <label class="form-label"> <strong>Date de retour :</strong></label>
                                                                                <div class="input-group">
                                                                                    <span class="input-group-text"><i class="fas fa-calendar-check"></i></span>
                                                                                    <input type="text" value="{{ \Carbon\Carbon::parse($demande->dateArrivee)->format('d/m/Y') }}" class="form-control" readonly>
                                                                                </div>
                                                                            </div>
                                                                            <!-- Agence Accréditée -->
                                                                            <div class="col-md-6 mb-3">
                                                                                <label class="form-label"> <strong>Agence Accréditée :</strong></label>
                                                                                <div class="input-group">
                                                                                    <span class="input-group-text"><i class="fas fa-building"></i></span>
                                                                                    <input type="text" value="{{ $offre->agence->nomAgence }}" class="form-control" readonly>
                                                                                </div>
                                                                            </div>
                                                                            <!-- Adresse de l'agence -->
                                                                            <div class="col-md-6 mb-3">
                                                                                <label class="form-label"> <strong>Adresse de l'Agence :</strong></label>
                                                                                <div class="input-group">
                                                                                    <span class="input-group-text"><i class="fas fa-address-card"></i></span>
                                                                                    <input type="text" value="{{ $offre->agence->user->email }}" class="form-control" readonly>
                                                                                </div>
                                                                            </div>
                                                                            <!-- Validité de l'Offre -->
                                                                            <div class="col-md-6 mb-3">
                                                                                <label class="form-label"> <strong>Validité de l'Offre :</strong></label>
                                                                                <div class="input-group">
                                                                                    <span class="input-group-text"><i class="fas fa-hourglass-half"></i></span>
                                                                                    <input type="text" value="{{ \Carbon\Carbon::parse($offre->dateFinValidite)->format('d/m/Y H:i') }}" class="form-control" readonly>
                                                                                </div>
                                                                            </div>
                                                                            <!-- Observation Fait sur l'offre -->
                                                                            <div class="col-md-6 mb-3">
                                                                                <label class="form-label"> <strong>Observation Fait sur l'offre :</strong></label>
                                                                                <textarea class="form-control" readonly>{{ $offre->description }}</textarea>
                                                                            </div>
                                                                            <!-- Description du besoin -->
                                                                            <div class="col-md-5 mb-3">
                                                                                <label class="form-label"> <strong>Description du besoin :</strong></label>
                                                                                <textarea class="form-control" readonly>{{ $demande->description }}</textarea>
                                                                            </div>
                                                                            <!-- Prix du Billet -->
                                                                            <div class="col-md-3 offset-1 col-sm-6 col-12">
                                                                                <label class="form-label"><strong>Prix du Billet :</strong></label>
                                                                                <div class="info-box">
                                                                                    <span class="info-box-icon bg-warning"><i class="far fa-money-bill-alt"></i></span>
                                                                                    <div class="info-box-content">
                                                                                        <span class="info-box-text">Prix</span>
                                                                                        <span class="info-box-number" >{{ $offre->prixBillet.' FCFA' }}</span>
                                                                                    </div>
                                                                                    <!-- /.info-box-content -->
                                                                                </div>
                                                                                <!-- /.info-box -->
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer bg-dark-primary">
                                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fermer</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @if ($offre->etats == "En attente" && $offre->prixBillet ==$offreMinPrix->prixBillet)
                                                <!-- Bouton de validation déclenche le modal -->
                                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#validateModal">
                                                    <i class="bi bi-check-lg"></i> Valider
                                                </button>
                                    
                                    
                                                <!-- Modal de validation -->
                                                <div class="modal fade" id="validateModal" tabindex="-1" aria-labelledby="validateModalLabel"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="validateModalLabel">Validation de l'offre</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <form action="{{ route('offres.valider', ['offre' => $offre->id]) }}" method="POST">
                                                                @csrf
                                                                <div class="modal-body">
                                                                    <div class="mb-3">
                                                                        <label for="motif" class="form-label">Motif de validation</label>
                                                                        {{-- <textarea class="form-control" id="motif" name="motif" required></textarea> --}}
                                                                        <select name="motif" id="" class="form-control custom-select">
                                                                            <option value="">Veuillez choisir le motif</option>
                                                                            <option value="">Bon prix</option>
                                                                            <option value="">Offre acceptable</option>
                                                                        </select>
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
                                                <div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="rejectModalLabel">Rejet de l'offre</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <form action="{{ route('offres.rejeter', ['offre' => $offre->id]) }}" method="POST">
                                                                @csrf
                                                                <!-- Si vous souhaitez changer la méthode HTTP utilisée par le formulaire (par ex., pour PATCH, PUT, DELETE), ajoutez @method('VOTRE_METHODE') -->
                                                                <div class="modal-body">
                                                                    <div class="mb-3">
                                                                        <label for="motifRejet" class="form-label">Motif du rejet</label>
                                                                        {{-- <textarea class="form-control" id="motifRejet" name="motifRejet"
                                                                            required></textarea> --}}
                                                                            <select name="motifRejet" id="" class="form-control custom-select">
                                                                                <option value="">Veuillez choisir le motif</option>
                                                                                <option value="">Offre trop chers</option>
                                                                                <option value="">Voyage non Conforme</option>
                                                                                <option value="">Trop d'escale</option>
                                                                            </select>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="submit" class="btn btn-danger">Confirmer le rejet</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
                                    
                                               
                                            </div>
                                               
                                                       
                                                
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    @endcanany
@endsection
