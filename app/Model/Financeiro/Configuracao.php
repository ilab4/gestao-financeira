<?php

namespace App\Model\Financeiro;

use Illuminate\Database\Eloquent\Model;

class Configuracao extends Model
{
    protected $table = 'financeiro_configuracao';
    
    protected $fillable = [
        'nome',
        'email',
        'whatsapp',
        'cidade',
        'uf',
    ];
}
