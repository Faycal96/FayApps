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
        // Validation des données soumises ici...

        $application = new Application();
        $application->procedure_id = $procedure->id;
        $application->user_id = Auth::id(); // Assurez-vous que l'utilisateur est connecté
        $application->status = 'submitted';
        $application->save();

        // Traiter les champs de formulaire dynamiques
        foreach ($procedure->fields as $field) {
            $value = $request->input("field_{$field->id}", null);
            $applicationField = new ApplicationField([
                'application_id' => $application->id,
                'field_id' => $field->id,
                'value' => $value,
            ]);
            $applicationField->save();
        }
}
}