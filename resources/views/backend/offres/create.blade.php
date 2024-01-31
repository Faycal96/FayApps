@extends('layouts.backend')

@section('content')
    <form method="POST" action="{{ route('offres.store') }}">

        @csrf

        <h1>Faire une offre</h1>
        <div class="col-lg-8 col-md-8 m-auto">
            <div class="form-group">
                <label>Code demande:</label>

                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-vote-yea"></i></span>
                    </div>
                    <input type="text" name="code_demande" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label>Choisir </label>
                <select class="form-control select2" style="width: 100%;">
                    <option selected="selected">Alabama</option>
                    <option>Alaska</option>
                </select>
            </div>
            <div class="form-group">
                <label>Prix Minimum:</label>

                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-money-check-alt"></i></span>
                    </div>
                    <input type="number" name="minPrix" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label>Prix Maximum:</label>

                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-money-check-alt"></i></span>
                    </div>
                    <input type="number" name="MaxPrix" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label>Date Debut Offre:</label>

                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                    </div>
                    <input type="date" name="dateDebutValidite" class="form-control" data-inputmask-alias="datetime"
                        data-inputmask-inputformat="dd/mm/yyyy" data-mask>
                </div>
            </div>
            <div class="form-group">
                <label>Date Fin Offre:</label>

                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                    </div>
                    <input type="date" name="dateFinValidite" class="form-control" data-inputmask-alias="datetime"
                        data-inputmask-inputformat="dd/mm/yyyy" data-mask>
                </div>
            </div>
            <div class="form-group">
                <label>Description de l'offre:</label>

                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"></i><i class="fas fa-info-circle"></i></span>
                    </div>
                    <textarea type="text" name="description" class="form-control"></textarea>
                </div>
            </div>
            <button type="submit" class="btn btn-flat btn-primary">Enregistrer</button>
        </div>
    </form>
@endsection
