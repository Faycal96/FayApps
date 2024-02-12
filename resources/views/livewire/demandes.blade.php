<div>
    {{-- @if(session()->has('erreur') && $password!='')
    <div class="alert alert-warning" role="alert">
        <span><i class="fas fa-exclamation-triangle"></i>{{ ' '.session('erreur') }}</span>
    </div>
    @endif --}}
    <form action="{{ route('demandes.store') }}" method="POST">
        @csrf
        <h6 class="text-center"><span class="text-danger">Les champs precedés d'étoile rouge sont obligatoires</span></h6>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-6 form-group">
                    <label>Numero Ordre de Mission:</label>
                    <div class="input-group">
                        {{-- <span class="input-group-text"><i class="fas fa-file-alt"></i></span> --}}
                        <input type="number" name="numeroOrdreMission" wire:model='numeroOrdreMission' class="form-control">
                    </div>
                </div>
                <!-- Lieu de Départ avec icône -->
                <div class="col-md-6 form-group">
                    <label>Nom Complet du Passager <sup class="text-danger">*</sup></label>
                    <div class="input-group">
                        <input type="text" wire:model='nomCompletPassager' name="nomCompletPassager"   class="form-control  @error('nomCompletPassager') is-invalid @enderror" value="{{ old('nomCompletPassager') }}" autocomplete="off">
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-md-6 form-group">
                    <label>Lieu de  Départ <sup class="text-danger">*</sup></label>
                    <div class="input-group">
                        {{-- <div class="input-group-prepend custom-prepend inline">
                            <span class="input-group-text">
                                <i class="fas fa-map-marker-alt"></i> <!-- Icône FontAwesome -->
                            </span>
                        </div> --}}

                        <select   wire:model='lieuDepart' name="lieuDepart" class="form-control select2bs4 custom-select"   value="{{ old('lieuDepart') }}" autocomplete="off" style="width: 100%;">
                            <option value="">Veuillez sélectionner une Ville</option>
                            @foreach ($cities as $city)
                            <option>{{ $city->city }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-6 form-group">
                    <label>Destination <sup class="text-danger">*</sup></label>
                    <div class="input-group">
                        <select  wire:model='lieuArrivee' name="lieuArrivee" class="form-control select2bs4 custom-select  "   value="{{ old('lieuArrivee') }}" autocomplete="off"  style="width: 100%;">
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
                    <label>Date de depart <sup class="text-danger">*</sup></label>
                    <div class="input-group">
                        {{-- <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span> --}}
                        <input type="date" name="dateDepart"  wire:model='dateDepart' class="form-control  " value="{{ old('dateDepart') }}" autocomplete="off" >
                    </div>
                </div>

                <div class="col-md-6 form-group">
                    <label>Date de retour <sup class="text-danger">*</sup></label>
                    <div class="input-group">
                        {{-- <span class="input-group-text"><i class="fas fa-calendar-check"></i></span> --}}
                        <input type="date" name="dateArrivee"  wire:model='dateArrivee' class="form-control " value="{{ old('dateArrivee') }}" autocomplete="off">
                    </div>
                </div>
            </div>
            <div class="row">

                <div class="col-md-6 form-group">
                    <label>Classe du Billet <sup class="text-danger">*</sup></label>
                    <div class="input-group">
                        <select name="classe_billet" wire:model='classe_billet' class="form-control custom-select @error('classe_billet') is-invalid @enderror" value="{{ old('classe_billet') }}" autocomplete="off">
                            <option value="">Veuillez Choisir la classe su billet</option>
                            <option value="economique">Économique</option>
                            <option value="affaire">Affaire</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-6 form-group">
                    <label>Délai de Reception en Heures <sup class="text-danger">*</sup></label>
                    <div class="input-group">
                        {{-- <span class="input-group-text"><i class="fas fa-clock"></i></span> --}}
                        <input type="number" name="duree" wire:model='duree' class="form-control @error('duree') is-invalid  @enderror" value="{{ old('duree') }}" autocomplete="off">

                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-12 form-group">
                    <label>Description du besoin:</label>
                    <div class="input-group">
                        {{-- <span class="input-group-text"><i class="fas fa-align-left"></i></span> --}}
                        <textarea name="description" wire:model='description' class="form-control @error('description') is-invalid @enderror" value="{{ old('description') }}" autocomplete="off"></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Annuler</button>
            <button type="submit" class="btn btn-success">Enregistrer</button>
        </div>
    </form>

</div>
