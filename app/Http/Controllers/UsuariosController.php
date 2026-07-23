<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;


class UsuariosController extends Controller
{

    // Function para visualizar a pagina
    public function usuarios()
    {        
        
        // Testes
        //dd('Está no UsuariosController | Linha: ' . __LINE__);
        $usuarios = User::all();
        return view('usuarios', compact('usuarios'));
    }
}