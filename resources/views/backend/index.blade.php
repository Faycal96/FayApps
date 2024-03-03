@extends('layouts.demandes')
@section('content')
        <header class="py-5">
            <div class="container px-lg-5">
                <div class="p-4 p-lg-5 bg-light rounded-3 text-center">
                    <div class="m-4 m-lg-5">
                        <h1 class="display-5 fw-bold">Bienvenue sur edemande.gov.bf!</h1>
                        <p class="fs-4">Votre guichet unique pour gérer efficacement vos demandes en ligne. Rejoignez-nous pour simplifier votre expérience [domaine d'application] dès aujourd'hui.</p>
                        <!-- Assurez-vous que le lien href pointe vers votre chemin de connexion (ajustez selon votre route de connexion) -->
                       <!-- Bouton pour ouvrir le modal -->
                       @guest      
<a class="btn btn-primary btn-lg" data-toggle="modal" data-target="#loginModal">
    <i class="bi bi-box-arrow-in-right"></i> Connexion
</a>
@endguest

<!-- Modal de connexion -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="loginModalLabel">Connexion</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <!-- Formulaire de connexion -->
          <div class="col-md-12">
              <div class="card">
                  <div class="card-header card-primary text-center">Veuillez entrer vos identifiants ici</div>
                  <div class="card-body">
                      <form method="POST" action="{{ route('login') }}">
                          @csrf
                          <!-- Structure du formulaire -->
                          <div class="form-group">
                              <label for="email">Adresse Email <sup class="text-danger">*</sup></label>
                              <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                              @error('email')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
  
                          <div class="form-group">
                              <label for="password">Mot de Passe <sup class="text-danger">*</sup></label>
                              <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                              @error('password')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
  
                          <div class="form-group form-check">
                              <input type="checkbox" class="form-check-input" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                              <label class="form-check-label" for="remember">Se Souvenir de Moi</label>
                          </div>
  
                          <button type="submit" class="btn btn-success">Connecter</button>
                          @if (Route::has('password.request'))
                              <a class="btn btn-link" href="{{ route('password.request') }}">Mot de passe oublié ?</a>
                          @endif
                          <h3><a class="btn btn-primary" href="{{ route('register') }}">Je n'ai pas de compte.</a></h3>
                      </form>
                  </div>
              </div>
          </div>
        </div>
      </div>
    </div>
  </
  
                        
                    </div>
                    
                </div>
            </div>
        </header>
        <!-- Page Content-->
        <section class="pt-4">
            <div class="container px-lg-5">
                @foreach ($ministeres as $ministere)
                    <div class="row gx-lg-5">
                        @foreach ($ministere->procedures as $procedure)
                            <div class="col-lg-6 col-xxl-4 mb-5">
                                <div class="card bg-light border-0 h-100 shadow">
                                    <div class="card-body text-center p-4 p-lg-5 pt-0 pt-lg-0">
                                        <div class="feature bg-primary bg-gradient text-white rounded-3 mb-4 mt-n4">
                                            <i class="bi {{ $procedure->icon ?? 'bi-file-earmark-text' }} fs-1"></i>
                                        </div>
                                        <h2 class="fs-4 fw-bold">{{ $procedure->name }}</h2>
                                        <p class="mb-0">{{ $procedure->description }} et il est delivré par le {{ $procedure->ministere->libelleLong ?? 'N/A' }}</p>
                                        @if ($procedure->is_paid)
                                            <p class="mt-3 fw-bold">Montant: {{ $procedure->amount }} FCFA</p>
                                        @endif
                                        @if(auth()->check() && auth()->user()->hasRole(['Client']) && $procedure->status == '1')

                                        <div class="d-flex justify-content-center align-items-center mt-3 gap-2">
                                            <a href="{{ route('procedures.applications.index', $procedure->id) }}" class="btn btn-primary btn-sm">Gérer mes demandes</a>
                                            <a href="{{ route('procedures.applications.create', $procedure) }}" class="btn btn-success btn-sm"><i class="bi bi-plus-circle"></i> Faire une demande</a>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </section>
        @endsection