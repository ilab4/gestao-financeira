<?php

namespace App\Model\Financeiro;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pessoa extends Model
{
    use SoftDeletes;
    
    protected $table = 'financeiro_pessoa';
 
    public function categoria(){
        return $this->belongsTo('App\Model\Financeiro\Categoria', 'categoria_id');
    }
    
    public function cargo(){
        return $this->belongsTo('App\Model\Financeiro\Cargo', 'cargo_id');
    }
    
    public function lancamento(){
    	return $this->hasMany('App\Model\Financeiro\Lancamento');
    }
}
