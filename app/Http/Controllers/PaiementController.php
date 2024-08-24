<?php

namespace App\Http\Controllers;

use App\Models\Paiement;
use App\Models\Pelerin;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaiementController extends Controller
{
    public function __construct()
    {
        

        $this->middleware('auth');
        
    }
    public function index()
    {
        // Récupérer l'utilisateur connecté
        $user = auth()->user();
    
        // Récupérer les pèlerins associés à l'agence de l'utilisateur connecté
        $pelerins = Pelerin::whereHas('user', function ($query) use ($user) {
            $query->where('agency_id', $user->agency_id);
        })->orderBy('created_at', 'desc')->get();
        
    
       // Récupérer les paiements associés aux pèlerins triés
$paiements = Paiement::with('pelerin')
->whereIn('pelerin_id', $pelerins->pluck('id'))
->orderBy('created_at', 'desc')
->get();

    
        return view('paiements.index', compact('paiements', 'pelerins'));
    }
    

    public function store(Request $request)
{
    $request->validate([
        'pelerin_id' => 'required|exists:pelerins,id',
        'montant' => 'required|numeric|min:0.01',
        'mode_paiement' => 'required|string|max:255',
        'note' => 'nullable|string',
    ]);

    $pelerin = Pelerin::find($request->pelerin_id);

    // Vérifiez que le montant ne dépasse pas le montant restant à payer
    if ($request->montant > $pelerin->montantRestant()) {
        return redirect()->back()->withErrors([
            'montant' => 'Le montant payé ne peut pas dépasser le montant restant à payer.'
        ])->withInput();
    }

    // Créer le paiement
    $paiement = Paiement::create($request->all());

    // Récupérer le pèlerin associé
    $pelerin = $paiement->pelerin;

    // Calculer les montants
    $totalVerse = $pelerin->montantTotalPaye();
    $resteAPayer = $pelerin->montantRestant();
    
    // Récupérer les informations de l'agence
    $user = Auth::user();
    $agence = $user->agency;
    $name = $user->name;

    // Génération du PDF
    $logo = public_path('images/logos/' . $agence->logo);
    $recuPath = public_path('recu');

    if (!is_dir($recuPath)) {
        mkdir($recuPath, 0777, true);
    }

    // Passer toutes les informations nécessaires à la vue
    $pdf = Pdf::loadView('pelerins.recu', compact('paiement', 'name', 'logo', 'agence', 'totalVerse', 'resteAPayer'));

    // Sauvegarder le PDF
    $pdfFilePath = $recuPath . '/' . $paiement->id . '_recu.pdf';
    $pdf->save($pdfFilePath);

    return redirect()->route('paiements.index')->with('success', 'Paiement enregistré avec succès.');
}


public function update(Request $request, Paiement $paiement)
{
    // Validation des champs
    $request->validate([
        'montant' => 'required|numeric|min:0.01',
        'mode_paiement' => 'required|string|max:255',
        'note' => 'nullable|string',
    ]);
    // Récupérer le pèlerin associé
    $pelerin = $paiement->pelerin;

    // Vérifiez que le montant ne dépasse pas le montant restant à payer
    if ($request->montant > $pelerin->montantRestant() + $paiement->montant) {
        return redirect()->back()->withErrors([
            'montant' => 'Le montant payé ne peut pas dépasser le montant restant à payer après la modification.'
        ])->withInput();
    }
 
    // Supprimer l'ancien reçu
    $recuPath = public_path('recu/' . $paiement->id . '_recu.pdf');
    if (file_exists($recuPath)) {
        unlink($recuPath);
    }

    // Mettre à jour le paiement
    $paiement->update($request->all());

    // Récupérer le pèlerin associé
    $pelerin = $paiement->pelerin;

    // Calculer les montants
    $totalVerse = $pelerin->montantTotalPaye();
    $resteAPayer = $pelerin->montantRestant();

    // Récupérer les informations de l'agence
    $user = Auth::user();
    $agence = $user->agency;
    $name = $user->name;

    // Génération du nouveau PDF
    $logo = public_path('images/logos/' . $agence->logo);

    // Passer toutes les informations nécessaires à la vue
    $pdf = Pdf::loadView('pelerins.recu', compact('paiement', 'name', 'logo', 'agence', 'totalVerse', 'resteAPayer'));

    // Sauvegarder le nouveau PDF
    $pdfFilePath = public_path('recu/' . $paiement->id . '_recu.pdf');
    $pdf->save($pdfFilePath);

    return redirect()->route('paiements.index')->with('success', 'Paiement mis à jour avec succès.');
}


    

    public function destroy(Paiement $paiement)
    {
        $paiement->delete();

        return redirect()->route('paiements.index')->with('success', 'Paiement supprimé avec succès.');
    }
}