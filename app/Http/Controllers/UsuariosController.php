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
        //dd('UsuariosController | Linha: ' . __LINE__);
        $vUsuarios = User::all();
        $vNTotalUsuarios = DB::table('users')->count();
            return view('usuarios', compact('vUsuarios', 'vNTotalUsuarios'));
    }    
    
    public function storeAction(Request $request)
    {                            

        // Remove formatação do CPF/CNPJ
        $vCpf_cnpj = preg_replace('/[^A-Z0-9]/', '', $request->cpf_cnpj);

        // Valida CPF/CNPJ
        if(!$this->validarCpfCnpj($vCpf_cnpj)) {
            return back()
                    ->withErrors(['cpf_cnpj' => 'CPF/CNPJ Invalido.'])
                    ->withInput();
        }                

        // ✅ VALIDAÇÃO DE DUPLICIDADE ANTES DE INSERIR
        // Verifica se CPF/CNPJ já existe
        $existingCpfCnpj = User::where('cpf_cnpj', $vCpf_cnpj)->first();
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

        $data['cpf_cnpj'] = $vCpf_cnpj;
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

    private function validarCpfCnpj(string $pCpf_cnpj): bool 
    {

        $vTamanho = strlen($pCpf_cnpj);

        // Valida o tamanho do CPF/CNPJ
        if ($vTamanho != 11 && $vTamanho != 14) {
            return false;
        }

        if($vTamanho != 14) {            
            $vCpf = $pCpf_cnpj;

            // Rejeita CPFs com todos os dígitos iguais
            if (preg_match('/^(\d)\1{10}$/', $vCpf)) {
                return false;
            }

            // ============================================
            // PRIMEIRO DÍGITO VERIFICADOR
            // ============================================
            $vSoma = 0;

            for ($vI = 0; $i < 9; $vI++) {
                $vSoma += intval($vCpf[$vI]) * (10 - $vI);
            }

            $vResto = $vSoma % 11;

            $vDv1 = ($vResto < 2) ? 0 : 11 - $vResto;

            if ($vDv1 !== intval($vCpf[9])) {
                return false;
            }

            // ============================================
            // SEGUNDO DÍGITO VERIFICADOR
            // ============================================
            $vSoma = 0;

            for ($vI = 0; $vI < 10; $vI++) {
                $vSoma += intval($vCpf[$vI]) * (11 - $vI);
            }

            $vResto = $vSoma % 11;

            $vDv2 = ($vResto < 2) ? 0 : 11 - $vResto;

            if ($vDv2 !== intval($vCpf[10])) {
                return false;
            }

            return true;
        } 
        else {
            $vCnpj = $pCpf_cnpj;

            // As 12 primeiras posições podem ser A-Z ou 0-9
            // Os 2 últimos caracteres devem ser dígitos
            if (!preg_match('/^[A-Z0-9]{12}[0-9]{2}$/', $vCnpj)) {
                return false;
            }

            // Evita CNPJ formado apenas por zeros
            if ($vCnpj === '00000000000000') {
                return false;
            }

            /**
             * Converte o caractere para o valor utilizado
             * no cálculo do CNPJ alfanumérico.
             *
             * Número:
             * ASCII - 48
             *
             * Letra:
             * ASCII - 48
             */
            $vValorCaractere = function ($vCaractere) {
                return ord($vCaractere) - 48;
            };

            // ============================================
            // PRIMEIRO DÍGITO VERIFICADOR
            // ============================================
            $vPesos = [5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];

            $vSoma = 0;

            for ($vI = 0; $vI < 12; $vI++) {
                $vValor = $vValorCaractere($vCnpj[$vI]);
                $vSoma += $vValor * $vPesos[$vI];
            }

            $vResto = $vSoma % 11;

            $vDv1 = 11 - $vResto;

            if ($vDv1 >= 10) {
                $vDv1 = 0;
            }

            // Compara com o primeiro dígito informado
            if ($vDv1 !== intval($vCnpj[12])) {
                return false;
            }

            // ============================================
            // SEGUNDO DÍGITO VERIFICADOR
            // ============================================
            $vPesos = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];

            $vSoma = 0;

            for ($vI = 0; $vI < 13; $vI++) {
                $vValor = $vValorCaractere($vCnpj[$vI]);
                $vSoma += $vValor * $vPesos[$vI];
            }

            $vResto = $vSoma % 11;

            $vDv2 = 11 - $vResto;

            if ($vDv2 >= 10) {
                $vDv2 = 0;
            }

            // Compara com o segundo dígito informado
            if ($vDv2 !== intval($vCnpj[13])) {
                return false;
            }

            return true;
        }
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