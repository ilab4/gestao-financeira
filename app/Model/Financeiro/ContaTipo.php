<?php

namespace App\Model\Financeiro;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContaTipo extends Model
{
    use SoftDeletes;
    
    protected $table = 'financeiro_conta_tipo';
    
    public function conta(){
    	return $this->hasMany('App\Model\Financeiro\Conta');
    }
   
}
