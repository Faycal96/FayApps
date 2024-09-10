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
    public function __construct()
    {
        

        $this->middleware('auth');
        
    }
    public function index(Request $request)
{
    // Récupérer l'utilisateur connecté
    $user = auth()->user();

   // Récupérer l'ID du motif candidat sélectionné ou utiliser un motif par défaut
   $motifCandidatId = $request->input('motifCandidatId', MotifCandidat::first()->id);
    $pelerinsForMotif = Pelerin::whereHas('user', function ($query) use ($user) {
        $query->where('agency_id', $user->agency_id);
    })->where('motif_candidat_id', $motifCandidatId)->get();

    // Filtrer les pèlerins qui ont payé entièrement (montant restant = 0)
    $pelerinsPayes = $pelerinsForMotif->filter(function ($pelerin) {
        return $pelerin->montantRestant() == 0;
    });

    // Filtrer les pèlerins qui n'ont pas encore tout payé (montant restant > 0)
    $pelerinsEnAttente = $pelerinsForMotif->filter(function ($pelerin) {
        return $pelerin->montantRestant() > 0;
    });
    // Filtrer les pèlerins qui n'ont pas encore tout payé (montant restant > 0)
    $pelerinsNonPaye = $pelerinsForMotif->filter(function ($pelerin) {
        return $pelerin->montantTotalPaye() == 0;
    });
  // Récupérer les pèlerins associés à l'agence de l'utilisateur connecté, triés par date de création en ordre décroissant
  $pelerins = Pelerin::whereHas('user', function ($query) use ($user) {
    $query->where('agency_id', $user->agency_id);
})->orderBy('created_at', 'desc')->get();

    // Statistiques
    $totalPelerinsForMotif = $pelerinsForMotif->count();
    $totalPelerinsPayes = $pelerinsPayes->count();
    $totalPelerinsEnAttente = $pelerinsEnAttente->count();
    $totalPelerinsNonPaye = $pelerinsNonPaye->count();
    $motifCandidats = MotifCandidat::all();
    $facilitateurs = Facilitateurs::where('agence_id', $user->agency_id)->pluck('nom', 'id');

    return view('pelerins.index', compact('totalPelerinsNonPaye','pelerins','motifCandidatId','totalPelerinsForMotif','motifCandidats','facilitateurs' ,'totalPelerinsPayes', 'totalPelerinsEnAttente'));
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
        'type_vol' => 'nullable|string|max:255',
        'lieu_naissance' => 'nullable|string|max:255',
    ]);
   
 // Vérifier si le numéro de passeport existe déjà
 $existingPelerin = Pelerin::where('passeport', $request->passeport)->first();
 if ($existingPelerin) {
     return redirect()->back()
         ->withErrors(['passeport' => 'Un pèlerin avec ce numéro de passeport existe déjà.'])
         ->withInput();
 }

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
   

    // Rediriger vers une page avec un message de succès
    return redirect()->route('pelerins.index')->with('success', 'Pèlerin ajouté avec succès.');
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
        'passeport' => 'required|string|max:255',
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

    
    // Vérifier si le passeport est déjà utilisé par un autre enregistrement
    $existingUser = Pelerin::where('passeport', $request->passeport)
                           ->where('id', '!=', $pelerin->id)
                           ->first();

    if ($existingUser) {
        return back()->withErrors(['passeport' => 'Ce numéro de passeport est déjà utilisé. Veuillez en choisir un autre.'])
                     ->withInput();
    }
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

   

    // Rediriger avec un message de succès
    return redirect()->route('pelerins.index')->with('success', 'Pèlerin mis à jour avec succès.');
}


    public function destroy(Pelerin $pelerin)
    {
        $pelerin->delete();

        return redirect()->route('pelerins.index')->with('success', 'Pèlerin supprimé avec succès.');
    }

}