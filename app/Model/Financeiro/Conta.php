<?php

namespace App\Model\Financeiro;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Conta extends Model
{
    use SoftDeletes;
    
    protected $table = 'financeiro_conta';
    
    public function contaTipo(){
        return $this->belongsTo('App\Model\Financeiro\ContaTipo', 'conta_tipo_id');
    }
    
    public function lancamento(){
    	return $this->hasMany('App\Model\Financeiro\Lancamento');
    }
    
    protected $casts = [
			'abertura' => 'date'
	];
   
}
