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
                    <h3 class="card-title">Gestion des Sources de Finacement</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <!-- Bouton de déclenchement pour le modal de création -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#createstructureModal">
                        <i class="bi bi-plus"></i> Ajouter une Structure
                    </button>

                    <!-- Modal de création -->
                    <div class="modal fade" id="createstructureModal" tabindex="-1" aria-labelledby="createstructureModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="createstructureModalLabel">Ajouter une Source de financement </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('source_financement.store') }}" method="POST">
                                        @csrf
                                       
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
                               
                                <th>Libellé Long</th>
                                <th>Ministere</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($source_financements as $source_financement)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                
                                <td>{{ $source_financement->libelleLong }}</td>
                                <td>{{ $source_financement->ministere->libelleLong }}</td>
                                <td>
                                    <!-- Bouton de déclenchement pour le modal de modification -->
                                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#editstructureModal{{ $source_financement->id }}">
                                        <i class="bi bi-pencil"></i> Modifier
                                    </button>

                                    <!-- Modal de modification -->
                                    <div class="modal fade" id="editstructureModal{{ $source_financement->id }}" tabindex="-1"
                                        aria-labelledby="editstructureModalLabel{{ $source_financement->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editstructureModalLabel">Modifier Structure Structure</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('source_financement.update', $source_financement->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                       
                                                        <div class="mb-3">
                                                            <label for="libelleLong" class="form-label">Libellé Long</label>
                                                            <input type="text" class="form-control" id="libelleLong" name="libelleLong" value="{{ $source_financement->libelleLong }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="ministere_id" class="form-label">Ministère</label>
                                                            <div style="overflow: hidden;">
                                                                <select class="form-select" id="ministere_id" name="ministere_id" required>
                                                                    <option value="">Sélectionner un ministère</option>
                                                                    @foreach($ministeres as $ministere)
                                                                        <option value="{{ $ministere->id }}" {{ $ministere->id == $source_financement->ministere_id ? 'selected' : '' }}>
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

                                 
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center">Aucune source de financement trouvé!</td>
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
