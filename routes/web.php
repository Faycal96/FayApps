<?php

use App\Http\Controllers\Admin\ProcedureController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\DemandeBilletController;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OffreController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RegisterDafController;
use App\Http\Controllers\RegisterDafController as ControllersRegisterDafController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/test', function () {
    return view('welcome');
})->name('welcome');

Route::get('/', [HomeController::class, 'index'])->name('backend.index');

Auth::routes();


//Route::get('/demande', [DemandeBilletController::class, 'demande'])->name('backend.demande');
Route::post('/users/{user}/validate', [UserController::class, 'valider'])->name('users.activate');
//Route::get('/offre', [OffreController::class, 'offre'])->name('backend.offre');
Route::patch('/users/{user}/activer', [UserController::class, 'activer'])->name('users.toggleStatus');
Route::patch('/users/{user}/toggleStatus', [UserController::class, 'toggleStatus'])->name('users.toggleStatus');

Route::post('/offres/offre/{demande}', [OffreController::class, 'offre'])->name('offres.offre');
Route::get('/cities', [CityController::class, 'index']);
Route::patch('/demandes/{demande}/toggleStatus', [DemandeBilletController::class, 'toggleStatus'])->name('demandes.toggleStatus');
Route::post('/demandes/{id}', [DemandeBilletController::class, 'destroy'])->name('demandes.destroy');

Route::put('/demandes/update/{id}', [DemandeBilletController::class, 'update'])->name('demandes.update');


Route::get('registerdaf', [RegisterDafController::class, 'afficherFormulaire'])->name('registerdaf');
Route::post('/storeDaf', [RegisterDafController::class, 'enregistrer'])->name('storeDaf');
Route::post('/offres/{offre}/valider', [OffreController::class, 'valider'])->name('offres.valider');
Route::post('/offres/{offre}/rejeter', [OffreController::class, 'rejeter'])->name('offres.rejeter');
Route::get('/notifications/read/{id}', [App\Http\Controllers\DemandeBilletController::class, 'markAsRead'])->name('notifications.read');

Route::get('procedures/{procedure}/applications/create', [ApplicationController::class, 'create'])->name('admin.applications.create');
Route::post('procedures/{procedure}/applications', [ApplicationController::class, 'store'])->name('admin.applications.store');

// Validation et rejet par un agent
Route::post('/applications/{application}/validate-agent', [ApplicationController::class, 'validateByAgent'])->name('applications.validate.agent');
Route::post('/applications/{application}/reject-agent', [ApplicationController::class, 'rejectByAgent'])->name('applications.reject.agent');

// Validation et rejet par un supérieur
Route::post('/applications/{application}/validate-superior', [ApplicationController::class, 'validateBySuperior'])->name('applications.validate.superior');
Route::post('/applications/{application}/reject-superior', [ApplicationController::class, 'rejectBySuperior'])->name('applications.reject.superior');
// Route pour afficher le formulaire de modification
Route::get('procedures/{procedure}/applications/{application}/edit', [ApplicationController::class, 'edit'])->name('admin.applications.edit');

// Route pour soumettre la mise à jour de l'application
Route::put('procedures/{procedure}/applications/{application}', [ApplicationController::class, 'update'])->name('admin.applications.update');

// Route pour supprimer une application
Route::post('procedures/{procedure}/applications/{application}', [ApplicationController::class, 'destroy'])->name('admin.applications.destroy');
// Route pour initier un paiement pour une application spécifique
Route::post('procedures/{procedure}/applications/{application}/payment', [PaymentController::class, 'createPayment'])->name('applications.payments.create');

// Route pour vérifier l'OTP d'un paiement spécifique lié à une application

Route::post('procedures/{procedure}/applications/{application}/payments/{payment}/verify', [PaymentController::class, 'verifyPayment'])->name('applications.payments.verify');


Route::get('procedures/{procedure}/applications/{application}/payments/create', [PaymentController::class, 'create'])->name('admin.payments.create');
Route::get('procedures/{procedure}/applications/{application}/payments/{payment}/verify', [PaymentController::class, 'showVerifyForm'])->name('admin.payments.verify');


// Route::post('registerdaf', [ControllersRegisterDafController::class, 'enregistrer'])->name('storeDaf');

Route::resources([
    'roles' => RoleController::class,
    'users' => UserController::class,
    'demandes' => DemandeBilletController::class,
    'offres' => OffreController::class,
    'procedures'=>ProcedureController::class,
    'procedures.fields' => FieldController::class,
    'procedures.applications' => ApplicationController::class,
    

]);
