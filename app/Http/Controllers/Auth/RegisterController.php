<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\AgenceAcredite;
use App\Models\User;
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
            // Rendre les champs suivants optionnels :
            'rccm' => ['nullable', 'mimes:pdf', 'max:10240'], // Optionnel, doit être un fichier PDF si présent
            'adressAgence' => ['nullable', 'string', 'max:255'], // Optionnel
            'numeroIfu' => ['nullable', 'string', 'max:255'], // Optionnel
            'dateCreationAgence' => ['nullable', 'date'], // Optionnel, doit être une date valide si présent
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
            'telephone' => $data['telephone'],
            'password' => Hash::make($data['password']),
        ]);
    
        // Assurez-vous que la création de l'utilisateur a réussi avant de continuer
        if (!$user) {
            return redirect()->back()->withInput()->withErrors(['error' => 'Erreur lors de la création de l\'utilisateur.']);
        }
        $user['typeUtilisateur'] = "Usager";
        $user['name'] = $data['name'];
      
        $user->save();
        // Configurez les valeurs par défaut pour les champs optionnels
        $rccm = $data['rccm'] ?? null; // Utilisez l'opérateur null coalescent pour gérer les cas où 'rccm' n'existe pas
        $adressAgence = $data['adressAgence'] ?? null;
        $numeroIfu = $data['numeroIfu'] ?? null;
        $dateCreationAgence = $data['dateCreationAgence'] ?? null;
    
        $agence = AgenceAcredite::create([
            'user_id' => $user->id,
            'nomAgence' => $data['name'],
            'adressAgence' => $adressAgence,
            'numeroIfu' => $numeroIfu,
            'dateCreationAgence' => $dateCreationAgence,
            'rccm' => $rccm,
            // ... autres champs de l'agence
        ]);
    
        // Enregistrez le fichier PDF si 'rccm' est présent et est un fichier téléchargé
        if (!empty($rccm) && is_uploaded_file($rccm)) {
            $pdfFile = $rccm;
            $pdfFileName = time() . '_' . $pdfFile->getClientOriginalName();
            $pdfPath = $pdfFile->storeAs('public/pdf_files', $pdfFileName);
    
            $agence->savePdfFile($pdfPath); // Assurez-vous que cette méthode existe et est correctement définie dans votre modèle `AgenceAcredite`
        }
    
        $clientRole = Role::where('name', 'Client')->first();
        if ($clientRole) {
            $user->roles()->attach($clientRole);
        }
    
        // $user->notify(new \App\Notifications\userNotification());
    
        return view('backend.index')->with('success', 'Votre compte a été créé avec succès, veuillez cliquer le bouton Connexion pour se connecter !');
    }
    


}
