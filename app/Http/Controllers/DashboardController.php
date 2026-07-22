<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class DashboardController extends Controller
{

    // Function para visualizar a pagina
    public function dashboard()
    {        
        
        // Testes
        dd('Está no DashboardController | Linha: ' . __LINE__);
        return view('dashboard', compact());
    }
}