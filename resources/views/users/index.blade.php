@extends('layouts.backend')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>150</h3>

                    <p>Total des utilisateurs</p>
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
                    <h3>53<sup style="font-size: 20px">%</sup></h3>

                    <p>Total DAF</p>
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
                    <h3>44</h3>

                    <p>Total Agence</p>
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

                    <p>Utilisateurs desactivés</p>
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
                                <th>Date creation</th>
                                <th>Nom</th>
                                <th>Email</th>
                                <th>Statut</th>
                                <th>Identité</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $user->created_at }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>

                                    @if($user->is_active == 1)
                                    <span class="badge bg-success">Activé</span>
                            @else 
                            <span class="badge bg-danger">Desactivé</span>
@endif
                                </td>

                                <td>
                                    @forelse ($user->getRoleNames() as $role)
                                        <span class="badge bg-primary">{{ $role }}</span>
                                    @empty
                                        <span>N/A</span>
                                    @endforelse
                                </td>
                                <td>
                                    <!-- Bouton de déclenchement pour le modal de détails -->
                                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#simpleDetailModal{{ $user->id }}">
                                                <i class="bi bi-eye"></i> Détails
                                            </button>
                                            <!-- Modal de détails -->
                                           <!-- Modal de détails simplifié -->
<div class="modal fade" id="simpleDetailModal{{ $user->id }}" tabindex="-1" aria-labelledby="simpleDetailModalLabel{{ $user->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #f8f9fa; border-bottom: 1px solid #e3e6f0;">
                <h5 class="modal-title" id="simpleDetailModalLabel{{ $user->id }}">Détails de l'utilisateur</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="background-color: #ffffff;">
                <p><strong>Nom :</strong> {{ $user->nom }}</p>
                <p><strong>Prénom :</strong> {{ $user->prenom }}</p>
                <p><strong>Email :</strong> {{ $user->email }}</p>
                <p><strong>Téléphone :</strong> {{ $user->telephone }}</p>
                <!-- Ajoutez d'autres détails ici selon le besoin -->
            </div>
            <div class="modal-footer" style="background-color: #f8f9fa; border-top: 1px solid #e3e6f0;">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>



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