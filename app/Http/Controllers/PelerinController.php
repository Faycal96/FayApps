<?php

namespace App\Http\Controllers;

use App\Models\Pelerin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PelerinController extends Controller
{
    public function index()
{
    // Récupérer le nombre total de pèlerins
    $totalPelerins = Pelerin::count();

    
    // Récupérer la liste des pèlerins pour affichage dans la table
    $pelerins = Pelerin::orderBy('created_at', 'desc')->paginate(10);

    // Retourner la vue avec les données nécessaires
    return view('pelerins.index', compact('totalPelerins', 'pelerins'));
}


    public function create()
    {
        return view('pelerins.create');
    }

    public function store(Request $request)
    {
        // Valider les données du formulaire
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'passeport' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'date_delivrance' => 'required|date',
            'date_naissance' => 'required|date',
            'date_expiration' => 'required|date',
            'sexe' => 'required|in:M,F',
            'nationalite' => 'required|string|max:255',
            'telephone' => 'required|string|max:255',
            'motif_candidat' => 'required|string|max:255',
            'facilitateur' => 'nullable|string|max:255',
            'ville_province' => 'nullable|string|max:255',
            'note_observation' => 'nullable|string|max:255',
        ]);
    
        $validatedData['user_id'] = Auth::id();
       // dd($validatedData);
        // Créer un nouvel enregistrement dans la base de données
        Pelerin::create($validatedData);
    
        // Rediriger vers une page avec un message de succès
        return redirect()->route('pelerins.index')->with('success', 'Pèlerin ajouté avec succès.');
    }
    

    public function edit(Pelerin $pelerin)
    {
        return view('pelerins.edit', compact('pelerin'));
    }

    public function update(Request $request, Pelerin $pelerin)
    {
        $validatedData = $request->validate([
            'nom' => 'string|max:255',
            'passeport' => 'string|max:255',
            'prenom' => 'string|max:255',
            'date_delivrance' => 'required|date',
            'date_naissance' => 'required|date',
            'date_expiration' => 'required|date',
            'sexe' => 'string|max:10',
            'nationalite' => 'string|max:255',
            'telephone' => 'string|max:20',
            'motif_candidat' => 'string|max:255',
            'facilitateur' => 'string|max:255',
            
            'ville_province' => 'string|max:255',
            'note_observation' => 'nullable|string',
        ]);
    
        // Log les données pour déboguer
       
    
        $pelerin->update($validatedData);
    
        return redirect()->route('pelerins.index')->with('success', 'Pèlerin mis à jour avec succès.');
    }
    

    public function destroy(Pelerin $pelerin)
    {
        $pelerin->delete();

        return redirect()->route('pelerins.index')->with('success', 'Pèlerin supprimé avec succès.');
    }
}