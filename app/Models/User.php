<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'nome_usuario',
        'nome',
        'tipo_usuario',
        'cpf',
        'telefone',
        'email',
        'password',
        'situacao_cadastral',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'situacao_cadastral' => 'boolean',
    ];
}