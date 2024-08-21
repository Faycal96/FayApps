<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use Illuminate\Http\Request;

class AgencyController extends Controller
{
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
}