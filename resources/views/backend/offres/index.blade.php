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
                            }, 5000); // Le message flash disparaîtra après 5 secondes (5000 millisecondes)
                    </script>
                    @endif
                    </p>
                    <div class="card-header">Liste des Offres</div>
                    <div class="card-body">

                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Reference</th>
                                    <th>Prix</th>
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

                                    <td>{{ $offre->PrixTotal }}</td>

                                    {{-- <td>{{ \Carbon\Carbon::parse($offre->dateDebutValidite)->format('d M Y à H:i:s') }}</td> --}}
                                    <td>{{ \Carbon\Carbon::parse($offre->dateFinValidite)->format('d M Y à H:i:s') }}</td>

                                    <td>{{ $offre->description }}</td>
                                    @if ($offre->etats == "validée")
                                        <td> <span class="badge bg-success">Validée</span>
                                        </td>

                                    @elseif ($offre->etats == "rejetée")
                                        <td><span class="badge bg-danger">Non retenue</span></td>
                                        @else
                                        <td><span class="badge bg-warning">En attente</span></td>
                                    @endif

                                    <td>
                                        <!-- Edit Button -->
                                        <button type="button" class="btn btn-sm btn-primary">
                                            <i class="fas fa-eye"></i>
                                        </button>

                                        @if ($offre->etats == "validée")
                                        <a class="btn btn-success text-white" href="{{ Storage::url($offre->participants) }}" target="_blank"><b><i class=" bi bi-download"></i>
                                            Télécharger</b>
                                        </a>

                                        <button title="Joindre le Routing" type="file"  data-toggle="modal" data-target="#modal-default" class="btn btn-warning text-white"><i class="bi bi-file-pdf"></i></button>

                                        @endif

                                        {{-- <a data-toggle="modal" data-target="#" type="button" title="Joindre le Routing"
                                            class="btn btn-warning">
                                            <i class="bi bi-upload"></i>
                                        </a> --}}

                                           {{-- Modal pour la liste des participants --}}
                                           <div class="modal fade" id="modal-default">
                                            <div class="modal-dialog">
                                              <div class="modal-content">
                                                <div class="modal-header">
                                                  <h4 class="modal-title">Joindre le Routing</h4>
                                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                  </button>
                                                </div>
                                                <form  action="{{ route('upload.routing', ['id' =>$offre->id, 'currentStatus' => $offre->etats ] ) }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <p>Le Routing </p>
                                                        <input name="file_routing" type="file" class="form-control border-primary">
                                                    </div>
                                                    <div class="modal-footer justify-content-between">
                                                        <button type="button" class="btn btn-warning" data-dismiss="modal">Fermer</button>
                                                        <button type="submit" class="btn btn-success">Joindre</button>
                                                    </div>
                                                </form>
                                              </div>
                                              <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                          </div>
                                          <!-- /.modal -->


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
