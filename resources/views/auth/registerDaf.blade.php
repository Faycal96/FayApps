@extends('layouts.header')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h3 class="text-center mt-3 mb-3">Inscription d'un Agent du ministère</h3>
            <div class="card">

                <div class="card-header text-center">  <sup class="text-danger">les champs precédés d'étoile rouge sont obligatoires</sup> </div>

                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form method="POST" action="{{ route('storeDaf') }}">
                        @csrf

                        <!-- Nom -->
                        <div class="row mb-3">
                            <label for="nom" class="col-md-4 col-form-label text-md-end">{{ __('Nom') }} <sup class="text-danger">*</sup></label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input id="nom" type="text" class="form-control @error('nom') is-invalid @enderror" name="nom" value="{{ old('nom') }}" required autocomplete="nom" autofocus>
                                </div>
                                @error('nom')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Prénom -->
                        <div class="row mb-3">
                            <label for="prenom" class="col-md-4 col-form-label text-md-end">{{ __('Prénom (s)') }}<sup class="text-danger">*</sup></label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user-edit"></i></span>
                                    <input id="prenom" type="text" class="form-control @error('prenom') is-invalid @enderror" name="prenom" value="{{ old('prenom') }}" required autocomplete="prenom">
                                </div>
                                @error('prenom')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                    
                                </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Ministères -->
                        <div class="row mb-3">
                            <label for="ministere" class="col-md-4 col-form-label text-md-end">{{ __('Ministère') }} <sup class="text-danger">*</sup></label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-building"></i></span>
                                    <select name="id_m" required class="form-select">
                                        <option value="">Veuillez choisir un Ministère</option>
                                        @foreach ($ministeres as $ministere)
                                        <option value="{{ $ministere->id }}">{{ $ministere->libelleLong }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Matricule -->
                        <div class="row mb-3">
                            <label for="matricule" class="col-md-4 col-form-label text-md-end">{{ __('Matricule') }} <sup class="text-danger">*</sup></label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-id-badge"></i></span>
                                    <input id="matricule" type="text" class="form-control @error('matricule') is-invalid @enderror" name="matricule" value="{{ old('matricule') }}" required autocomplete="matricule">
                                </div>
                                @error('matricule')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="roles" class="col-md-4 col-form-label text-md-end text-start">{{ __('Profil') }}<sup class="text-danger">*</label>
                            <div class="col-md-6">  
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-users"></i></span>         
                                <select class="form-select @error('roles') is-invalid @enderror" aria-label="Roles" id="roles" name="roles">
                                    <option value="">Veuillez choisir votre profil</option>
                                    <option value="DAF MINISTERE" {{ old('roles') == 'DAF MINISTERE' ? 'selected' : '' }}>DMP</option>
                                    <option value="DAF VRAI" {{ old('roles') == 'DAF VRAI' ? 'selected' : '' }}>DAF</option>
                                </select>
                                
                                @if ($errors->has('roles'))
                                    <span class="text-danger">{{ $errors->first('roles') }}</span>
                                @endif
                            </div>
                        </div>
                        </div>
                        
                        

                        <!-- Téléphone -->
                        <div class="row mb-3">
                            <label for="telephone" class="col-md-4 col-form-label text-md-end">{{ __('Téléphone') }} <sup class="text-danger">*</sup></label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    <input id="telephone" type="text" class="form-control @error('telephone') is-invalid @enderror" name="telephone" value="{{ old('telephone') }}" required autocomplete="telephone">
                                </div>
                                @error('telephone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Adresse Email') }} <sup class="text-danger">*</sup></label>
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


                        <!-- Password -->
                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Mot de Passe') }} <sup class="text-danger">*</sup></label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                </div>
                                <span id="passwordError" class="invalid-feedback" role="alert"></span>
                                {{-- @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror --}}
                            </div>
                        </div>

                        <!-- Confirm Password -->
                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirmez Mot de Passe') }} <sup class="text-danger">*</sup></label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                </div>
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


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('password-confirm');
        const passwordError = document.getElementById('passwordError');
        const submitButton = document.querySelector('button[type="submit"]');

        // Fonction de validation du mot de passe
        function validatePassword() {
            const password = passwordInput.value;
            const confirmPassword = confirmPasswordInput.value;

            // Réinitialiser les classes d'erreur
            passwordInput.classList.remove('is-invalid');
            confirmPasswordInput.classList.remove('is-invalid');

            // Vérifier la longueur du mot de passe
            if (password.length < 8) {
                // Afficher un message d'erreur si le mot de passe est trop court
                passwordError.innerText = 'Le mot de passe doit comporter au moins 8 caractères.';
                passwordInput.classList.add('is-invalid');
                confirmPasswordInput.classList.add('is-invalid');
                disableSubmitButton();
            } else if (password !== confirmPassword) {
                // Afficher un message d'erreur si les mots de passe ne correspondent pas
                passwordError.innerText = 'Les mots de passe ne correspondent pas.';
                passwordInput.classList.add('is-invalid');
                confirmPasswordInput.classList.add('is-invalid');
                disableSubmitButton();
            } else {
                // Effacer le message d'erreur si les conditions sont remplies
                passwordError.innerText = '';
                enableSubmitButton();
            }
        }

        // Fonction pour désactiver le bouton "Enregistrer"
        function disableSubmitButton() {
            submitButton.disabled = true;
        }

        // Fonction pour activer le bouton "Enregistrer"
        function enableSubmitButton() {
            submitButton.disabled = false;
        }

        // Écouter les événements input sur les champs de mot de passe
        passwordInput.addEventListener('input', validatePassword);
        confirmPasswordInput.addEventListener('input', validatePassword);

        // Exécuter la validation initiale
        validatePassword();
    });
</script>






@endsection
