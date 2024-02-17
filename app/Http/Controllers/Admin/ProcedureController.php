<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ministere;
use App\Models\Procedure;
use Illuminate\Http\Request;

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
        return view('admin.procedures.create',compact('ministeres'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|boolean',
            'ministry_id' => 'required|exists:ministeres,id',
            // Ajoutez d'autres champs ici
        ]);

        $procedure = Procedure::create($validatedData);

        return redirect()->route('procedures.index')->with('success', 'Procédure ajoutée avec succès.');
    }

    public function show(Procedure $procedure)
    {
        return view('admin.procedures.show', compact('procedure'));
    }

    public function edit(Procedure $procedure)
    {
        return view('admin.procedures.edit', compact('procedure'));
    }

    public function update(Request $request, Procedure $procedure)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|boolean',
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