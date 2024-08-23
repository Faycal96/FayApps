<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\Agency;
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
        $agencies = Agency::all();

        return view('auth.registerDaf', 
        ['agencies' => $agencies,
        'ministeres' => $ministeres,
        'roles' => Role::pluck('name')->all()
        ]
    );
    } 


    public function enregistrer(Request $request)
    {

        // Utilisez la méthode validate() sur l'instance de Request
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            
            'telephone' => 'required|string|max:255',
            // 'typeUtilisateur' =>'required|string|max:255',
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
            
            
        ]);
        $existingUser = User::where('email', $request->email)->first();

        if ($existingUser) {
            // Afficher un message d'erreur à l'utilisateur
            return back()->withErrors(['email' => 'Cette adresse e-mail est déjà utilisée. Veuillez en choisir une autre.'])->withInput();
        }

        // Créez un nouvel utilisateur
        $user = User::create([
            'name' => $request->input('prenom').''.$request->input('nom'),
            'nom' => $request->input('nom'),
            'prenom' => $request->input('prenom'),
            
            'telephone' => $request->input('telephone'),
            'id_m' =>$request->input('id_m'),
            'agency_id' =>$request->input('agency_id'),
            'typeUtilisateur' => $request->input('typeUtilisateur'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            
        ]);
        $user->assignRole($request->roles);
        $user['typeUtilisateur']= "Agent";
        $user['name']= $request->prenom.' '.$request->nom;
        $user['id_m']= $request->id_m;
        $user['agency_id']= $request->agency_id;
        //  dd($user['name']);
        $user->save();

       
      //  $user->notify(new \App\Notifications\userNotification());


        // Vous pouvez ajouter d'autres logiques ici si nécessaire

        // Redirigez ou affichez une vue
        // return view('welcome')->with('success', 'Votre compte a été créé avec succès et est en attente de validation !!');
        return redirect()->route('users.index')->with('success', 'Votre compte a été créé avec succès et est en attente de validation !!');

        // return redirect($this->redirectPath())->with('success', 'Votre compte a été Créee avec success et en attente de Validation !! !');
    }
}
