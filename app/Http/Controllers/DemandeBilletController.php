<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDemandeBilletRequest;
use App\Http\Requests\UpdateDemandeBilletRequest;
use App\Models\AgenceAcredite;
use App\Models\City;
use App\Models\DemandeBillet;
use App\Models\Offre;
use App\Models\User;
use App\Notifications\DemandeCreatedNotification;
use Carbon\Carbon;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;



class DemandeBilletController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(DemandeBillet $demande)
    {
         // Récupère l'offre avec le prix le plus bas pour la demande spécifiée
         $offreMinPrix = Offre::where('demande_id', $demande->id)
         ->orderBy('prixBillet', 'asc') // Trie par prixBillet en ordre croissant
         ->first();
         $cities = City::all();

        //
        return view('backend.demandes.index', [
            'demandes' => DemandeBillet::latest('id')->paginate(10000000000),
            'offreMinPrix' => $offreMinPrix, // Passez l'offreMinPrix à la vue
            'cities'=> $cities,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('backend.demandes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDemandeBilletRequest $request)
    {
        //enregistrer une demande de billet

        $code = null;
        //recuperer le maximum de id
        $id = DemandeBillet::max('id');


        if (isset($id)) {
            $code = 'BF-MTDPCE-OM-'.DemandeBillet::max('id') + 001;
        } else {
            $code = 'BF-MTDPCE-OM-001';
        }

        $dateDepart = $request->dateDepart;
        $dateArrivee = $request->dateArrivee;

        $request->merge(['user_id' => Auth::id()]);
        $request->merge(['created_by' => Auth::user()->name]);
        $request->merge(['code_demande' => $code]);
        //$request->merge(['etat' => 'ACTIF']);
        $demande = DemandeBillet::create($request->all());


        $users = User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'Agence Voyage');
        })->get();

        // Envoyer une notification à chaque agence
        
            // Vous pouvez récupérer des informations supplémentaires de l'agence si nécessaire
            // $agence = AgenceAcredite::where('user_id', $user->id)->first();

            // Ensuite, notifier l'utilisateur (qui est une agence dans ce cas)
            foreach ($users as $user) {
                $user->notify(new \App\Notifications\DemandeCreatedNotification($demande, $user));

            }

            return redirect()->route('demandes.index')->with('success', 'Votre demande a été enregistrée.');


        // return redirect()->route('demandes.index')
        //     ->with('success', 'Votre demande a été enregistrée.');

        /*
        $numeroOrdreMission = $request->numeroOrdreMission;
        $lieuDepart = $request->lieuDepart;
        $lieuArrivee = $request->lieuArrivee;
         $dateDepart= $request->dateDepart;
        $dateArrivee = $request->dateArrivee;
        $duree = $request->duree;
        $description = $request->description;
        */
    
    }


    /**
     * Display the specified resource.
     */
    public function show(DemandeBillet $demande)
    {
        $offreMinPrix = Offre::where('demande_id', $demande->id)
                             ->with('agence') // Charge la relation agence
                             ->orderBy('prixBillet', 'asc')
                             ->first();

        return view('backend.demandes.show', [
            'demande' => $demande,
            'offreMinPrix' => $offreMinPrix,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DemandeBillet $demandeBillet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDemandeBilletRequest $request, DemandeBillet $demandeBillet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DemandeBillet $demandeBillet)
    {
        //
    }
}
