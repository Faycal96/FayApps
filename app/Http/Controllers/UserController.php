<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\AgenceAcredite;
use App\Models\Ministere;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Instantiate a new UserController instance.
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['createdaf']]);
        $this->middleware('auth', ['except' => ['storedaf']]);

        $this->middleware('auth');
        $this->middleware('permission:create-user|edit-user|delete-user', ['only' => ['index','show']]);
        $this->middleware('permission:create-user', ['only' => ['create','store']]);
        $this->middleware('permission:edit-user', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-user', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        // ID du ministère de l'utilisateur connecté
        $userMinistereId = auth()->user()->id_m;
    
        // Récupère tous les utilisateurs et précharge les agences liées
        $users = User::with('agenceAcredite')->latest('id')->paginate(10); // Pagination ajustée pour l'exemple
    
        // Statistiques générales
        $totalUsers = User::count();
        $disabledUsers = User::where('is_active', 0)->count();
        $usersWithAgence = User::whereHas('agenceAcredite')->count();
        $usersWithoutAgence = User::whereDoesntHave('agenceAcredite')->count();
    
        // Statistiques spécifiques au ministère de l'utilisateur connecté
        $totalUsersByMinistere = User::where('id_m', $userMinistereId)->count();
        $disabledUsersByMinistere = User::where('id_m', $userMinistereId)->where('is_active', 0)->count();
        $activatedUsersByMinistere = User::where('id_m', $userMinistereId)->where('is_active', 1)->count();
        $usersWithAgenceByMinistere = User::where('id_m', $userMinistereId)->whereHas('agenceAcredite')->count();
        $usersWithoutAgenceByMinistere = User::where('id_m', $userMinistereId)->whereDoesntHave('agenceAcredite')->count();
    
        // Retourne la vue avec les utilisateurs et toutes les statistiques
        return view('users.index', [
            'users' => $users,
            'totalUsers' => $totalUsers,
            'disabledUsers' => $disabledUsers,
            'usersWithAgence' => $usersWithAgence,
            'usersWithoutAgence' => $usersWithoutAgence,
            // Statistiques par ministère
            'totalUsersByMinistere' => $totalUsersByMinistere,
            'disabledUsersByMinistere' => $disabledUsersByMinistere,
            'activatedUsersByMinistere' => $activatedUsersByMinistere,
            'usersWithAgenceByMinistere' => $usersWithAgenceByMinistere,
            'usersWithoutAgenceByMinistere' => $usersWithoutAgenceByMinistere,
            // Autres données potentiellement utiles pour la vue
            'ministeres' => Ministere::all(), // Assurez-vous que cette collection est nécessaire pour la vue
            'currentMinistereId' => $userMinistereId,
        ]);
    }
    


    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('users.create', [
            'roles' => Role::pluck('name')->all(),
            'ministeres' =>Ministere::all(),
        ]);
       
    }
    // public function createdaf(): View
    // {
    //     return view('registerDaf');
    // }



/*
** store daf
*/

 public function storedaf(StoreUserRequest $request): RedirectResponse
    {
        $input = $request->all();
        $input['password'] = Hash::make($request->password);

        $user = User::create($input);
        $user->assignRole($request->roles);

        return redirect()->route('/')
                ->withSuccess('New user is added successfully.');
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        $input = $request->all();
        $input['password'] = Hash::make($request->password);

        $user = User::create($input);
        $user->assignRole($request->roles);

        return redirect()->route('users.index')
                ->withSuccess('New user is added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): View
    {

        return view('users.show', [
            'user' => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): View
    {
        // Check Only Super Admin can update his own Profile
        if ($user->hasRole('Super Admin')){
            if($user->id != auth()->user()->id){
                abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSIONS');
            }
        }

        return view('users.edit', [
            'user' => $user,
            'roles' => Role::pluck('name')->all(),
            'userRoles' => $user->roles->pluck('name')->all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $input = $request->all();

        if(!empty($request->password)){
            $input['password'] = Hash::make($request->password);
        }else{
            $input = $request->except('password');
        }

        $user->update($input);

        $user->syncRoles($request->roles);

        return redirect()->back()
                ->withSuccess('User is updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        // About if user is Super Admin or User ID belongs to Auth User
        if ($user->hasRole('Super Admin') || $user->id == auth()->user()->id)
        {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSIONS');
        }

        $user->syncRoles([]);
        $user->delete();
        return redirect()->route('users.index')
                ->withSuccess('Utilisateur est supprimé avec succès !.');
    }

    public function toggleStatus(User $user)
    {
        // Bascule l'état actif/inactif
        $user->is_active = !$user->is_active;
        $user->save();

        // Vérifie l'état après l'enregistrement et envoie la notification appropriée
        if ($user->is_active) {
            // Si l'utilisateur est maintenant actif, envoie une notification d'activation
            $user->notify(new \App\Notifications\AccountActivated());
        } else {
            // Sinon, envoie une notification de désactivation
            $user->notify(new \App\Notifications\AccountDeactivated());
        }

        // Redirige l'utilisateur vers la page précédente avec un message de succès
        return back()->with('success', 'L\'état de l\'utilisateur a été mis à jour avec succès.');
    }

}
