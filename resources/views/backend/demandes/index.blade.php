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
                                    <th>Lieu Depart</th>
                                    <th>Lieu Arrivée</th>
                                    <th>Date Depart</th>
                                    <th>Date Arrivée</th>
                                    <th>Num Ordre Mission</th>
                                    <th>Durée</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            @foreach ($demandes as $demande)
                                <tbody>
                                    <tr>
                                        <td>{{ $demande->id }}</td>
                                        <td>{{ $demande->lieuDepart }}</td>
                                        <td>{{ $demande->lieuArrivee }}</td>
                                        <td>{{ $demande->DateDepart }}</td>
                                        <td>{{ $demande->DateArrivee }}</td>
                                        <td>{{ $demande->numeroOrdreMission }}</td>
                                        <td>{{ $demande->duree }}</td>
                                        <td>
                                            <button type="button" class="btn btn-warning btn-sm">
                                                <a href="{{ route('demandes.show', $demande) }}">
                                                    <i class="bi bi-eye"></i> Détails
                                                </a>
                                            </button>
                                            <button type="button" class="btn btn-warning btn-sm">
                                                <a href="{{ route('offres.offre', $demande) }}">
                                                    <i class="bi bi-eye"></i> Faire une offre
                                                </a>
                                            </button>
                                            <button type="button" class="btn btn-warning btn-sm">
                                                <a href="{{ route('demandes.edit', $demande) }}">
                                                    <i class="bi bi-eye"></i> Modifier
                                                </a>
                                            </button>
                                            <button type="button" class="btn btn-warning btn-sm">
                                                <a href="{{ route('demandes.destroy', $demande) }}">
                                                    <i class="bi bi-eye"></i> Supprimer
                                                </a>
                                            </button>


                                            <!-- Bouton de déclenchement -->
                                            <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal"
                                                data-bs-target="#activateOffreModal{{ $demande->id }}">
                                                <i class="bi bi-toggle-on"></i> Faire offre
                                            </button>

                                            <!-- Modal d'activation -->
                                            <div class="modal fade" id="activateOffreModal{{ $demande->id }}"
                                                tabindex="-1" aria-labelledby="activateOffreModalLabel{{ $demande->id }}"
                                                aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h2 class="modal-title"
                                                                id="activateOffreModalLabel{{ $demande->id }}">
                                                                Faire une offre</h2>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form method="POST" action="{{ route('offres.store') }}">

                                                                @csrf

                                                                <button type="submit"
                                                                    class="btn btn-flat btn-primary">Enregistrer</button>

                                                                <div>
                                                                    <div class="col-lg-12 col-md-12 m-auto">

                                                                        <div class="row">
                                                                            <div class="form-group  m-auto">
                                                                                <label>Code demande:</label>

                                                                                <div class="input-group">
                                                                                    <div class="input-group-prepend">
                                                                                        <span class="input-group-text"><i
                                                                                                class="fas fa-vote-yea"></i></span>
                                                                                    </div>
                                                                                    <input type="text" name="demande_id"
                                                                                        value="{{ $demande->id }}"
                                                                                        class="form-control" readonly>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group  m-auto">
                                                                                <label>Prix :</label>

                                                                                <div class="input-group">
                                                                                    <div class="input-group-prepend">
                                                                                        <span class="input-group-text"><i
                                                                                                class="fas fa-money-check-alt"></i></span>
                                                                                    </div>
                                                                                    <input type="number" name="prixBillet"
                                                                                        class="form-control">
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row mt-4">
                                                                            <div class="form-group  m-auto">
                                                                                <label>Date Debut Offre:</label>

                                                                                <div class="input-group">
                                                                                    <div class="input-group-prepend">
                                                                                        <span class="input-group-text"><i
                                                                                                class="far fa-calendar-alt"></i></span>
                                                                                    </div>
                                                                                    <input type="date"
                                                                                        name="dateDebutValidite"
                                                                                        class="form-control"
                                                                                        data-inputmask-alias="datetime"
                                                                                        data-inputmask-inputformat="dd/mm/yyyy"
                                                                                        data-mask>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group m-auto">
                                                                                <label>Date Fin Offre:</label>

                                                                                <div class="input-group">
                                                                                    <div class="input-group-prepend">
                                                                                        <span class="input-group-text"><i
                                                                                                class="far fa-calendar-alt"></i></span>
                                                                                    </div>
                                                                                    <input type="date"
                                                                                        name="dateFinValidite"
                                                                                        class="form-control"
                                                                                        data-inputmask-alias="datetime"
                                                                                        data-inputmask-inputformat="dd/mm/yyyy"
                                                                                        data-mask>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="form-group mt-4">
                                                                            <label>Description de l'offre:</label>

                                                                            <div class="input-group">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text"></i><i
                                                                                            class="fas fa-info-circle"></i></span>
                                                                                </div>
                                                                                <textarea type="text" name="description" class="form-control"></textarea>
                                                                            </div>
                                                                        </div>

                                                                        <div class="form-group mt-4">
                                                                            <label>Certification sur l'honneur:</label>

                                                                            <div class="input-group">

                                                                                <input type="checkbox" name="engagement"
                                                                                    value="1" class="form-control"
                                                                                    required>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                        </div>
                                                        </form>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Annuler</button>

                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                        </td>
                                    </tr>
                                </tbody>
                            @endforeach

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
