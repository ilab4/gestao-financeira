<?php namespace App\Http\Controllers\Financeiro;


use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Model\Financeiro\ContaTipo;
use App\Model\Financeiro\Conta;
use App\Model\Financeiro\Banco;
use Request;
use Session;


class ContaController extends FinanceiroController {
    
    
    public function __construct()
    {
        $this->middleware('authFinanceiroMiddleware');
    }
    
    public function index(){
        
        $resultado = Conta::with('contaTipo')->get();
        
        return view('financeiro/conta/index')->with('resultado', $resultado);
            
    }
    
    
    public function editar($id){
        
        $resultado = Conta::find($id);
        
        $resultado_contatipo = ContaTipo::all();
        
        $resultado_bancos = Banco::where(['ativo' => 1])->orderBy('descricao', 'ASC')->get();
        
        return view('financeiro/conta/data')->with('resultado', $resultado)->with('conta_tipo', $resultado_contatipo)->with('bancos', $resultado_bancos);
            
    }
    
    
    public function novo(){
        
        $resultado_contatipo = ContaTipo::all();
        
        $resultado_bancos = Banco::where(['ativo' => 1])->orderBy('descricao', 'ASC')->get();
        
        return view('financeiro/conta/data')->with('conta_tipo', $resultado_contatipo)->with('bancos', $resultado_bancos);
            
    }
    
    public function salvar(){
        
        if(Request::input('id') AND Request::input('id') > 0){
            $obj = Conta::find(Request::input('id'));
        } else {
            $obj = new Conta(); 
        }
             
        
        
        if(NULL !== Request::input('abertura')){
            $data_abertura_arr = explode("/", Request::input('abertura'));
            $data_abertura = $data_abertura_arr[2].'-'.$data_abertura_arr[1].'-'.$data_abertura_arr[0];
            $obj->abertura = $data_abertura;
        }
        
        if(NULL !== Request::input('valor')){
            $valor = Request::input('valor');
            $valor = str_replace(".","",$valor);
            $valor = str_replace(",",".",$valor);
            $obj->valor = $valor;
        }
        
        
        $obj->nome = Request::input('nome');
        $obj->conta_tipo_id = Request::input('conta_tipo_id');
        $obj->banco_id = Request::input('banco_id');
        $obj->agencia = Request::input('agencia');
        $obj->numero = Request::input('conta');
        $obj->contato = Request::input('contato');
        $obj->telefone = Request::input('telefone');
        $obj->email = Request::input('email');
        $obj->obs = Request::input('obs');
        $obj->dashboard = Request::input('dashboard');
        $obj->ativo = Request::input('ativo');
        $obj->save();
        
        Session::put('status.msg', 'Registro salvo com sucesso!');
        
        return redirect(getenv('APP_URL_FIN').'/financeiro/contas');
            
    }

}