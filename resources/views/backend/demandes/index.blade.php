@extends('layouts.backend')

@section('content')
<div class="container-fluid">
    @if (isset(Auth::user()->agence))
    <div class="row">
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>150</h3>

                    <p>Total de mes Propositions</p>
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

                    <p>Propositions Retenues</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="#" class="small-box-footer"> <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        {{-- <div class="col-lg-3 col-6">
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
        </div> --}}
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>65</h3>

                    <p>Propositions rejettées</p>
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
    <div class="row">
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>150</h3>

                    <p>Total Demandes</p>
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
                    <h3>53</h3>

                    <p>Total offres retenues </p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="#" class="small-box-footer"> <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->

        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>65</h3>

                    <p>Total Demandes sans Offres</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
                <a href="#" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
    </div>
    @endif



    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Gestion des demandes</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    {{-- Bouton pour ouvrir le modal de création de demande --}}
                    @canany(['create-demande-billet'])
                    <div class="col-3 offset-7">
                        <button type="button" class="btn btn-success btn-sm my-2" data-bs-toggle="modal"
                            data-bs-target="#newDemandeModal">
                            <i class="bi bi-plus-circle"></i> Faire une nouvelle demande
                        </button>
                    </div>

                    @endcanany


                    {{-- Modal pour la création d'une nouvelle demande --}}
                    <div class="modal fade" id="newDemandeModal" tabindex="-1" aria-labelledby="newDemandeModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header bg-gray-dark text-white">
                                    <h5 class="modal-title" id="newDemandeModalLabel">Faire une nouvelle demande</h5>

                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form method="POST" action="{{ route('demandes.store') }}">
                                    @csrf
                                    <div class="modal-body">
                                        <h6 class="text-center"> <span class="text-danger "> Les champs précédés
                                                d'étoile rouge sont obligatoires</span> </h6>
                                        <div class="row">
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label>Numero Ordre de Mission</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i
                                                            class="fas fa-file-alt"></i></span>
                                                    <input type="text" name="numeroOrdreMission" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label>Lieu Départ <sup class="text-danger">*</sup> </label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i
                                                            class="fas fa-map-marker-alt"></i></span>
                                                    <input type="text" name="lieuDepart" class="form-control">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">

                                            <div class=" col-md-6 form-group">
                                                <label>Minimal</label>
                                                <select class="form-control select2bs4" style="width: 100%;">
                                                    <option selected="selected">Alabama</option>
                                                    <option>Alaska</option>
                                                    <option>California</option>
                                                    <option>Delaware</option>
                                                    <option>Tennessee</option>
                                                    <option>Texas</option>
                                                    <option>Washington</option>
                                                </select>
                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label>Lieu d'Arrivée <sup class="text-danger">*</sup></label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i
                                                            class="fas fa-map-marker-alt"></i></span>
                                                    <input type="text" name="lieuArrivee" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label>Date de depart <sup class="text-danger">*</sup></label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i
                                                            class="fas fa-calendar-alt"></i></span>
                                                    <input type="date" name="dateDepart" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label>Date de retour <sup class="text-danger">*</sup></label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i
                                                            class="fas fa-calendar-check"></i></span>
                                                    <input type="date" name="dateArrivee" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label>Délai de Reception en Heures <sup
                                                        class="text-danger">*</sup></label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                                    <input type="number" name="duree" value="24" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 form-group">
                                                <label>Besoin specifique:</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i
                                                            class="fas fa-align-left"></i></span>
                                                    <textarea name="description" class="form-control"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"> <i
                                                class="bi bi-x"></i> Annuler</button>
                                        <button type="submit" class="btn btn-success"> <i
                                                class="bi bi-check"></i>Enregistrer</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>



                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Num Ordre Mission</th>
                                <th>Lieu Depart</th>
                                <th>Lieu Arrivée</th>
                                <th>Date Depart</th>
                                <th>Date Retour</th>
                                <th>statut</th>
                                <th>Délai de Reception</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        @foreach ($demandes as $demande)
                        <tbody>
                            @if ($demande->user_id == auth()->id() || auth()->user()->hasRole(['Agence Voyage']))
                            <tr>
                                <td>{{ $demande->id }}</td>
                                <td>{{ $demande->numeroOrdreMission }}</td>
                                <td>{{ $demande->lieuDepart }}</td>
                                <td>{{ $demande->lieuArrivee }}</td>


                                <td>{{ \Carbon\Carbon::parse($demande->dateDepart)->format('d M Y à H:i:s') }}</td>
                                <td>{{ \Carbon\Carbon::parse($demande->dateArrivee)->format('d M Y à H:i:s') }}</td>
                                @if ($demande->etat ==1)

                                <td> <span class="badge bg-success">En cours</span></td>
                                @else
                                <td><span class="badge bg-danger">Fermée</span></td>
                                @endif


                                <td>{{ $demande->duree.'Heures' }}</td>
                                <td>
                                    <!-- Bouton pour ouvrir le modal de détails -->
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#detailDemandeModal">
                                        <i class="bi bi-eye"></i> Détails
                                    </button>
                                    <!-- Modal de détails de la demande -->
                                    <div class="modal fade" id="detailDemandeModal" tabindex="-1"
                                        aria-labelledby="detailDemandeModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header bg-gray-dark text-white">
                                                    <h5 class="modal-title" id="detailDemandeModalLabel">Détails de la
                                                        Demande</h5>
                                                    <button type="button" class="btn-close btn-close-white"
                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body bg-light">
                                                    <div class="row">
                                                        <!-- Numéro Ordre de Mission et Lieu Départ -->
                                                        <div class="col-md-6 mb-3">
                                                            <i class="bi bi-file-earmark-text me-2"></i><strong>Numéro
                                                                Ordre de Mission :</strong> {{
                                                            $demande->numeroOrdreMission }}
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <i class="bi bi-geo-alt me-2"></i><strong>Lieu Départ
                                                                :</strong> {{ $demande->lieuDepart }}
                                                        </div>

                                                        <!-- Lieu Arrivée et Date Départ -->
                                                        <div class="col-md-6 mb-3">
                                                            <i class="bi bi-geo me-2"></i><strong>Lieu Arrivée
                                                                :</strong> {{ $demande->lieuArrivee }}
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <i class="bi bi-calendar-event me-2"></i><strong>Date Départ
                                                                :</strong> {{
                                                            \Carbon\Carbon::parse($demande->dateDepart)->format('d/m/Y')
                                                            }}
                                                        </div>

                                                        <!-- Date Arrivée et Durée -->
                                                        <div class="col-md-6 mb-3">
                                                            <i class="bi bi-calendar-check me-2"></i><strong>Date
                                                                Arrivée :</strong> {{
                                                            \Carbon\Carbon::parse($demande->dateArrivee)->format('d/m/Y')
                                                            }}
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <i class="bi bi-hourglass-split me-2"></i><strong>Durée
                                                                :</strong> {{ $demande->duree }}
                                                        </div>


                                                        <!-- Description du besoin -->
                                                        <div class="col-12 mb-3">
                                                            <i class="bi bi-textarea-t me-2"></i><strong>Description du
                                                                besoin :</strong> {{ $demande->description }}
                                                        </div>
                                                        {{--
                                                        <!-- Description du besoin -->
                                                        <div class="col-12 mb-3">
                                                            <i class="bi bi-textarea-t me-2"></i><strong>Description du
                                                                besoin :</strong> {{ $demande->prix_minimum }}
                                                        </div> --}}
                                                        {{-- @if($demande->offres->isNotEmpty())
                                                        <div>Prix minimum: {{ $demande->offres->first()->prixBillet }}
                                                        </div>
                                                        @else
                                                        <div>Pas d'offres disponibles</div>
                                                        @endif --}}
                                                    </div>
                                                </div>
                                                <div class="modal-footer bg-dark-primary">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Fermer</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    @if($demande->offres->isEmpty() )
                                    @canany(['create-demande-billet'])

                                    <button type="button" class="btn btn-warning btn-sm">
                                        <a class="text-white" href="{{ route('demandes.edit', $demande) }}">
                                            <i class="bi bi-pencil-square"></i> Modifier
                                        </a>
                                    </button>

                                    @endcanany
                                    @endif

                                    @if($demande->offres->isNotEmpty() && $demande->etat ==0)

                                    @canany(['create-demande-billet'])

                                    <button type="button" class="btn btn-info btn-sm">
                                        <a class="text-white" href="{{ route('demandes.show', $demande) }}">
                                            <i class="bi bi-pencil-square"></i> Voir l'offre
                                        </a>
                                    </button>
                                    @endcanany
                                    @endif
                                    @if($demande->offres->isEmpty())
                                    @canany(['create-demande-billet'])
                                    <!-- Bouton pour déclencher le modal de suppression d'une demande -->
                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#deleteDemandeModal{{ $demande->id }}">
                                        <i class="bi bi-trash"></i> Supprimer
                                    </button>

                                    <!-- Modal de suppression d'une demande -->
                                    <div class="modal fade" id="deleteDemandeModal{{ $demande->id }}" tabindex="-1"
                                        aria-labelledby="deleteDemandeModalLabel{{ $demande->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title"
                                                        id="deleteDemandeModalLabel{{ $demande->id }}">Confirmer la
                                                        Suppression</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Êtes-vous sûr de vouloir supprimer cette demande ?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Annuler</button>
                                                    <form action="{{ route('demandes.destroy', $demande->id) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Supprimer</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    @endcanany
                                    </button>
                                    @endif




                                    <!-- Bouton de déclenchement -->

                                    @if($demande->etat ==1)
                                    @canany(['propose-demande-billet'])
                                    <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal"
                                        data-bs-target="#activateOffreModal{{ $demande->id }}">
                                        <i class="bi bi-toggle-on"></i> Faire une offre
                                    </button>
                                    @endcanany
                                    @endif

                                    <!-- Button pour ouvrir la modal -->



                                    <!-- Modal d'activation -->
                                    <div class="modal fade" id="activateOffreModal{{ $demande->id }}" tabindex="-1"
                                        aria-labelledby="activateOffreModalLabel{{ $demande->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h2 class="modal-title"
                                                        id="activateOffreModalLabel{{ $demande->id }}">
                                                        Je Propose mon offre</h2>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="POST" action="{{ route('offres.store') }}">

                                                        @csrf

                                                        <div>
                                                            <div class="col-lg-12 col-md-12 m-auto">

                                                                <div class="row">
                                                                    <div class="col-6">
                                                                        <div class="form-group m-auto">
                                                                            <label>Code demande:</label>
                                                                            <div class="input-group">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text"><i
                                                                                            class="fas fa-vote-yea"></i></span>
                                                                                </div>
                                                                                <input type="text"
                                                                                    value="{{ $demande->code_demande }}"
                                                                                    class="form-control" readonly>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- Champ caché pour envoyer l'ID de la demande -->
                                                                    <input type="hidden" name="demande_id"
                                                                        value="{{ $demande->id }}">

                                                                    <div class="col-6">
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


                                                                </div>

                                                                <div class="row mt-4">
                                                                    {{-- <div class="form-group  m-auto">
                                                                        <label>Date Debut Offre:</label>

                                                                        <div class="input-group">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text"><i
                                                                                        class="far fa-calendar-alt"></i></span>
                                                                            </div>
                                                                            <input type="date" name="dateDebutValidite"
                                                                                class="form-control"
                                                                                data-inputmask-alias="datetime"
                                                                                data-inputmask-inputformat="dd/mm/yyyy"
                                                                                data-mask>
                                                                        </div>
                                                                    </div> --}}
                                                                    <div class="form-group m-auto">
                                                                        <label>Valable jusqu'au:</label>

                                                                        <div class="input-group">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text"><i
                                                                                        class="far fa-calendar-alt"></i></span>
                                                                            </div>
                                                                            <input type="date" name="dateFinValidite"
                                                                                class="form-control"
                                                                                data-inputmask-alias="datetime"
                                                                                data-inputmask-inputformat="dd/mm/yyyy"
                                                                                data-mask>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group mt-4">
                                                                    <label>Observation de l'offre:</label>

                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"></i><i
                                                                                    class="fas fa-info-circle"></i></span>
                                                                        </div>
                                                                        <textarea type="text" name="description"
                                                                            class="form-control"></textarea>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group mt-4">
                                                                    <label> <b>Certification sur l'honneur:</b></label>
                                                                    <span class="text-danger"> En cochant cette case, je
                                                                        m'engage sur la disponibilite du billet.</span>

                                                                    <div class="input-group">

                                                                        <input type="checkbox" name="engagement"
                                                                            value="1" class="form-control text-success"
                                                                            required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                </div>
                                                <div class="modal-footer">

                                                    <button type="button" class="btn btn-danger"
                                                        data-bs-dismiss="modal">Fermer</button>
                                                    <button type="submit"
                                                        class="btn btn-flat btn-success">Soumettre</button>

                                                </div>
                                                </form>


                                            </div>
                                        </div>
                                    </div>

                                </td>
                            </tr>
                            @endif
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
