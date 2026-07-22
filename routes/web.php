<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Só pode acessar essa rota quem NÃO está autenticado.
Route::middleware('guest')->group(function () { 
    Route::get('/', [LoginController::class, 'login'])->name('login'); // view
    // Rota para autenticação do usuario.
    Route::post('/authenticate-action', [LoginController::class, 'authenticateAction'])->name('authenticate'); // action
});


// Só pode acessar essa rota quem ESTÁ logado.
Route::middleware('auth')->group(function() {        

    Route::post('/logout-action', [LoginController::class, 'logoutAction'])->name('logout');// action
    Route::post('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');// view
});