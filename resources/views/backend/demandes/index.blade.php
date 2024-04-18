@extends('layouts.backend')

@section('content')
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
<div class="container-fluid">

    @if (isset(Auth::user()->agence))

    <div class="row">
        <div class="col-lg-4">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $nombreOffres }}</h3>
                    @if ($nombreOffres <= 1) <p>Proposition  totale</p>
                        @else
                        <p>Propositions  totales</p>
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
                    @if ($nombreOfrresValidees <= 1) <p>Proposition Retenue</p>
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

        <div class="col-lg-4">
            <!-- small box -->
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $nombreOfrresRejettees }}</h3>
                    @if ($nombreOfrresRejettees <= 1) <p>Propositions non Retenues</p>
                        @else
                        <p>Propositionss non Retenues</p>
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
    <div class="row">
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $nombreDemandes }}</h3>

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
                    <h3>{{ $nombreOffreRetenues }}</h3>

                    <p>Total Offres retenues </p>
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
                    <h3>{{ $nombreDemandesSansOffres }}</h3>

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
                    {{-- <div class="col-3 offset-7">
                        <button type="button" class="btn btn-success btn-sm my-2" data-bs-toggle="modal"
                            data-bs-target="#newDemandeModal">
                            <i class="bi bi-plus-circle"></i> Faire une nouvelle demande
                        </button>
                    </div> --}}



                    <div class="card card-light mx-auto col-md-11 shadow border-bottom-secondary collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title">Faire une Demande</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <a title="Faire une nouvelle Demande"
                                        class="d-sm-inline-block btn btn-success btn-icon-split">
                                        <span class="icon text-white">
                                            <i class="fas fa-plus"> Nouvelle Demande</i>
                                        </span>
                                    </a>
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            {{-- @livewire('demandes') --}}


                            <div>
                                {{-- @if(session()->has('erreur') && $password!='')
                                <div class="alert alert-warning" role="alert">
                                    <span><i class="fas fa-exclamation-triangle"></i>{{ ' '.session('erreur')
                                        }}</span>
                                </div>
                                @endif --}}
                                <form action="{{ route('demandes.store') }}" method="POST">
                                    @csrf
                                    <h6 class="text-center"><span class="text-danger">Les champs precedés d'étoile
                                            rouge
                                            sont obligatoires</span></h6>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label>Nombre de passager  <sup class="text-danger">*</sup>:</label>
                                                <div class="input-group">
                                                    {{-- <span class="input-group-text"><i
                                                            class="fas fa-file-alt"></i></span> --}}
                                                    <input type="number" name="nombrePassager"
                                                        wire:model='nombrePassager' class="form-control">
                                                </div>
                                            </div>
                                            <!-- Lieu de Départ avec icône -->
                                            <div class="col-md-6 form-group">
                                                <label>Source de financement <sup class="text-danger">*</sup> </label>
                                                <div class="input-group">
                                                    <input type="text" name="sourceFinancement"
                                                        class="form-control    value=" {{ old('sourceFinancement') }}"
                                                        autocomplete="off">
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label>Lieu de Départ <sup class="text-danger">*</sup></label>
                                                <div class="input-group">
                                                    {{-- <div class="input-group-prepend custom-prepend inline">
                                                        <span class="input-group-text">
                                                            <i class="fas fa-map-marker-alt"></i>
                                                            <!-- Icône FontAwesome -->
                                                        </span>
                                                    </div> --}}

                                                    <select wire:model='lieuDepart' name="lieuDepart" required
                                                        class="form-control select2bs4 custom-select"
                                                        value="{{ old('lieuDepart') }}" autocomplete="off"
                                                        style="width: 100%;">
                                                        <option value="">Veuillez sélectionner une Ville</option>
                                                        @foreach ($cities as $city)
                                                        <option>{{ $city->city.' - '.$city->country }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6 form-group">
                                                <label>Destination <sup class="text-danger">*</sup></label>
                                                <div class="input-group">
                                                    <select wire:model='lieuArrivee' name="lieuArrivee" required
                                                        class="form-control select2bs4 custom-select  "
                                                        value="{{ old('lieuArrivee') }}" autocomplete="off"
                                                        style="width: 100%;">
                                                        <option value="">Veuillez sélectionner une Ville</option>
                                                        @foreach ($cities as $city)
                                                        <option>{{ $city->city.' - '.$city->country }}</option>
                                                        @endforeach
                                                    </select>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label>Date de depart <sup class="text-danger">*</sup></label>
                                                <div class="input-group">
                                                    {{-- <span class="input-group-text"><i
                                                            class="fas fa-calendar-alt"></i></span> --}}
                                                    <input type="date" name="dateDepart" class="form-control"
                                                        value="{{ old('dateDepart') }}" autocomplete="off">
                                                </div>
                                            </div>

                                            <div class="col-md-6 form-group">
                                                <label>Date de retour <sup class="text-danger">*</sup></label>
                                                <div class="input-group">
                                                    {{-- <span class="input-group-text"><i
                                                            class="fas fa-calendar-check"></i></span> --}}
                                                    <input type="date" name="dateArrivee" class="form-control "
                                                        value="{{ old('dateArrivee') }}" autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">

                                            <div class="col-md-6 form-group">
                                                <label>Classe du Billet <sup class="text-danger">*</sup></label>
                                                <div class="input-group">
                                                    <select name="classe_billet" required
                                                        class="form-control custom-select @error('classe_billet') is-invalid @enderror"
                                                        value="{{ old('classe_billet') }}" autocomplete="off">
                                                        <option value="">Veuillez Choisir la classe su billet
                                                        </option>
                                                        <option value="economique">Économique</option>
                                                        <option value="affaire">Affaire</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6 form-group">
                                                <label>Délai de Reception des offres en Heures <sup
                                                        class="text-danger">*</sup></label>
                                                <div class="input-group">
                                                    {{-- <span class="input-group-text"><i
                                                            class="fas fa-clock"></i></span> --}}
                                                    <input type="number" name="duree" required
                                                        class="form-control @error('duree') is-invalid  @enderror"
                                                        value="{{ old('duree') }}" autocomplete="off">

                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="structure">Structure<sup class="text-danger">*</sup></label>
                                                <select name="structure" class="form-control" required>
                                                    <option value="">Sélectionnez une structure</option>
                                                    @foreach ($structures as $structure)
                                                        <option value="{{ $structure->libelleLong }}">{{ $structure->libelleLong }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            
                                            <div class="col-md-6 form-group">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label for="escale">Escale<sup class="text-danger">*</sup></label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="assurance">Assurance<sup class="text-danger">*</sup></label>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-check">
                                                            <input type="hidden" name="escale" value="0"> <!-- Valeur par défaut si la case n'est pas cochée -->
                                                            <input type="radio" name="escale" id="escale" class="form-check-input escale-trigger" value="1">
                                                            <label class="form-check-label" for="escale">Oui</label>
                                                            <span style="margin-right: 25px;"></span> <!-- Espacement entre les labels -->
                                                            <input type="radio" name="escale" id="escale-oui" class="form-check-input escale-trigger" value="1">
                                                            <label class="form-check-label" for="escale-oui">Non</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-check">
                                                            <input type="checkbox" name="assurance" id="assurance" class="form-check-input" value="1">
                                                            <label class="form-check-label" for="assurance">Oui</label>
                                                            <span style="margin-right: 25px;"></span> <!-- Espacement entre les labels -->
                                                            <input type="checkbox" name="assurance" id="assurance-non" class="form-check-input" value="0">
                                                            <label class="form-check-label" for="assurance-non">Non</label>
                                                    
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                       

                                        <div id="escaleFields" style="display: none;">
                                            <table class="table datatable table-bordered table-striped datatable-table">
                                                <thead class="dst-form-thead">
                                                    <tr>
                                                        <th colspan="3" style="text-align: center">Escale(s)</th>
                                                    </tr>
                                                    <tr>
                                                        <th>Lieu escale <span style="color:red">*</span></th>
                                                        <th>Durée <span style="color:red">*</span></th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <!-- Champs pour la première escale -->
                                                    <tr class="escale-field" id="escaleField1">
                                                        <td>
                                                            <select name="lieuEscale[]" id="lieuEscale1" required class="form-control lieuEscale" autocomplete="off">
                                                                <option value="">Veuillez sélectionner une Ville</option>
                                                                @foreach ($cities as $city)
                                                                    <option value="{{ $city->city }}">{{ $city->city.' - '.$city->country }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="number" name="dureeEscale[]" id="dureeEscale1" class="form-control dureeEscale">
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-xs" data-id="0" onclick="deleteRowCV(this)" title="Supprimer la ligne"> <i class="fa fa-trash text-danger"></i></button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="3">
                                                            {{-- <button type="button" id="addEscale" class="btn btn-primary" style="display: none;">Ajouter une escale</button> --}}
                                                            <a class="btn btn-default" id="addEscale" style="display: none">
                                                                <i class="fa fa-plus-circle text-success"></i>
                                                                <span>Ajouter un escale </span>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>                                        


                                        <div class="row">
                                            <div class="col-12 form-group">
                                                <label>Autres Informations</label>
                                                <div class="input-group">
                                                    {{-- <span class="input-group-text"><i
                                                            class="fas fa-align-left"></i></span> --}}
                                                    <textarea name="description" required
                                                        class="form-control @error('description') is-invalid @enderror"
                                                        value="{{ old('description') }}" autocomplete="off"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger"
                                            data-bs-dismiss="modal">Annuler</button>
                                        <button type="submit" class="btn btn-success">Enregistrer</button>
                                    </div>
                                </form>

                            </div>

                        </div>
                    </div>
                    @endcanany


                    {{-- Modal pour la création d'une nouvelle demande --}}
                    <div class="modal fade" id="newDemandeModal" tabindex="-1" aria-labelledby="newDemandeModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header bg-gray-dark text-white">
                                    <h5 class="modal-title" id="newDemandeModalLabel">Faire une nouvelle demande
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form method="POST" action="{{ route('demandes.store') }}">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label>Lieu de Départ <sup class="text-danger">*</sup></label>
                                                <div class="input-group">
                                                    {{-- <div class="input-group-prepend custom-prepend inline">
                                                        <span class="input-group-text">
                                                            <i class="fas fa-map-marker-alt"></i>
                                                            <!-- Icône FontAwesome -->
                                                        </span>
                                                    </div> --}}

                                                    <select wire:model='lieuDepart' name="lieuDepart" required
                                                        class="form-control select2bs4 custom-select"
                                                        value="{{ old('lieuDepart') }}" autocomplete="off"
                                                        style="width: 100%;">
                                                        <option value="">Veuillez sélectionner une Ville</option>
                                                        @foreach ($cities as $city)
                                                        <option>{{ $city->city }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label>Numero Ordre de Mission:</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i
                                                            class="fas fa-file-alt"></i></span>
                                                    <input type="text" name="numeroOrdreMission" class="form-control">
                                                </div>
                                            </div>
                                            <!-- Lieu de Départ avec icône -->
                                            <div class="col-md-6 form-group">
                                                <label>Lieu Départ <sup class="text-danger">*</sup></label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="fas fa-map-marker-alt"></i>
                                                            <!-- Icône FontAwesome -->
                                                        </span>
                                                    </div>
                                                    <select name="lieuDepart" required
                                                        class="form-control custom-select">
                                                        @foreach ($cities as $city)
                                                        <option value="{{ $city->city }}">{{ $city->city }} - {{
                                                            $city->country }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">

                                            <!-- Lieu d'Arrivée avec icône -->
                                            <div class="col-md-6 form-group">
                                                <label>Lieu Arrivée <sup class="text-danger">*</sup></label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="fas fa-map-marker-alt"></i>
                                                            <!-- Icône FontAwesome -->
                                                        </span>
                                                    </div>
                                                    <select name="lieuArrivee" required
                                                        class="form-control custom-select">
                                                        @foreach ($cities as $city)
                                                        <option value="{{ $city->city }}">{{ $city->city }} - {{
                                                            $city->country }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6 form-group">
                                                <label>Date de depart:</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i
                                                            class="fas fa-calendar-alt"></i></span>
                                                    <input type="date" name="dateDepart" required class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label>Date de retour:</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i
                                                            class="fas fa-calendar-check"></i></span>
                                                    <input type="date" required name="dateArrivee" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label>Delai de Reception:</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                                    <input type="text" name="duree" class="form-control" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label>Classe du Billet <sup class="text-danger">*</sup></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-plane"></i>
                                                        <!-- Icône FontAwesome pour la classe du billet -->
                                                    </span>
                                                </div>
                                                <select name="classe_billet" class="form-control custom-select"
                                                    required>
                                                    <option value="economique">Économique</option>
                                                    <option value="affaire">Affaire</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12 form-group">
                                                <label>Description du besoin:</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i
                                                            class="fas fa-align-left"></i></span>
                                                    <textarea name="description" class="form-control" required
                                                        placeholder="Merci de detailler vos besoins en specifiant votre compagnie de choix, si vous voulez des escales, et d'autres informations pertinentes "></textarea>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Annuler</button>
                                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>



                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Reference</th>
                                <th>Lieu Depart</th>
                                <th>Lieu Arrivée</th>
                                <th>Date Depart</th>
                                <th>Date Retour</th>
                                <th>Statut</th>
                                <th>Timing</th>
                                <th>Délai</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        @php
                        $i =1;
                        @endphp
                        @foreach ($demandes as $demande)
                        <tbody>
                            @if ($demande->user_id == auth()->id() || auth()->user()->hasRole(['Agence Voyage']))
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $demande->code_demande }}</td>
                                <td>{{ $demande->lieuDepart }}</td>
                                <td>{{ $demande->lieuArrivee }}</td>


                                <td>{{ \Carbon\Carbon::parse($demande->dateDepart)->format('d M Y ') }}</td>
                                <td>{{ \Carbon\Carbon::parse($demande->dateArrivee)->format('d M Y') }}</td>

                                @if ($demande->etat ==1)

                                <td> <span class="badge bg-success">En cours</span></td>
                                @else
                                <td><span class="badge bg-danger">Fermée</span></td>
                                @endif
                                <td>{{ $demande->created_at->diffForHumans() }}</td>

                                <td>{{ $demande->duree.' Heures' }}</td>
                                {{-- <td>{{
                                    \Carbon\Carbon::createFromTimestamp($demande->duree)->diffForHumans($demande->date_debut)
                                    }} Heures</td> --}}



                                <td>
                                    <!-- Bouton pour ouvrir le modal de détails -->
                                    <button title="Voir Détails" type="button" class="btn btn-primary btn-sm"
                                        data-bs-toggle="modal" data-bs-target="#detailDemandeModal{{ $demande->id }}">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <!-- Modal de détails de la demande -->
                                    <div class="modal fade" id="detailDemandeModal{{ $demande->id }}" tabindex="-1"
                                        aria-labelledby="detailDemandeModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header bg-gray-dark text-white">
                                                    <h5 class="modal-title"
                                                        id="detailDemandeModalLabel{{ $demande->id }}">Détails de
                                                        la
                                                        Demande</h5>
                                                    <button type="button" class="btn-close btn-close-white"
                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body bg-light">
                                                    <div class="row">
                                                         <!-- Lieu Départ -->
                                                         <div class="col-md-6 mb-3">
                                                            <label class="form-label"><i
                                                                    class="bi bi-geo-alt me-2"></i><strong>Lieu
                                                                    Départ
                                                                    :</strong></label>
                                                            <div class="input-group">
                                                                <input type="text" value="{{ $demande->lieuDepart }}"
                                                                    class="form-control" readonly>
                                                            </div>
                                                        </div>

                                                        <!-- Lieu Arrivée -->
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label"><i
                                                                    class="bi bi-geo me-2"></i><strong>Lieu Arrivée
                                                                    :</strong></label>
                                                            <div class="input-group">
                                                                <input type="text" value="{{ $demande->lieuArrivee }}"
                                                                    class="form-control" readonly>
                                                            </div>
                                                        </div>

                                                        <!-- Date Départ -->
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label"><i
                                                                    class="bi bi-calendar-event me-2"></i><strong>Date
                                                                    Départ :</strong></label>
                                                            <div class="input-group">
                                                                <input type="text"
                                                                    value="{{ \Carbon\Carbon::parse($demande->dateDepart)->format('d/m/Y') }}"
                                                                    class="form-control" readonly>
                                                            </div>
                                                        </div>

                                                        <!-- Date Arrivée -->
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label"><i
                                                                    class="bi bi-calendar-check me-2"></i><strong>Date
                                                                    Arrivée :</strong></label>
                                                            <div class="input-group">
                                                                <input type="text"
                                                                    value="{{ \Carbon\Carbon::parse($demande->dateArrivee)->format('d/m/Y') }}"
                                                                    class="form-control" readonly>
                                                            </div>
                                                        </div>

                                                       <!-- Nombre de passager -->
                                                     <div class="col-md-6 mb-3">
                                                        <label class="form-label"><i
                                                                class="bi bi-file-earmark-text me-2"></i><strong>Nombre de passager:</strong></label>
                                                        <div class="input-group">
                                                            <input type="text" value="{{ $demande->nombrePassager }}"
                                                                class="form-control" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label"><i
                                                                class="bi bi-building me-2"></i><strong>Structure:</strong></label>
                                                        <div class="input-group">
                                                            <input type="text" value="{{ $demande->structure }}"
                                                                class="form-control" readonly>
                                                        </div>
                                                    </div>

                                                        <!-- Durée -->
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label"><i
                                                                    class="bi bi-hourglass-split me-2"></i><strong>Delai
                                                                    de Reception :</strong></label>
                                                            <div class="input-group">
                                                                <input type="text"
                                                                    value="{{ $demande->duree.' Heures' }}"
                                                                    class="form-control" readonly>
                                                            </div>
                                                        </div>

                                                        <!-- Description du besoin -->
                                                        <div class="col-12 mb-3">
                                                            <label class="form-label"><i
                                                                    class="bi bi-textarea-t me-2"></i><strong>Description
                                                                    du besoin :</strong></label>
                                                            <div class="input-group">
                                                                <textarea class="form-control"
                                                                    readonly>{{ $demande->description }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer bg-dark-primary">
                                                    <button type="button" class="btn btn-danger"
                                                        data-bs-dismiss="modal">Fermer</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                </div>


                @if($demande->offres->isEmpty() && $demande->etat ==1)
                @canany(['create-demande-billet'])

                <button title="Modifier" type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                    data-bs-target="#modifDemandeModal{{ $demande->id }}">
                    <i class="bi bi-pencil-square"></i>

                </button>
                <div class="modal fade" id="modifDemandeModal{{ $demande->id }}" tabindex="-1"
                    aria-labelledby="detailDemandeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-gray-dark text-white">
                                <h5 class="modal-title" id="detailDemandeModalLabel">Modification de la demande</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form action="{{ route('demandes.update', ['demande' => $demande->id]) }}" method="POST">
                                @method('PUT')
                                @csrf
                                <div class="modal-body bg-light">
                                    <div class="row">
                                        <!-- Numéro Ordre de Mission -->
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label"><i
                                                    class="bi bi-file-earmark-text me-2"></i><strong>Numéro
                                                    Ordre de Mission :</strong></label>
                                            <div class="input-group">
                                                <input type="text" name="numeroOrdreMission"
                                                    value="{{ $demande->numeroOrdreMission }}" class="form-control">
                                            </div>
                                        </div>

                                        <!-- Lieu Départ -->
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label"><i class="bi bi-geo-alt me-2"></i><strong>Lieu
                                                    Départ
                                                    :</strong></label>

                                            <div class="input-group">

                                                <input type="text" name="lieuDepart" value="{{ $demande->lieuDepart }}"
                                                    class="form-control">
                                            </div>
                                        </div>

                                        <!-- Lieu Arrivée -->
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label"><i class="bi bi-geo me-2"></i><strong>Lieu Arrivée
                                                    :</strong></label>
                                            <div class="input-group">
                                                <input type="text" name="lieuArrivee"
                                                    value="{{ $demande->lieuArrivee }}" class="form-control">
                                            </div>
                                        </div>

                                        <!-- Date Départ -->
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label"><i
                                                    class="bi bi-calendar-event me-2"></i><strong>Date
                                                    Départ :</strong></label>
                                            <div class="input-group">
                                                {{-- <input type="date" name="dateDepart"
                                                    value="{{ $demande->dateDepart->format('d-m-Y') }}"
                                                    class="form-control"> --}}
                                                <input type="date" name="dateDepart"
                                                    value="{{ date('Y-m-d', strtotime($demande->dateDepart)) }}"
                                                    class="form-control">
                                            </div>
                                        </div>

                                        <!-- Date Arrivée -->
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label"><i
                                                    class="bi bi-calendar-check me-2"></i><strong>Date
                                                    Retour :</strong></label>
                                            <div class="input-group">
                                                <input type="date" name="dateArrivee"
                                                    value="{{ date('Y-m-d', strtotime($demande->dateArrivee)) }}"
                                                    class="form-control">
                                            </div>
                                        </div>

                                        <!-- Durée -->
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label"><i
                                                    class="bi bi-hourglass-split me-2"></i><strong>Delai
                                                    de Reception :</strong></label>
                                            <div class="input-group">
                                                <input type="number" name="duree" value="{{ $demande->duree }}"
                                                    class="form-control">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">Heures</span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Description du besoin -->
                                        <div class="col-12 mb-3">
                                            <label class="form-label"><i
                                                    class="bi bi-textarea-t me-2"></i><strong>Description
                                                    du besoin :</strong></label>
                                            <div class="input-group">
                                                <textarea name="description"
                                                    class="form-control">{{ $demande->description }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer bg-dark-primary">
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fermer</button>
                                    <button type="submit" class="btn btn-success">Mettre à jour</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


                @endcanany
                @endif

                @if($demande->etat ==0)

                @canany(['create-demande-billet'])

                <button type="button" class="btn btn-info btn-sm">
                    <a class="text-white" href="{{ route('demandes.show', $demande) }}">
                        <i class="bi bi-pencil-square"></i> Voir l'offre
                    </a>
                </button>
                @endcanany
                @endif
                @if($demande->offres->isEmpty() && $demande->etat ==1)
                @canany(['create-demande-billet'])
                <!-- Bouton pour déclencher le modal de suppression d'une demande -->
                <button title="Supprimer" type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                    data-bs-target="#deleteDemandeModal{{ $demande->id }}">
                    <i class="bi bi-trash"></i>
                </button>

                <!-- Modal de suppression d'une demande -->
                <div class="modal fade" id="deleteDemandeModal{{ $demande->id }}" tabindex="-1"
                    aria-labelledby="deleteDemandeModalLabel{{ $demande->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteDemandeModalLabel{{ $demande->id }}">Confirmer la
                                    Suppression</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Êtes-vous sûr de vouloir supprimer cette demande ?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                <form action="{{ route('demandes.destroy', $demande->id) }}" method="post">
                                    @csrf
                                    {{-- @method('DELETE') --}}
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
                @if ($demande->etat == 1)
                @canany(['propose-demande-billet'])
                <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal"
                    data-bs-target="#activateOffreModal{{ $demande->id }}">
                    <i class="bi bi-toggle-on"></i> Faire une offre
                </button>
                @endcanany
                @endif


                <!-- Modal d'activation -->
                <div class="modal fade" id="activateOffreModal{{ $demande->id }}" tabindex="-1"
                    aria-labelledby="activateOffreModalLabel{{ $demande->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h2 class="modal-title" id="activateOffreModalLabel{{ $demande->id }}">
                                    Je Propose mon offre</h2>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="{{ route('offres.store') }}"enctype="multipart/form-data">

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
                                                            <input type="text" value="{{ $demande->code_demande }}"
                                                                class="form-control" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Champ caché pour envoyer l'ID de la demande -->
                                                <input type="hidden" name="demande_id" value="{{ $demande->id }}">

                                                <div class="col-6">
                                                    <div class="form-group m-auto">
                                                        <label>Nombre de billet:</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i
                                                                        class="fas fa-plane"></i></span>
                                                            </div>
                                                            <input type="text" value="{{ $demande->nombrePassager }}"
                                                                class="form-control" readonly>
                                                        </div>
                                                    </div>
                                                </div>


                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group m-auto">
                                                        <label>Lieu de départ:</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i
                                                                        class="fas fa-map-marker-alt"></i></span>
                                                            </div>
                                                            <input type="text" value="{{ $demande->lieuDepart }}"
                                                                class="form-control" readonly>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Lieu d'arrivée -->
                                                <div class="col-6">
                                                    <div class="form-group m-auto">
                                                        <label>Lieu d'arrivée:</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i
                                                                        class="fas fa-map-marker-alt"></i></span>
                                                            </div>
                                                            <input type="text" value="{{ $demande->lieuArrivee }}"
                                                                class="form-control" readonly>
                                                        </div>
                                                    </div>
                                                </div>


                                            </div>
                                          

                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group  m-auto">
                                                        <label>Prix en F CFA <sup class="text-danger">*</sup> </label>

                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i
                                                                        class="fas fa-money-check-alt"></i></span>
                                                            </div>
                                                            <input type="number" name="prixBillet"
                                                                class="form-control is-valid" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <script>
                                                    document.getElementById('prix').addEventListener('input', function(e) {
                                                    // Supprime tous les caractères non numériques de la saisie
                                                    var prix = this.value.replace(/\D/g, '');

                                                    // Ajoute des espaces tous les trois caractères, en commençant par la fin
                                                    prix = prix.replace(/\B(?=(\d{3})+(?!\d))/g, ' ');

                                                    // Met à jour la valeur du champ de saisie avec le prix formaté
                                                    this.value = prix;
                                                });

                                                </script>

                                                <div class="col-6">
                                                    <div class="form-group m-auto">
                                                        <label>Valable jusqu'au <sup class="text-danger">*</sup></label>

                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i
                                                                        class="far fa-calendar-alt"></i></span>
                                                            </div>
                                                            <input type="date" name="dateFinValidite"
                                                                class="form-control" data-inputmask-alias="datetime"
                                                                data-inputmask-inputformat="dd/mm/yyyy" data-mask
                                                                required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group  m-auto">
                                                        <label>Prix Assurance en F CFA <sup class="text-danger">*</sup> </label>

                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i
                                                                        class="fas fa-money-check-alt"></i></span>
                                                            </div>
                                                            <input type="number" name="prixAssurance"
                                                                class="form-control is-valid" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <script>
                                                    document.getElementById('prix').addEventListener('input', function(e) {
                                                    // Supprime tous les caractères non numériques de la saisie
                                                    var prix = this.value.replace(/\D/g, '');

                                                    // Ajoute des espaces tous les trois caractères, en commençant par la fin
                                                    prix = prix.replace(/\B(?=(\d{3})+(?!\d))/g, ' ');

                                                    // Met à jour la valeur du champ de saisie avec le prix formaté
                                                    this.value = prix;
                                                });

                                                </script>

                                                <div class="col-md-6 form-group">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label for="escale">Escale<sup class="text-danger">*</sup></label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="assurance">Documents<sup class="text-danger">*</sup></label>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-check">
                                                                <input type="hidden" name="escale" value="0"> <!-- Valeur par défaut si la case n'est pas cochée -->
                                                                <input type="radio" name="escale" id="escale" class="form-check-input escaleOffre-trigger" value="1">
                                                                <label class="form-check-label" for="escale">Oui</label>
                                                                <span style="margin-right: 25px;"></span> <!-- Espacement entre les labels -->
                                                                <input type="radio" name="escale" id="escale-oui" class="form-check-input escaleOffre-trigger" value="0">
                                                                <label class="form-check-label" for="escale-oui">Non</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-check">
                                                                <input type="hidden" name="document" value="0"> <!-- Valeur par défaut si la case n'est pas cochée -->
                                                                <input type="radio" name="document" id="document" class="form-check-input document-trigger" value="1">
                                                                <label class="form-check-label" for="document">Oui</label>
                                                                <span style="margin-right: 25px;"></span> <!-- Espacement entre les labels -->
                                                                <input type="radio" name="document" id="document-oui" class="form-check-input document-trigger" value="0">
                                                                <label class="form-check-label" for="document-oui">Non</label>
                                                            </div>
                                                            
                                                            
                                                            
                                                        </div>
                                                    </div>
                                                </div>      
                                            </div>
                                            <div id="escaleOffreFields" style="display: none;">
                                                <table class="table datatable table-bordered table-striped datatable-table">
                                                    <thead class="dst-form-thead">
                                                        <tr>
                                                            <th colspan="3" style="text-align: center">Escale(s)</th>
                                                        </tr>
                                                        <tr>
                                                            <th>Lieu escale <span style="color:red">*</span></th>
                                                            <th>Durée <span style="color:red">*</span></th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <!-- Champs pour la première escale -->
                                                        <tr class="escale-field" id="escaleField1">
                                                            <td>
                                                                <select name="lieuEscale[]" id="lieuEscale1" required class="form-control lieuEscale" autocomplete="off">
                                                                    <option value="">Veuillez sélectionner une Ville</option>
                                                                    @foreach ($cities as $city)
                                                                        <option value="{{ $city->city }}">{{ $city->city.' - '.$city->country }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input type="number" name="dureeEscale[]" id="dureeEscale1" class="form-control dureeEscale">
                                                            </td>
                                                            <td>
                                                                <button class="btn btn-xs" data-id="0" onclick="deleteRowCV(this)" title="Supprimer la ligne"> <i class="fa fa-trash text-danger"></i></button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="3">
                                                                {{-- <button type="button" id="addEscaleOffre" class="btn btn-primary" style="display: none;">Ajouter une escale</button> --}}
                                                                <a class="btn btn-default" id="addEscaleOffre" style="display: none">
                                                                    <i class="fa fa-plus-circle text-success"></i>
                                                                    <span>Ajouter un escale </span>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>   
                                            <div id="documentFields" style="display: none;">
                                                <table class="table datatable table-bordered table-striped datatable-table">
                                                    <thead class="dst-form-thead">
                                                        <tr>
                                                            <th colspan="3" style="text-align: center">Documents</th>
                                                        </tr>
                                                        <tr>
                                                            <th>Libellé du document <span style="color:red">*</span></th>
                                                            <th>Fichier <span style="color:red">*</span></th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <!-- Champs pour le premier document -->
                                                        <tr class="document-field" id="documentField1">
                                                            <td>
                                                                <input type="text" name="libelle[]" id="libelle1" required class="form-control">
                                                            </td>
                                                            <td>
                                                                <input type="file" name="fichier[]" id="fichier1" required class="form-control-file">
                                                            </td>
                                                            <td>
                                                                <button class="btn btn-xs" data-id="0" onclick="deleteDocumentRow(this)" title="Supprimer la ligne"> <i class="fa fa-trash text-danger"></i></button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="3">
                                                                <a class="btn btn-default" id="addDocument">
                                                                    <i class="fa fa-plus-circle text-success"></i>
                                                                    <span>Ajouter un document </span>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                            
                                            
                                            
                                            <div class="row mt-4">
                                                <div class="col-12">
                                                    <div class="form-group m-auto">
                                                        <label>Compagnie <sup class="text-danger">*</sup></label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i
                                                                        class="fas fa-plane-departure"></i></span>
                                                            </div>
                                                            <select name="compagnie" class="form-control"
                                                                id="compagnieSelect" required>
                                                                <option value="">Sélectionnez une compagnie</option>
                                                                <option value="Ethiopian Airlines">Ethiopian Airlines
                                                                </option>
                                                                <option value="Air Burkina">Air Burkina</option>
                                                                <option value="Air Ivoir">Air Ivoir</option>
                                                                <option value="Air Mali">Air Mali</option>
                                                                <option value="Air Alger">Air Alger</option>
                                                                <option value="Royal Air Maroc">Royal Air Maroc</option>
                                                                <option value="Brusel Airlines">Brusel Airlines</option>
                                                                <option value="Autre">Autre</option>
                                                            </select>
                                                            <input type="text" id="autreCompagnieInput"
                                                                class="form-control d-none"
                                                                placeholder="Nom de la compagnie">

                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="form-group mt-4">
                                                <label>Observation de l'offre:</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i
                                                                class="fas fa-info-circle"></i></span>
                                                    </div>
                                                    <textarea type="text" name="description" class="form-control"
                                                        placeholder="Merci de detailler votre offre, en specifiant le nombre des escales, la compagnie de trasport et d'autres informations pertinentes votre billet"></textarea>
                                                </div>
                                            </div>


                                            <div class="form-group mt-4">
                                                <label> <b>Certification sur l'honneur:</b></label>
                                                <span class="text-danger"> En cochant cette case, je m'engage sur la
                                                    disponibilite du billet.</span>

                                                <div class="input-group">

                                                    <input type="checkbox" name="engagement" value="1"
                                                        class="form-control text-success" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                            <div class="modal-footer">

                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fermer</button>
                                <button type="submit" class="btn btn-flat btn-success">Soumettre</button>

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

<script>
    document.getElementById('compagnieSelect').addEventListener('change', function () {
    var autreCompagnieInput = document.getElementById('autreCompagnieInput');
    if (this.value === 'Autre') {
        autreCompagnieInput.classList.remove('d-none');
        autreCompagnieInput.name = 'compagnie'; // Assurer que l'input a le bon nom pour la soumission
        this.name = ''; // Temporairement retirer le nom du select pour éviter la soumission
    } else {
        autreCompagnieInput.classList.add('d-none');
        autreCompagnieInput.name = ''; // Retirer le nom pour éviter la soumission de ce champ
        this.name = 'compagnie'; // Restaurer le nom du select pour la soumission
    }
});


</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const escaleSelect = document.getElementById('escale');
        const escaleFields = document.getElementById('escaleFields');

        escaleSelect.addEventListener('change', function () {
            if (this.value === '1') {
                escaleFields.style.display = 'block';
            } else {
                escaleFields.style.display = 'none';
            }
        });
    });
</script>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const escaleTrigger = document.querySelector('.escale-trigger');
    const escaleFields = document.getElementById('escaleFields');
    let addEscaleBtn = document.getElementById('addEscale');
    let escaleCounter = 1; // Compteur global pour les escales

    escaleTrigger.addEventListener('change', function () {
        if (this.value === '1') {
            escaleFields.style.display = 'block';
            addEscaleBtn.style.display = 'block';
        } else {
            escaleFields.style.display = 'none';
            addEscaleBtn.style.display = 'none';
        }
    });

    addEscaleBtn.addEventListener('click', addNewEscale);

    // Fonction pour ajouter une nouvelle escale
    function addNewEscale() {
        const escaleField = document.querySelector('.escale-field').cloneNode(true);
        const uniqueId = new Date().getTime(); // Génère un ID unique basé sur le timestamp
        escaleField.id = 'escaleField' + uniqueId;
        escaleField.querySelector('.lieuEscale').id = 'lieuEscale' + uniqueId; // Utilisez .lieuEscale pour sélectionner le select
        escaleField.querySelector('[name="dureeEscale[]"]').id = 'dureeEscale' + uniqueId;
        escaleFields.querySelector('tbody').appendChild(escaleField);
    }
 });

function deleteRowCV(me) {
    $(me).closest('tr').remove();
}
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
      const escaleTrigger = document.querySelector('.escaleOffre-trigger');
      const escaleFields = document.getElementById('escaleOffreFields');
      let addEscaleBtn = document.getElementById('addEscaleOffre');
      let escaleCounter = 1; // Compteur global pour les escales
  
      escaleTrigger.addEventListener('change', function () {
          if (this.value === '1') {
              escaleFields.style.display = 'block';
              addEscaleBtn.style.display = 'block';
          } else {
              escaleFields.style.display = 'none';
              addEscaleBtn.style.display = 'none';
          }
      });
  
      addEscaleBtn.addEventListener('click', addNewEscale);
  
      // Fonction pour ajouter une nouvelle escale
      function addNewEscale() {
          const escaleField = document.querySelector('.escale-field').cloneNode(true);
          const uniqueId = new Date().getTime(); // Génère un ID unique basé sur le timestamp
          escaleField.id = 'escaleField' + uniqueId;
          escaleField.querySelector('.lieuEscale').id = 'lieuEscale' + uniqueId; // Utilisez .lieuEscale pour sélectionner le select
          escaleField.querySelector('[name="dureeEscale[]"]').id = 'dureeEscale' + uniqueId;
          escaleFields.querySelector('tbody').appendChild(escaleField);
      }
   });
  
  function deleteRowCV(me) {
      $(me).closest('tr').remove();
  }
</script>
<script>

document.addEventListener('DOMContentLoaded', function () {
    const documentTrigger = document.querySelector('.document-trigger');
    const documentFields = document.getElementById('documentFields');
    let addDocumentBtn = document.getElementById('addDocument');

    if (documentTrigger && documentFields && addDocumentBtn) {
        documentTrigger.addEventListener('change', function () {
            if (this.value === '1') {
                documentFields.style.display = 'block';
                addDocumentBtn.style.display = 'block';
            } else {
                documentFields.style.display = 'none';
                addDocumentBtn.style.display = 'none';
            }
        });

        addDocumentBtn.addEventListener('click', addNewDocument);
    } else {
        console.error('Les éléments nécessaires ne sont pas correctement définis.');
    }

    function addNewDocument() {
        const documentField = document.querySelector('.document-field');
        if (documentField) {
            const clonedDocumentField = documentField.cloneNode(true);
            const uniqueId = new Date().getTime();
            clonedDocumentField.id = 'documentField' + uniqueId;
            const libelleDocument = clonedDocumentField.querySelector('[name="libelle[]"]');
            const fichierDocument = clonedDocumentField.querySelector('[name="fichier[]"]');
            if (libelleDocument) libelleDocument.id = 'libelle' + uniqueId;
            if (fichierDocument) fichierDocument.id = 'fichier' + uniqueId;
            documentFields.querySelector('tbody').appendChild(clonedDocumentField);
        } else {
            console.error('Le champ de document initial est introuvable.');
        }
    }
});

function deleteDocumentRow(me) {
    $(me).closest('tr').remove();
}

</script>
  

@endsection
