<?php namespace App\Http\Controllers\Financeiro;


use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Model\Financeiro\Banco;
use Request;
use Session;


class BancoController extends FinanceiroController {
    
    
    public function __construct()
    {
        $this->middleware('authFinanceiroMiddleware');
    }
    
    public function index(){
        
        $resultado = Banco::all();
        
        return view('financeiro/configuracao/banco/index')->with('resultado', $resultado);
            
    }
    
    
    public function editar($id){
        
        $resultado = Banco::find($id);
        
        return view('financeiro/configuracao/banco/data')->with('resultado', $resultado);
            
    }
    
    
    public function novo(){
        
        return view('financeiro/configuracao/banco/data');
            
    }
    
    public function salvar(){
        
        if(Request::input('id') AND Request::input('id') > 0){
            $obj = Banco::find(Request::input('id'));
        } else {
            $obj = new Banco(); 
        }
             
        $ativo = 0;
        if(Request::input('ativo')){
            $ativo = 1;
        }
        
        $obj->descricao = Request::input('descricao');
        $obj->numero = Request::input('numero');
        $obj->ativo = $ativo;
        $obj->save();
        
        Session::put('status.msg', 'Registro salvo com sucesso!');
        
        return redirect(getenv('APP_URL_FIN').'/financeiro/bancos');
            
    }

}