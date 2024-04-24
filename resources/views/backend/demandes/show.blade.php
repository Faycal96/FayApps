@extends('layouts.backend')

@section('content')
    
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
                                            <td>{{ $offre->PrixTotal }} FCFA</td>
                                           
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
                                                                            @if($offre->escale)
                                                                            <div class="col-12 mb-3">
                                                                                <table class="table datatable table-bordered table-striped datatable-table">
                                                                                    <thead class="dst-form-thead">
                                                                                        <tr>
                                                                                            <th colspan="3" style="text-align: center">Escale(s)</th>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <th><i
                                                                                                class="bi bi-geo-alt me-2"></i>Lieu escale <span style="color:red">*</span></th>
                                                                                            <th><i
                                                                                                class="bi bi-hourglass-split me-2"></i>Durée <span style="color:red">*</span></th>
                                                                                           
                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                        @foreach ($offre->itineraires as $key => $itineraire)
                                                                                        <tr class="escale-field" id="escaleField{{ $key + 1 }}">
                                                                                            <td>
                                                                                                <input type="text" value="{{ $itineraire->lieuEscale }}" class="form-control" readonly>
                                                                                            </td>
                                                                                            <td>
                                                                                                <input type="text" value="{{ $itineraire->dureeEscale }}" class="form-control" readonly>
                                                                                            </td>
                                                                                            
                                                                                        </tr>
                                                                                        @endforeach
                                                                                    </tbody>
                                                                                 
                                                                                </table>
                                                                            </div>
                                                                            @endif
                                                                           
                                                                            <!-- Validité de l'Offre -->
                                                                            <div class="col-md-6 mb-3">
                                                                                <label class="form-label"> <strong>Validité de l'Offre :</strong></label>
                                                                                <div class="input-group">
                                                                                    <span class="input-group-text"><i class="fas fa-hourglass-half"></i></span>
                                                                                    <input type="text" value="{{ \Carbon\Carbon::parse($offre->dateFinValidite)->format('d/m/Y H:i') }}" class="form-control" readonly>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6 mb-3">
                                                                                <label class="form-label"> <strong>Compagnie :</strong></label>
                                                                                <text class="form-control" readonly>{{ $offre->compagnie }}</text>
                                                                            </div>
                                                                            
                                                                            @if($offre->document)
                                                                            <div class="col-12 mb-3">
                                                                                <table class="table datatable table-bordered table-striped datatable-table">
                                                                                    <thead class="dst-form-thead">
                                                                                        <tr>
                                                                                            <th colspan="3" style="text-align: center">Document(s)</th>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <th><i
                                                                                                class="bi bi-file-earmark-text me-2"></i>Libelle <span style="color:red">*</span></th>
                                                                                            <th><i
                                                                                                class="bi bi-file-earmark-arrow-down me-2"></i>Fichier <span style="color:red">*</span></th>
                                                                                           
                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                        @foreach ($offre->documents as $key => $document)
                                                                                        <tr class="document-field" id="documentField{{ $key + 1 }}">
                                                                                            <td>
                                                                                                <input type="text" value="{{ $document->libelle}}" class="form-control" readonly>
                                                                                            </td>
                                                                                            <td>
                                                                                                
                                                                                                <a href="{{ asset('storage/' . str_replace('public/', '', $document->fichier)) }}"
                                                                                                    class="btn btn-info btn-sm" target="_blank">
                                                                                                    <i class="bi bi-download"></i> Télécharger le document
                                                                                                </a>
                                                                                                
                                                                                            </td>
                                                                                           
                                                                                        </tr>
                                                                                        @endforeach
                                                                                    </tbody>
                                                                                 
                                                                                </table>
                                                                            </div>
                                                                            @endif
                                                                            @if($offre->PrixAssurance)
                                                                            <div class="col-md-6 mb-3">
                                                                                <label class="form-label"> <strong>Prix de l'assurance :</strong></label>
                                                                                <text class="form-control" readonly>{{ $offre->PrixAssurance.' FCFA' }}</text>
                                                                            </div>
                                                                            <div class="col-md-6 mb-3">
                                                                                <label class="form-label"> <strong>Prix du billet sans Assurance :</strong></label>
                                                                                <text class="form-control" readonly>{{ $offre->prixBillet.' FCFA' }}</text>
                                                                            </div>
                                                                            @endif                                                                            
                                                                            <!-- Observation Fait sur l'offre -->
                                                                            <div class="col-md-6 mb-3">
                                                                                <label class="form-label"> <strong>Observation Faite sur l'offre :</strong></label>
                                                                                <textarea class="form-control" readonly>{{ $offre->description }}</textarea>
                                                                            </div>
                                                                            
                                                                            <!-- Prix du Billet -->
                                                                            <div class="col-md-3 offset-1 col-sm-6 col-12">
                                                                                <label class="form-label"><strong>Prix du Billet :</strong></label>
                                                                                <div class="info-box">
                                                                                    <span class="info-box-icon bg-warning"><i class="far fa-money-bill-alt"></i></span>
                                                                                    <div class="info-box-content">
                                                                                        <span class="info-box-text">Prix</span>
                                                                                        <span class="info-box-number" >{{ $offre->PrixTotal.' FCFA' }}</span>
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
                                                @canany(['create-demande-billet'])
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
                                                                        <textarea class="form-control" id="motif" name="motif" required></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="submit" class="btn btn-success"><i class="fas fa-check-circle"></i> Valider</button>
                                                                    <!-- Icône pour annuler avec un bouton de fermeture du modal -->
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times-circle"></i> Annuler</button>
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
                                                                <div class="modal-body">
                                                                    <div class="mb-3">
                                                                        <label for="motifRejet" class="form-label">Motif du rejet</label>
                                                                        <textarea class="form-control" id="motifRejet" name="motifRejet" required></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="submit" class="btn btn-danger"><i class="fas fa-times-circle"></i> Confirmer le rejet</button>
                                                                    <!-- Icône pour annuler avec un bouton de fermeture du modal -->
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-check-circle"></i> Annuler</button>
                                                                </div>
                                                            </form>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
                                                @endcanany
                                                @if ($offre->etats == "validée" && $offre->PrixTotal == $offreMinPrix->PrixTotal)
                                                <!-- Bouton de validation déclenche le modal -->
                                                <button title="Quittance" type="button" target="blank" class="btn btn-success " data-bs-toggle="modal"><a href="{{ route('quittance', ['uuid' => $offre->id]) }}"> <i class="bi bi-receipt-cutoff"></i></a></button>
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
   
@endsection
