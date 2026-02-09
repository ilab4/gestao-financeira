<?php namespace App\Http\Controllers\Financeiro;


use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Model\Financeiro\Categoria;
use Request;
use Session;


class CategoriaController extends FinanceiroController {
    
    
    public function __construct()
    {
        $this->middleware('authFinanceiroMiddleware');
    }
    
    public function index(){
        
        $resultado = Categoria::all();
        
        return view('financeiro/configuracao/categoria/index')->with('resultado', $resultado);
            
    }
    
    
    public function editar($id){
        
        $resultado = Categoria::find($id);
        
        return view('financeiro/configuracao/categoria/data')->with('resultado', $resultado);
            
    }
    
    
    public function novo(){
        
        return view('financeiro/configuracao/categoria/data');
            
    }
    
    public function salvar(){
        
        if(Request::input('id') AND Request::input('id') > 0){
            $obj = Categoria::find(Request::input('id'));
        } else {
            $obj = new Categoria(); 
        }
             
        $ativo = 0;
        if(Request::input('ativo')){
            $ativo = 1;
        }
        
        $obj->descricao = Request::input('descricao');
        $obj->ativo = $ativo;
        $obj->save();
        
        Session::put('status.msg', 'Registro salvo com sucesso!');
        
        return redirect(getenv('APP_URL_FIN').'/financeiro/categorias');
            
    }

}