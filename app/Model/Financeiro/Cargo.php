<?php

namespace App\Model\Financeiro;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cargo extends Model
{
    use SoftDeletes;
    
    protected $table = 'financeiro_cargo';
    
    public function pessoa(){
    	return $this->hasMany('App\Model\Financeiro\Pessoa');
    }
   
}
