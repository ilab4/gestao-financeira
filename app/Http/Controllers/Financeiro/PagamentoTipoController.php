<?php namespace App\Http\Controllers\Painel;


use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\PagamentoTipo;
use Request;
use Session;


class PagamentoTipoController extends PainelController {
    
    
    public function __construct()
    {
        $this->middleware('authMiddleware');
    }
    
    public function index(){
        
        $pagamentos_tipo = PagamentoTipo::orderBy('descricao', 'ASC')->get();
        return view('painel/configuracao/pagamento_tipo/index')->with('pagamentos_tipo', $pagamentos_tipo);
            
    }
    
    public function download(){
        
        $pagamentos_tipo = PagamentoTipo::orderBy('descricao', 'ASC')->get();
        return view('painel/configuracao/pagamento_tipo/download')->with('pagamentos_tipo', $pagamentos_tipo);
            
    }
    
    public function novo(){
        
        return view('painel/configuracao/pagamento_tipo/data');
            
    }
    
    public function editar($id){
        
        $pagamento_tipo = PagamentoTipo::find($id);
        return view('painel/configuracao/pagamento_tipo/data')->with('p', $pagamento_tipo);
            
    } 
    
    public function salvar(){
        
        if(Request::input('id') AND Request::input('id') > 0){
            $pagamento_tipo = PagamentoTipo::find(Request::input('id'));
        } else {
            $pagamento_tipo = new PagamentoTipo(); 
        }
        
        $ativo = 0;
        if(Request::input('ativo')){
            $ativo = 1;
        }
        
        $pagamento_tipo->descricao = Request::input('descricao');
        $pagamento_tipo->ativo = $ativo;

        if($pagamento_tipo->save()){
            
            Session::put('status.msg', 'Tipo de pagamento salvo com sucesso!');
            return redirect('painel/tipos-de-pagamento');
            
        } else {
            
            return view('painel/configuracao/pagamento_tipo/data');
            
        }
        
    }    
    
}