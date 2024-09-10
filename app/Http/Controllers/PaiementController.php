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

// Récupérer les pèlerins sans paiements en utilisant une jointure gauche
$pelerinsS = Pelerin::leftJoin('paiements', 'pelerins.id', '=', 'paiements.pelerin_id')
    ->whereNull('paiements.id')
    ->whereHas('user', function ($query) use ($user) {
        $query->where('agency_id', $user->agency_id);
    })
    ->orderBy('pelerins.created_at', 'desc')
    ->select('pelerins.*')
    ->get();


       

    return view('paiements.index', compact('paiements', 'pelerins','pelerinsS'));
}


public function store(Request $request)
{
    // Validation des données d'entrée
    $request->validate([
        'pelerin_id' => 'required|exists:pelerins,id',
        'montant' => 'required|numeric|min:0.01',
        'mode_paiement' => 'required|string|max:255',
        'note' => 'nullable|string',
    ]);

    // Trouver le pèlerin
    $pelerin = Pelerin::find($request->pelerin_id);

    // Vérifier que le montant ne dépasse pas le montant restant à payer
    if ($request->montant > $pelerin->montantRestant()) {
        return redirect()->back()->withErrors([
            'montant' => 'Le montant payé ne peut pas dépasser le montant restant à payer.'
        ])->withInput();
    }

    // Calculer les montants
    $totalVerse = $pelerin->montantTotalPaye() + $request->montant;
    $resteAPayer = $pelerin->montantRestant() - $request->montant;

    // Créer le paiement
    $paiement = Paiement::create([
        'pelerin_id' => $request->pelerin_id,
        'montant' => $request->montant,
        'mode_paiement' => $request->mode_paiement,
        'note' => $request->note,
        'statut_paiement' => $resteAPayer <= 0 ? 'Payé' : 'En cours',
        'total_verse' => $totalVerse,
        'reste_a_payer' => $resteAPayer,
        'montant_vers_avant_annulation' =>  $request->montant,
    ]);

    // Redirection avec message de succès
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
      
    
        // Vérifiez que le montant ne dépasse pas le montant restant à payer après la modification
        if ($request->montant > $pelerin->montantRestant() + $paiement->montant) {
            return redirect()->back()->withErrors([
                'montant' => 'Le montant payé ne peut pas dépasser le montant restant à payer après la modification.'
            ])->withInput();
        }
    
       
    
       // Calculer les montants
    $totalVerse = $pelerin->montantTotalPaye() + $request->montant - $paiement->montant;
    $resteAPayer = $pelerin->montantRestant() + $paiement->montant - $request->montant;

    // Mettre à jour le paiement
    $paiement->update([
        'montant' => $request->montant,
        'mode_paiement' => $request->mode_paiement,
        'note' => $request->note,
        'statut_paiement' => $resteAPayer <= 0 ? 'Payé' : 'En cours',
        'total_verse' => $totalVerse,
        'reste_a_payer' => $resteAPayer,
        'montant_vers_avant_annulation' =>  $request->montant,

    ]);
       
    
        return redirect()->route('paiements.index')->with('success', 'Paiement mis à jour avec succès.');
    }
    

    

    public function destroy(Paiement $paiement)
    {
        $paiement->delete();

        return redirect()->route('paiements.index')->with('success', 'Paiement supprimé avec succès.');
    }
    public function cancel(Request $request, Paiement $paiement)
    {
        // Validation du motif d'annulation
        $request->validate([
            'motif_annulation' => 'required|string|max:255',
        ]);
    
        // Stocker le montant versé avant annulation
        $montantVerse = $paiement->montant;
    
        // Annuler le paiement : mettre à jour le statut et enregistrer le motif
        $paiement->update([
            'statut_paiement' => 'Annulé',
            'motif_annulation' => $request->motif_annulation,
            'montant' => 0, // Réinitialiser le montant du paiement annulé
        ]);
    
        // Réduire le montant total payé du pèlerin
        $pelerin = $paiement->pelerin;
    
        // Calculer les montants
        $totalVerse = $pelerin->montantTotalPaye() - $montantVerse;
        $resteAPayer = $pelerin->montantRestant() + $montantVerse;
    
        // Mettre à jour les montants du pèlerin
        $pelerin->update([
            'total_verse' => $totalVerse,
            'reste_a_payer' => $resteAPayer,
        ]);
    
        return redirect()->route('paiements.index')->with('success', 'Paiement annulé avec succès.');
    }
    
    public function generatePdf($id)
    {
        $paiement = Paiement::findOrFail($id);
    
        $user = Auth::user();
        $agence = $user->agency;
        $name = $user->name;
        $logo = public_path('images/logos/' . $agence->logo);
    
        $pdf = Pdf::loadView('pelerins.recu', [
            'paiement' => $paiement,
            'name' => $name,
            'logo' => $logo,
            'agence' => $agence,
            'totalVerse' => $paiement->total_verse,
            'resteAPayer' => $paiement->reste_a_payer,
            
        ]);
    
        return $pdf->stream('recu_' . $paiement->id . '.pdf');
    }
    

} 