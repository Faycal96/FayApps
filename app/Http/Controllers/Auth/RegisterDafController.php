<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Models\AgenceAcredite;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;

class RegisterDafController extends Controller
{



    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'adresseAgence' =>['required', 'string', 'max:255'],
            'numeroIfu' =>['required', 'string', 'max:255'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        if (!$user) {
            return redirect()->back()->withInput()->withErrors(['error' => 'Erreur lors de la création de l\'utilisateur.']);
        }

        AgenceAcredite::create([
            'user_id' => $user->id,
            'nomAgence' => $data['name'],
            'adresseAgence' => $data['adresseAgence'],
            'numeroIfu' => $data['numeroIfu'],
            'dateCreationAgence' => $data['dateCreationAgence'],
            // ... autres champs de l'agence
        ]);

        return view('welcome')->with('success', 'Votre compte a été Créee qvec success et en attente de Validation !!');

    }

    public function createdaf(Request $request)
{
    // Votre logique de création ici

    return view('auth.registerDaf'); // Ou rediriger vers une autre vue après la création
}


protected function storeDaf(StoreUserRequest $request)
{
    $user = User::create([
        'nom' => $request->input('nom'),
        'prenom' => $request->input('prenom'),
        'matricule' => $request->input('matricule'),
        'telephone' => $request->input('telephone'),
        'email' => $request->input('email'),
        'password' => Hash::make($request->input('password')),
    ]);

    return view('welcome')->with('success', 'Votre compte a été créé avec succès et est en attente de validation !!');
}


}
