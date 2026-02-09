<?php

namespace App\Model\Financeiro;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlanoConta extends Model
{
    use SoftDeletes;
    
    protected $table = 'financeiro_plano_conta';
   
    public function lancamento(){
    	return $this->hasMany('App\Model\Financeiro\Lancamento');
    }
}
