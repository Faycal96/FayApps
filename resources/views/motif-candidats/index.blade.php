@extends('layouts.backend')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>5</h3>
                    <p>Total des Motifs Candidats</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person"></i>
                </div>
                <a href="#" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>56</h3>
                    <p>Motifs Candidats liés à des Pelerins</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="#" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            @if(session('success'))
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <span class="alert-heading">{{ session('success') }}</span>
            </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Gestion des Motifs Candidats</h3>
                </div>
                <div class="card-body">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createMotifCandidatModal">
                        <i class="bi bi-plus"></i> Ajouter un Motif Candidat
                    </button>

                    <!-- Modal de création -->
                    <div class="modal fade" id="createMotifCandidatModal" tabindex="-1" aria-labelledby="createMotifCandidatModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="createMotifCandidatModalLabel">Ajouter un Motif Candidat</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('motif-candidats.store') }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="nom" class="form-label">Nom</label>
                                            <input type="text" class="form-control" id="nom" name="nom" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="montant" class="form-label">Montant de l'édition</label>
                                            <input type="number" class="form-control" id="montant" name="montant" required>
                                        </div>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <table id="motifCandidatTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nom</th>
                                <th>Montant</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($motifCandidats as $motifCandidat)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $motifCandidat->nom }}</td>
                                <td>{{ $motifCandidat->montant }}</td>
                                <td>
                                    <!-- Bouton de déclenchement pour le modal de modification -->
                                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editMotifCandidatModal{{ $motifCandidat->id }}">
                                        <i class="bi bi-pencil"></i> Modifier
                                    </button>

                                    <!-- Modal de modification -->
                                    <div class="modal fade" id="editMotifCandidatModal{{ $motifCandidat->id }}" tabindex="-1" aria-labelledby="editMotifCandidatModalLabel{{ $motifCandidat->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editMotifCandidatModalLabel{{ $motifCandidat->id }}">Modifier un Motif Candidat</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('motif-candidats.update', $motifCandidat->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="mb-3">
                                                            <label for="nom" class="form-label">Nom</label>
                                                            <input type="text" class="form-control" id="nom" name="nom" value="{{ $motifCandidat->nom }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="montant" class="form-label">Montant de l'édition</label>
                                                            <input type="number" class="form-control" id="montant" name="montant" value="{{ $motifCandidat->montant }}" required>
                                                        </div>
                                                        
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Bouton de déclenchement pour le modal de suppression -->
                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteMotifCandidatModal{{ $motifCandidat->id }}">
                                        <i class="bi bi-trash"></i> Supprimer
                                    </button>

                                    <!-- Modal de suppression -->
                                    <div class="modal fade" id="deleteMotifCandidatModal{{ $motifCandidat->id }}" tabindex="-1" aria-labelledby="deleteMotifCandidatModalLabel{{ $motifCandidat->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteMotifCandidatModalLabel{{ $motifCandidat->id }}">Supprimer le Motif Candidat</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Êtes-vous sûr de vouloir supprimer ce motif candidat ?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                    <form action="{{ route('motif-candidats.destroy', $motifCandidat->id) }}" method="POST">
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
                                <td colspan="4" class="text-center">Aucun motif candidat trouvé!</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
