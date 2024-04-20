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
                    <h3 class="card-title">Gestion des Structures</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <!-- Bouton de déclenchement pour le modal de création -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#createstructureModal">
                        <i class="bi bi-plus"></i> Ajouter Structure Structure
                    </button>

                    <!-- Modal de création -->
                    <div class="modal fade" id="createstructureModal" tabindex="-1" aria-labelledby="createstructureModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="createstructureModalLabel">Ajouter une Structure Structure</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('structures.store') }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="libelleCourt" class="form-label">Libellé Court</label>
                                            <input type="text" class="form-control" id="libelleCourt" name="libelleCourt" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="libelleLong" class="form-label">Libellé Long</label>
                                            <input type="text" class="form-control" id="libelleLong" name="libelleLong" required>
                                        </div>
                                        <div class="mb-3">
                                            <div style="overflow: hidden;">
                                            <label for="ministere_id" class="form-label">Ministère</label>
                                            <select class="form-select" id="ministere_id" name="ministere_id" required>
                                                <option value="">Sélectionner un ministère</option>
                                                @foreach($ministeres as $ministere)
                                                    <option value="{{ $ministere->id }}">{{ $ministere->libelleLong }}</option>
                                                @endforeach
                                            </select>
                                        </div>
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
                                <th>Ministere</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($structures as $structure)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $structure->libelleCourt }}</td>
                                <td>{{ $structure->libelleLong }}</td>
                                <td>{{ $structure->ministere->libelleLong }}</td>
                                <td>
                                    <!-- Bouton de déclenchement pour le modal de modification -->
                                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#editstructureModal{{ $structure->id }}">
                                        <i class="bi bi-pencil"></i> Modifier
                                    </button>

                                    <!-- Modal de modification -->
                                    <div class="modal fade" id="editstructureModal{{ $structure->id }}" tabindex="-1"
                                        aria-labelledby="editstructureModalLabel{{ $structure->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editstructureModalLabel">Modifier Structure Structure</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('structures.update', $structure->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="mb-3">
                                                            <label for="libelleCourt" class="form-label">Libellé Court</label>
                                                            <input type="text" class="form-control" id="libelleCourt" name="libelleCourt" value="{{ $structure->libelleCourt }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="libelleLong" class="form-label">Libellé Long</label>
                                                            <input type="text" class="form-control" id="libelleLong" name="libelleLong" value="{{ $structure->libelleLong }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="ministere_id" class="form-label">Ministère</label>
                                                            <div style="overflow: hidden;">
                                                                <select class="form-select" id="ministere_id" name="ministere_id" required>
                                                                    <option value="">Sélectionner un ministère</option>
                                                                    @foreach($ministeres as $ministere)
                                                                        <option value="{{ $ministere->id }}" {{ $ministere->id == $structure->ministere_id ? 'selected' : '' }}>
                                                                            {{ $ministere->libelleLong }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
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
                                        data-bs-target="#mergestructuresModal{{ $structure->id }}">
                                        <i class="bi bi-arrow-merge"></i> Fusionner
                                    </button>

                                    <!-- Modal de fusion -->
                                    <div class="modal fade" id="mergestructuresModal{{ $structure->id }}" tabindex="-1"
                                        aria-labelledby="mergestructuresModalLabel{{ $structure->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="mergestructuresModalLabel">Fusionner des Structures</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('structures.merge') }}" method="POST">
                                                        @csrf
                                                        <div class="mb-3">
                                                            <label for="structure1_id" class="form-label">Structure 1</label>
                                                            <select class="form-select" id="structure1_id" name="structure1_id" required>
                                                                <option value="">Sélectionner une Structure</option>
                                                                @foreach($structures as $structureOption)
                                                                    <option value="{{ $structureOption->id }}">{{ $structureOption->libelleLong }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="structure2_id" class="form-label">Structure 2</label>
                                                            <select class="form-select" id="structure2_id" name="structure2_id" required>
                                                                <option value="">Sélectionner une autre Structure</option>
                                                                @foreach($structures as $structureOption)
                                                                    <option value="{{ $structureOption->id }}">{{ $structureOption->libelleLong }}</option>
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
                                <td colspan="4" class="text-center">Aucune structure trouvé!</td>
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
