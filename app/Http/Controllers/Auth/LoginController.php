<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }

    protected function redirectTo()
    {
        $user = Auth::user(); // Récupérer l'utilisateur connecté

        // Exemple de redirection basée sur le rôle de l'utilisateur
        if ($user->hasRole(['Admin','Super Admin'])) {
            return '/users'; // Chemin pour les administrateurs
        } elseif ($user->hasRole('DAF MINISTERE')) {
            return '/demandes'; // Chemin pour les utilisateurs standards
        }
        elseif ($user->hasRole('Agence Voyage')) {
            return '/demandes'; // Chemin pour les utilisateurs standards
        }

}
protected function attemptLogin(Request $request)
{
    return $this->guard()->attempt(
        ['email' => $request->email, 'password' => $request->password, 'is_active' => 1], $request->filled('remember')
    );
}
}
