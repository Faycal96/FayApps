<?php

namespace App\Http\Controllers;

use App\Models\Field;
use App\Models\Procedure;
use Illuminate\Http\Request;

class FieldController extends Controller
{
    public function index(Procedure $procedure)
    {
        $fields = $procedure->fields;
        return view('admin.fields.index', compact('fields', 'procedure'));
    }

    public function create(Procedure $procedure)
    {
        return view('admin.fields.create', compact('procedure'));
    }

    public function store(Request $request, Procedure $procedure)
    {
        $validatedData = $request->validate([
            'label' => 'required|string|max:255',
            'type' => 'required|in:text,textarea,date,number,file',
            // Ajoutez d'autres règles de validation selon vos besoins
        ]);

        $procedure->fields()->create($validatedData);

        return redirect()->route('procedures.fields.index', $procedure)->with('success', 'Champ créé avec succès.');
    }

    public function show(Procedure $procedure, Field $field)
    {
        return view('admin.fields.show', compact('field', 'procedure'));
    }

    public function edit(Procedure $procedure, Field $field)
    {
        return view('admin.fields.edit', compact('field', 'procedure'));
    }

    public function update(Request $request, Procedure $procedure, Field $field)
    {
        $validatedData = $request->validate([
            'label' => 'required|string|max:255',
            'type' => 'required|in:text,textarea,date,number,file',
            // Ajoutez d'autres règles de validation selon vos besoins
        ]);

        $field->update($validatedData);

        return redirect()->route('procedures.fields.index', $procedure)->with('success', 'Champ mis à jour avec succès.');
    }

    public function destroy(Procedure $procedure, Field $field)
    {
        $field->delete();
        return back()->with('success', 'Champ supprimé avec succès.');
    }
}