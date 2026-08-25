<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\MovimentacaoFinanceira;
use App\Models\CartaoCredito;
use App\Models\MovimentacaoGrupo;
use Carbon\Carbon;

class DespesasController extends Controller
{

    // Function para visualizar a pagina
    public function despesas()
    {       
        // Testes
        //dd('Está no DespesasController | Linha: ' . __LINE__);

        // Busca todas as movimentações do usuário logado
        $movimentacoes = MovimentacaoFinanceira::select(
                            'mf.id',
                            'mf.user_id',
                            'mf.descricao',
                            'mf.tipo_movimentacao',
                            'mf.valor',
                            'mf.classificacao_financeira',
                            'mf.status_pagamento',
                            'mf.forma_pagamento',
                            'mf.quantidade_parcelas',
                            'mf.data_pagamento',
                            'mf.dia_vencimento',
                            'mf.created_at',
                            'mf.despesa_repete_mes',
                            'cc.nome_cartao'
                        )
                        ->from('movimentacao_financeira as mf')
                        ->leftJoin('cartao_credito as cc', 'cc.id', '=', 'mf.cartao_credito_id')
                        ->where('mf.user_id', Auth::id())
                        ->where('mf.tipo_movimentacao', 'D')
                        // Descomentar para que o sistema busque apenas as despesas do mês atual e as despesas atrasadas do mês anterior
                        ->whereRaw("
                            (
                                MONTH(mf.data_vencimento) = MONTH(CURDATE()) 
                                AND YEAR(mf.data_vencimento) = YEAR(CURDATE())
                            )
                            OR
                            (
                                MONTH(mf.data_vencimento) = MONTH(CURDATE() - INTERVAL 1 MONTH)
                                AND YEAR(mf.data_vencimento) = YEAR(CURDATE() - INTERVAL 1 MONTH)
                                AND mf.status_pagamento = 'Atrasado'
                            )
                        ")
                        ->orderBy('mf.created_at', 'desc')
                        ->get();

        
        $nTotalDespesas = MovimentacaoFinanceira::where('tipo_movimentacao', 'D')->count();
       
        // Busca cartões para o select
        $cartoes = CartaoCredito::where('user_id', Auth::id())->get();
        
        $totalValor = MovimentacaoFinanceira::select(                            
                            'mf.valor'
                        )
                        ->from('movimentacao_financeira as mf')
                        ->leftJoin('cartao_credito as cc', 'cc.id', '=', 'mf.cartao_credito_id')
                        ->where('mf.user_id', Auth::id())
                        ->where('mf.tipo_movimentacao', 'D')
                        ->sum('mf.valor');

        // ============================================
        // MÊS ATUAL E ANTERIOR
        // ============================================
        
        $dataAtual = Carbon::now();
        $mesAtual = $dataAtual->month;
        $anoAtual = $dataAtual->year;
        
        $dataAnterior = Carbon::now()->subMonthNoOverflow();
        $mesAnterior = $dataAnterior->month;
        $anoAnterior = $dataAnterior->year;        

        // Despesas Fixas - Mês Atual
        $vTotalFixaMesAtual = MovimentacaoFinanceira::where('user_id', Auth::id())
            ->where('tipo_movimentacao', 'D')
            ->where('classificacao_financeira', 'Fixa')
            ->whereMonth('data_pagamento', $mesAtual)
            ->whereYear('data_pagamento', $anoAtual)
            ->sum('valor');

        // Despesas Fixas - Mês Anterior
        $vTotalFixaMesAnterior = MovimentacaoFinanceira::where('user_id', Auth::id())
            ->where('tipo_movimentacao', 'D')
            ->where('classificacao_financeira', 'Fixa')
            ->whereMonth('data_pagamento', $mesAnterior)
            ->whereYear('data_pagamento', $anoAnterior)
            ->sum('valor');

        // Despesas Variáveis - Mês Atual
        $vTotalVariavelMesAtual = MovimentacaoFinanceira::where('user_id', Auth::id())
            ->where('tipo_movimentacao', 'D')
            ->where('classificacao_financeira', 'Variável')
            ->whereMonth('data_pagamento', $mesAtual)
            ->whereYear('data_pagamento', $anoAtual)
            ->sum('valor');

        // Despesas Variáveis - Mês Anterior
        $vTotalVariavelMesAnterior = MovimentacaoFinanceira::where('user_id', Auth::id())
            ->where('tipo_movimentacao', 'D')
            ->where('classificacao_financeira', 'Variável')
            ->whereMonth('data_pagamento', $mesAnterior)
            ->whereYear('data_pagamento', $anoAnterior)
            ->sum('valor');                        
                    
        return view('despesas', compact('movimentacoes', 'nTotalDespesas', 'cartoes', 'totalValor', 'vTotalFixaMesAtual', 'vTotalFixaMesAnterior', 'vTotalVariavelMesAtual', 'vTotalVariavelMesAnterior'));
    }

    // Function para visualizar a pagina de detalhamento
    public function detalhamentoDespesas($id)
    {       
        // Testes
        //dd('Está no DespesasController | Linha: ' . __LINE__);
        $movimentacoes = MovimentacaoFinanceira::select(
                            'mf.id',
                            'mf.user_id',
                            'mf.descricao',
                            'mf.tipo_movimentacao',
                            'mf.valor',
                            'mf.classificacao_financeira',
                            'mf.status_pagamento',
                            'mf.forma_pagamento',
                            'mf.quantidade_parcelas',
                            'mf.data_pagamento',
                            'mf.dia_vencimento',                            
                            'mf.created_at',
                            'mf.despesa_repete_mes',
                            'cc.nome_cartao'
                        )
                        ->from('movimentacao_financeira as mf')
                        ->leftJoin('cartao_credito as cc', 'cc.id', '=', 'mf.cartao_credito_id')
                        ->where('mf.id', $id)
                        ->where('mf.user_id', Auth::id())                        
                        ->where('mf.tipo_movimentacao', 'D')
                        ->orderBy('mf.created_at', 'desc')
                        ->firstOrFail();
        $movimentacoes = $movimentacoes->first(); // Pega o primeiro registro do resultado da consulta
        //dd($movimentacoes);
        $nTotalDespesas = MovimentacaoFinanceira::where('tipo_movimentacao', 'D')->count();
       
        $cartoes = CartaoCredito::where('user_id', Auth::id())->get();              

        $totalValor = MovimentacaoFinanceira::select(                            
                            'mf.valor'
                        )
                        ->from('movimentacao_financeira as mf')
                        ->leftJoin('cartao_credito as cc', 'cc.id', '=', 'mf.cartao_credito_id')
                        ->where('mf.user_id', Auth::id())
                        ->where('mf.tipo_movimentacao', 'D')
                        ->sum('mf.valor');

        // ============================================
        // MÊS ATUAL E ANTERIOR
        // ============================================
        
        $dataAtual = Carbon::now();
        $mesAtual = $dataAtual->month;
        $anoAtual = $dataAtual->year;
        
        $dataAnterior = Carbon::now()->subMonthNoOverflow();
        $mesAnterior = $dataAnterior->month;
        $anoAnterior = $dataAnterior->year;        

        $vTotalFixaMesAtual = MovimentacaoFinanceira::where('user_id', Auth::id())
            ->where('tipo_movimentacao', 'D')
            ->where('classificacao_financeira', 'Fixa')
            ->whereMonth('data_pagamento', $mesAtual)
            ->whereYear('data_pagamento', $anoAtual)
            ->sum('valor');

        $vTotalFixaMesAnterior = MovimentacaoFinanceira::where('user_id', Auth::id())
            ->where('tipo_movimentacao', 'D')
            ->where('classificacao_financeira', 'Fixa')
            ->whereMonth('data_pagamento', $mesAnterior)
            ->whereYear('data_pagamento', $anoAnterior)
            ->sum('valor');

        $vTotalVariavelMesAtual = MovimentacaoFinanceira::where('user_id', Auth::id())
            ->where('tipo_movimentacao', 'D')
            ->where('classificacao_financeira', 'Variável')
            ->whereMonth('data_pagamento', $mesAtual)
            ->whereYear('data_pagamento', $anoAtual)
            ->sum('valor');

        $vTotalVariavelMesAnterior = MovimentacaoFinanceira::where('user_id', Auth::id())
            ->where('tipo_movimentacao', 'D')
            ->where('classificacao_financeira', 'Variável')
            ->whereMonth('data_pagamento', $mesAnterior)
            ->whereYear('data_pagamento', $anoAnterior)
            ->sum('valor');                                
        return view('detalhamentoDespesa', compact('movimentacoes', 'nTotalDespesas', 'cartoes', 'totalValor', 'vTotalFixaMesAtual', 'vTotalFixaMesAnterior', 'vTotalVariavelMesAtual', 'vTotalVariavelMesAnterior'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeAction(Request $request)
    {
        // Testes
        //dd('Está no MovimentacaoFinanceiraController | Linha: ' . __LINE__);
        dd($request->all());   

        // Validações básicas
        $data = $request->validate([
            'descricao' => 'required|string|max:255',            
            'valor' => 'required|numeric|min:0',
            'classificacao_financeira' => 'required',
            'status_pagamento' => 'required',
            //'forma_pagamento' => 'required',
            'quantidade_parcelas' => 'nullable|integer|min:0',
            'cartao_credito_id' => 'nullable|exists:cartao_credito,id',
            'data_pagamento' => 'nullable|date',
            'dia_vencimento' => 'nullable|numeric|min:0|max:31',            
            'despesa_repete_mes' => 'nullable|boolean',
        ], [
            'descricao.required' => 'A descrição é obrigatória.',
            'descricao.max' => 'A descrição não pode ter mais de 255 caracteres.',
            
            'valor.required' => 'O valor é obrigatório.',
            'valor.numeric' => 'O valor deve ser um número válido.',
            'valor.min' => 'O valor deve ser maior ou igual a 0.',
            
            'classificacao_financeira.required' => 'A classificação financeira é obrigatória.',
            
            'status_pagamento.required' => 'O status de pagamento é obrigatório.',
            
            //'forma_pagamento.required' => 'A forma de pagamento é obrigatória.',    
            
            'quantidade_parcelas.integer' => 'O número de parcelas deve ser um número inteiro.',
            'quantidade_parcelas.min' => 'O número de parcelas deve ser maior ou igual a 0.',
            
            'cartao_credito_id.exists' => 'O cartão de crédito selecionado não é válido.',
            
            'data_pagamento.date' => 'A data de pagamento deve ser uma data válida.',
            
            'dia_vencimento.numeric' => 'O dia de vencimento deve ser um número válido.',
            'dia_vencimento.min' => 'O dia de vencimento deve ser no mínimo 0.',
            'dia_vencimento.max' => 'O dia de vencimento deve ser no máximo 31.',        
        
            'despesa_repete_mes.boolean' => 'O campo repetir no próximo mês deve ser verdadeiro ou falso.',
        ]);

        $agora = Carbon::now();
        $data['data_vencimento'] = sprintf('%04d-%02d-%02d', $agora->year, $agora->month, $data['dia_vencimento']);
        
        // ✅ Tratamento do checkbox (se não veio, é 0)
        $data['despesa_repete_mes'] = $request->has('despesa_repete_mes') ? 1 : 0;

        // Adiciona o user_id
        $data['user_id'] = Auth::id();
        
        // Adiciona o tipo_movimentacao
        $data['tipo_movimentacao'] = 'D';

        // ============================================
        // VERIFICA SE TEM PARCELAS
        // ============================================
        $quantidadeParcelas = (int) $data['quantidade_parcelas'];

        if ($quantidadeParcelas > 1) {
            // ============================================
            // CRIA O GRUPO DE PARCELAS
            // ============================================
            $tipoGrupo = 'OUTROS';
            $formaPagamento = $data['forma_pagamento'];
            
            if ($formaPagamento === 'CARTAO_CREDITO' || $formaPagamento === 'Crédito') {
                $tipoGrupo = 'CARTAO_CREDITO';
            } elseif ($formaPagamento === 'BOLETO' || $formaPagamento === 'Boleto') {
                $tipoGrupo = 'BOLETO';
            } elseif ($formaPagamento === 'PIX' || $formaPagamento === 'Pix') {
                $tipoGrupo = 'PIX';
            }

            // Calcula o valor de cada parcela
            $valorParcela = $data['valor'] / $quantidadeParcelas;

            // Cria o grupo
            $grupo = MovimentacaoGrupo::create([
                'user_id' => Auth::id(),
                'tipo_grupo' => $tipoGrupo,
                'valor_total' => $data['valor'],
                'quantidade_parcelas' => $quantidadeParcelas,
                'parcelas_pagas' => 0,
            ]);

            // ============================================
            // CRIA AS PARCELAS INDIVIDUAIS
            // ============================================
            for ($i = 1; $i <= $quantidadeParcelas; $i++) {
                // Define o dia de vencimento (se não informado, usa o dia atual)
                $diaVencimento = $data['dia_vencimento'] ?? date('d');
                
                // ✅ CORRIGIDO: Aumenta o mês a cada parcela
                $dataBase = Carbon::now()->addMonths($i - 1);
                
                // ✅ Cria a data de vencimento com o dia personalizado
                $dataVencimento = sprintf('%04d-%02d-%02d', $dataBase->year, $dataBase->month, $diaVencimento);
                
                // Define o status da parcela (a primeira pode ser paga, as demais pendentes)
                $statusPagamento = ($i === 1 && $data['status_pagamento'] === 'Pago') ? 'Pago' : 'Pendente';
                
                // Cria a parcela
                MovimentacaoFinanceira::create([
                    'user_id' => Auth::id(),
                    'grupo_id' => $grupo->id,
                    'descricao' => $data['descricao'] . ' - Parcela ' . $i . '/' . $quantidadeParcelas,
                    'tipo_movimentacao' => 'D',
                    'valor' => $valorParcela,
                    'classificacao_financeira' => $data['classificacao_financeira'],
                    'status_pagamento' => $statusPagamento,
                    'forma_pagamento' => $data['forma_pagamento'],
                    'quantidade_parcelas' => $quantidadeParcelas,
                    'cartao_credito_id' => $data['cartao_credito_id'] ?? null,
                    'data_pagamento' => ($i == 1 && $data['status_pagamento'] == 'Pago') ? Carbon::now() : null, // Inicialmente nula, será atualizada conforme o pagamento
                    'data_vencimento' => $dataVencimento,
                    'dia_vencimento' => $diaVencimento,
                    'despesa_repete_mes' => $data['despesa_repete_mes'],
                ]);
            }

            // ✅ REMOVIDO: Atualização do grupo com data_fim (não usado mais)

            return redirect()->route('despesas')->with('success', 'Despesa parcelada criada com sucesso! ' . $quantidadeParcelas . ' parcelas geradas.');

        } else {
            // ============================================
            // DESPESA ÚNICA (SEM PARCELAS)
            // ============================================
            // Cria a movimentação
            MovimentacaoFinanceira::create($data);

            return redirect()->route('despesas')->with('success', 'Movimentação cadastrada com sucesso!');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateAction(Request $request, $id)
    {
        // Testes
        //dd('Está no MovimentacaoFinanceiraController | Linha: ' . __LINE__);
        
        try {
            // Busca a movimentação pelo ID e verifica se pertence ao usuário logado
            $movimentacao = MovimentacaoFinanceira::where('id', $id)
                                                ->where('user_id', Auth::id())
                                                ->firstOrFail();

            // Regras de validação
            $rules = [
                'descricao' => 'required|string|max:255',
                'valor' => 'required|numeric|min:0',
                'classificacao_financeira' => 'required',
                'status_pagamento' => 'required',
                'forma_pagamento' => 'required',
                'quantidade_parcelas' => 'nullable|integer|min:0',
                'cartao_credito_id' => 'nullable|exists:cartao_credito,id',
                'data_pagamento' => 'nullable|date',
                'dia_vencimento' => 'nullable|integer|min:0',
                'despesa_repete_mes' => 'nullable|boolean',
            ];

            // Mensagens de validação
            $messages = [
                'descricao.required' => 'A descrição é obrigatória.',
                'descricao.max' => 'A descrição não pode ter mais de 255 caracteres.',
                
                'valor.required' => 'O valor é obrigatório.',
                'valor.numeric' => 'O valor deve ser um número válido.',
                'valor.min' => 'O valor deve ser maior ou igual a 0.',
                
                'classificacao_financeira.required' => 'A classificação financeira é obrigatória.',
                
                'status_pagamento.required' => 'O status de pagamento é obrigatório.',
                
                'forma_pagamento.required' => 'A forma de pagamento é obrigatória.',
                
                'quantidade_parcelas.integer' => 'O número de parcelas deve ser um número inteiro.',
                'quantidade_parcelas.min' => 'O número de parcelas deve ser maior ou igual a 0.',
                
                'cartao_credito_id.exists' => 'O cartão de crédito selecionado não é válido.',
                
                'data_pagamento.date' => 'A data de pagamento deve ser uma data válida.',

                'dia_vencimento.integer' => 'O dia de vencimento deve ser um número inteiro.',
                'dia_vencimento.min' => 'O dia de vencimento deve ser maior ou igual a 0.',
                
                'despesa_repete_mes.boolean' => 'O campo repetir no próximo mês deve ser verdadeiro ou falso.',
            ];

            // Valida os dados
            $data = $request->validate($rules, $messages);

            // Verifica se o cartão de crédito pertence ao usuário
            if ($request->filled('cartao_credito_id')) {
                $cartao = CartaoCredito::where('id', $request->cartao_credito_id)
                                    ->where('user_id', Auth::id())
                                    ->first();
                
                if (!$cartao) {
                    return back()
                        ->withErrors(['cartao_credito_id' => 'Cartão de crédito não encontrado ou não pertence ao usuário.'])
                        ->withInput();
                }
            }

            // Mantém o tipo_movimentacao como 'D' (Despesa)
            $data['tipo_movimentacao'] = 'D';

            // Atualiza a movimentação
            $movimentacao->update($data);

            // Retorna JSON para requisições AJAX
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Movimentação atualizada com sucesso!',
                    'data' => $movimentacao->fresh()
                ]);
            }

            return redirect()->route('despesas')->with('success', 'Movimentação atualizada com sucesso!');

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Movimentação não encontrada!'
                ], 404);
            }
            return redirect()->route('despesas')->with('error', 'Movimentação não encontrada!');
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'errors' => $e->errors()
                ], 422);
            }
            return back()->withErrors($e->errors())->withInput();
            
        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erro ao atualizar movimentação: ' . $e->getMessage()
                ], 500);
            }
            return back()
                ->withErrors(['error' => 'Erro ao atualizar movimentação: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyAction($id)
    {
        // Testes
        //dd('Está no MovimentacaoFinanceiraController | Linha: ' . __LINE__);

        try {
            // Busca a movimentação pelo ID e verifica se pertence ao usuário logado
            $movimentacao = MovimentacaoFinanceira::where('id', $id)
                                                  ->where('user_id', Auth::id())
                                                  ->firstOrFail();
            
            // Exclui a movimentação
            $movimentacao->delete();
            
            // Retorna sucesso
            return response()->json([
                'success' => true,
                'message' => 'Movimentação excluída com sucesso!'
            ]);
            
        } catch (\Exception $e) {
            // Retorna erro
            return response()->json([
                'success' => false,
                'message' => 'Erro ao excluir movimentação: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get totals for dashboard (AJAX).
     */
    public function getTotals()
    {
        $totalReceitas = MovimentacaoFinanceira::where('user_id', Auth::id())
                        ->where('tipo_movimentacao', 'RECEITA')
                        ->sum('valor');
        
        $totalDespesas = MovimentacaoFinanceira::where('user_id', Auth::id())
                        ->where('tipo_movimentacao', 'DESPESA')
                        ->sum('valor');
        
        $saldo = $totalReceitas - $totalDespesas;
        
        $movimentacoesPendentes = MovimentacaoFinanceira::where('user_id', Auth::id())
                                    ->whereIn('status_pagamento', ['NAO_PAGO', 'pendente', 'atrasado'])
                                    ->count();

        return response()->json([
            'success' => true,
            'data' => [
                'total_receitas' => $totalReceitas,
                'total_despesas' => $totalDespesas,
                'saldo' => $saldo,
                'movimentacoes_pendentes' => $movimentacoesPendentes,
            ]
        ]);
    }

    /**
     * Filter movimentacoes by date range.
     */
    public function filterByDate(Request $request)
    {
        $query = MovimentacaoFinanceira::where('user_id', Auth::id());

        if ($request->filled('data_inicio')) {
            $query->whereDate('created_at', '>=', $request->data_inicio);
        }

        if ($request->filled('data_fim')) {
            $query->whereDate('created_at', '<=', $request->data_fim);
        }

        if ($request->filled('tipo_movimentacao')) {
            $query->where('tipo_movimentacao', $request->tipo_movimentacao);
        }

        if ($request->filled('status_pagamento')) {
            $query->where('status_pagamento', $request->status_pagamento);
        }

        $movimentacoes = $query->orderBy('created_at', 'desc')->get();

        return response()->json([
            'success' => true,
            'data' => $movimentacoes
        ]);
    }

    /**
    * Get expenses that should be repeated.
    */
    public function getDespesasRepetirAction()
    {
        try {
            // Busca despesas do mês anterior com despesa_repete_mes = 1
            $mesAnterior = Carbon::now()->subMonth()->month;
            $anoAnterior = Carbon::now()->subMonth()->year;
            
            // ✅ Busca despesas do mês anterior que devem ser repetidas
            $despesas = MovimentacaoFinanceira::where('user_id', Auth::id())
                ->where('tipo_movimentacao', 'D')
                ->where('despesa_repete_mes', 1)
                ->whereMonth('data_pagamento', $mesAnterior)
                ->whereYear('data_pagamento', $anoAnterior)
                ->get();
            
            // Verifica se já foram criadas neste mês (evita duplicação)
            $mesAtual = Carbon::now()->month;
            $anoAtual = Carbon::now()->year;
            
            $despesasFiltradas = [];
            
            foreach ($despesas as $despesa) {
                // Verifica se já existe uma despesa igual neste mês
                $existe = MovimentacaoFinanceira::where('user_id', Auth::id())
                    ->where('tipo_movimentacao', 'D')
                    ->where('descricao', $despesa->descricao)
                    ->where('valor', $despesa->valor)
                    ->where('classificacao_financeira', $despesa->classificacao_financeira)
                    ->whereMonth('created_at', $mesAtual)
                    ->whereYear('created_at', $anoAtual)
                    ->exists();
                
                if (!$existe) {
                    $despesasFiltradas[] = $despesa;
                }
            }
            
            return response()->json([
                'success' => true,
                'data' => $despesasFiltradas
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao buscar despesas: ' . $e->getMessage()
            ], 500);
        }
    }

}