<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\User;
use Illuminate\Http\Request;

class AgencyController extends Controller
{
    public function __construct()
    {
        

        $this->middleware('auth');
        
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $agencies = Agency::all();
        return view('agencies.index', compact('agencies'));
    }

    public function create()
    {
        return view('agencies.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'email' => 'required|string|email|max:255|unique:agencies',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validation pour la photo
        ]);
     
        if ($request->hasFile('logo')) {
            if (!file_exists(public_path('images/logos'))) {
                mkdir(public_path('images/logos'), 0755, true);
            }
            $imageName = time().'.'.$request->logo->getClientOriginalExtension();
            $request->logo->move(public_path('images/logos'), $imageName);
            $validatedData['logo'] = $imageName;
        }
        
        Agency::create($validatedData);

        return redirect()->route('agencies.index')->with('success', 'Agence créée avec succès.');
    }

    public function edit(Agency $agency)
    {
        return view('agencies.edit', compact('agency'));
    }

    public function update(Request $request, Agency $agency)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'email' => 'required|string|email|max:255|unique:agencies,email,' . $agency->id,
        ]);

        $agency->update($request->all());

        return redirect()->route('agencies.index')->with('success', 'Agence mise à jour avec succès.');
    }

    public function destroy(Agency $agency)
    {
        $agency->delete();
        return redirect()->route('agencies.index')->with('success', 'Agence supprimée avec succès.');
    }
    public function toggleStatus(Request $request, Agency $agency)
    {
        if ($agency->is_active) {
            // Désactivation de l'agence et des utilisateurs
            $agency->is_active = false;
            $agency->save();
    
            // Désactiver tous les utilisateurs associés
            User::where('agency_id', $agency->id)->update(['is_active' => false]);
        } else {
            // Activation de l'agence
            $request->validate([
                'fin_validite' => 'required|date',
            ]);
    
            $agency->is_active = true;
            $agency->fin_validite = $request->fin_validite;
            $agency->save();
    
            // Activer tous les utilisateurs associés
            User::where('agency_id', $agency->id)->update(['is_active' => true]);
        }
    
        return redirect()->back()->with('success', 'Statut de l\'agence mis à jour avec succès.');
    }
}   