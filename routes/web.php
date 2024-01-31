<?php

use App\Http\Controllers\DemandeBilletController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OffreController;
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
});

Auth::routes();

Route::get('/admin', [HomeController::class, 'index'])->name('backend.index');
//Route::get('/demande', [DemandeBilletController::class, 'demande'])->name('backend.demande');
//Route::get('/offre', [OffreController::class, 'offre'])->name('backend.offre');

Route::resources([
    'roles' => RoleController::class,
    'users' => UserController::class,
    'demandes' => DemandeBilletController::class,
    'offres' => OffreController::class,

]);
