<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UsuariosController;

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
    Route::post('/authenticate-action', [LoginController::class, 'authenticateAction'])->name('authenticate'); // action
});


// Só pode acessar essa rota quem ESTÁ logado.
Route::middleware('auth')->group(function() {        
    Route::post('/logout-action', [LoginController::class, 'logoutAction'])->name('logout');// action
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');// view
    Route::get('/usuarios', [UsuariosController::class, 'usuarios'])->name('usuarios');// view
});

// Ex: Só pode acessar essa rota quem ESTÁ logado E é ADMIN
/*Route::middleware(['auth', 'user.type:USUARIO_ADMIN'])->group(function() {        
    Route::get('/usuarios', [UsuariosController::class, 'usuarios'])->name('usuarios');
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
});*/
