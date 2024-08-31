@extends('layouts.backend')

@section('content')

<div class="container-fluid">
 

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
                        }, 6000); // Le message flash disparaîtra après 6 secondes (6000 millisecondes)
                </script>
                @endif
            </p>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Gestion des Agences</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <!-- Bouton de déclenchement pour le modal de création -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createAgencyModal">
                        <i class="bi bi-plus"></i> Ajouter une Agence
                    </button>

                    <!-- Modal de création -->
                    <div class="modal fade" id="createAgencyModal" tabindex="-1" aria-labelledby="createAgencyModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="createAgencyModalLabel">Ajouter une Agence</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('agencies.store') }}"  method="POST" enctype="multipart/form-data">
                                        @csrf
                                         <!-- Champ pour uploader la logo -->
                                         <div class="col-md-6 mb-3">
                                            <i class="bi bi-camera-fill me-2"></i>
                                            <label for="logo" class="form-label"><strong>logo (facultatif)</strong></label>
                                            <input type="file" class="form-control @error('logo') is-invalid @enderror" id="logo" name="logo" accept="image/*" onchange="previewImage(event)">
                                            @error('logo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Prévisualisation de l'image -->
                                        <div class="col-md-6 mb-3">
                                            <label><strong>Prévisualisation de la logo</strong></label>
                                            <div id="image-preview" style="border: 1px solid #ddd; padding: 5px; max-width: 100%; display: none;">
                                                <img id="image-display" src="" alt="Prévisualisation" style="max-width: 100%; height: auto;" />
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Nom</label>
                                            <input type="text" class="form-control" id="name" name="name" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="address" class="form-label">Adresse</label>
                                            <input type="text" class="form-control" id="address" name="address" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="phone_number" class="form-label">Numéro de téléphone</label>
                                            <input type="text" class="form-control" id="phone_number" name="phone_number" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="email" name="email" required>
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
                                <th>Nom</th>
                                <th>Adresse</th>
                                <th>Téléphone</th>
                                <th>Email</th>
                                <th>date_validité</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($agencies as $agency)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $agency->name }}</td>
                                <td>{{ $agency->address }}</td>
                                <td>{{ $agency->phone_number }}</td>
                                <td>{{ $agency->email }}</td>
                                 <td>{{ $agency->fin_validite }}</td>
                                 <td>

                                    @if($agency->is_active == 1)
                                    <span class="badge bg-success">Activé</span>
                                    @else
                                    <span class="badge bg-danger">Desactivé</span>
                                    @endif
                                </td>
                                <td>
                                    
                                    <!-- Bouton de déclenchement pour le modal de modification -->
                                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editAgencyModal{{ $agency->id }}">
                                        <i class="bi bi-pencil"></i> Modifier
                                    </button>

                                    <!-- Modal de modification -->
                                    <div class="modal fade" id="editAgencyModal{{ $agency->id }}" tabindex="-1" aria-labelledby="editAgencyModalLabel{{ $agency->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editAgencyModalLabel{{ $agency->id }}">Modifier une Agence</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('agencies.update', $agency->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="mb-3">
                                                            <label for="name" class="form-label">Nom</label>
                                                            <input type="text" class="form-control" id="name" name="name" value="{{ $agency->name }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="address" class="form-label">Adresse</label>
                                                            <input type="text" class="form-control" id="address" name="address" value="{{ $agency->address }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="phone_number" class="form-label">Numéro de téléphone</label>
                                                            <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{ $agency->phone_number }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="email" class="form-label">Email</label>
                                                            <input type="email" class="form-control" id="email" name="email" value="{{ $agency->email }}" required>
                                                        </div>
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Bouton pour activer/désactiver -->
                                    @if ($agency->is_active)
                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deactivateAgencyModal{{ $agency->id }}">
                                        <i class="bi bi-toggle-off"></i>   Désactiver
                                    </button>
                                    @else
                                    <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#activateAgencyModal{{ $agency->id }}">
                                        <i class="bi bi-toggle-on"></i>   Activer
                                    </button>
                                    @endif

                                    <!-- Modal d'activation -->
                                    <div class="modal fade" id="activateAgencyModal{{ $agency->id }}" tabindex="-1" aria-labelledby="activateAgencyModalLabel{{ $agency->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{ route('agencies.toggleStatus', $agency->id) }}" method="POST">
                                                @csrf
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="activateAgencyModalLabel{{ $agency->id }}">Activer l'agence</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="fin_validite" class="form-label">Date de fin de validité</label>
                                                        <input type="date" class="form-control" id="fin_validite" name="fin_validite" required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary">Activer</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    </div>

                                    <!-- Modal de désactivation -->
                                    <div class="modal fade" id="deactivateAgencyModal{{ $agency->id }}" tabindex="-1" aria-labelledby="deactivateAgencyModalLabel{{ $agency->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{ route('agencies.toggleStatus', $agency->id) }}" method="POST">
                                                @csrf
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deactivateAgencyModalLabel{{ $agency->id }}">Désactiver l'agence</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Êtes-vous sûr de vouloir désactiver cette agence ? Cela désactivera également tous les utilisateurs associés.</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-danger">Désactiver</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    </div>


                                    {{-- <!-- Bouton de déclenchement pour le modal de suppression -->
                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteAgencyModal{{ $agency->id }}">
                                        <i class="bi bi-trash"></i> Supprimer
                                    </button>

                                    <!-- Modal de suppression -->
                                    <div class="modal fade" id="deleteAgencyModal{{ $agency->id }}" tabindex="-1" aria-labelledby="deleteAgencyModalLabel{{ $agency->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteAgencyModalLabel{{ $agency->id }}">Supprimer l'Agence</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Êtes-vous sûr de vouloir supprimer cette agence ?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                    <form action="{{ route('agencies.destroy', $agency->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Supprimer</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div> --}}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">Aucune agence trouvée!</td>
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
