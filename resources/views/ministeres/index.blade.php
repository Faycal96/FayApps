@extends('layouts.backend')

@section('content')

<div class="container-fluid">
    <div class="row">
        <!-- Ajoutez ici votre code HTML pour afficher les statistiques ou les informations générales -->
    </div>

    <div class="row">
        <div class="col-12">
            <p>
                @if(session('success'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <span class="alert-heading">{{ session('success') }}</span>
                </div>

                <script>
                    setTimeout(function() {
                            document.querySelector('.alert.alert-success').style.display = 'none';
                        }, 6000); // Le message flash disparaîtra après 5 secondes (5000 millisecondes)
                </script>
                @endif
            </p>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Gestion des Ministères</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <!-- Bouton de déclenchement pour le modal de création -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#createMinistereModal">
                        <i class="bi bi-plus"></i> Ajouter un Ministère
                    </button>

                    <!-- Modal de création -->
                    <div class="modal fade" id="createMinistereModal" tabindex="-1" aria-labelledby="createMinistereModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="createMinistereModalLabel">Ajouter un Ministère</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('ministeres.store') }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="libelleCourt" class="form-label">Libellé Court</label>
                                            <input type="text" class="form-control" id="libelleCourt" name="libelleCourt" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="libelleLong" class="form-label">Libellé Long</label>
                                            <input type="text" class="form-control" id="libelleLong" name="libelleLong" required>
                                        </div>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Libellé Court</th>
                                <th>Libellé Long</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($ministeres as $ministere)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $ministere->libelleCourt }}</td>
                                <td>{{ $ministere->libelleLong }}</td>
                                <td>
                                    <!-- Bouton de déclenchement pour le modal de modification -->
                                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#editMinistereModal{{ $ministere->id }}">
                                        <i class="bi bi-pencil"></i> Modifier
                                    </button>

                                    <!-- Modal de modification -->
                                    <div class="modal fade" id="editMinistereModal{{ $ministere->id }}" tabindex="-1"
                                        aria-labelledby="editMinistereModalLabel{{ $ministere->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editMinistereModalLabel">Modifier un Ministère</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('ministeres.update', $ministere->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="mb-3">
                                                            <label for="libelleCourt" class="form-label">Libellé Court</label>
                                                            <input type="text" class="form-control" id="libelleCourt" name="libelleCourt" value="{{ $ministere->libelleCourt }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="libelleLong" class="form-label">Libellé Long</label>
                                                            <input type="text" class="form-control" id="libelleLong" name="libelleLong" value="{{ $ministere->libelleLong }}" required>
                                                        </div>
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Bouton de déclenchement pour le modal de fusion -->
                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#mergeMinisteresModal{{ $ministere->id }}">
                                        <i class="bi bi-arrow-merge"></i> Fusionner
                                    </button>

                                    <!-- Modal de fusion -->
                                    <div class="modal fade" id="mergeMinisteresModal{{ $ministere->id }}" tabindex="-1"
                                        aria-labelledby="mergeMinisteresModalLabel{{ $ministere->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="mergeMinisteresModalLabel">Fusionner des Ministères</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('ministeres.merge') }}" method="POST">
                                                        @csrf
                                                        <div class="mb-3">
                                                            <label for="ministere1_id" class="form-label">Ministère 1</label>
                                                            <select class="form-select" id="ministere1_id" name="ministere1_id" required>
                                                                <option value="">Sélectionner un ministère</option>
                                                                @foreach($ministeres as $ministereOption)
                                                                    <option value="{{ $ministereOption->id }}">{{ $ministereOption->libelleLong }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="ministere2_id" class="form-label">Ministère 2</label>
                                                            <select class="form-select" id="ministere2_id" name="ministere2_id" required>
                                                                <option value="">Sélectionner un autre ministère</option>
                                                                @foreach($ministeres as $ministereOption)
                                                                    <option value="{{ $ministereOption->id }}">{{ $ministereOption->libelleLong }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                                        <button type="submit" class="btn btn-primary">Fusionner</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center">Aucun ministère trouvé!</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</div><!-- /.container-fluid -->

@endsection
