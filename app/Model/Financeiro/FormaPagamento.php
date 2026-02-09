<?php

namespace App\Model\Financeiro;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormaPagamento extends Model
{
    use SoftDeletes;
    
    protected $table = 'financeiro_forma_pagamento';
   
    public function programacao(){
    	return $this->hasMany('App\Model\Financeiro\Programacao');
    }
    
}
