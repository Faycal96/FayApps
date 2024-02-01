@extends('layouts.backend')

@section('content')
    <h1>Faire une demande</h1>
    <div class="col-lg-8 col-md-8 m-auto">
        <div class="form-group">
            <label>Numero Ordre de Mission:</label>

            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                </div>
                <input type="text" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label>Lieu Départ:</label>

            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="far fa-regular fa-location-dot"></i></span>
                </div>
                <input type="text" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label>Lieu Arrivée:</label>

            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="far fa-sharp fa-regular fa-location-dot"></i></span>
                </div>
                <input type="text" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label>Date Départ:</label>

            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                </div>
                <input type="text" class="form-control" data-inputmask-alias="datetime"
                    data-inputmask-inputformat="dd/mm/yyyy" data-mask>
            </div>
        </div>
        <div class="form-group">
            <label>Date Arrivée:</label>

            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                </div>
                <input type="text" class="form-control" data-inputmask-alias="datetime"
                    data-inputmask-inputformat="dd/mm/yyyy" data-mask>
            </div>
        </div>
        <div class="form-group">
            <label>Descrition du besoin:</label>

            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"></i><i class=" fa-solid fa-circle-info"></i></span>
                </div>
                <textarea type="text" class="form-control"></textarea>
            </div>
        </div>
        <button type="submit" class="btn btn-flat btn-primary">Enregistrer</button>
    </div>
@endsection
