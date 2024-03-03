@extends('layouts.demandes')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h3 class="text-center mt-3 mb-3">Inscription d'un Usager/Client</h3>
            <div class="card">
                <div class="card-header"></div>
                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Type de compte -->
                        <div class="row mb-3">
                            <label for="typeUtilisateur" class="col-md-4 col-form-label text-md-end">{{ __('Type de Compte') }}</label>
                            <div class="col-md-6">
                                <select id="typeUtilisateur" class="form-control" name="typeUtilisateur" onchange="toggletypeUtilisateurFields(this.value);">
                                    <option value="entreprise">Personne morale ou entreprise</option>
                                    <option value="individu">Personne morale ou particulier</option>
                                </select>
                            </div>
                        </div>

                        <!-- Nom de l'Agence ou Nom complet pour individu -->
                        <div class="row mb-3" id="nameField">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Nom complet') }} <sup class="text-danger">*</sup></label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-building"></i></span>
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                </div>
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Champs spécifiques à l'entreprise -->
                        <div id="entrepriseFields">
                            
                            

                            <!-- Date de création -->
                            <div class="row mb-3">
                                <label for="dateCreationAgence" class="col-md-4 col-form-label text-md-end">{{ __('Date de Création') }} <sup class="text-danger">*</sup></label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                        <input id="dateCreationAgence" type="date" class="form-control @error('dateCreationAgence') is-invalid @enderror" name="dateCreationAgence" value="{{ old('dateCreationAgence') }}" required autocomplete="dateCreationAgence">
                                    </div>
                                    @error('dateCreationAgence')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Numéro IFU -->
                            <div class="row mb-3">
                                <label for="numeroIfu" class="col-md-4 col-form-label text-md-end">{{ __('Numéro IFU') }} <sup class="text-danger">*</sup></label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                        <input id="numeroIfu" type="number" class="form-control @error('numeroIfu') is-invalid @enderror" name="numeroIfu" value="{{ old('numeroIfu') }}" required autocomplete="numeroIfu">
                                    </div>
                                    @error('numeroIfu')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- RCCM -->
                            <div class="row mb-3">
                                <label for="rccm" class="col-md-4 col-form-label text-md-end">{{ __('Registre de Commerce') }} <sup class="text-danger">*</sup></label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-file-alt"></i></span>
                                        <input id="rccm" type="file" class="form-control @error('rccm') is-invalid @enderror" name="rccm" value="{{ old('rccm') }}" required>
                                    </div>
                                    @error('rccm')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Champs communs -->
                        <!-- Email -->
                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('E-Mail') }} <sup class="text-danger">*</sup></label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                </div>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <!-- Adresse -->
<div class="row mb-3">
    <label for="adressAgence" class="col-md-4 col-form-label text-md-end">{{ __('Adresse') }} <sup class="text-danger">*</sup></label>
    <div class="col-md-6">
        <div class="input-group">
            <span class="input-group-text"><i class="fas fa-home"></i></span>
            <input id="adressAgence" type="text" class="form-control @error('adressAgence') is-invalid @enderror" name="adressAgence" value="{{ old('adressAgence') }}" required autocomplete="adressAgence">
        </div>
        @error('adressAgence')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

<!-- Téléphone -->
<div class="row mb-3">
    <label for="telephone" class="col-md-4 col-form-label text-md-end">{{ __('Téléphone') }} <sup class="text-danger">*</sup></label>
    <div class="col-md-6">
        <div class="input-group">
            <span class="input-group-text"><i class="fas fa-phone"></i></span>
            <input id="telephone" type="number" class="form-control @error('telephone') is-invalid @enderror" name="telephone" value="{{ old('telephone') }}" required autocomplete="telephone">
        </div>
        @error('telephone')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

                        

                        <!-- Mot de passe -->
                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Mot de Passe') }} <sup class="text-danger">*</sup></label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                </div>
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Confirmation du mot de passe -->
                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirmer le Mot de Passe') }} <sup class="text-danger">*</sup></label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
function toggletypeUtilisateurFields(value) {
    // Cache ou montre les champs en fonction du type de compte sélectionné
    if (value === 'entreprise') {
        document.getElementById('entrepriseFields').style.display = 'block';
    } else {
        document.getElementById('entrepriseFields').style.display = 'none';
    }
}
// Initialisation pour s'assurer que l'état initial correspond au type de compte sélectionné
toggletypeUtilisateurFields(document.getElementById('typeUtilisateur').value);
</script>
@endsection
