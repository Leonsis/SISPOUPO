<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Exibe a página de login.
    */
    public function login() 
    {
        // Testes
        //dd('Está no LoginController | Linha: ' . __LINE__);
        return view('login');
    }

    /*
     * Faz a autenticação do usuário e redireciona para a página de dashboard.
    */
    public function authenticateAction(Request $request) 
    {
        // Testes
        //dd('Está no LoginController | Linha: ' . __LINE__);
        
        $credentials = $request->only('nome_usuario', 'password');
        
        if (Auth::attempt($credentials)) {
            
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        //return redirect()->route('login')->with('error', 'Usuario ou senha invalidas');
        return redirect(url('/') . '/')->with('error', 'Usuario ou senha invalidas');
    }


    /*
     * Function para deslogar da seção.
    */
    public function logoutAction(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate(); // Invalida a sessão atual.
        $request->session()->regenerateToken(); //Regenera o token CSRF para evitar ataques de falsificação de solicitação entre sites (CSRF).]
        
        return redirect('/login');
    }
}