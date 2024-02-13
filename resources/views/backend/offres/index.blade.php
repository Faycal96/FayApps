@extends('layouts.backend')

@section('content')
    <div class="container-fluid">


    @if (isset(Auth::user()->agence))

    <div class="row">
        <div class="col-lg-4">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $nombreOffres }}</h3>
                    @if ($nombreOffres <= 1)
                    <p>Proposition au totale</p>
                    @else
                    <p>Propositions au totales</p>
                    @endif

                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="#" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4">
            <!-- small box -->
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $nombreOfrresValidees }}</h3>
                    @if ($nombreOfrresValidees <= 1)
                    <p>Proposition Retenue</p>
                    @else
                    <p>Propositions Retenues</p>
                    @endif

                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="#" class="small-box-footer"> <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->

        <!-- ./col -->
        <div class="col-lg-4">
            <!-- small box -->
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $nombreOfrresRejettees }}</h3>
                    @if ($nombreOfrresRejettees <= 1)
                    <p>Proposition non Retenue</p>
                    @else
                    <p>Propositions non Retenues</p>
                    @endif

                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
                <a href="#" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
    </div>


    @else
    @endif

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">Liste des Offres</div>
                    <div class="card-body">

                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Code Demande</th>
                                    <th>Prix Minimum</th>
                                    <th>Validité</th>
                                    <th>Observation</th>
                                    <th>statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($offres as $offre)
                                @if ($offre->agence->user_id == auth()->id())
                                <tr>
                                    <td>{{ $offre->code_offre}}</td>

                                    <td>{{ $offre->prixBillet }}</td>

                                    {{-- <td>{{ \Carbon\Carbon::parse($offre->dateDebutValidite)->format('d M Y à H:i:s') }}</td> --}}
                                    <td>{{ \Carbon\Carbon::parse($offre->dateFinValidite)->format('d M Y à H:i:s') }}</td>

                                    <td>{{ $offre->description }}</td>
                                    @if ($offre->etats == "validée")
                                        <td> <span class="badge bg-success">Validée</span></td>
                                    @else
                                        <td><span class="badge bg-warning">En attente</span></td>
                                    @endif


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
