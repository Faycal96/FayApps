@extends('layouts.backend')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>3</h3>
                    <p>Total des Facilitateurs</p>
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
                    <h3>6</h3>
                    <p>Facilitateurs associés à des agences</p>
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
                    <h3 class="card-title">Gestion des Facilitateurs</h3>
                </div>
                <div class="card-body">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createFacilitateurModal">
                        <i class="bi bi-plus"></i> Ajouter un Facilitateur
                    </button>

                    <!-- Modal de création -->
                    <div class="modal fade" id="createFacilitateurModal" tabindex="-1" aria-labelledby="createFacilitateurModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="createFacilitateurModalLabel">Ajouter un Facilitateur</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('facilitateurs.store') }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="nom" class="form-label">Nom</label>
                                            <input type="text" class="form-control" id="nom" name="nom" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="telephone" class="form-label">Téléphone</label>
                                            <input type="number" class="form-control" id="telephone" name="telephone" value="{{ old('telephone', $facilitateur->telephone ?? '') }}">
                                        </div>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <table id="facilitateurTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nom</th>
                                <th>Agence</th>
                                <th>Telephone</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($facilitateurs as $facilitateur)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $facilitateur->nom }}</td>
                                <td>{{ $facilitateur->agence->name }}</td>
                                <td>{{ $facilitateur->telephone }}</td>
                                <td>
                                    <!-- Bouton de déclenchement pour le modal de modification -->
                                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editFacilitateurModal{{ $facilitateur->id }}">
                                        <i class="bi bi-pencil"></i> Modifier
                                    </button>

                                    <!-- Modal de modification -->
                                    <div class="modal fade" id="editFacilitateurModal{{ $facilitateur->id }}" tabindex="-1" aria-labelledby="editFacilitateurModalLabel{{ $facilitateur->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editFacilitateurModalLabel{{ $facilitateur->id }}">Modifier un Facilitateur</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('facilitateurs.update', $facilitateur->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="mb-3">
                                                            <label for="nom" class="form-label">Nom</label>
                                                            <input type="text" class="form-control" id="nom" name="nom" value="{{ $facilitateur->nom }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="telephone" class="form-label">Telephone</label>
                                                            <input type="number" class="form-control" id="nom" name="telephone" value="{{ $facilitateur->telephone }}" required>
                                                        </div>
                                                        
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Bouton de déclenchement pour le modal de suppression -->
                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteFacilitateurModal{{ $facilitateur->id }}">
                                        <i class="bi bi-trash"></i> Supprimer
                                    </button>

                                    <!-- Modal de suppression -->
                                    <div class="modal fade" id="deleteFacilitateurModal{{ $facilitateur->id }}" tabindex="-1" aria-labelledby="deleteFacilitateurModalLabel{{ $facilitateur->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteFacilitateurModalLabel{{ $facilitateur->id }}">Supprimer le Facilitateur</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Êtes-vous sûr de vouloir supprimer ce facilitateur ?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                    <form action="{{ route('facilitateurs.destroy', $facilitateur->id) }}" method="POST">
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
                                <td colspan="4" class="text-center">Aucun facilitateur trouvé!</td>
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
