<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UsuariosController extends Controller
{

    // Function para visualizar a pagina
    public function usuarios()
    {        
        
        // Testes
        //dd('Está no UsuariosController | Linha: ' . __LINE__);
        $usuarios = User::all();
        $nTotalUsuarios = DB::table('users')->count();
            return view('usuarios', compact('usuarios', 'nTotalUsuarios'));
    }


    public function storeAction(Request $request)
    {
        // Remove formatação do CPF/CNPJ
        $cpf_cnpj = preg_replace('/[^a-zA-Z0-9]/', '', $request->cpf_cnpj);
        $tamanho = strlen($cpf_cnpj);

        // Valida o tamanho
        if ($tamanho != 11 && $tamanho != 14) {
            return back()
                ->withErrors(['cpf_cnpj' => 'CPF deve ter 11 dígitos ou CNPJ 14 dígitos.'])
                ->withInput();
        }

        // ✅ VALIDAÇÃO DE DUPLICIDADE ANTES DE INSERIR
        // Verifica se CPF/CNPJ já existe
        $existingCpfCnpj = User::where('cpf_cnpj', $cpf_cnpj)->first();
        if ($existingCpfCnpj) {
            return back()
                ->withErrors(['cpf_cnpj' => 'Este CPF/CNPJ já está cadastrado.'])
                ->withInput();
        }

        // Verifica se Nome de Usuário já existe
        $existingUsername = User::where('nome_usuario', $request->nome_usuario)->first();
        if ($existingUsername) {
            return back()
                ->withErrors(['nome_usuario' => 'Este Nome de Usuário já está em uso.'])
                ->withInput();
        }

        // Verifica se Email já existe
        $existingEmail = User::where('email', $request->email)->first();
        if ($existingEmail) {
            return back()
                ->withErrors(['email' => 'Este E-mail já está cadastrado.'])
                ->withInput();
        }

        // Se passou por todas as validações, cria o usuário
        $data = $request->validate([
            'nome_usuario' => 'required|string|max:100',
            'nome'         => 'required|string|max:100',
            'tipo_usuario' => 'required|string|max:50',
            'cpf_cnpj'     => 'required|string',
            'telefone'     => 'required|string|max:20',
            'email'        => 'required|email|max:100',
            'password'     => 'required|string',
            'situacao_cadastral' => 'required|integer|in:0,1',
        ]);

        $data['cpf_cnpj'] = $cpf_cnpj;
        $data['password'] = bcrypt($data['password']);
        
        User::create($data);

        return redirect()->route('usuarios')->with('success', 'Usuário cadastrado com sucesso!');
    }

    public function updateAction(Request $request, $id)
    {
        // Testes
        //dd('Está no UsuariosController | Linha: ' . __LINE__);

        // Busca o usuário pelo ID
        $usuario = User::findOrFail($id);

        // Remove formatação do CPF/CNPJ
        $cpf_cnpj = preg_replace('/[^0-9]/', '', $request->cpf_cnpj);
        $tamanho = strlen($cpf_cnpj);

        // Valida o tamanho do CPF/CNPJ
        if ($tamanho != 11 && $tamanho != 14) {
            return back()
                ->withErrors(['cpf_cnpj' => 'CPF deve ter 11 dígitos ou CNPJ 14 dígitos.'])
                ->withInput();
        }
    
        // Regras de validação
        $rules = [
            'nome_usuario' => 'required|string|max:100|unique:users,nome_usuario,' . $id,
            'nome'         => 'required|string|max:100',
            'tipo_usuario' => 'required|string|max:50',
            'cpf_cnpj'     => 'required|string|unique:users,cpf_cnpj,' . $id,
            'telefone'     => 'required|string|max:20',
            'email'        => 'required|email|max:100',
            'situacao_cadastral' => 'required|integer|in:0,1',
        ];

        // Se a senha foi preenchida, adiciona validação
        if ($request->filled('password')) {
            $rules['password'] = 'required|string|min:6|confirmed';
        }

        // Valida os dados
        $data = $request->validate($rules);

        // Substitui pelo CPF sem formatação
        $data['cpf_cnpj'] = $cpf_cnpj;

        // Se a senha foi preenchida, criptografa
        if ($request->filled('password')) {
            $data['password'] = Hash::make($data['password']);
        } else {
            // Remove o campo password para não alterar
            unset($data['password']);
        }

        // Atualiza o usuário
        $usuario->update($data);

        // Redireciona com mensagem de sucesso
        return redirect()->route('usuarios')->with('success', 'Usuário atualizado com sucesso!');
    }

    public function destroyAction($id)
    {
        // Testes
        //dd('Está no UsuariosController | Linha: ' . __LINE__);

        try {
            // Busca o usuário pelo ID
            $usuario = User::findOrFail($id);
            
            // Verifica se não está tentando excluir a si mesmo (opcional)
            if (auth()->check() && auth()->id() == $id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Você não pode excluir seu próprio usuário!'
                ], 403);
            }
            
            // Exclui o usuário
            $usuario->delete();
            
            // Retorna sucesso
            return response()->json([
                'success' => true,
                'message' => 'Usuário excluído com sucesso!'
            ]);
            
        } catch (\Exception $e) {
            // Retorna erro
            return response()->json([
                'success' => false,
                'message' => 'Erro ao excluir usuário: ' . $e->getMessage()
            ], 500);
        }
    }
}