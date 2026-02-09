<?php namespace App\Http\Controllers\Financeiro;


use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Model\Financeiro\Cargo;
use Request;
use Session;


class CargoController extends FinanceiroController {
    
    
    public function __construct()
    {
        $this->middleware('authFinanceiroMiddleware');
    }
    
    public function index(){
        
        $resultado = Cargo::all();
        
        return view('financeiro/configuracao/cargo/index')->with('resultado', $resultado);
            
    }
    
    
    public function editar($id){
        
        $resultado = Cargo::find($id);
        
        return view('financeiro/configuracao/cargo/data')->with('resultado', $resultado);
            
    }
    
    
    public function novo(){
        
        return view('financeiro/configuracao/cargo/data');
            
    }
    
    public function salvar(){
        
        if(Request::input('id') AND Request::input('id') > 0){
            $obj = Cargo::find(Request::input('id'));
        } else {
            $obj = new Cargo(); 
        }
             
        $ativo = 0;
        if(Request::input('ativo')){
            $ativo = 1;
        }
        
        $obj->descricao = Request::input('descricao');
        $obj->ativo = $ativo;
        $obj->save();
        
        Session::put('status.msg', 'Registro salvo com sucesso!');
        
        return redirect(getenv('APP_URL_FIN').'/financeiro/cargos');
            
    }

}