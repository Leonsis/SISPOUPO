<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovimentacaoGrupo extends Model
{
    use HasFactory;

    protected $table = 'movimentacao_grupo';

    protected $fillable = [
        'user_id',
        'tipo_grupo',
        'valor_total',
        'quantidade_parcelas',
        'parcelas_pagas',
        'data_fim',
    ];

    protected $casts = [
        'valor_total' => 'decimal:2',
        'quantidade_parcelas' => 'integer',
        'parcelas_pagas' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function movimentacoes()
    {
        return $this->hasMany(MovimentacaoFinanceira::class, 'grupo_id');
    }
}