<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterDafController extends Controller
{
    public function afficherFormulaire()
    {
        return view('auth.registerDaf');
    }


    public function enregistrer(Request $request)
    {
        // dd('La méthode enregistrer est appelée.');
        // Vérifiez si l'email existe déjà
        // $existingUser = User::where('email', $request->input('email'))->first();

        // if ($existingUser) {
        //     // L'email existe déjà, renvoyez une erreur ou gérez-le selon vos besoins
        //     return redirect()->back()->withErrors(['email' => 'Cet email est déjà enregistré.']);
        // }

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
            'typeUtilisateur' => $request->input('typeUtilisateur'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        $user['typeUtilisateur']= "DAF";
        $user['name']= $request->prenom.' '.$request->nom;
        //  dd($user['name']);
        $user->save();

        // Vous pouvez ajouter d'autres logiques ici si nécessaire

        // Redirigez ou affichez une vue
        return view('welcome')->with('success', 'Votre compte a été créé avec succès et est en attente de validation !!');

        // return redirect($this->redirectPath())->with('success', 'Votre compte a été Créee avec success et en attente de Validation !! !');
    }
}
