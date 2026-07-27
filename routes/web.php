<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\DespesasController;
use App\Http\Controllers\ConfigController;

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
//Route::middleware('guest')->group(function () { 
    Route::get('/', [LoginController::class, 'login'])->name('login'); // view
    Route::post('/authenticate-action', [LoginController::class, 'authenticateAction'])->name('authenticate'); // action
//});


// Só pode acessar essa rota quem ESTÁ logado.
Route::middleware('auth')->group(function() {            
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');// view
    Route::get('/despesas', [DespesasController::class, 'despesas'])->name('despesas');// view
    Route::get('/usuarios', [UsuariosController::class, 'usuarios'])->name('usuarios');// view
    Route::get('/config', [ConfigController::class, 'config'])->name('config');// view
    Route::post('/store-action', [UsuariosController::class, 'storeAction'])->name('usuarios.store');// action
    Route::put('/update-action/{id}', [UsuariosController::class, 'updateAction'])->name('usuarios.update');// action
    Route::delete('/delete-action/{id}', [UsuariosController::class, 'destroyAction'])->name('usuarios.destroy');// action
    Route::post('/logout-action', [LoginController::class, 'logoutAction'])->name('logout');// action



    // TESTAR ROTAS
    // Criar cartão (POST)
    Route::post('/cartoes/store-action', [ConfigController::class, 'storeAction'])->name('cartoes.store');    
    // Atualizar cartão (PUT)
    Route::put('/cartoes/update-action/{id}', [ConfigController::class, 'updateAction'])->name('cartoes.update');    
    // Deletar cartão (DELETE)
    Route::delete('/cartoes/delete-action/{id}', [ConfigController::class, 'destroyAction'])->name('cartoes.destroy');
});

// Ex: Só pode acessar essa rota quem ESTÁ logado E é ADMIN
/*Route::middleware(['auth', 'user.type:USUARIO_ADMIN'])->group(function() {        
    Route::get('/usuarios', [UsuariosController::class, 'usuarios'])->name('usuarios');
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
});*/
