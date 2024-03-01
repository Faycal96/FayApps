<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\ApplicationField;
use App\Models\Procedure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ApplicationController extends Controller
{
    // Affiche la liste des demandes
    public function index(Procedure $procedure)
    {
        $applications = Application::where('procedure_id', $procedure->id)
                        ->with(['fields', 'user']) // Assurez-vous que la relation est bien définie
                        ->get();
    
                        $uniqueFieldNames = $applications->flatMap(function ($application) {
                            return $application->fields->pluck('label');
                        })->unique()->sort()->values();
    
        // Correction: s'assurer que 'procedure' est inclus dans les données passées à la vue
        return view('admin.applications.index', compact('applications', 'procedure','uniqueFieldNames'));
    }
    

    // Montre le formulaire pour créer une nouvelle demande
    public function create(Procedure $procedure)
    {
        // Vérifie si la procédure est active
        

        return view('admin.applications.create', compact('procedure'));
    }

    public function store(Request $request, Procedure $procedure)
    {
        $latestApplication = Application::latest()->first();
        $nextId = $latestApplication ? ((int)substr($latestApplication->request_number, 5) + 1) : 1;
        $uniqueRequestNumber = 'BFD00' . str_pad($nextId, 5, '0', STR_PAD_LEFT);
    
        $application = new Application([
            'procedure_id' => $procedure->id,
            'user_id' => Auth::id(), // Assurez-vous que l'utilisateur est connecté
            'status' => 'submitted',
            'request_number' => $uniqueRequestNumber,
        ]);
        $application->save();
    
        // Traiter les champs de formulaire dynamiques
        foreach ($procedure->fields as $field) {
            $value = null; // Valeur par défaut
            switch ($field->type) {
                case 'file':
                    if ($request->hasFile("field_{$field->id}")) {
                        $file = $request->file("field_{$field->id}");
                        $value = $file->store('public/documents'); // Chemin de stockage du fichier
                    }
                    break; 
                case 'checkbox':
                    $value = $request->input("field_{$field->id}", false) ? '1' : '0';
                    break;
                default:
                    $value = $request->input("field_{$field->id}", null);
                    break;
            }
    
            $applicationField = new ApplicationField([
                'application_id' => $application->id,
                'field_id' => $field->id,
                'value' => $value,
            ]);
            $applicationField->save();
        }
    
        return redirect()->route('procedures.fields.index', $procedure)->with('success', 'Application soumise avec succès.');
    }
    public function validateByAgent(Request $request, Application $application)
{
    $request->validate(['motif' => 'required|string']);
    
    $application->update([
        'status' => 'validated_by_agent',
        'motif' => $request->motif,
    ]);

    // Logique pour envoyer des notifications ou autres actions après validation

    return back()->withSuccess('Demande validée par l\'agent avec succès.');
}
public function rejectByAgent(Request $request, Application $application)
{
    $request->validate(['motif' => 'required|string']);
    
    $application->update([
        'status' => 'rejected_by_agent',
        'motif' => $request->motif,
    ]);

    // Logique pour envoyer des notifications ou autres actions après rejet

    return back()->withSuccess('Demande rejetée par l\'agent avec succès.');
}
public function validateBySuperior(Request $request, Application $application)
{
    $request->validate([
        'motif' => 'required|string',
        'document' => 'required|file|mimes:pdf,doc,docx|max:10240', // Exemple pour PDF, DOC, et DOCX avec une taille max de 10MB
    ]);
    
    // Stockez le document et récupérez son chemin
    $documentPath = $request->file('document')->store('public/documents');
   
    
    // Assurez-vous que le chemin est correctement enregistré dans votre base de données
    // Par exemple, si vous voulez juste enregistrer le nom du fichier et non tout le chemin
    $documentName = $request->file('document')->hashName(); // Cela générera un nom unique pour le fichier

    $application->update([
        'status' => 'validated_by_superior',
        'motif' => $request->motif,
        'document_path' => $documentPath, // Ou utilisez $documentName si vous préférez juste le nom du fichier
    ]);
   
    // Logique pour envoyer des notifications ou autres actions après validation

    return back()->withSuccess('Demande validée par le supérieur avec succès.');
}

public function rejectBySuperior(Request $request, Application $application)
{
    $request->validate(['motif' => 'required|string']);
    
    $application->update([
        'status' => 'rejected_by_superior',
        'motif' => $request->motif,
    ]);

    // Logique pour envoyer des notifications ou autres actions après rejet
    
    return back()->withSuccess('Demande rejetée par le supérieur avec succès.');
}
public function edit(Procedure $procedure, Application $application)
{
    // Assurez-vous que l'application appartient à la procédure
    if ($application->procedure_id != $procedure->id) {
        abort(404); // Ou toute autre gestion d'erreur appropriée
    }
    return view('admin.applications.edit', compact('application', 'procedure'));
}
public function update(Request $request, Procedure $procedure, Application $application)
{
    // Pas besoin de générer un nouveau numéro de demande, on garde l'ancien
    // Mise à jour des attributs simples de l'application si nécessaire
    // Exemple: $application->status = 'updated_status';

    // Traiter les champs de formulaire dynamiques
    foreach ($procedure->fields as $field) {
        // Chercher si un ApplicationField existe déjà pour ce champ
        $applicationField = ApplicationField::where('application_id', $application->id)
                                            ->where('field_id', $field->id)
                                            ->first();

        $value = null; // Valeur par défaut
        switch ($field->type) {
            case 'file':
                if ($request->hasFile("field_{$field->id}")) {
                    // Supprimer l'ancien fichier si existant
                    if ($applicationField && Storage::exists($applicationField->value)) {
                        Storage::delete($applicationField->value);
                    }

                    // Télécharger le nouveau fichier et mettre à jour le chemin
                    $file = $request->file("field_{$field->id}");
                    $value = $file->store('public/documents');
                }
                break;
            case 'checkbox':
                $value = $request->input("field_{$field->id}", false) ? '1' : '0';
                break;
            default:
                $value = $request->input("field_{$field->id}", null);
                break;
        }

        // Si un ApplicationField existe, mettre à jour, sinon créer un nouveau
        if ($applicationField) {
            $applicationField->update(['value' => $value]);
        } else {
            ApplicationField::create([
                'application_id' => $application->id,
                'field_id' => $field->id,
                'value' => $value,
            ]);
        }
    }

    // Redirection avec un message de succès
    return redirect()->route('procedures.fields.index', $procedure)->with('success', 'Application mise à jour avec succès.');
}



public function destroy(Procedure $procedure, Application $application)
{
    // Vérifiez si l'application appartient à la procédure pour une sécurité accrue
    if ($application->procedure_id != $procedure->id) {
        abort(404); // Ou toute autre gestion d'erreur appropriée
    }

    $application->delete();

    // Redirection avec un message de succès
    return back()->with('success', 'Application supprimée avec succès.');
}

    
}