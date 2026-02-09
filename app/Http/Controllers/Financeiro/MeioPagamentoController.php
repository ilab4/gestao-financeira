<?php namespace App\Http\Controllers\Financeiro;


use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Model\Financeiro\FormaPagamento;
use Request;
use Session;


class MeioPagamentoController extends FinanceiroController {
    
    
    public function __construct()
    {
        $this->middleware('authFinanceiroMiddleware');
    }
    
    public function index(){
        
        $resultado = FormaPagamento::all();
        
        return view('financeiro/configuracao/meios_de_pagamento/index')->with('resultado', $resultado);
            
    }
    
    
    public function editar($id){
        
        $resultado = FormaPagamento::find($id);
        
        return view('financeiro/configuracao/meios_de_pagamento/data')->with('resultado', $resultado);
            
    }
    
    
    public function novo(){
        
        return view('financeiro/configuracao/meios_de_pagamento/data');
            
    }
    
    public function salvar(){
        
        if(Request::input('id') AND Request::input('id') > 0){
            $obj = FormaPagamento::find(Request::input('id'));
        } else {
            $obj = new FormaPagamento(); 
        }
             
        $ativo = 0;
        if(Request::input('ativo')){
            $ativo = 1;
        }
        
        $obj->descricao = Request::input('descricao');
        $obj->ativo = $ativo;
        $obj->save();
        
        Session::put('status.msg', 'Registro salvo com sucesso!');
        
        return redirect(getenv('APP_URL_FIN').'/financeiro/meios-de-pagamento');
            
    }

}