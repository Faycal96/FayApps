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
                    <div class="card-header">Liste des Offres</div>
                    <div class="card-body">
                        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addOffreModal">
                            Ajouter une nouvelle offre
                        </button>
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Code Demande</th>
                                    <th>Prix Minimum</th>

                                    <th>Date Debut Offre</th>
                                    <th>Date Fin Offre</th>
                                    <th>Description</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($offres as $offre)
                                @if ($offre->agence->user_id == auth()->id())
                                <tr>
                                    <td>{{ $offre->code_offre}}</td>

                                    <td>{{ $offre->prixBillet }}</td>

                                    <td>{{ \Carbon\Carbon::parse($offre->dateDebutValidite)->format('d M Y à H:i:s') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($offre->dateFinValidite)->format('d M Y à H:i:s') }}</td>

                                    <td>{{ $offre->description }}</td>
                                    <td>
                                        <!-- Edit Button -->
                                        <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#editOffreModal{{ $offre->id }}">
                                            Modifier
                                        </button>

                                        <!-- Delete Button -->
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteOffreModal{{ $offre->id }}">
                                            Supprimer
                                        </button>
                                    </td>
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
@endsection
