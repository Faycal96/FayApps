@extends('layouts.backend')

@section('content')

<div class="container-fluid">
    <form action="{{ route('pelerins.index') }}" method="GET">
        <div class="form-group">
            <label for="motifCandidatId">Sélectionner le Motif</label>
            <select name="motifCandidatId" id="motifCandidatId" class="form-control" style="width: 200px;" onchange="this.form.submit()">

                @foreach($motifCandidats as $motif)
                    <option value="{{ $motif->id }}" {{ $motif->id == $motifCandidatId ? 'selected' : '' }}>
                        {{ $motif->nom }}
                    </option>
                @endforeach
            </select>
        </div>
    </form>
    
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $totalPelerinsForMotif }}</h3>
                    <p>Total des Pèlerins pour le Motif</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $totalPelerinsPayes }}</h3>
                    <p>Pèlerins soldés</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $totalPelerinsEnAttente }}</h3>
                    <p>Pèlerins en Attente</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $totalPelerinsNonPaye }}</h3>
                    <p>Pèlerins non payés</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
            </div>
        </div>
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
            @if(auth()->user()->hasRole(['Admin']))
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
                                    <form action="{{ route('pelerins.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                        <!-- Champ pour uploader la photo -->
                                        <div class="col-md-6 mb-3">
                                            <i class="bi bi-camera-fill me-2"></i>
                                            <label for="photo" class="form-label"><strong>Photo (facultatif)</strong></label>
                                            <input type="file" class="form-control @error('photo') is-invalid @enderror" id="photo" name="photo" accept="image/*" onchange="previewImage(event)">
                                            @error('photo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Prévisualisation de l'image -->
                                        <div class="col-md-6 mb-3">
                                            <label><strong>Prévisualisation de la photo</strong></label>
                                            <div id="image-preview" style="border: 1px solid #ddd; padding: 5px; max-width: 100%; display: none;">
                                                <img id="image-display" src="" alt="Prévisualisation" style="max-width: 100%; height: auto;" />
                                            </div>
                                        </div>

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
                                                <label for="passeport" class="form-label"><strong>Passeport ou CNIB</strong></label>
                                                <input type="text" class="form-control @error('passeport') is-invalid @enderror" id="passeport" name="passeport" value="{{ old('passeport') }}"required>
                                                @error('passeport')
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
                                                <i class="bi bi-calendar-event-fill me-2"></i>
                                                <label for="date_delivrance" class="form-label"><strong>Date de Délivrance</strong></label>
                                                <input type="date" class="form-control @error('date_delivrance') is-invalid @enderror" id="date_delivrance" name="date_delivrance" value="{{ old('date_delivrance') }}"required>
                                                @error('date_delivrance')
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
                                                <i class="bi bi-calendar-fill me-2"></i>
                                                <label for="date_naissance" class="form-label"><strong>Date de Naissance</strong></label>
                                                <input type="date" class="form-control @error('date_naissance') is-invalid @enderror" id="date_naissance" name="date_naissance" value="{{ old('date_naissance') }}"required>
                                                @error('date_naissance')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                               <!-- Champ Lieu de Naissance -->
                                            <div class="col-md-6 mb-3">
                                                <i class="bi bi-geo-alt-fill me-2"></i>
                                                <label for="lieu_naissance" class="form-label"><strong>Lieu de Naissance</strong></label>
                                                <input type="text" class="form-control @error('lieu_naissance') is-invalid @enderror" id="lieu_naissance" name="lieu_naissance" value="{{ old('lieu_naissance') }}" required>
                                                @error('lieu_naissance')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                          
                                            <div class="col-md-6 mb-3">
                                                <i class="bi bi-gender-ambiguous me-2"></i>
                                                <label for="sexe" class="form-label"><strong>Sexe</strong></label>
                                                <select class="form-control @error('sexe') is-invalid @enderror" id="sexe" name="sexe"required>
                                                    <option value="">Sélectionner</option>
                                                    <option value="M" {{ old('sexe') == 'M' ? 'selected' : '' }}>Masculin</option>
                                                    <option value="F" {{ old('sexe') == 'F' ? 'selected' : '' }}>Féminin</option>
                                                </select>
                                                @error('sexe')
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
                                                <label for="motif_candidat_id" class="form-label"><strong>Motif Candidat</strong></label>
                                                <select class="form-control @error('motif_candidat_id') is-invalid @enderror" id="motif_candidat_id" name="motif_candidat_id" required>
                                                    <option value="">Sélectionner un motif</option>
                                                    @foreach($motifCandidats as $motifCandidat)
                                                        <option value="{{ $motifCandidat->id }}" {{ old('motif_candidat_id') == $motifCandidat->id ? 'selected' : '' }}>{{ $motifCandidat->nom }}</option>
                                                    @endforeach
                                                </select>
                                                @error('motif_candidat_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                            
                                            
                                          
                                            
                                            <div class="col-md-6 mb-3">
                                                <i class="bi bi-person-fill me-2"></i>
                                                <label for="facilitateur" class="form-label"><strong>Facilitateur</strong></label>
                                                <select class="form-control @error('facilitateur_id') is-invalid @enderror" id="facilitateur" name="facilitateur" required>
                                                    <option value="">Sélectionner un facilitateur</option>
                                                    @foreach($facilitateurs as $id => $nom)
                                                        <option value="{{$nom }}" {{ old('facilitateur_id') == $nom ? 'selected' : '' }}>{{ $nom }}</option>
                                                    @endforeach
                                                </select>
                                                @error('facilitateur_id')
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
                                                                <!-- Champ Type de Vol -->
                                            <div class="col-md-6 mb-3">
                                                <i class="bi bi-airplane-fill me-2"></i>
                                                <label for="type_vol" class="form-label"><strong>Type de Vol</strong></label>
                                                <select class="form-control @error('type_vol') is-invalid @enderror" id="type_vol" name="type_vol" required>
                                                    <option value="">Sélectionner</option>
                                                    <option value="Charter" {{ old('type_vol') == 'Charter' ? 'selected' : '' }}>Charter</option>
                                                    <option value="Régulier" {{ old('type_vol') == 'Régulier' ? 'selected' : '' }}>Régulier</option>
                                                </select>
                                                @error('type_vol')
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
                    
            @endif
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
                                <th>Date Naissance</th>
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
                            @if ($pelerin->user->agency_id ==auth()->user()->agency_id)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ \Carbon\Carbon::parse($pelerin->date_naissance)->format('d/m/Y') }}</td>
                                <td>{{ $pelerin->passeport }}</td>
                                <td>{{ $pelerin->nom }}</td>
                                <td>{{ $pelerin->prenom }}</td>
                                <td>{{ $pelerin->facilitateur }}</td>
                                
                                <td>
                                    @if($pelerin->montantRestant() == 0)
                                    <span class="badge bg-success">Definitif</span>
                                   
                                    @else
                                    <span class="badge bg-warning">Provisoire</span>
                                    @endif
                                </td>

                                <td>
                                    <a href="{{ asset('recipisses/' . $pelerin->id . '_recipisse.pdf') }}" 
                                        class="btn btn-info btn-sm" target="_blank">
                                        <i class="bi bi-download"></i> Récépissé
                                     </a>

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

                                                @if($pelerin->photo)
                                                <label><strong>Prévisualisation de la photo</strong></label>
                                                    <div class="col-md-12 mb-3 text-center">
                                                        
                                                        <img src="{{ asset('images/pelerins/' . $pelerin->photo) }}" alt="Photo du pèlerin" class="img-fluid rounded" style="max-height: 300px; object-fit: cover;">
                                                    </div>
                                                @endif
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
                                                <!-- Nationalité -->
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label"><i class="bi bi-geo-alt me-2"></i><strong>Nationalité :</strong></label>
                                                    <div class="input-group">
                                                        <input type="text" value="{{ $pelerin->nationalite }}" class="form-control" readonly>
                                                    </div>
                                                </div>

                                                <!-- Date de Délivrance -->
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label"><i class="bi bi-calendar-event-fill me-2"></i><strong>Date de Délivrance :</strong></label>
                                                    <div class="input-group">
                                                        <input type="text" value="{{ \Carbon\Carbon::parse($pelerin->date_delivrance)->format('d/m/Y') }}" class="form-control" readonly>
                                                    </div>
                                                </div>
                                                 <!-- Date d'Expiration -->
                                                 <div class="col-md-6 mb-3">
                                                    <label class="form-label"><i class="bi bi-file-earmark-text-fill me-2"></i><strong>Date d'Expiration :</strong></label>
                                                    <div class="input-group">
                                                        <input type="text" value="{{ \Carbon\Carbon::parse($pelerin->date_expiration)->format('d/m/Y') }}" class="form-control" readonly>
                                                    </div>
                                                </div>

                                                <!-- Date de Naissance -->
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label"><i class="bi bi-calendar-fill me-2"></i><strong>Date de Naissance :</strong></label>
                                                    <div class="input-group">
                                                        <input type="text" value="{{ \Carbon\Carbon::parse($pelerin->date_naissance)->format('d/m/Y') }}" class="form-control" readonly>
                                                    </div>
                                                </div>

                                                                            <!-- Lieu de Naissance -->
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label"><i class="bi bi-geo-alt-fill me-2"></i><strong>Lieu de Naissance :</strong></label>
                                                    <div class="input-group">
                                                        <input type="text" value="{{ $pelerin->lieu_naissance }}" class="form-control" readonly>
                                                    </div>
                                                </div>

                                               

                                                <!-- Sexe -->
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label"><i class="bi bi-gender-ambiguous me-2"></i><strong>Sexe :</strong></label>
                                                    <div class="input-group">
                                                        <input type="text" value="{{ $pelerin->sexe == 'M' ? 'Masculin' : 'Féminin' }}" class="form-control" readonly>
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
                                                    <label class="form-label"><i class="bi bi-clipboard me-2"></i><strong>Edition :</strong></label>
                                                    <div class="input-group">
                                                        <input type="text" value="{{ $pelerin->motifCandidat->nom }}" class="form-control" readonly>
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
                                                                            <!-- Type de Vol -->
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label"><i class="bi bi-airplane-fill me-2"></i><strong>Type de Vol :</strong></label>
                                                    <div class="input-group">
                                                        <input type="text" value="{{ $pelerin->type_vol }}" class="form-control" readonly>
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



                            @if(auth()->user()->hasRole(['Admin']))
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
                                            <form action="{{ route('pelerins.update', $pelerin->id) }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body bg-light">
                                                    <div class="row">
                                                        <!-- Photo actuelle -->
                                                        <div class="col-md-6 mb-3">
                                                            <label><strong>Photo actuelle</strong></label>
                                                            @if($pelerin->photo)
                                                                <img src="{{ asset('images/pelerins/' . $pelerin->photo) }}" alt="Photo actuelle" style="max-width: 100%; height: auto;"/>
                                                            @else
                                                                <p>Aucune photo</p>
                                                            @endif
                                                        </div>
                                
                                                        <!-- Champ pour uploader la nouvelle photo -->
                                                        <div class="col-md-6 mb-3">
                                                            <i class="bi bi-camera-fill me-2"></i>
                                                            <label for="photo" class="form-label"><strong>Photo (facultatif)</strong></label>
                                                            <input type="file" class="form-control @error('photo') is-invalid @enderror" id="photo" name="photo" accept="image/*" onchange="previewImage(event)">
                                                            @error('photo')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                
                                                        <!-- Prévisualisation de la nouvelle photo -->
                                                        <div class="col-md-6 mb-3">
                                                            <label><strong>Prévisualisation de la nouvelle photo</strong></label>
                                                            <div id="image-preview" style="border: 1px solid #ddd; padding: 5px; max-width: 100%; display: none;">
                                                                <img id="image-display" src="" alt="Prévisualisation" style="max-width: 100%; height: auto;" />
                                                            </div>
                                                        </div>
                                                        <!-- Nom -->
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label"><i class="bi bi-person-fill me-2"></i><strong>Nom :</strong></label>
                                                            <input type="text" class="form-control @error('nom') is-invalid @enderror" id="nom" name="nom" value="{{ $pelerin->nom }}" required>
                                                            @error('nom')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                
                                                        <!-- Prénom -->
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label"><i class="bi bi-person-fill me-2"></i><strong>Prénom :</strong></label>
                                                            <input type="text" class="form-control @error('prenom') is-invalid @enderror" id="prenom" name="prenom" value="{{ $pelerin->prenom }}" required>
                                                            @error('prenom')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                
                                                        <!-- Passeport -->
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label"><i class="bi bi-file-text-fill me-2"></i><strong>Passeport :</strong></label>
                                                            <input type="text" class="form-control @error('passeport') is-invalid @enderror" id="passeport" name="passeport" value="{{ $pelerin->passeport }}" required>
                                                            @error('passeport')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <!-- Nationalité -->
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label"><i class="bi bi-geo-alt me-2"></i><strong>Nationalité :</strong></label>
                                                            <input type="text" class="form-control @error('nationalite') is-invalid @enderror" id="nationalite" name="nationalite" value="{{ $pelerin->nationalite }}" required>
                                                            @error('nationalite')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                
                                                        <!-- Date de Délivrance -->
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label"><i class="bi bi-calendar-event-fill me-2"></i><strong>Date de Délivrance :</strong></label>
                                                            <input type="date" class="form-control @error('date_delivrance') is-invalid @enderror" id="date_delivrance" name="date_delivrance" value="{{ \Carbon\Carbon::parse($pelerin->date_delivrance)->format('Y-m-d') }}" required>
                                                            @error('date_delivrance')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <!-- Date d'Expiration -->
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label"><i class="bi bi-file-earmark-text-fill me-2"></i><strong>Date d'Expiration :</strong></label>
                                                            <input type="date" class="form-control @error('date_expiration') is-invalid @enderror" id="date_expiration" name="date_expiration" value="{{ \Carbon\Carbon::parse($pelerin->date_expiration)->format('Y-m-d') }}" required>
                                                            @error('date_expiration')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                
                                                        <!-- Date de Naissance -->
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label"><i class="bi bi-calendar-fill me-2"></i><strong>Date de Naissance :</strong></label>
                                                            <input type="date" class="form-control @error('date_naissance') is-invalid @enderror" id="date_naissance" name="date_naissance" value="{{ \Carbon\Carbon::parse($pelerin->date_naissance)->format('Y-m-d') }}" required>
                                                            @error('date_naissance')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                                                        <!-- Champ Lieu de Naissance -->
                                                        <div class="col-md-6 mb-3">
                                                            <i class="bi bi-geo-alt-fill me-2"></i>
                                                            <label for="lieu_naissance" class="form-label"><strong>Lieu de Naissance</strong></label>
                                                            <input type="text" class="form-control @error('lieu_naissance') is-invalid @enderror" id="lieu_naissance" name="lieu_naissance" value="{{ old('lieu_naissance', $pelerin->lieu_naissance) }}" required>
                                                            @error('lieu_naissance')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                
                                                        
                                
                                                        <!-- Sexe -->
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label"><i class="bi bi-gender-ambiguous me-2"></i><strong>Sexe :</strong></label>
                                                            <select class="form-control @error('sexe') is-invalid @enderror" id="sexe" name="sexe" required>
                                                                <option value="">Sélectionner</option>
                                                                <option value="M" {{ $pelerin->sexe == 'M' ? 'selected' : '' }}>Masculin</option>
                                                                <option value="F" {{ $pelerin->sexe == 'F' ? 'selected' : '' }}>Féminin</option>
                                                            </select>
                                                            @error('sexe')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                
                                                        
                                
                                                        <!-- Téléphone -->
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label"><i class="bi bi-phone-fill me-2"></i><strong>Téléphone :</strong></label>
                                                            <input type="number" class="form-control @error('telephone') is-invalid @enderror" id="telephone" name="telephone" value="{{ $pelerin->telephone }}" required>
                                                            @error('telephone')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                
                                                        <!-- Motif Candidat -->
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label"><i class="bi bi-clipboard me-2"></i><strong>Motif  :</strong></label>
                                                            <select class="form-control @error('motif_candidat_id') is-invalid @enderror" id="motif_candidat_id" name="motif_candidat_id" required>
                                                                <option value="">Sélectionner le motif</option>
                                                                @foreach($motifCandidats as $motifCandidat)
                                                                    <option value="{{ $motifCandidat->id }}" {{ $pelerin->motif_candidat_id == $motifCandidat->id ? 'selected' : '' }}>{{ $motifCandidat->nom }}</option>
                                                                @endforeach
                                                            </select>
                                                            @error('motif_candidat_id')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                
                                                        <!-- Facilitateur -->
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label"><i class="bi bi-person-fill me-2"></i><strong>Facilitateur :</strong></label>
                                                            <select class="form-control @error('facilitateur_id') is-invalid @enderror" id="facilitateur" name="facilitateur" required>
                                                                <option value="">Sélectionner un facilitateur</option>
                                                                @foreach($facilitateurs as $id => $nom)
                                                                    <option value="{{ $nom }}" {{ $pelerin->facilitateur_id == $id ? 'selected' : '' }}>{{ $nom }}</option>
                                                                @endforeach
                                                            </select>
                                                            @error('facilitateur_id')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                
                                                        <!-- Ville ou Province -->
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label"><i class="bi bi-map-fill me-2"></i><strong>Ville ou Province :</strong></label>
                                                            <input type="text" class="form-control @error('ville_province') is-invalid @enderror" id="ville_province" name="ville_province" value="{{ $pelerin->ville_province }}" required>
                                                            @error('ville_province')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                                                        <!-- Champ Type de Vol -->
                                                        <div class="col-md-6 mb-3">
                                                            <i class="bi bi-airplane-fill me-2"></i>
                                                            <label for="type_vol" class="form-label"><strong>Type de Vol</strong></label>
                                                            <select class="form-control @error('type_vol') is-invalid @enderror" id="type_vol" name="type_vol" required>
                                                                <option value="">Sélectionner</option>
                                                                <option value="Charter" {{ old('type_vol', $pelerin->type_vol) == 'Charter' ? 'selected' : '' }}>Charter</option>
                                                                <option value="Regulier" {{ old('type_vol', $pelerin->type_vol) == 'Regulier' ? 'selected' : '' }}>Regulier</option>
                                                            </select>
                                                            @error('type_vol')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                
                                                        <!-- Note/Observation -->
                                                        <div class="col-md-12 mb-3">
                                                            <label class="form-label"><i class="bi bi-pencil-square me-2"></i><strong>Note/Observation :</strong></label>
                                                            <textarea class="form-control @error('note_observation') is-invalid @enderror" id="note_observation" name="note_observation" rows="3">{{ $pelerin->note_observation }}</textarea>
                                                            @error('note_observation')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
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

                                  @endif
                                </td>
                            </tr>
                            @endif
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
<script>
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function(){
            var output = document.getElementById('image-display');
            output.src = reader.result;
            document.getElementById('image-preview').style.display = 'block';
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>

