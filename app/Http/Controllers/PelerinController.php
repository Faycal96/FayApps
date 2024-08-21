<?php

namespace App\Http\Controllers;

use App\Models\Facilitateurs;
use App\Models\MotifCandidat;
use App\Models\Pelerin;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PelerinController extends Controller
{
    public function index()
{
    // Récupérer le nombre total de pèlerins
    $totalPelerins = Pelerin::count();

    
  // Récupérer l'utilisateur connecté
        $user = auth()->user();
    
        // Récupérer les pèlerins associés à l'agence de l'utilisateur connecté, triés par date de création en ordre décroissant
$pelerins = Pelerin::whereHas('user', function ($query) use ($user) {
    $query->where('agency_id', $user->agency_id);
})->orderBy('created_at', 'desc')->get();

    

    $facilitateurs = Facilitateurs::where('agence_id', Auth::user()->agency_id)->pluck('nom', 'id');

    $motifCandidats = MotifCandidat::all();
    // Retourner la vue avec les données nécessaires
    return view('pelerins.index', compact('totalPelerins', 'pelerins','facilitateurs','motifCandidats'));
}


    public function create()
    {
        $facilitateurs = Facilitateurs::where('agence_id', Auth::user()->agence_id)->pluck('nom', 'id');
        return view('pelerins.create', compact('facilitateurs'));
}

public function store(Request $request)
{
    // Valider les données du formulaire
    $validatedData = $request->validate([
        'nom' => 'required|string|max:255',
        'passeport' => 'required|string|max:255',
        'prenom' => 'required|string|max:255',
        'date_delivrance' => 'required|date',
        'date_naissance' => 'required|date',
        'date_expiration' => 'required|date',
        'sexe' => 'required|in:M,F',
        'nationalite' => 'required|string|max:255',
        'telephone' => 'required|string|max:255',
        'motif_candidat_id' => 'required|int|max:10',
        'facilitateur' => 'nullable|string|max:255',
        'ville_province' => 'nullable|string|max:255',
        'note_observation' => 'nullable|string|max:255',
        'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:8012',
    ]);

    $validatedData['user_id'] = Auth::id();


    // Gestion de l'upload de la photo
    if ($request->hasFile('photo')) {
        $imageName = time().'.'.$request->photo->getClientOriginalExtension();
        $request->photo->move(public_path('images/pelerins'), $imageName);
        $validatedData['photo'] = $imageName;
    }

    // Créer un nouvel enregistrement dans la base de données
    $pelerin = Pelerin::create($validatedData);

    $user = Auth::user();
    $agence = $user->agency;
    //dd( $agence->name);
    // Génération du PDF
    $logo = public_path('images/logos/' . Auth::user()->agency->logo);
    // Chemin pour sauvegarder le PDF
    $recipissePath = public_path('recipisses');
    if (!is_dir($recipissePath)) {
        mkdir($recipissePath, 0777, true);
    }

    $pdf = PDF::loadView('pelerins.recipisse', compact('pelerin', 'logo', 'agence'));

    // Sauvegarder le PDF
    $pdfFilePath = $recipissePath . '/' . $pelerin->id . '_recipisse.pdf';
    $pdf->save($pdfFilePath);

    // Rediriger vers une page avec un message de succès
    return redirect()->route('pelerins.index')
    ->with('success', 'Pèlerin ajouté avec succès.')
    ->with('pdf', url('recipisses/' . $pelerin->id . '_recipisse.pdf'));
}

    

    public function edit(Pelerin $pelerin)
    {
        return view('pelerins.edit', compact('pelerin'));
    }

    public function update(Request $request, Pelerin $pelerin)
{
    // Validation des données
    $validatedData = $request->validate([
        'nom' => 'string|max:255',
        'passeport' => 'string|max:255',
        'prenom' => 'string|max:255',
        'date_delivrance' => 'required|date',
        'date_naissance' => 'required|date',
        'date_expiration' => 'required|date',
        'sexe' => 'string|max:10',
        'nationalite' => 'string|max:255',
        'telephone' => 'string|max:20',
        'motif_candidat_id' => 'string|max:255',
        'facilitateur' => 'string|max:255',
        'ville_province' => 'string|max:255',
        'note_observation' => 'nullable|string',
        'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:8012',
    ]);

    // Gestion de l'upload de la photo
    if ($request->hasFile('photo')) {
        // Supprimer l'ancienne photo si elle existe
        if ($pelerin->photo) {
            $oldPhotoPath = public_path('images/pelerins/' . $pelerin->photo);
            if (file_exists($oldPhotoPath)) {
                unlink($oldPhotoPath);
            }
        }

        $imageName = time().'.'.$request->photo->getClientOriginalExtension();
        $request->photo->move(public_path('images/pelerins'), $imageName);
        $validatedData['photo'] = $imageName;
    }

    // Mise à jour des données du pèlerin
    $pelerin->update($validatedData);

    // Supprimer l'ancien récépissé s'il existe
    $recipissePath = public_path('recipisses/' . $pelerin->id . '_recipisse.pdf');
    if (file_exists($recipissePath)) {
        unlink($recipissePath);
    }

    // Génération d'un nouveau PDF
    $user = Auth::user();
    $agence = $user->agency;
    $logo = public_path('images/logos/' . $user->agency->logo);

    $pdf = PDF::loadView('pelerins.recipisse', compact('pelerin', 'logo', 'agence'));

    // Sauvegarder le nouveau PDF
    $pdfFilePath = public_path('recipisses') . '/' . $pelerin->id . '_recipisse.pdf';
    $pdf->save($pdfFilePath);

    // Rediriger avec un message de succès
    return redirect()->route('pelerins.index')->with('success', 'Pèlerin mis à jour avec succès.')
                                            ->with('pdf', url('recipisses/' . $pelerin->id . '_recipisse.pdf'));
}


    public function destroy(Pelerin $pelerin)
    {
        $pelerin->delete();

        return redirect()->route('pelerins.index')->with('success', 'Pèlerin supprimé avec succès.');
    }

}