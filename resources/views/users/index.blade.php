@extends('layouts.backend')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $totalUsers }}</h3>

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
                    <h3>{{ $usersWithoutAgence }}<sup style="font-size: 20px"></sup></h3>

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
                    <h3>{{ $usersWithAgence }}</h3>

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
                    <h3>{{ $disabledUsers }}</h3>

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
                        }, 6000); // Le message flash disparaîtra après 5 secondes (5000 millisecondes)
                </script>
                @endif
            </p>
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
                                <td>{{ $user->created_at->translatedFormat('d M Y à H:i:s') }}</td>
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
                                    {{ $role }}
                                    @empty
                                    <span>N/A</span>
                                    @endforelse
                                </td>
                                <td>
                                    <!-- Bouton de déclenchement pour le modal de détails -->
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#simpleDetailModal{{ $user->id }}">
                                        <i class="bi bi-eye"></i> Détails
                                    </button>
                                    <!-- Modal de détails -->
                                    <!-- Modal de détails simplifié -->
                                    <div class="modal fade" id="simpleDetailModal{{ $user->id }}" tabindex="-1"
                                        aria-labelledby="simpleDetailModalLabel{{ $user->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <!-- Augmentation de la taille avec modal-lg -->
                                            <div class="modal-content">
                                                <div class="modal-header bg-gray-dark text-white">
                                                    <h5 class="modal-title" id="simpleDetailModalLabel{{ $user->id }}">
                                                        Détails de l'Utilisateur</h5>
                                                    <button type="button" class="btn-close btn-close-white"
                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body bg-light">
                                                    <div class="row">

                                                        @if ($user->agenceAcredite)
                                                        <!-- Nom et Email -->
                                                        <div class="col-md-6 mb-3">
                                                            <i class="bi bi-person-fill me-2"></i><strong>Nom :</strong>
                                                            {{ $user->name }}
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <i class="bi bi-envelope-fill me-2"></i><strong>Email
                                                                :</strong> {{ $user->email }}
                                                        </div>

                                                        <!-- Téléphone et Adresse de l'Agence (si applicable) -->
                                                        <div class="col-md-6 mb-3">
                                                            <i class="bi bi-telephone-fill me-2"></i><strong>Téléphone
                                                                :</strong> {{ $user->telephone }}
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <i class="bi bi-building me-2"></i><strong>Adresse de
                                                                l'Agence :</strong> {{
                                                            $user->agenceAcredite->adressAgence }}
                                                        </div>

                                                        <!-- Numéro IFU et Date de Création de l'Agence -->
                                                        <div class="col-md-6 mb-3">
                                                            <i class="bi bi-hash me-2"></i><strong>Numéro IFU :</strong>
                                                            {{ $user->agenceAcredite->numeroIfu }}
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <i class="bi bi-calendar-event-fill me-2"></i><strong>Date
                                                                de Création de l'Agence :</strong> {{
                                                            $user->agenceAcredite->dateCreationAgence }}
                                                        </div>

                                                        <!-- RCCM -->
                                                        <div class="col-12 mb-3">
                                                            <i class="bi bi-file-earmark-pdf-fill me-2"></i><strong>RCCM
                                                                :</strong>
                                                            <a href="{{ asset('storage/' . str_replace('public/', '', $user->agenceAcredite->rccm)) }}"
                                                                class="btn btn-info btn-sm" target="_blank">
                                                                <i class="bi bi-download"></i> Télécharger RCCM
                                                            </a>
                                                        </div>
                                                        @else
                                                        <!-- Nom et Email -->
                                                        <div class="col-md-6 mb-3">
                                                            <i class="bi bi-person-fill me-2"></i><strong>Nom :</strong>
                                                            {{ $user->name }}
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <i class="bi bi-envelope-fill me-2"></i><strong>Email
                                                                :</strong> {{ $user->email }}
                                                        </div>

                                                        <!-- Téléphone et Adresse de l'Agence (si applicable) -->
                                                        <div class="col-md-6 mb-3">
                                                            <i class="bi bi-telephone-fill me-2"></i><strong>Téléphone
                                                                :</strong> {{ $user->telephone }}
                                                        </div>
                                                        <!-- Matricule -->
                                                        <div class="col-md-6 mb-3">
                                                            <i class="bi bi-person-badge-fill me-2"></i><strong>Matricule
                                                                :</strong> {{ $user->matricule }}
                                                        </div>

                                                        <!-- Ministère -->
                                                        <div class="col-md-6 mb-3">
                                                            <i class="bi bi-building me-2"></i><strong>Ministère :
                                                                @foreach ($ministeres as $min)

                                                            </strong> {{ $user->id_m==$min->id ? $min->libelleLong : ''
                                                            }}
                                                            @endforeach
                                                        </div>

                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="modal-footer bg-dark-primary">
                                                    <button type="button" class="btn btn-dark"
                                                        data-bs-dismiss="modal">Fermer</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>



                                    @can('edit-user')
                                    @if($user->is_active == 1)
                                    <!-- Bouton de déclenchement -->
                                    <button type="button" class="btn btn-sm btn-secondary" data-bs-toggle="modal"
                                        data-bs-target="#deactivateUserModal{{ $user->id }}">
                                        <i class="bi bi-toggle-off"></i> Désactiver
                                    </button>

                                    <!-- Modal de désactivation -->
                                    <div class="modal fade" id="deactivateUserModal{{ $user->id }}" tabindex="-1"
                                        aria-labelledby="deactivateUserModalLabel{{ $user->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title"
                                                        id="deactivateUserModalLabel{{ $user->id }}">Confirmer la
                                                        Désactivation</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Êtes-vous sûr de vouloir désactiver cet utilisateur ?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Annuler</button>
                                                    <form action="{{ route('users.toggleStatus', $user->id) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit"
                                                            class="btn btn-primary">Désactiver</button>
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
                                    <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal"
                                        data-bs-target="#activateUserModal{{ $user->id }}">
                                        <i class="bi bi-toggle-on"></i> Activer
                                    </button>

                                    <!-- Modal d'activation -->
                                    <div class="modal fade" id="activateUserModal{{ $user->id }}" tabindex="-1"
                                        aria-labelledby="activateUserModalLabel{{ $user->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="activateUserModalLabel{{ $user->id }}">
                                                        Confirmer l'Activation</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Êtes-vous sûr de vouloir activer cet utilisateur ?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Annuler</button>
                                                    <form action="{{ route('users.toggleStatus', $user->id) }}"
                                                        method="post">
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
                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#deleteUserModal{{ $user->id }}">
                                        <i class="bi bi-trash"></i> Supprimer
                                    </button>

                                    <!-- Modal de suppression -->
                                    <div class="modal fade" id="deleteUserModal{{ $user->id }}" tabindex="-1"
                                        aria-labelledby="deleteUserModalLabel{{ $user->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteUserModalLabel{{ $user->id }}">
                                                        Confirmer la Suppression</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Êtes-vous sûr de vouloir supprimer cet utilisateur ?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Annuler</button>
                                                    <form action="{{ route('users.destroy', $user->id) }}"
                                                        method="post">
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
