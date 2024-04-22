<?php

namespace App\Http\Controllers;

use App\Models\Ministere;
use App\Models\SourceFinancement;
use Illuminate\Http\Request;

class SourceFinancementController extends Controller
{
    public function index()
    {
        $source_financements = SourceFinancement::with('ministere')->get();
        $ministeres = Ministere::all();
        return view('source_financement.index', compact('source_financements','ministeres'));
    }

    public function create()
    {
        $ministeres = Ministere::all();
        return view('source_financement.create', compact('ministeres'));
    }

    public function store(Request $request)
    {
        $request->validate([
           
            'libelleLong' => 'required',
            'ministere_id' => 'required|exists:ministeres,id',
        ]);

        SourceFinancement::create($request->all());

        return redirect()->route('source_financement.index')->with('success', 'Source de financement ajoutée avec succès.');
    }

    public function edit($id)
    {
        $source_financements = SourceFinancement::findOrFail($id);
        $ministeres = Ministere::all();
        return view('source_financement.edit', compact('source_financements', 'ministeres'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
           
            'libelleLong' => 'required',
            'ministere_id' => 'required|exists:ministeres,id',
        ]);

        $source_financements = SourceFinancement::findOrFail($id);
        $source_financements->update($request->all());

        return redirect()->route('source_financement.index')->with('success', 'Source de financement mise à jour avec succès.');
    }

   
}