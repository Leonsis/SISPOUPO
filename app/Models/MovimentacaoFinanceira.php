<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovimentacaoFinanceira extends Model
{
    use HasFactory;

    // ============================================
    // CONSTANTES PARA TIPOS
    // ============================================

    /**
     * Tipos de movimentação
     */
    const TIPO_RECEITA = 'RECEITA';
    const TIPO_DESPESA = 'DESPESA';

    /**
     * Classificações financeiras
     */
    const CLASSIFICACAO_FIXA = 'FIXA';
    const CLASSIFICACAO_VARIAVEL = 'VARIAVEL';

    /**
     * Status de pagamento
     */
    const STATUS_PAGO = 'PAGO';
    const STATUS_NAO_PAGO = 'NAO_PAGO';
    const STATUS_PENDENTE = 'pendente';
    const STATUS_ATRASADO = 'atrasado';

    /**
     * Formas de pagamento
     */
    const FORMA_DINHEIRO = 'DINHEIRO';
    const FORMA_CARTAO_CREDITO = 'CARTAO_CREDITO';
    const FORMA_CARTAO_DEBITO = 'CARTAO_DEBITO';
    const FORMA_PIX = 'PIX';
    const FORMA_TRANSFERENCIA = 'TRANSFERENCIA_BANCARIA';
    const FORMA_BOLETO = 'boleto';
    const FORMA_CHEQUE = 'cheque';

    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'movimentacao_financeira';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'descricao',
        'tipo_movimentacao',
        'valor',
        'classificacao_financeira',
        'status_pagamento',
        'forma_pagamento',
        'quantidade_parcelas',
        'cartao_credito_id',
        'grupo_id', // ← ADICIONADO
        'data_pagamento',
        'data_vencimento',
        'dia_vencimento',
        'Observacoes',
        'despesa_repete_mes',
    ];

    // Adicione o relacionamento
    public function grupo()
    {
        return $this->belongsTo(MovimentacaoGrupo::class, 'grupo_id');
    }

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'valor' => 'decimal:2',
        'quantidade_parcelas' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        // Nenhum campo sensível
    ];

    // ============================================
    // RELACIONAMENTOS
    // ============================================

    /**
     * Get the user that owns the movimentacao financeira.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the cartao de credito associated with the movimentacao financeira.
     */
    public function cartaoCredito()
    {
        return $this->belongsTo(CartaoCredito::class, 'cartao_credito_id');
    }

    // ============================================
    // SCOPES (Consultas comuns)
    // ============================================

    /**
     * Scope a query to only include receitas.
     */
    public function scopeReceitas($query)
    {
        return $query->where('tipo_movimentacao', 'RECEITA');
    }

    /**
     * Scope a query to only include despesas.
     */
    public function scopeDespesas($query)
    {
        return $query->where('tipo_movimentacao', 'DESPESA');
    }

    /**
     * Scope a query to only include movimentacoes pagas.
     */
    public function scopePagas($query)
    {
        return $query->where('status_pagamento', 'PAGO');
    }

    /**
     * Scope a query to only include movimentacoes nao pagas.
     */
    public function scopeNaoPagas($query)
    {
        return $query->where('status_pagamento', 'NAO_PAGO');
    }

    /**
     * Scope a query to only include movimentacoes pendentes.
     */
    public function scopePendentes($query)
    {
        return $query->where('status_pagamento', 'pendente');
    }

    /**
     * Scope a query to only include movimentacoes atrasadas.
     */
    public function scopeAtrasadas($query)
    {
        return $query->where('status_pagamento', 'atrasado');
    }

    /**
     * Scope a query to only include despesas fixas.
     */
    public function scopeFixas($query)
    {
        return $query->where('classificacao_financeira', 'FIXA');
    }

    /**
     * Scope a query to only include despesas variaveis.
     */
    public function scopeVariaveis($query)
    {
        return $query->where('classificacao_financeira', 'VARIAVEL');
    }

    // ============================================
    // MÉTODOS AUXILIARES
    // ============================================

    /**
     * Verifica se a movimentação é uma receita.
     */
    public function isReceita()
    {
        return $this->tipo_movimentacao === 'RECEITA';
    }

    /**
     * Verifica se a movimentação é uma despesa.
     */
    public function isDespesa()
    {
        return $this->tipo_movimentacao === 'DESPESA';
    }

    /**
     * Verifica se a movimentação está paga.
     */
    public function isPago()
    {
        return $this->status_pagamento === 'PAGO';
    }

    /**
     * Verifica se a movimentação é fixa.
     */
    public function isFixa()
    {
        return $this->classificacao_financeira === 'FIXA';
    }

    /**
     * Verifica se a movimentação é variável.
     */
    public function isVariavel()
    {
        return $this->classificacao_financeira === 'VARIAVEL';
    }

    /**
     * Get the formatted valor.
     */
    public function getValorFormatadoAttribute()
    {
        return 'R$ ' . number_format($this->valor, 2, ',', '.');
    }

    /**
     * Get the status pagamento label.
     */
    public function getStatusPagamentoLabelAttribute()
    {
        $labels = [
            'PAGO' => 'Pago',
            'NAO_PAGO' => 'Não Pago',
            'pendente' => 'Pendente',
            'atrasado' => 'Atrasado',
        ];
        return $labels[$this->status_pagamento] ?? $this->status_pagamento;
    }

    /**
     * Get the tipo movimentacao label.
     */
    public function getTipoMovimentacaoLabelAttribute()
    {
        $labels = [
            'RECEITA' => 'Receita',
            'DESPESA' => 'Despesa',
        ];
        return $labels[$this->tipo_movimentacao] ?? $this->tipo_movimentacao;
    }

    /**
     * Get the classificacao financeira label.
     */
    public function getClassificacaoFinanceiraLabelAttribute()
    {
        $labels = [
            'FIXA' => 'Fixa',
            'VARIAVEL' => 'Variável',
        ];
        return $labels[$this->classificacao_financeira] ?? $this->classificacao_financeira;
    }

    /**
     * Get the forma pagamento label.
     */
    public function getFormaPagamentoLabelAttribute()
    {
        $labels = [
            'DINHEIRO' => 'Dinheiro',
            'CARTAO_CREDITO' => 'Cartão de Crédito',
            'CARTAO_DEBITO' => 'Cartão de Débito',
            'PIX' => 'PIX',
            'TRANSFERENCIA_BANCARIA' => 'Transferência Bancária',
            'boleto' => 'Boleto',
            'cheque' => 'Cheque',
        ];
        return $labels[$this->forma_pagamento] ?? $this->forma_pagamento;
    }
}