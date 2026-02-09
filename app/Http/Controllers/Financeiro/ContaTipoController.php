<?php namespace App\Http\Controllers\Financeiro;


use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Model\Financeiro\ContaTipo;
use Request;
use Session;


class ContaTipoController extends FinanceiroController {
    
    
    public function __construct()
    {
        $this->middleware('authFinanceiroMiddleware');
    }
    
    public function index(){
        
        $resultado = ContaTipo::all();
        
        return view('financeiro/configuracao/conta_tipo/index')->with('resultado', $resultado);
            
    }
    
    
    public function editar($id){
        
        $resultado = ContaTipo::find($id);
        
        return view('financeiro/configuracao/conta_tipo/data')->with('resultado', $resultado);
            
    }
    
    
    public function novo(){
        
        return view('financeiro/configuracao/conta_tipo/data');
            
    }
    
    public function salvar(){
        
        if(Request::input('id') AND Request::input('id') > 0){
            $obj = ContaTipo::find(Request::input('id'));
        } else {
            $obj = new ContaTipo(); 
        }
             
        $ativo = 0;
        if(Request::input('ativo')){
            $ativo = 1;
        }
        
        $obj->descricao = Request::input('descricao');
        $obj->ativo = $ativo;
        $obj->save();
        
        Session::put('status.msg', 'Registro salvo com sucesso!');
        
        return redirect(getenv('APP_URL_FIN').'/financeiro/conta-tipo');
            
    }

}