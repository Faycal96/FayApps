@extends('layouts.backend')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $totalPelerins }}</h3>

                    <p>Total des pèlerins</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="#" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>9</h3>

                    <p>Pèlerins avec paiements en attente</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="#" class="small-box-footer"> <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>2</h3>

                    <p>Pèlerins complétés</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="#" class="small-box-footer"> <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>65</h3>

                    <p>Pèlerins annulés</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
                <a href="#" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
    </div>

    <div class="row">
        <div class="col-12">
            <p>
                @if(session('success'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <span class="alert-heading">{{session('success')}}</span>

                </div>

                <script>
                    setTimeout(function() {
                            document.querySelector('.alert.alert-success').style.display = 'none';
                        }, 6000); // Le message flash disparaîtra après 6 secondes (6000 millisecondes)
                </script>
                @endif
            </p>
            <!-- Bouton pour ouvrir le modal d'ajout -->
                <div class="row mb-3">
                    <div class="col-12">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPelerinModal">
                            <i class="bi bi-plus-circle"></i> Ajouter un Pèlerin
                        </button>
                    </div>
                </div>

                    <!-- Modal d'ajout -->
                    <div class="modal fade" id="addPelerinModal" tabindex="-1" aria-labelledby="addPelerinModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <div class="modal-header bg-gray-dark text-white">
                                    <h5 class="modal-title" id="addPelerinModalLabel">Ajouter un Pèlerin</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body bg-light">
                                    <form action="{{ route('pelerins.store') }}" method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <i class="bi bi-person-fill me-2"></i>
                                                <label for="nom" class="form-label"><strong>Nom</strong></label>
                                                <input type="text" class="form-control @error('nom') is-invalid @enderror" id="nom" name="nom" value="{{ old('nom') }}" required>
                                                @error('nom')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <i class="bi bi-person-fill me-2"></i>
                                                <label for="prenom" class="form-label"><strong>Prenom</strong></label>
                                                <input type="text" class="form-control @error('prenom') is-invalid @enderror" id="prenom" name="prenom" value="{{ old('prenom') }}"required>
                                                @error('prenom')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <i class="bi bi-file-text-fill me-2"></i>
                                                <label for="passeport" class="form-label"><strong>Passport</strong></label>
                                                <input type="text" class="form-control @error('passeport') is-invalid @enderror" id="passeport" name="passeport" value="{{ old('passeport') }}"required>
                                                @error('passeport')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <i class="bi bi-calendar-event-fill me-2"></i>
                                                <label for="date_delivrance" class="form-label"><strong>Date de Délivrance</strong></label>
                                                <input type="date" class="form-control @error('date_delivrance') is-invalid @enderror" id="date_delivrance" name="date_delivrance" value="{{ old('date_delivrance') }}"required>
                                                @error('date_delivrance')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <i class="bi bi-calendar-fill me-2"></i>
                                                <label for="date_naissance" class="form-label"><strong>Date de Naissance</strong></label>
                                                <input type="date" class="form-control @error('date_naissance') is-invalid @enderror" id="date_naissance" name="date_naissance" value="{{ old('date_naissance') }}"required>
                                                @error('date_naissance')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <i class="bi bi-file-earmark-text-fill me-2"></i>
                                                <label for="date_expiration" class="form-label"><strong>Date d'Expiration</strong></label>
                                                <input type="date" class="form-control @error('date_expiration') is-invalid @enderror" id="date_expiration" name="date_expiration" value="{{ old('date_expiration') }}"required>
                                                @error('date_expiration')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <i class="bi bi-gender-ambiguous me-2"></i>
                                                <label for="sexe" class="form-label"><strong>Sexe</strong></label>
                                                <select class="form-control @error('sexe') is-invalid @enderror" id="sexe" name="sexe">
                                                    <option value="">Sélectionner</option>
                                                    <option value="M" {{ old('sexe') == 'M' ? 'selected' : '' }}>Masculin</option>
                                                    <option value="F" {{ old('sexe') == 'F' ? 'selected' : '' }}>Féminin</option>
                                                </select>
                                                @error('sexe')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <i class="bi bi-geo-alt me-2"></i>
                                                <label for="nationalite" class="form-label"><strong>Nationalité</strong></label>
                                                <input type="text" class="form-control @error('nationalite') is-invalid @enderror" id="nationalite" name="nationalite" value="{{ old('nationalite') }}"required>
                                                @error('nationalite')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <i class="bi bi-phone-fill me-2"></i>
                                                <label for="telephone" class="form-label"><strong>Téléphone</strong></label>
                                                <input type="number" class="form-control @error('telephone') is-invalid @enderror" id="telephone" name="telephone" value="{{ old('telephone') }}"required>
                                                @error('telephone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <i class="bi bi-clipboard me-2"></i>
                                                <label for="motif_candidat" class="form-label"><strong>Motif Candidat</strong></label>
                                                <input type="text" class="form-control @error('motif_candidat') is-invalid @enderror" id="motif_candidat" name="motif_candidat" value="{{ old('motif_candidat') }}"required>
                                                @error('motif_candidat')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <i class="bi bi-person-fill me-2"></i>
                                                <label for="facilitateur" class="form-label"><strong>Facilitateur</strong></label>
                                                <input type="text" class="form-control @error('facilitateur') is-invalid @enderror" id="facilitateur" name="facilitateur" value="{{ old('facilitateur') }}"required>
                                                @error('facilitateur')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <i class="bi bi-map-fill me-2"></i>
                                                <label for="ville_province" class="form-label"><strong>Ville ou Province</strong></label>
                                                <input type="text" class="form-control @error('ville_province') is-invalid @enderror" id="ville_province" name="ville_province" value="{{ old('ville_province') }}"required>
                                                @error('ville_province')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <i class="bi bi-pencil-square me-2"></i>
                                                <label for="note_observation" class="form-label"><strong>Note/Observation</strong></label>
                                                <textarea class="form-control @error('note_observation') is-invalid @enderror" id="note_observation" name="note_observation">{{ old('note_observation') }}</textarea>
                                                @error('note_observation')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="modal-footer bg-dark-primary">
                                            <button type="submit" class="btn btn-success">Enregistrer</button>
                                            <button type="button" class="btn btn-warning" data-bs-dismiss="modal">Fermer</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Gestion des Pèlerins</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Date Inscription</th>
                                <th>Passport</th>
                                <th>Nom</th>
                                <th>Prenom</th>
                                <th>Facilitateur</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pelerins as $pelerin)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $pelerin->created_at->translatedFormat('d M Y à H:i:s') }}</td>
                                <td>{{ $pelerin->passeport }}</td>
                                <td>{{ $pelerin->nom }}</td>
                                <td>{{ $pelerin->prenom }}</td>
                                <td>{{ $pelerin->facilitateur }}</td>
                                
                                <td>
                                    @if($pelerin->statut == 'completed')
                                    <span class="badge bg-success">Complété</span>
                                    @elseif($pelerin->statut == 'Non payé')
                                    <span class="badge bg-warning">En attente</span>
                                    @else
                                    <span class="badge bg-danger">Annulé</span>
                                    @endif
                                </td>

                                <td>
                                    <!-- Bouton de déclenchement pour le modal de détails -->
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#simpleDetailModal{{ $pelerin->id }}">
                                        <i class="bi bi-eye"></i> Détails
                                    </button>
                                 <!-- Modal de détails -->
<!-- Modal de détails du pèlerin -->
<div class="modal fade" id="simpleDetailModal{{ $pelerin->id }}" tabindex="-1" aria-labelledby="simpleDetailModalLabel{{ $pelerin->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-gray-dark text-white">
                <h5 class="modal-title" id="simpleDetailModalLabel{{ $pelerin->id }}">Détails du Pèlerin</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body bg-light">
                <div class="row">
                    <!-- Nom -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label"><i class="bi bi-person-fill me-2"></i><strong>Nom :</strong></label>
                        <div class="input-group">
                            <input type="text" value="{{ $pelerin->nom }}" class="form-control" readonly>
                        </div>
                    </div>

                    <!-- Prenom -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label"><i class="bi bi-person-fill me-2"></i><strong>Prenom :</strong></label>
                        <div class="input-group">
                            <input type="text" value="{{ $pelerin->prenom }}" class="form-control" readonly>
                        </div>
                    </div>

                    <!-- Passport -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label"><i class="bi bi-file-text-fill me-2"></i><strong>Passport :</strong></label>
                        <div class="input-group">
                            <input type="text" value="{{ $pelerin->passeport }}" class="form-control" readonly>
                        </div>
                    </div>

                    <!-- Date de Délivrance -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label"><i class="bi bi-calendar-event-fill me-2"></i><strong>Date de Délivrance :</strong></label>
                        <div class="input-group">
                            <input type="text" value="{{ \Carbon\Carbon::parse($pelerin->date_delivrance)->format('d/m/Y') }}" class="form-control" readonly>
                        </div>
                    </div>

                    <!-- Date de Naissance -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label"><i class="bi bi-calendar-fill me-2"></i><strong>Date de Naissance :</strong></label>
                        <div class="input-group">
                            <input type="text" value="{{ \Carbon\Carbon::parse($pelerin->date_naissance)->format('d/m/Y') }}" class="form-control" readonly>
                        </div>
                    </div>

                    <!-- Date d'Expiration -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label"><i class="bi bi-file-earmark-text-fill me-2"></i><strong>Date d'Expiration :</strong></label>
                        <div class="input-group">
                            <input type="text" value="{{ \Carbon\Carbon::parse($pelerin->date_expiration)->format('d/m/Y') }}" class="form-control" readonly>
                        </div>
                    </div>

                    <!-- Sexe -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label"><i class="bi bi-gender-ambiguous me-2"></i><strong>Sexe :</strong></label>
                        <div class="input-group">
                            <input type="text" value="{{ $pelerin->sexe == 'M' ? 'Masculin' : 'Féminin' }}" class="form-control" readonly>
                        </div>
                    </div>

                    <!-- Nationalité -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label"><i class="bi bi-geo-alt me-2"></i><strong>Nationalité :</strong></label>
                        <div class="input-group">
                            <input type="text" value="{{ $pelerin->nationalite }}" class="form-control" readonly>
                        </div>
                    </div>

                    <!-- Téléphone -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label"><i class="bi bi-phone-fill me-2"></i><strong>Téléphone :</strong></label>
                        <div class="input-group">
                            <input type="text" value="{{ $pelerin->telephone }}" class="form-control" readonly>
                        </div>
                    </div>

                    <!-- Motif Candidat -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label"><i class="bi bi-clipboard me-2"></i><strong>Motif Candidat :</strong></label>
                        <div class="input-group">
                            <input type="text" value="{{ $pelerin->motif_candidat }}" class="form-control" readonly>
                        </div>
                    </div>

                    <!-- Facilitateur -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label"><i class="bi bi-person-fill me-2"></i><strong>Facilitateur :</strong></label>
                        <div class="input-group">
                            <input type="text" value="{{ $pelerin->facilitateur }}" class="form-control" readonly>
                        </div>
                    </div>

                    <!-- Ville ou Province -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label"><i class="bi bi-map-fill me-2"></i><strong>Ville ou Province :</strong></label>
                        <div class="input-group">
                            <input type="text" value="{{ $pelerin->ville_province }}" class="form-control" readonly>
                        </div>
                    </div>

                    <!-- Note/Observation -->
                    <div class="col-12 mb-3">
                        <label class="form-label"><i class="bi bi-pencil-square me-2"></i><strong>Note/Observation :</strong></label>
                        <div class="input-group">
                            <textarea class="form-control" readonly>{{ $pelerin->note_observation }}</textarea>
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



                                    
                                    <!-- Bouton de déclenchement pour le modal de modification -->
                                    <button type="button" class="btn btn-sm btn-secondary" data-bs-toggle="modal"
                                        data-bs-target="#editPilgrimModal{{ $pelerin->id }}">
                                        <i class="bi bi-pencil"></i> Modifier
                                    </button>

                                  <!-- Modal de modification -->
<div class="modal fade" id="editPilgrimModal{{ $pelerin->id }}" tabindex="-1" aria-labelledby="editPilgrimModalLabel{{ $pelerin->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-gray-dark text-white">
                <h5 class="modal-title" id="editPilgrimModalLabel{{ $pelerin->id }}">Modifier le Pèlerin</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('pelerins.update', $pelerin->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body bg-light">
                    <div class="row">
                        <!-- Nom -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="bi bi-person-fill me-2"></i><strong>Nom :</strong></label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="nom" name="nom" value="{{ $pelerin->nom }}" required>
                            </div>
                        </div>

                         <!-- prenom -->
                         <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="bi bi-person-fill me-2"></i><strong>Prenom :</strong></label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="prenom" name="prenom" value="{{ $pelerin->prenom }}" required>
                            </div>
                        </div>

                        <!-- Passport -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="bi bi-file-text-fill me-2"></i><strong>Passport :</strong></label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="passport" name="passeport" value="{{ $pelerin->passport }}" required>
                            </div>
                        </div>

                        <!-- Date de Délivrance -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="bi bi-calendar-event-fill me-2"></i><strong>Date de Délivrance :</strong></label>
                            <div class="input-group">
                                <input type="date" class="form-control" id="date_delivrance" name="date_delivrance" value="{{ \Carbon\Carbon::parse($pelerin->date_delivrance)->format('Y-m-d') }}" required>
                            </div>
                        </div>

                        <!-- Date de Naissance -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="bi bi-calendar-fill me-2"></i><strong>Date de Naissance :</strong></label>
                            <div class="input-group">
                                <input type="date" class="form-control" id="date_naissance" name="date_naissance" value="{{ \Carbon\Carbon::parse($pelerin->date_naissance)->format('Y-m-d') }}" required>
                            </div>
                        </div>

                        <!-- Date d'Expiration -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="bi bi-file-earmark-text-fill me-2"></i><strong>Date d'Expiration :</strong></label>
                            <div class="input-group">
                                <input type="date" class="form-control" id="date_expiration" name="date_expiration" value="{{ \Carbon\Carbon::parse($pelerin->date_expiration)->format('Y-m-d') }}" required>
                            </div>
                        </div>

                        <!-- Sexe -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="bi bi-gender-ambiguous me-2"></i><strong>Sexe :</strong></label>
                            <div class="input-group">
                                <select class="form-select" id="sexe" name="sexe" required>
                                    <option value="M" {{ $pelerin->sexe == 'M' ? 'selected' : '' }}>Masculin</option>
                                    <option value="F" {{ $pelerin->sexe == 'F' ? 'selected' : '' }}>Féminin</option>
                                </select>
                            </div>
                        </div>

                        <!-- Nationalité -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="bi bi-geo-alt me-2"></i><strong>Nationalité :</strong></label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="nationalite" name="nationalite" value="{{ $pelerin->nationalite }}" required>
                            </div>
                        </div>

                        <!-- Téléphone -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="bi bi-phone-fill me-2"></i><strong>Téléphone :</strong></label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="telephone" name="telephone" value="{{ $pelerin->telephone }}" required>
                            </div>
                        </div>

                        <!-- Motif Candidat -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="bi bi-clipboard me-2"></i><strong>Motif Candidat :</strong></label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="motif_candidat" name="motif_candidat" value="{{ $pelerin->motif_candidat }}" required>
                            </div>
                        </div>

                        <!-- Facilitateur -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="bi bi-person-fill me-2"></i><strong>Facilitateur :</strong></label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="facilitateur" name="facilitateur" value="{{ $pelerin->facilitateur }}" required>
                            </div>
                        </div>

                        <!-- Ville ou Province -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="bi bi-map-fill me-2"></i><strong>Ville ou Province :</strong></label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="ville_province" name="ville_province" value="{{ $pelerin->ville_province }}" required>
                            </div>
                        </div>

                        <!-- Note/Observation -->
                        <div class="col-12 mb-3">
                            <label class="form-label"><i class="bi bi-pencil-square me-2"></i><strong>Note/Observation :</strong></label>
                            <div class="input-group">
                                <textarea class="form-control" id="note_observation" name="note_observation" rows="3">{{ $pelerin->note_observation }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-dark-primary">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>

                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
        data-bs-target="#deletePelerinModal{{ $pelerin->id }}">
    <i class="bi bi-trash"></i> Supprimer
</button>

<!-- Modal de suppression -->
<div class="modal fade" id="deletePelerinModal{{ $pelerin->id }}" tabindex="-1"
     aria-labelledby="deletePelerinModalLabel{{ $pelerin->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deletePelerinModalLabel{{ $pelerin->id }}">
                    Confirmer la Suppression
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Êtes-vous sûr de vouloir supprimer ce pèlerin ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <form action="{{ route('pelerins.destroy', $pelerin->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Supprimer</button>
                </form>
            </div>
        </div>
    </div>
</div>

                                  
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">Aucun pèlerin trouvé.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    {{ $pelerins->links() }}
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>

@endsection

@push('scripts')
<!-- Include your custom scripts if needed -->
@endpush
