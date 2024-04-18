<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDemandeBilletRequest;
use App\Http\Requests\UpdateDemandeBilletRequest;
use App\Models\AgenceAcredite;
use App\Models\City;
use App\Models\DemandeBillet;
use App\Models\ItineraireDemande;
use App\Models\Offre;
use App\Models\User;
use App\Notifications\DemandeCreatedNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;



class DemandeBilletController extends Controller
{

    /**
     * Display a listing of the resource.
     */

     public function __construct()
     {
       
         $this->middleware('auth');

     }


    public function index(DemandeBillet $demande)
    {

        $user = Auth::user();
        if ($user) {
            // Récupérer toutes les demandes de l'utilisateur connecté
            $demandes = $user->demandes;

            // Initialiser le compteur des offres retenues
            $nombreOffresRetenues = 0;
            $nombreDemandesSansOffres = 0;

            // Parcourir toutes les demandes de l'utilisateur
            foreach ($demandes as $demande) {
                // Pour chaque demande, récupérer les offres associées retenues
                $offresRetenues = $demande->offres()->where('etats', 'validée')->get();

                // Mettre à jour le compteur des offres retenues
                $nombreOffresRetenues += $offresRetenues->count();

                if ($demande->offres()->count() === 0) {
                    $nombreDemandesSansOffres++;
                }
            }
        }



         // Récupérer l'utilisateur connecté
    $user = Auth::user();


    if ($user->ministere) {
        // Compter le nombre de demandes de l'utilisateur connecté
        $nombreDemandes = $user->demandes->count();
        // $nombreOffreRetenues = $offre->count();

    } else {
        // Si aucun utilisateur n'est connecté, définir le nombre de demandes sur 0
        $nombreDemandes = 0;

    }
    // dd($nombreOffreRetenues);

    if($user->agence)
    {
        $nombreOffres = $user->agence->offres->count();
        $nombreOfrresValidees = $user->agence->offres->where('etats', 'validée')->count();
        $nombreOfrresRejettees = $user->agence->offres->where('etats', 'rejetée')->count();
    }else{
        $nombreOffres =0;
        $nombreOfrresValidees= 0;
        $nombreOfrresRejettees =0;
    }


         // Récupère l'offre avec le prix le plus bas pour la demande spécifiée
         $offreMinPrix = Offre::where('demande_id', $demande->id)
         ->orderBy('prixBillet', 'asc') // Trie par prixBillet en ordre croissant
         ->first();
         $cities = City::all();

         if($user->ministere) {
            $structures = $user->ministere->structures;
         }else{
            $structures = []; 
        }

        //
        return view('backend.demandes.index', [
            'demandes' => DemandeBillet::latest('id')->paginate(10000000000),
            'offreMinPrix' => $offreMinPrix, // Passez l'offreMinPrix à la vue
            'cities'=> $cities,
            'structures'=> $structures,
            'nombreDemandes' => $nombreDemandes, // Passer le nombre de demandes à la vue
            'nombreOffreRetenues' =>$nombreOffresRetenues,
            'nombreDemandesSansOffres' =>$nombreDemandesSansOffres,
            'nombreOffres' =>$nombreOffres,
            'nombreOfrresValidees' =>$nombreOfrresValidees,
            'nombreOfrresRejettees' =>$nombreOfrresRejettees,
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
        $demande = DemandeBillet::create($request->except(['lieuEscale', 'dureeEscale']));
        if ($request->has('escale') && $request->escale == '1' && $request->has('lieuEscale') && $request->has('dureeEscale')) {
            $escales = []; 
    
            foreach ($request->lieuEscale as $key => $lieuEscale) {
                $escales[] = [
                    'lieuEscale' => $lieuEscale,
                    'dureeEscale' => $request->dureeEscale[$key],
                    'demande_billet_id' => $demande->id,
                ];
            }
    
            ItineraireDemande::insert($escales);
        }

        $users = User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'Agence Voyage');
        })->get();

        // Envoyer une notification à chaque agence

            // Vous pouvez récupérer des informations supplémentaires de l'agence si nécessaire
            // $agence = AgenceAcredite::where('user_id', $user->id)->first();

            // Ensuite, notifier l'utilisateur (qui est une agence dans ce cas)


            // Préparer les notifications pour chaque utilisateur
            $notifications = [];
            foreach ($users as $user) {
                // Créer une instance de la notification pour chaque utilisateur
                $notifications[] = new \App\Notifications\DemandeCreatedNotification($demande, $user);
            }

            // Envoyer toutes les notifications en une seule opération
            //Notification::send($users, $notifications);


            foreach ($users as $user) {
                $user->notify(new \App\Notifications\DemandeCreatedNotification($demande, $user));

            }

            return redirect()->route('demandes.index')->with('success', 'Votre demande a été enregistrée.');


    }


    /**
     * Display the specified resource.
     */
    public function show(DemandeBillet $demande)
    {
        $offres = Offre::where('demande_id', $demande->id)
                       
                       ->with('agence')
                       ->orderBy('prixBillet', 'asc')
                       ->get();
     $offreMinPrix = Offre::where('demande_id', $demande->id)
                       ->where('etats', '!=', 'rejetée')
                       ->with('agence')
                       ->orderBy('prixBillet', 'asc')
                       ->first();
    
        return view('backend.demandes.show', [
            'demande' => $demande,
            'offreMinPrix' => $offreMinPrix,
            'offres' => $offres, // Passer toutes les offres à la vue
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
    public function update(Request $request, $demande)
    {

        $demandeBillet = DemandeBillet::findOrFail($demande);

        // Mettre à jour les attributs de la demande de billet avec les données du formulaire
        $demandeBillet->dateDepart = Carbon::parse($request->input('dateDepart'))->format('Y-m-d');
        $demandeBillet->dateArrivee = Carbon::parse($request->input('dateArrivee'))->format('Y-m-d');

        $demandeBillet->update($request->all());



    // Rediriger l'utilisateur vers une autre page avec un message de succès
    return redirect()->route('demandes.index')->with('success', 'La demande  a été mise à jour avec succès.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // $demande = DemandeBillet::with('user')->find($id);
        $demandeBillet = DemandeBillet::findOrFail($id);

        // dd($demandeBillet->user_id);
         // Vérifiez si la demande appartient à l'utilisateur connecté ou a les autorisations nécessaires pour la supprimer
    if ($demandeBillet->user_id === Auth::user()->id) {
        // Supprimer la demande
        // dd($demandeBillet);
        $demandeBillet->delete();

        return redirect()->route('demandes.index')->with('success', 'La demande a été supprimée avec succès.');
    } else {
        // Retourner une réponse indiquant que l'utilisateur n'a pas les autorisations nécessaires pour supprimer la demande
        return redirect()->route('demandes.index')->with('error', 'Vous n\'êtes pas autorisé à supprimer cette demande.');
    }
    }
    public function markAsRead(Request $request, $id)
{
    $notification = auth()->user()->notifications()->findOrFail($id);
    $notification->markAsRead();
    return redirect()->back();
}

}
