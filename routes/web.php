<?php

use App\Http\Controllers\Auth\RegisterDafController;
use App\Http\Controllers\HomeController;
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
Route::get('/demande', [HomeController::class, 'demande'])->name('backend.demande');
Route::post('/users/{user}/validate', [UserController::class, 'valider'])->name('users.activate');

Route::get('registerdaf', [RegisterDafController::class, 'createdaf'])->name('registerdaf');
Route::post('registerdaf', [UserController::class, 'storedaf'])->name('storeDaf');

Route::resources([
    'roles' => RoleController::class,
    'users' => UserController::class,

]);
