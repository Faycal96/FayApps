@extends('layouts.backend')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Gestion des Utilisateurs</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nom</th>
                                <th>Email</th>
                                <th>Identité</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @forelse ($user->getRoleNames() as $role)
                                        <span class="badge bg-primary">{{ $role }}</span>
                                    @empty
                                        <span>N/A</span>
                                    @endforelse
                                </td>
                                <td>
                                    <!-- Exemple de boutons d'action -->
                                    <a href="{{ route('users.show', $user->id) }}" class="btn btn-warning btn-sm"><i class="bi bi-eye"></i> Afficher</a>
                                    
                                    @can('edit-user')
                                    @if($user->is_active == 1)
                                        <!-- Bouton de déclenchement -->
                                        <button type="button" class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#deactivateUserModal{{ $user->id }}">
                                            <i class="bi bi-toggle-off"></i> Désactiver
                                        </button>
                                
                                        <!-- Modal de désactivation -->
                                        <div class="modal fade" id="deactivateUserModal{{ $user->id }}" tabindex="-1" aria-labelledby="deactivateUserModalLabel{{ $user->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deactivateUserModalLabel{{ $user->id }}">Confirmer la Désactivation</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Êtes-vous sûr de vouloir désactiver cet utilisateur ?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                        <form action="{{ route('users.toggleStatus', $user->id) }}" method="post">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" class="btn btn-primary">Désactiver</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endcan
                                @can('edit-user')
    @if($user->is_active == 0)
        <!-- Bouton de déclenchement -->
        <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#activateUserModal{{ $user->id }}">
            <i class="bi bi-toggle-on"></i> Activer
        </button>

        <!-- Modal d'activation -->
        <div class="modal fade" id="activateUserModal{{ $user->id }}" tabindex="-1" aria-labelledby="activateUserModalLabel{{ $user->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="activateUserModalLabel{{ $user->id }}">Confirmer l'Activation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Êtes-vous sûr de vouloir activer cet utilisateur ?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <form action="{{ route('users.toggleStatus', $user->id) }}" method="post">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-primary">Activer</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endcan

                                    
@can('delete-user')
<!-- Bouton de déclenchement -->
<button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteUserModal{{ $user->id }}">
    <i class="bi bi-trash"></i> Supprimer
</button>

<!-- Modal de suppression -->
<div class="modal fade" id="deleteUserModal{{ $user->id }}" tabindex="-1" aria-labelledby="deleteUserModalLabel{{ $user->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteUserModalLabel{{ $user->id }}">Confirmer la Suppression</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Êtes-vous sûr de vouloir supprimer cet utilisateur ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <form action="{{ route('users.destroy', $user->id) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Supprimer</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endcan

                                   
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">Aucun utilisateur trouvé!</td>
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