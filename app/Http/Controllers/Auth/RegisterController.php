<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\AgenceAcredite;
use App\Models\User;
use App\Notifications\userNotification;
use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

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
    // public function __construct()
    // {
    //     $this->middleware('guest');
    // }




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
            'email' => 'required|email',
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'adressAgence' =>['required', 'string', 'max:255'],
            'numeroIfu' =>['required', 'string', 'max:255'],
            // 'rccm' => 'required|mimes:pdf|max:10240',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    // protected function create(array $data)
    // {
    //     $existingUser = User::where('email', $data['email'])->first();

    //     if ($existingUser) {
    //         // Afficher un message d'erreur à l'utilisateur
    //         return back()->withErrors(['email' => 'Cette adresse e-mail est déjà utilisée. Veuillez en choisir une autre.'])->withInput();
    //     }
    //     $user = User::create([
    //         'name' => $data['name'],
    //         'email' => $data['email'],
    //         'telephone' =>$data['telephone'],
    //         'password' => Hash::make($data['password']),
    //     ]);



    //     $user['typeUtilisateur'] = "Agence";
    //     $user['name'] = $data['name'];


    //     //  dd($user['name']);

    //     // $user->save();

    //   $agence =  AgenceAcredite::create([
    //         'user_id' => $user->id,
    //         'nomAgence' => $data['name'],
    //         'adressAgence' => $data['adressAgence'],
    //         'numeroIfu' => $data['numeroIfu'],
    //         'dateCreationAgence' => $data['dateCreationAgence'],
    //         'rccm' =>$data['rccm'],
    //         // ... autres champs de l'agence
    //     ]);



    //     // Enregistrez le fichier PDF
    //     if ($data['rccm'] && is_uploaded_file($data['rccm'])) {
    //         $pdfFile = $data['rccm'];
    //         $pdfFileName = time() . '_' . $pdfFile->getClientOriginalName();
    //         $pdfPath = $pdfFile->storeAs('public/pdf_files', $pdfFileName);

    //         $agence->savePdfFile($pdfPath);
    //     }
    //     $clientRole = Role::where('name', 'Agence Voyage')->first();
    //     if ($clientRole) {
    //         $user->roles()->attach($clientRole);
    //     }

    //     // $user->notify(new \App\Notifications\userNotification());

    //     $user->notify(new userNotification()); // Envoyer la notification

    //     return view('welcome')->with('success', 'Votre compte a été créee avec success et en attente de Validation !!');

    // }


    protected function create(array $data)
{
    // Trouver un utilisateur avec l'email donné
    $existingUser = User::where('email', $data['email'])->first();

    if ($existingUser) {
        // Option 1 : Lancer une exception
        throw new \Exception('Cette adresse e-mail est déjà utilisée.');

        // Option 2 : Retourner null pour signaler un problème
        // return null;
    }

    // Créer un nouvel utilisateur
    $user = User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'telephone' => $data['telephone'],
        'password' => Hash::make($data['password']),
    ]);

    // Assignation des rôles et autres propriétés
    $user->typeUtilisateur = "Agence";
    $clientRole = Role::where('name', 'Agence Voyage')->first();
    if ($clientRole) {
        $user->roles()->attach($clientRole);
    }

    // Créer une agence associée
    $agence = AgenceAcredite::create([
        'user_id' => $user->id,
        'nomAgence' => $data['name'],
        'adressAgence' => $data['adressAgence'],
        'numeroIfu' => $data['numeroIfu'],
        'dateCreationAgence' => $data['dateCreationAgence'],
        'rccm' => $data['rccm'],
    ]);

    // Enregistrement du PDF
    if ($data['rccm'] && is_uploaded_file($data['rccm'])) {
        $pdfFile = $data['rccm'];
        $pdfFileName = time() . '_' . $pdfFile->getClientOriginalName();
        $pdfPath = $pdfFile->storeAs('public/pdf_files', $pdfFileName);
        $agence->savePdfFile($pdfPath);
    }

    $clientRole = Role::where('name', 'Agence Voyage')->first();
        // if ($clientRole) {
        //     $user->roles()->attach($clientRole);
        // }

        if ($user && $clientRole && !$user->roles->contains($clientRole->id)) {
            $user->roles()->attach($clientRole);
        }


        $user->notify(new userNotification()); // Envoyer la notification

    return $user; // Retourner un objet User valide

  // Retourner une vue avec l'utilisateur et un message de succès
//   return view('welcome', [
//     // 'user' => $user, // Objet utilisateur
//     'success' => 'Votre compte a été créé avec succès et est en attente de validation.', // Message de succès
// ]);

}



}
