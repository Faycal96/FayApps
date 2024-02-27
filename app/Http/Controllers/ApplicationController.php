<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\ApplicationField;
use App\Models\Procedure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    
}