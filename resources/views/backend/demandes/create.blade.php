@extends('layouts.backend')

@section('content')
<div class="container-fluid">
    <form method="POST" action="{{ route('demandes.store') }}">

        @csrf

        <h1>Faire une demande</h1>
        <div class="col-lg-8 col-md-8 m-auto">
            <div class="form-group">
                <label>Numero Ordre de Mission:</label>

                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-vote-yea"></i></span>
                    </div>
                    <input type="text" name="numeroOrdreMission" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label>Lieu Départ:</label>

                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                    </div>
                    <input type="text" name="lieuDepart" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label>Lieu Arrivée:</label>

                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-globe"></i></span>
                    </div>
                    <input type="text" name="lieuArrivee" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label>Date Départ:</label>

                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                    </div>
                    <input type="date" name="dateDepart" class="form-control" data-inputmask-alias="datetime"
                        data-inputmask-inputformat="dd/mm/yyyy" data-mask>
                </div>
            </div>
            <div class="form-group">
                <label>Date Arrivée:</label>

                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                    </div>
                    <input type="date" name="dateArrivee" class="form-control" data-inputmask-alias="datetime"
                        data-inputmask-inputformat="dd/mm/yyyy" data-mask>
                </div>
            </div>
            <div class="form-group">
                <label>Durée:</label>

                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-hourglass-half"></i></span>
                    </div>
                    <input type="text" name="duree" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label>Descrition du besoin:</label>

                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-info-circle"></i></span>
                    </div>
                    <textarea type="text" name="description" class="form-control"></textarea>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Enregistrer</button>
        </div>
    </form>
</div>
@endsection
