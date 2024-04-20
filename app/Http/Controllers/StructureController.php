<?php

namespace App\Http\Controllers;

use App\Models\Ministere;
use Illuminate\Http\Request;
use App\Models\Structure;

class StructureController extends Controller
{
    public function index()
    {
        $structures = Structure::with('ministere')->get();
        $ministeres = Ministere::all();
        return view('structures.index', compact('structures','ministeres'));
    }

    public function create()
    {
        $ministeres = Ministere::all();
        return view('structures.create', compact('ministeres'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'libelleCourt' => 'required',
            'libelleLong' => 'required',
            'ministere_id' => 'required|exists:ministeres,id',
        ]);

        Structure::create($request->all());

        return redirect()->route('structures.index')->with('success', 'Structure ajoutée avec succès.');
    }

    public function edit($id)
    {
        $structure = Structure::findOrFail($id);
        $ministeres = Ministere::all();
        return view('structures.edit', compact('structure', 'ministeres'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'libelleCourt' => 'required',
            'libelleLong' => 'required',
            'ministere_id' => 'required|exists:ministeres,id',
        ]);

        $structure = Structure::findOrFail($id);
        $structure->update($request->all());

        return redirect()->route('structures.index')->with('success', 'Structure mise à jour avec succès.');
    }

    public function merge(Request $request)
    {
        $request->validate([
            'structure1_id' => 'required|exists:structures,id',
            'structure2_id' => 'required|exists:structures,id',
        ]);

        $structure1 = Structure::findOrFail($request->structure1_id);
        $structure2 = Structure::findOrFail($request->structure2_id);

        // Mettez ici la logique pour fusionner les deux structures

        return redirect()->route('structures.index')->with('success', 'Structures fusionnées avec succès.');
    }
}
