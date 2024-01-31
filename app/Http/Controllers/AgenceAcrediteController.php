<?php

namespace App\Http\Controllers;

use App\Models\AgenceAcredite;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAgenceAcrediteRequest;
use App\Http\Requests\UpdateAgenceAcrediteRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AgenceAcrediteController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['create', 'store']]);
        // ... rest of your constructor
    }
    public function index()
    {
        return view('welcome');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('welcome');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAgenceAcrediteRequest $request)
    {

        $validatedData = $request->validated();

        $user = User::create([
            'name' => $request->name,
            'typeUtilisateur' => 'Agence',
            'email' => $request->email,
            'password' => Hash::make('12345678'),
        ]);
        // dd($user);

        $user->save();

        $agence = new  AgenceAcredite([
            'user_id' => $user->id,
            // 'user_id' => auth()->user()->id, // Vous pouvez ajuster cela en fonction de votre logique d'utilisateur
            'nomAgence' => $validatedData['name'],
            'adressAgence' => $validatedData['adresseAgence'],
            'dateCreationAgence' => $validatedData['dateCreationAgence'],
            'numeroIfu' => $validatedData['numeroIfu'],
        ]);


        // Enregistrer dans la base de données
        $agence->save();

           // Gérer le fichier Registre de Commerce
           if ($request->hasFile('rccm')) {
            $file = $request->file('rccm');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('rccm', $fileName, 'public');
            $agence->registrecommerce = $fileName;
        }


        // Rediriger vers la page d'accueil
        // return redirect()->route('home')->with('success', "Inscription réussie !");
        // return redirect()->route('home')->with('success', "success enregistrer");
        return redirect()->back();
    }



    /**
     * Display the specified resource.
     */
    public function show(AgenceAcredite $agenceAcredite)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AgenceAcredite $agenceAcredite)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAgenceAcrediteRequest $request, AgenceAcredite $agenceAcredite)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AgenceAcredite $agenceAcredite)
    {
        //
    }
}
