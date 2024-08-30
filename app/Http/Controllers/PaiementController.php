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

    return view('paiements.index', compact('paiements', 'pelerins'));
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
    
        // Créer le paiement
        $paiement = Paiement::create([
            'pelerin_id' => $request->pelerin_id,
            'montant' => $request->montant,
            'mode_paiement' => $request->mode_paiement,
            'note' => $request->note,
            'statut_paiement' => 'En cours', // Ajout du statut "En cours"
        ]);
    
        // Récupérer le pèlerin associé
        $pelerin = $paiement->pelerin;
    
        // Calculer les montants
        $totalVerse = $pelerin->montantTotalPaye();
        $resteAPayer = $pelerin->montantRestant();
   
        // Mettre à jour le statut du paiement en fonction du montant restant
    if ($resteAPayer <= 0) {
        $paiement->statut_paiement = 'Payé';
    } else {
        $paiement->statut_paiement = 'En cours';
    }
    $paiement->save();
    
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
    
        // Supprimer l'ancien reçu
        $recuPath = public_path('recu/' . $paiement->id . '_recu.pdf');
        if (file_exists($recuPath)) {
            unlink($recuPath);
        }
    
        // Mettre à jour le paiement
        $paiement->update($request->only(['montant', 'mode_paiement', 'note']));
    
        // Calculer les montants
        $totalVerse = $pelerin->montantTotalPaye();
        $resteAPayer = $pelerin->montantRestant();
    
        // Mettre à jour le statut du paiement en fonction du montant restant
        if ($resteAPayer <= 0) {
            $paiement->statut_paiement = 'Payé';
        } else {
            $paiement->statut_paiement = 'En cours';
        }
        $paiement->save();
    
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
            'statut_paiement' => 'annulé',
            'motif_annulation' => $request->motif_annulation,
            'montant' => 0, // Réinitialiser le montant du paiement annulé
        ]);
    
        // Réduire le montant total payé du pèlerin
        $pelerin = $paiement->pelerin;
    
        // Calculer les montants
        $totalVerse = $pelerin->montantTotalPaye();
        $resteAPayer = $pelerin->montantRestant();
    
        // Supprimer l'ancien reçu s'il existe
        $recuPath = public_path('recu/' . $paiement->id . '_recu.pdf');
        if (file_exists($recuPath)) {
            unlink($recuPath);
        }
    
        // Générer un nouveau reçu avec les montants mis à jour
        $user = Auth::user();
        $agence = $user->agency;
        $name = $user->name;
        $logo = public_path('images/logos/' . $agence->logo);
    
        $pdf = PDF::loadView('pelerins.recu', compact('paiement', 'pelerin', 'logo', 'agence', 'totalVerse', 'resteAPayer', 'name', 'montantVerse'));
    
        // Sauvegarder le nouveau PDF
        $pdfFilePath = public_path('recu/' . $paiement->id . '_recu.pdf');
        $pdf->save($pdfFilePath);
    
        return redirect()->route('paiements.index')->with('success', 'Paiement annulé avec succès.');
    }
} 