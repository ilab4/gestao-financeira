<?php

namespace App\Model\Financeiro;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CentroCusto extends Model
{
    use SoftDeletes;
    
    protected $table = 'financeiro_centro_custo';
   
    public function lancamento(){
    	return $this->hasMany('App\Model\Financeiro\Lancamento');
    }
}
