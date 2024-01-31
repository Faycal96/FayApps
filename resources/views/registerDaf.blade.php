@extends('layouts.header')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h3 class="text-center mt-3 mb-3">Inscription d'un agent du ministère </a></h3>

            <div class="card card-primary">

                <div class="card-header">Agence</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('agences.store') }}" enctype="multipart/form-data">
                        @csrf


                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Nom Agence') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="adresseAgence" class="col-md-4 col-form-label text-md-end">{{ __('adresse Agence') }}</label>

                            <div class="col-md-6">
                                <input id="adresseAgence" type="text" class="form-control @error('adresseAgence') is-invalid @enderror" name="adresseAgence" value="{{ old('adresseAgence') }}" required autocomplete="adresseAgence" autofocus>

                                @error('adresseAgence')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="dateCreationAgence" class="col-md-4 col-form-label text-md-end">{{ __('Date de creation') }}</label>

                            <div class="col-md-6">
                                <input id="dateCreationAgence" type="date" class="form-control @error('dateCreationAgence') is-invalid @enderror" name="dateCreationAgence" value="{{ old('dateCreationAgence') }}" required autocomplete="dateCreationAgence" autofocus>

                                @error('dateCreationAgence')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Address Email de l\'agence') }}</label>

                            <div class="col-md-6">
                                <input id="adresse" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">


                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="numeroIfu" class="col-md-4 col-form-label text-md-end">{{ __('Numero Ifu') }}</label>

                            <div class="col-md-6">
                                <input id="numeroIfu" type="text" class="form-control @error('numeroIfu') is-invalid @enderror" name="numeroIfu" value="{{ old('numeroIfu') }}" required autocomplete="numeroIfu">


                            </div>
                        </div>

                           <div class="row mb-3">
                            <label for="rccm" class="col-md-4 col-form-label text-md-end">{{ __('Registre de Commerce de l\'agence') }}</label>

                            <div class="col-md-6">
                                <input id="rccm" type="file" class="form-control @error('rccm') is-invalid @enderror" name="rccm" value="{{ old('rccm') }}" required autocomplete="rccm">

                            </div>
                        </div>
                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-success">
                                    {{ __('Enregistrer') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>


            </div>
        </div>
    </div>
</div>



@endsection
