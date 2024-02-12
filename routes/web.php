<?php

use App\Http\Controllers\CityController;
use App\Http\Controllers\DemandeBilletController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OffreController;
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

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Auth::routes();

Route::get('/admin', [HomeController::class, 'index'])->name('backend.index');
//Route::get('/demande', [DemandeBilletController::class, 'demande'])->name('backend.demande');
Route::post('/users/{user}/validate', [UserController::class, 'valider'])->name('users.activate');
//Route::get('/offre', [OffreController::class, 'offre'])->name('backend.offre');
Route::patch('/users/{user}/activer', [UserController::class, 'activer'])->name('users.toggleStatus');
Route::patch('/users/{user}/toggleStatus', [UserController::class, 'toggleStatus'])->name('users.toggleStatus');

Route::post('/offres/offre/{demande}', [OffreController::class, 'offre'])->name('offres.offre');
Route::get('/cities', [CityController::class, 'index']);
Route::patch('/demandes/{demande}/toggleStatus', [DemandeBilletController::class, 'toggleStatus'])->name('demandes.toggleStatus');

Route::get('registerdaf', [RegisterDafController::class, 'afficherFormulaire'])->name('registerdaf');
Route::post('/storeDaf', [RegisterDafController::class, 'enregistrer'])->name('storeDaf');
Route::post('/offres/{offre}/valider', [OffreController::class, 'valider'])->name('offres.valider');
Route::post('/offres/{offre}/rejeter', [OffreController::class, 'rejeter'])->name('offres.rejeter');

// Route::post('registerdaf', [ControllersRegisterDafController::class, 'enregistrer'])->name('storeDaf');

Route::resources([
    'roles' => RoleController::class,
    'users' => UserController::class,
    'demandes' => DemandeBilletController::class,
    'offres' => OffreController::class,

]);
