<?php

namespace App\Livewire;

use App\Models\City;
use App\Models\DemandeBillet;
use App\Models\Offre;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Demandes extends Component
{
    public $numeroOrdreMission;
    public $nomCompletPassager;
    public $lieuDepart;
    public $lieuArrivee;
    public $dateDepart;
    public $dateArrivee;
    public $classe_billet;
    public $duree;
    public $description;


    public function store()
    {

        $code = null;
        //recuperer le maximum de id
        $id = DemandeBillet::max('id');


        if (isset($id)) {
            $code = 'BF-MTDPCE-OM-'.DemandeBillet::max('id') + 001;
        } else {
            $code = 'BF-MTDPCE-OM-001';
        }

        // Enregistrement des données
        $demande = DemandeBillet::create([
            'numeroOrdreMission' => $this->numeroOrdreMission,
            'nomCompletPassager' => $this->nomCompletPassager,
            'code_demande' =>$code,
            'lieuDepart' => $this->lieuDepart,
            'lieuArrivee' => $this->lieuArrivee,
            'dateDepart' => $this->dateDepart,
            'dateArrivee' => $this->dateArrivee,
            'classe_billet' => $this->classe_billet,
            'duree' => $this->duree,
            'description' => $this->description,
            'user_id'=> Auth::id(),
            'created_by' => Auth::id(), // Utilisation de la fonction helper Auth::id() pour récupérer l'ID de l'utilisateur authentifié
        ]);

        $demande->save();

        // Message de succès
        session()->flash('success', 'Demande enregistrée avec succès!');

        // Redirection
        return redirect()->route('demandes.index');
    }
    public function render()
    {
        $demandes = DemandeBillet::latest('id')->paginate(10);
        $cities = City::all();

        return view('livewire.demandes', [
            'demandes' => $demandes,
            'cities'=> $cities,
        ]);
    }


    public function index()
    {
        $cities = City::all();


        return response()->json($cities);
    }
}
