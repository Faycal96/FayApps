<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOffreRequest;
use App\Http\Requests\UpdateOffreRequest;
use App\Models\DemandeBillet;
use App\Models\DocumentOffre;
use App\Models\ItineraireOffre;
use App\Models\Offre;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use NumberToWords\NumberToWords;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
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
    // Enregistrer une demande de billet

    // Générer le code de l'offre
    $code = null;
    $id = Offre::max('id');
    if (isset($id)) {
        $code = 'BF-MTDPCE-OM-' . str_pad($id + 1, 3, '0', STR_PAD_LEFT);
    } else {
        $code = 'BF-MTDPCE-OM-001';
    }

    // Ajouter les données supplémentaires
    $request->merge([
        'agence_id' => Auth::user()->agence->id,
        'created_by' => Auth::user()->name,
        'code_offre' => $code,
    ]);

    // Créer l'offre
    $offre = Offre::create($request->except(['lieuEscale', 'dureeEscale', 'libelle', 'fichier']));

    // Gérer les escales
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

    // Gérer les documents
    if ($request->has('libelle') && $request->hasFile('fichier')) {
        $documents = [];
    
        foreach ($request->libelle as $key => $libelle) {
            $file = $request->file('fichier')[$key];
    
            // Vérifier si un fichier a été téléchargé
            if ($file && $file->isValid()) {
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

    // Calcul du prix total en fonction de la présence de l'assurance
    $prixBillet = $request->input('prixBillet');
    $prixAssurance = $request->input('prixAssurance', 0);
    $prixTotals = $prixAssurance > 0 ? $prixBillet + $prixAssurance : $prixBillet;
    $nombrPassager= $offre->demande->nombrePassager;
    $prixTotal=$nombrPassager * $prixTotals;

    // Mise à jour du prix total de l'offre
    $offre->prixTotal = $prixTotal;
    $offre->save();

    // Redirection avec un message de succès
    return redirect()->route('offres.index')->with('success', 'Votre offre a été enregistrée.');
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

    // Générer le PDF
    $pdf = $this->generatePDF($offre);

    // Récupérer les informations nécessaires pour l'e-mail
    $offreDetails = [
        'demandeId' => $offre->demande->code_demande,
        'prix' => $offre->PrixTotal,
        'offreId' => $offre->id,
    ];

    // Trouver l'agence à notifier
    $agence = $offre->agence->user;

    // Envoyer la notification avec le PDF en pièce jointe
    $agence->notify(new \App\Notifications\OffreValideeNotification($offreDetails, $pdf));

    return redirect()->route('demandes.index')->with('success', 'L\'offre a été validée avec succès.');
}
private function generatePDF($offre)
{
    $numberToWords = new NumberToWords();
    $numberTransformer = $numberToWords->getNumberTransformer('fr');
    $prixBillet = $offre->prixBillet;
    $prixAssurance = $offre->PrixAssurance;
    $prixTotal = $offre->PrixTotal;
    $nbrePassager = $offre->demande->nombrePassager;
    $montantEnLettre = $numberTransformer->toWords($prixTotal);
    $totalBillet = $prixBillet * $nbrePassager;
    $totalAssurance = $prixAssurance * $nbrePassager;
    $donneQrCode = env('APP_URL')."/quittance/".$offre;
        $qrcode = base64_encode(QrCode::format('svg')->size(200)->errorCorrection('H')->generate($donneQrCode));
        //dd($qrcode);

    $data = [
        "offre" => $offre,
        "montantEnLettre" => $montantEnLettre,
        "prixBillet" => $prixBillet,
        "prixAssurance" => $prixAssurance,
        "prixTotal" => $prixTotal,
        "nbrePassager" => $nbrePassager,
        "totalBillet" => $totalBillet,
        "totalAssurance" => $totalAssurance,
        "qrCode" => $qrcode,
    ];

    $pdf = PDF::loadView("etats.quittance", $data);
    return $pdf->output();
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
