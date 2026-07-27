<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class DespesasController extends Controller
{

    // Function para visualizar a pagina
    public function despesas()
    {        
        // Cada usuário vê seus próprios dados
        $usuario = Auth::user();
        
        // Testes
        //dd('Está no DespesasController | Linha: ' . __LINE__);
        return view('despesas');
    }
}