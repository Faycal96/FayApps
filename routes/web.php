<?php

use App\Http\Controllers\AgenceAcrediteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('registerdaf', [UserController::class, 'createdaf'])->name('registerdaf');
Route::post('registerdaf', [UserController::class, 'storedaf']);

Route::get('register', [UserController::class, 'create'])->name('register');
Route::post('register/store', [UserController::class, 'storeAgence'])->name('storeAgence');




Route::resource('agences', AgenceAcrediteController::class)->only(['index', 'create', 'show', 'edit', 'update', 'destroy']);

Route::post('agences/store', [AgenceAcrediteController::class, 'store'])->name('enregistrer');

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::resources([
    'roles' => RoleController::class,
    'users' => UserController::class,

]);

// // Routes spécifiques pour l'enregistrement d'utilisateurs
// Route::get('users/register', [UserController::class, 'create'])->name('users.register');
// Route::post('users/register', [UserController::class, 'store']);

