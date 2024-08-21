<?php

namespace App\Http\Controllers;

use App\Models\MotifCandidat;
use Illuminate\Http\Request;

class MotifCandidatController extends Controller
{
    public function index()
    {
        $motifCandidats = MotifCandidat::all();
        return view('motif-candidats.index', compact('motifCandidats'));
    }

    public function create()
    {
        return view('motif-candidats.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'montant' => 'required|numeric',
        ]);

        MotifCandidat::create($request->all());

        return redirect()->route('motif-candidats.index')->with('success', 'Motif Candidat créé avec succès.');
    }

    public function edit(MotifCandidat $motifCandidat)
    {
        return view('motif-candidats.edit', compact('motifCandidat'));
    }

    public function update(Request $request, MotifCandidat $motifCandidat)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'montant' => 'required|numeric',
        ]);

        $motifCandidat->update($request->all());

        return redirect()->route('motif-candidats.index')->with('success', 'Motif Candidat mis à jour avec succès.');
    }

    public function destroy(MotifCandidat $motifCandidat)
    {
        $motifCandidat->delete();
        return redirect()->route('motif-candidats.index')->with('success', 'Motif Candidat supprimé avec succès.');
    }
}