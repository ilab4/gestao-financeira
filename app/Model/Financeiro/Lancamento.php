<?php

namespace App\Model\Financeiro;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lancamento extends Model
{
    use SoftDeletes;
    
    protected $table = 'financeiro_lancamento';
   
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
			'data_lancamento' => 'date'
	];
}
