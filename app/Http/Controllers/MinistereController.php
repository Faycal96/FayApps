<?php

namespace App\Http\Controllers;

use App\Models\Ministere;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMinistereRequest;
use App\Http\Requests\UpdateMinistereRequest;
use Illuminate\Http\Request;

class MinistereController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ministeres = Ministere::all();
            return view('ministeres.index', compact('ministeres'));
    }

   // Méthode pour afficher le formulaire de création d'un ministère
   public function create()
   {
       return view('ministeres.create');
   }

   // Méthode pour enregistrer un nouveau ministère
   public function store(Request $request)
   {
       $request->validate([
           'libelleCourt' => 'required',
           'libelleLong' => 'required',
       ]);

       Ministere::create($request->all());

       return redirect()->route('ministeres.index')->with('success', 'Ministère ajouté avec succès.');
   }

   // Méthode pour afficher le formulaire de modification d'un ministère
   public function edit(Ministere $ministere)
   {
       return view('ministeres.edit', compact('ministere'));
   }

   // Méthode pour mettre à jour un ministère existant
   public function update(Request $request, Ministere $ministere)
   {
       $request->validate([
           'libelleCourt' => 'required',
           'libelleLong' => 'required',
       ]);

       $ministere->update($request->all());

       return redirect()->route('ministeres.index')->with('success', 'Ministère modifié avec succès.');
   }

   // Méthode pour fusionner deux ministères
   public function merge(Request $request)
   {
       $request->validate([
           'ministere1_id' => 'required|exists:ministeres,id',
           'ministere2_id' => 'required|exists:ministeres,id',
       ]);

       $ministere1 = Ministere::findOrFail($request->ministere1_id);
       $ministere2 = Ministere::findOrFail($request->ministere2_id);

       // Mettez ici la logique pour fusionner les deux ministères

       return redirect()->route('ministeres.index')->with('success', 'Ministères fusionnés avec succès.');
   }
}