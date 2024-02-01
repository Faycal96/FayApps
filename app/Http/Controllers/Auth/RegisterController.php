<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\AgenceAcredite;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }


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

    protected function createdaf(array $data)
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

}
