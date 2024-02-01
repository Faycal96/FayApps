<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\Ministere;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

use Illuminate\Foundation\Auth\RegistersUsers;
use Spatie\Permission\Models\Role;

class RegisterDafController extends Controller
{
    public function afficherFormulaire()
    {

        $ministeres = Ministere::all(); // Vous pouvez ajuster ceci en fonction de votre logique

        return view('auth.registerDaf', ['ministeres' => $ministeres]);
    }


    public function enregistrer(Request $request)
    {

        // Utilisez la méthode validate() sur l'instance de Request
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'matricule' => 'required|string|max:255',
            'telephone' => 'required|string|max:255',
            // 'typeUtilisateur' =>'required|string|max:255',
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Créez un nouvel utilisateur
        $user = User::create([
            'name' => $request->input('prenom').''.$request->input('nom'),
            'nom' => $request->input('nom'),
            'prenom' => $request->input('prenom'),
            'matricule' => $request->input('matricule'),
            'telephone' => $request->input('telephone'),
            'id_m' =>$request->input('id_m'),
            'typeUtilisateur' => $request->input('typeUtilisateur'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        $user['typeUtilisateur']= "DAF";
        $user['name']= $request->prenom.' '.$request->nom;
        $user['id_m']= $request->id_m;
        //  dd($user['name']);
        $user->save();

        $clientRole = Role::where('name', 'DAF MINISTERE')->first();
        if ($clientRole) {
            $user->roles()->attach($clientRole);
        }



        // Vous pouvez ajouter d'autres logiques ici si nécessaire

        // Redirigez ou affichez une vue
        // return view('welcome')->with('success', 'Votre compte a été créé avec succès et est en attente de validation !!');
        return redirect()->route('welcome')->with('success', 'Votre compte a été créé avec succès et est en attente de validation !!');

        // return redirect($this->redirectPath())->with('success', 'Votre compte a été Créee avec success et en attente de Validation !! !');
    }
}
