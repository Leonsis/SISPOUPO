<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\CartaoCredito;


class ConfigController extends Controller
{

    // Function para visualizar a pagina
    public function config()
    {        
        // Cada usuário vê seus próprios dados
        $usuario = Auth::user();
        
        // Testes
        //dd('Está no ConfigController | Linha: ' . __LINE__);
        $cartoes = CartaoCredito::all();
        $nTotalCartoes = DB::table('cartao_credito')->count();
        $totalLimite = CartaoCredito::sum('limite_credito');
        return view('config', compact('cartoes', 'nTotalCartoes', 'totalLimite'));
    }


    public function storeAction(Request $request)
    {
        // Testes
        //dd('Está no ConfigController | Linha: ' . __LINE__);
        // Valida os dados do formulário
        $data = $request->validate([
            'nome_cartao' => 'required|string|max:100',
            'limite_credito' => 'required|numeric|min:0|max:9999999999.99',
            'dia_vencimento' => 'required|numeric|min:0',
        ], [
            'nome_cartao.required' => 'O nome do cartão é obrigatório.',
            'limite_credito.required' => 'O limite de crédito é obrigatório.',
            'limite_credito.numeric' => 'O limite deve ser um número válido.',
            'limite_credito.min' => 'O limite deve ser maior ou igual a 0.',
            'dia_vencimento.required' => 'A data de vencimento é obrigatória.',
            'dia_vencimento.after_or_equal' => 'A data de vencimento deve ser hoje ou uma data futura.',
        ]);

        // Adiciona o user_id do usuário logado
        $data['user_id'] = Auth::id();

        // Cria o cartão de crédito
        CartaoCredito::create($data);

        return redirect()->route('config')->with('success', 'Cartão de crédito cadastrado com sucesso!');
    }

    public function updateAction(Request $request, $id)
    {
        // Busca o cartão pelo ID e verifica se pertence ao usuário logado
        $cartao = CartaoCredito::where('id', $id)
                               ->where('user_id', Auth::id())
                               ->firstOrFail();

        // Valida os dados
        $data = $request->validate([
            'nome_cartao' => 'required|string|max:100',
            'limite_credito' => 'required|numeric|min:0|max:9999999999.99',
            'dia_vencimento' => 'required|date|after_or_equal:today',
        ], [
            'nome_cartao.required' => 'O nome do cartão é obrigatório.',
            'limite_credito.required' => 'O limite de crédito é obrigatório.',
            'limite_credito.numeric' => 'O limite deve ser um número válido.',
            'limite_credito.min' => 'O limite deve ser maior ou igual a 0.',
            'dia_vencimento.required' => 'A data de vencimento é obrigatória.',
            'dia_vencimento.after_or_equal' => 'A data de vencimento deve ser hoje ou uma data futura.',
        ]);

        // Atualiza o cartão
        $cartao->update($data);

        return redirect()->route('cartoes')->with('success', 'Cartão de crédito atualizado com sucesso!');
    }

    public function destroyAction($id)
    {
        try {
            // Busca o cartão pelo ID e verifica se pertence ao usuário logado
            $cartao = CartaoCredito::where('id', $id)
                                   ->where('user_id', Auth::id())
                                   ->firstOrFail();

            $cartao->delete();

            return response()->json([
                'success' => true,
                'message' => 'Cartão de crédito excluído com sucesso!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao excluir cartão: ' . $e->getMessage()
            ], 500);
        }
    }
}