<?php

namespace App\Model\Financeiro;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DocumentoTipo extends Model
{
    use SoftDeletes;
    
    protected $table = 'financeiro_documento_tipo';
    
    public function programacao(){
    	return $this->hasMany('App\Model\Financeiro\Programacao');
    }
   
}
