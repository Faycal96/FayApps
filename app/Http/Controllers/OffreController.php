<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOffreRequest;
use App\Http\Requests\UpdateOffreRequest;
use App\Models\Offre;
use Illuminate\Support\Facades\Auth;

class OffreController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    //faire une offre de prix pour une demande de billet
    public function offre()
    {
        return view('backend.offre');
    }

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('backend.offres.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOffreRequest $request)
    {
        //
        //enregistrer une demande de billet

        $code = null;
        //recuperer le maximum de id
        $id = Offre::max('id');

        //verifier si id existe et si il est differrent de null
        // creer le code
        if (isset($id)) {
            $code = 'BF-MTDPCE-OM-'.Offre::max('id') + 001;
        } else {
            $code = 'BF-MTDPCE-OM-001';
        }

        $request->merge(['user_id' => Auth::id()]);
        $request->merge(['created_by' => Auth::user()->name]);
        $request->merge(['code_offre' => $code]);
        $request->merge(['etat' => 'ACTIF']);

        Offre::create($request->all());

        return redirect()->route('offres.index')
            ->with('success', 'Votre offre a été enregistrée.');

        /*
        $numeroOrdreMission = $request->numeroOrdreMission;
        $lieuDepart = $request->lieuDepart;
        $lieuArrivee = $request->lieuArrivee;
        $dateDepart = $request->dateDepart;
        $dateArrivee = $request->dateArrivee;
        $duree = $request->duree;
        $description = $request->description;
        */
    }

    /**
     * Display the specified resource.
     */
    public function show(Offre $offre)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Offre $offre)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOffreRequest $request, Offre $offre)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Offre $offre)
    {
        //
    }
}
