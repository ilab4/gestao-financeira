<?php

namespace App\Model\Financeiro;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categoria extends Model
{
    use SoftDeletes;
    
    protected $table = 'financeiro_categoria';
   
    public function pessoa(){
    	return $this->hasMany('App\Model\Financeiro\Pessoa');
    }
}
