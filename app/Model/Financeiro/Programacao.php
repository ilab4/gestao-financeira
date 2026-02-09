<?php

namespace App\Model\Financeiro;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Programacao extends Model
{
    use SoftDeletes;
    
    protected $table = 'financeiro_programacao';
    
    public function documentoTipo(){
        return $this->belongsTo('App\Model\Financeiro\DocumentoTipo', 'documento_tipo_id');
    }
    
    public function formaPagamento(){
        return $this->belongsTo('App\Model\Financeiro\FormaPagamento', 'forma_pagamento_id');
    }
    
    public function planoConta(){
        return $this->belongsTo('App\Model\Financeiro\PlanoConta', 'plano_conta_id');
    }
    
    public function centroCusto(){
        return $this->belongsTo('App\Model\Financeiro\CentroCusto', 'centro_custo_id');
    }
    
    public function pessoa(){
        return $this->belongsTo('App\Model\Financeiro\Pessoa', 'pessoa_id');
    }
    
    public function conta(){
        return $this->belongsTo('App\Model\Financeiro\Conta', 'conta_id');
    }
    
    protected $casts = [
			'data_emissao' => 'date',
			'data_vencimento' => 'date',
			'data_competencia' => 'date',
			'data_recebimento' => 'date',
			'data_lancamento' => 'date'
	];
   
}
