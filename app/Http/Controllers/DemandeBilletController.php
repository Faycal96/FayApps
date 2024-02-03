<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDemandeBilletRequest;
use App\Http\Requests\UpdateDemandeBilletRequest;
use App\Models\DemandeBillet;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DemandeBilletController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('backend.demandes.index', [
            'demandes' => DemandeBillet::latest('id')->paginate(10000000000),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('backend.demandes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDemandeBilletRequest $request)
    {
        //enregistrer une demande de billet

        $code = null;
        //recuperer le maximum de id
        $id = DemandeBillet::max('id');

        //verifier si id existe et si il est differrent de null
        // creer le code
        if (isset($id)) {
            $code = 'BF-MTDPCE-OM-'.DemandeBillet::max('id') + 001;
        } else {
            $code = 'BF-MTDPCE-OM-001';
        }

        $dateDepart = $request->dateDepart;
        $dateArrivee = $request->dateArrivee;
        // dd((Carbon::now()->format('d/m/Y')));
        // if ($dateDepart->lt(Carbon::now()->format('d/m/Y'))) {

        // // }
        // if ($dateArrivee->lt($dateDepart)) {

        // }
        /*
        $request->merge(['dateDepart' => $dateDepart]);
        $request->merge(['dateArrivee' => $dateArrivee]);
        */
        $request->merge(['user_id' => Auth::id()]);
        $request->merge(['created_by' => Auth::user()->name]);
        $request->merge(['code_demande' => $code]);
        //$request->merge(['etat' => 'ACTIF']);

        DemandeBillet::create($request->all());

        return redirect()->route('demandes.index')
            ->with('success', 'Votre demande a été enregistrée.');

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
    public function show(DemandeBillet $demandeBillet)
    {
        //
        //dd($demandeBillet);

        //dd(DemandeBillet::join('offres', 'demande_billets.id', '=', 'offres.demande_id')->where('demande_billets.id', 'like', $demandeBillet)->max('prixBillet'));
        //dd(DemandeBillet::join('offres', 'demande_billets.id', '=', 'offres.demande_id')->where('demande_billets.id', '=', $demandeBillet)->get());

        return view('backend.demandes.show', [
            'demande' => $demandeBillet,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DemandeBillet $demandeBillet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDemandeBilletRequest $request, DemandeBillet $demandeBillet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DemandeBillet $demandeBillet)
    {
        //
    }
}
