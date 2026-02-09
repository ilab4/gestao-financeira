<?php namespace App\Http\Controllers\Financeiro;


use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Model\Financeiro\Configuracao;
use Request;
use Session;


class ConfiguracaoController extends FinanceiroController {
    
    
    public function __construct()
    {
        $this->middleware('authFinanceiroMiddleware');
    }
    
    public function sistema(){
        
        $sistema = Configuracao::find(1);
        

        return view('financeiro/configuracao/sistema/data')->with('sistema', $sistema);
            
    }
    
    public function sistema_salvar(){
        
        if(Request::input('id') AND Request::input('id') > 0){
            $configuracao = Configuracao::find(Request::input('id'));
        } else {
            $configuracao = new Configuracao(); 
        }
        
        $cnpj = str_replace(".","", Request::input('cnpj'));
        $cnpj = str_replace("-","", $cnpj);
        $cnpj = str_replace("/","", $cnpj);
        
        $configuracao->nome = Request::input('nome');
        $configuracao->cnpj = $cnpj;
        $configuracao->email = Request::input('email');
        $configuracao->telefone = Request::input('telefone');
        $configuracao->whatsapp = Request::input('whatsapp');
        $configuracao->cep = Request::input('cep');
        $configuracao->endereco = Request::input('endereco');
        $configuracao->numero = Request::input('numero');
        $configuracao->bairro = Request::input('bairro');
        $configuracao->cidade = Request::input('cidade');
        $configuracao->uf = Request::input('uf');
        
        $configuracao->save();
        
        Session::put('status.msg', 'Configuração do sistema salva com sucesso!');
        
        return redirect(getenv('APP_URL_FIN').'/financeiro/configuracao');
            
    }

}