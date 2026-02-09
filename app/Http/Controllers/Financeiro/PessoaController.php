<?php namespace App\Http\Controllers\Financeiro;


use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Model\Financeiro\Pessoa;
use App\Model\Financeiro\Banco;
use App\Model\Financeiro\Categoria;
use Request;
use Session;


class PessoaController extends FinanceiroController {
    
    
    public function __construct()
    {
        $this->middleware('authFinanceiroMiddleware');
    }
    
    public function index(){
        
        $url = $_SERVER["REQUEST_URI"];
        
        $url_arr = explode("/", $url);
        
        $area = end($url_arr);
        
        if($area == 'clientes'):
            $varArea = 'cliente';
        elseif($area == 'colaboradores'):
            $varArea = 'colaborador';
        elseif($area == 'fornecedores'):
            $varArea = 'fornecedor';
        endif;
        
        $pessoas = Pessoa::where(['tipo_cadastro' => $varArea])->with('categoria')->with('cargo')->orderBy('nome', 'ASC')->get();
        
        return view('financeiro/pessoa/index')->with('pessoas', $pessoas)->with('area', $area);
            
    }
    
    public function novo(){
        
        $url = $_SERVER["REQUEST_URI"];
        $url = str_replace("/novo", "", $url);
        
        $url_arr = explode("/", $url);
        
        $area = end($url_arr);
        
        $bancos = Banco::where(["ativo" => 1])->orderBy('descricao', 'ASC')->get();
        $categorias = Categoria::where(["ativo" => 1])->orderBy('descricao', 'ASC')->get();
        
        return view('financeiro/pessoa/data')->with('bancos', $bancos)->with('categorias', $categorias)->with('area', $area);
            
    }
    
    public function editar($id){
        
        $bancos = Banco::where(["ativo" => 1])->orderBy('descricao', 'ASC')->get();
        $categorias = Categoria::where(["ativo" => 1])->orderBy('descricao', 'ASC')->get();
        
        $pessoa = Pessoa::find($id);
        return view('financeiro/pessoa/data')->with('p', $pessoa)->with('bancos', $bancos)->with('categorias', $categorias);
            
    } 
    
    public function salvar(){
        
     
        if(Request::input('id') AND Request::input('id') > 0){
            $pessoa = Pessoa::find(Request::input('id'));
        } else {
            $pessoa = new Pessoa(); 
        }
        
        $ativo = 0;
        if(Request::input('ativo')){
            $ativo = 1;
        }
        
        $area = Request::input('area');
        if($area == 'clientes'):
            $varArea = 'cliente';
        elseif($area == 'colaboradores'):
            $varArea = 'colaborador';
        elseif($area == 'fornecedores'):
            $varArea = 'fornecedor';
        endif;
        
        $cep = Request::input('cep');
        $cep = str_replace(".","",$cep);
        $cep = str_replace("-","",$cep);
        
        $cnpj_cpf = Request::input('cnpj_cpf');
        $cnpj_cpf = str_replace(".","",$cnpj_cpf);
        $cnpj_cpf = str_replace("-","",$cnpj_cpf);
        $cnpj_cpf = str_replace("/","",$cnpj_cpf);
        
        $pessoa->nome = Request::input('nome');
        $pessoa->cnpj_cpf = $cnpj_cpf;
        $pessoa->tipo_pessoa = Request::input('tipo');
        $pessoa->tipo_cadastro = $varArea;
        $pessoa->email = Request::input('email');
        $pessoa->categoria_id = Request::input('categoria');
        $pessoa->celular = Request::input('celular');
        $pessoa->telefone1 = Request::input('telefone1');
        $pessoa->telefone2 = Request::input('telefone2');
        $pessoa->cep = $cep;
        $pessoa->endereco = Request::input('endereco');
        $pessoa->numero = Request::input('numero');
        $pessoa->complemento = Request::input('complemento');
        $pessoa->bairro = Request::input('bairro');
        $pessoa->cidade = Request::input('cidade');
        $pessoa->uf = Request::input('uf');
        $pessoa->obs = Request::input('obs');
        
        $pessoa->conta_banco = Request::input('conta_banco');
        $pessoa->conta_tipo = Request::input('conta_tipo');
        $pessoa->conta_agencia = Request::input('conta_agencia');
        $pessoa->conta_numero = Request::input('conta_numero');
        $pessoa->conta_obs = Request::input('conta_obs');
        $pessoa->ativo = $ativo;

        if($pessoa->save()){
            Session::put('status.msg', 'Registro salvo com sucesso!');
            return redirect('financeiro/pessoa/'.$area);
        } else {
            return view('financeiro/pessoa/data');
        }
        
    }  
    
    public function _ajax_cnpj_cpf(){
        
        $cnpj_cpf = Request::input('cnpj_cpf');
        
        $pessoa = Pessoa::where(['cnpj_cpf' => $cnpj_cpf])->get();

        if(count($pessoa)):
            return 2;
        else:
            return 1;
        endif;
        
    }
    
    public function _ajax_cep(){
        
        $cep = Request::input('cep');
        $cep = str_replace(".","",$cep);
        $cep = str_replace("-","",$cep);
        
        $ceps = DB::select("SELECT logradouro, tipo_logradouro, cidade, bairro, uf
		 	  FROM protense_financeiro.aux_bairro b, protense_financeiro.aux_cidade c, protense_financeiro.aux_endereco e
			  WHERE e.id_bairro = b.id_bairro AND c.id_cidade = b.id_cidade AND cep='$cep'");
        
        if(count($ceps)){
            $dados['sucesso'] = (int) 1;
            $dados['endereco']= (string) $ceps[0]->tipo_logradouro . ' ' . $ceps[0]->logradouro ;
            $dados['bairro']  = (string) utf8_encode($ceps[0]->bairro);
            $dados['cidade']  = (string) utf8_encode($ceps[0]->cidade);
            $dados['uf']  = (string) $ceps[0]->uf;

        } else {
            $dados['sucesso'] = (int) 0;

        }

        echo json_encode($dados);
        
    }
    
    
}