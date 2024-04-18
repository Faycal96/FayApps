<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOffreRequest;
use App\Http\Requests\UpdateOffreRequest;
use App\Models\DemandeBillet;
use App\Models\DocumentOffre;
use App\Models\ItineraireOffre;
use App\Models\Offre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OffreController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    //faire une offre de prix pour une demande de billet

    public function index()
    {

         // Récupérer l'utilisateur connecté
        $user = Auth::user();

        if ($user->agence) {
            $nombreOffres = $user->agence->offres->count();
            $nombreOfrresValidees = $user->agence->offres->where('etats', 'validée')->count();
            $nombreOfrresRejettees = $user->agence->offres->where('etats', 'rejetée')->count();
        } else {
            $nombreOffres = 0;
            $nombreOfrresValidees = 0;
            $nombreOfrresRejettees = 0;
        }
        //
        return view('backend.offres.index', [
            'offres' => Offre::latest('id')->paginate(10000000000),
            'nombreOffres' =>$nombreOffres,
            'nombreOfrresValidees' =>$nombreOfrresValidees,
            'nombreOfrresRejettees' =>$nombreOfrresRejettees,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function offre(DemandeBillet $demande)
    {
        //
        // dd($demande);
        // Auth::id();
        // $demande_billets = DemandeBillet::where('etat', '=', false)
        //where('user_id', '=', Auth::id())

        //   ->get();

        // dd($demande_billets);

        //faire un tableau avec bouton faire une offre
        //ppartir directement sur la page et selectionner la demande concernée pour l'offre
        // toutes les informations enregistrees

        return view('backend.offres.create');
    }

    public function create()
    {
        //
        Auth::id();
        $demande_billets = DemandeBillet::where('etat', '=', false)
            //where('user_id', '=', Auth::id())
            ->get();

        // dd($demande_billets);

        return view('backend.offres.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOffreRequest $request)
    {
        //
        //enregistrer une demande de billet

        $code = null;
        //recuperer le maximum de id
        $id = Offre::max('id');

        //verifier si id existe et si il est differrent de null
        // creer le code
        if (isset($id)) {
            $code = 'BF-MTDPCE-OM-' . Offre::max('id') + 001;
        } else {
            $code = 'BF-MTDPCE-OM-001';
        }

        //$request->merge(['user_id' => Auth::id()]);
        $request->merge(['agence_id' => Auth::user()->agence->id]);
        $request->merge(['created_by' => Auth::user()->name]);
        $request->merge(['code_offre' => $code]);
        //$request->merge(['etat' => ]);

        //dd($request);
        //dd(Auth::user()->agence->id);
       
        $offre = Offre::create($request->except(['lieuEscale', 'dureeEscale','libelle','fichier']));
        if ($request->has('escale') && $request->escale == '1' && $request->has('lieuEscale') && $request->has('dureeEscale')) {
            $escales = []; 
    
            foreach ($request->lieuEscale as $key => $lieuEscale) {
                $escales[] = [
                    'lieuEscale' => $lieuEscale,
                    'dureeEscale' => $request->dureeEscale[$key],
                    'offre_id' => $offre->id,
                ];
            }
    
            ItineraireOffre::insert($escales);
        }
        if ($request->has('libelle') && $request->hasFile('fichier')) {
            $documents = [];
        
            foreach ($request->libelle as $key => $libelle) {
                $file = $request->file('fichier')[$key];
        
                // Vérifier si un fichier a été téléchargé
                if ($file && $file->isValid()) { // Assurez-vous que le fichier est valide
                    // Stocker le fichier et récupérer le chemin d'accès
                    $filePath = $file->store('public/pdf_files');
        
                    // Ajouter le document à la liste des documents
                    $documents[] = [
                        'libelle' => $libelle,
                        'fichier' => $filePath,
                        'offre_id' => $offre->id,
                    ];
                }
            }
        
            // Insérer les documents dans la base de données
            DocumentOffre::insert($documents);
        }
        
        return redirect()->route('offres.index')
            ->with('success', 'Votre offre a été enregistrée.');

       
    }

    /**
     * Display the specified resource.
     */
    public function show(Offre $offre)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Offre $offre)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOffreRequest $request, Offre $offre)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Offre $offre)
    {
        //
    }
    public function valider(Request $request, $offreId)
    {
        $offre = Offre::findOrFail($offreId);
        $offre->etats = 'validée';
        $offre->motif = $request->motif;
        $offre->save();

        Offre::where('demande_id', $offre->demande_id)
        ->where('id', '!=', $offre->id) // Exclure l'offre actuellement validée
        ->update(['etats' => 'rejetée']);

        // Récupérer les informations nécessaires
        $offreDetails = [
            'demandeId' => $offre->demande->code_demande, // Assurez-vous que l'offre a une relation 'demande'
            'prix' => $offre->prixBillet,
            'offreId' => $offre->id,
        ];

        // Trouver l'agence à notifier
        $agence = $offre->agence->user;

        // Assurez-vous d'avoir une relation 'agence' ou similaire

        // Envoyer la notification
        $agence->notify(new \App\Notifications\OffreValideeNotification($offreDetails));



        return redirect()->route('demandes.index')->with('success', 'L\'offre a été validée avec succès.');
    }

    public function rejeter(Request $request, $offreId)
    {
        $offre = Offre::findOrFail($offreId);
        $offre->etats = 'rejetée'; // Ou tout autre valeur représentant l'état rejeté
        $offre->motif = $request->motif; // Assurez-vous que le champ existe dans votre base de données
        $offre->save();

        return redirect()->route('demandes.index')->with('error', 'L\'offre a été rejetée.');
    }
}
