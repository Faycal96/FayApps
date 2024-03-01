<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ministere;
use App\Models\Procedure;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProcedureController extends Controller
{
    public function index()
    {
        
        $procedures = Procedure::all();
        $ministeres = Ministere::all(); // Récupère tous les ministères
    return view('admin.procedures.index', compact('ministeres','procedures'));
}

public function create()
{
    $ministeres = Ministere::all();
    $users = User::where('id_m', auth()->user()->id_m)
    ->where('id', '!=', auth()->id())
    ->get();
// Assurez-vous que cette logique correspond à votre structure
    $userMinistryId = auth()->user()->id_m;
    return view('admin.procedures.create', compact('ministeres', 'userMinistryId', 'users'));
}


public function store(Request $request)
{
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'status' => 'required|boolean',
        'is_paid' => 'required|boolean',
        'ministry_id' => 'required|exists:ministeres,id',
        'description' => 'required|string',
        'user_ids' => 'required|array',
        'user_ids.*' => 'exists:users,id',
        'amount' => 'nullable|numeric|min:0', // Rendre nullable et conditionnel
    ]);

    // Préparer les données pour la création, incluant le montant si is_paid est vrai
    $createData = [
        'name' => $validatedData['name'],
        'status' => $validatedData['status'],
        'is_paid' => $validatedData['is_paid'],
        'ministry_id' => $validatedData['ministry_id'],
        'description' => $validatedData['description'],
        // Ajouter le montant conditionnellement
        'amount' => $request->is_paid ? ($request->amount ?? 0) : null, // Utiliser null ou 0 si non payant
    ];

    // Créer la procédure
    $procedure = Procedure::create($createData);

    // Associer les utilisateurs, si nécessaire
    if (!empty($validatedData['user_ids'])) {
        $procedure->users()->attach($validatedData['user_ids']);
    }

    return redirect()->route('procedures.index')->with('success', 'Procédure ajoutée avec succès.');
}


    public function show(Procedure $procedure)
    {
        return view('admin.procedures.show', compact('procedure'));
    }

    public function edit(Procedure $procedure)
    {
        $users = User::where('id_m', auth()->user()->id_m)->get();
        return view('admin.procedures.edit', compact('procedure','users'));
    }

    public function update(Request $request, Procedure $procedure)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|boolean',
            'is_paid' => 'required|boolean',
            'description' => 'required|string',
            'user_ids' => 'required|array', // Validez les ID des utilisateurs sélectionnés
        'user_ids.*' => 'exists:users,id', // Chaque ID d'utilisateur doit exister dans la table des utilisateurs
   
            // Ajoutez d'autres champs ici
        ]);

        $procedure->update($validatedData);

        return redirect()->route('procedures.index')->with('success', 'Procédure mise à jour avec succès.');
    }

    public function destroy(Procedure $procedure)
    {
        $procedure->delete();
        return back()->with('success', 'Procédure supprimée avec succès.');
    }
}