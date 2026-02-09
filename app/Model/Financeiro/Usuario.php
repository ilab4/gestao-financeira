<?php

namespace App\Model\Financeiro;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $table = 'financeiro_usuario';
    
    protected $fillable = [
        'nome',
        'usuario',
        'senha',
        'admin',
        'ativo',
    ];
   
}
