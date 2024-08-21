<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\Facilitateurs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FacilitateursController extends Controller
{
    public function index()
    {
        $facilitateurs = Facilitateurs::with('agence')->get();
        $agences = Agency::all();
        return view('facilitateurs.index', compact('facilitateurs','agences'));
    }

    public function create()
    {
        $agences = Agency::all();
        return view('facilitateurs.create', compact('agences'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'telephone' => 'nullable|string|max:20',
           
        ]);
        $validated['agence_id'] = Auth::user()->agency->id;

        Facilitateurs::create($validated);
        return redirect()->route('facilitateurs.index')->with('success', 'Facilitateur ajouté avec succès.');
    }

    public function edit(Facilitateurs $facilitateur)
    {
        $agences = Agency::all();
        return view('facilitateurs.edit', compact('facilitateur', 'agences'));
    }

    public function update(Request $request, Facilitateurs $facilitateur)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'telephone' => 'nullable|string|max:20',
            
        ]);
        $validated['agence_id'] = Auth::user()->agency->id;
        $facilitateur->update($validated);
        return redirect()->route('facilitateurs.index')->with('success', 'Facilitateur mis à jour avec succès.');
    }

    public function destroy(Facilitateurs $facilitateur)
    {
        $facilitateur->delete();
        return redirect()->route('facilitateurs.index')->with('success', 'Facilitateur supprimé avec succès.');
    }
}