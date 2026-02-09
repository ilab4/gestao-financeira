<?php namespace App\Http\Controllers\Financeiro;


use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Model\Financeiro\Pessoa;
use App\Model\Financeiro\Banco;
use App\Model\Financeiro\Categoria;
use App\Model\Financeiro\Lancamento;
use App\Model\Financeiro\CentroCusto;
use App\Model\Financeiro\PlanoConta;
use App\Model\Financeiro\Conta;
use App\Model\Financeiro\Programacao;
use Request;
use Session;


class LancamentoController extends FinanceiroController {
    
    
    public function __construct()
    {
        $this->middleware('authFinanceiroMiddleware');
    }
    
    public function index(){
        
        $url = $_SERVER["REQUEST_URI"];
        
        $url_arr = explode("/", $url);
        
        $area = end($url_arr);
        
        if($area == 'depositar'):
            $varArea = 'deposito';
            $varAreaBusca = 'C';
            $tipo_lancamento = 1;
        elseif($area == 'pagar'):
            $varAreaBusca = 'D';
            $varArea = 'pagamento';
            $tipo_lancamento = 2;
        elseif($area == 'transferir'):
            $varArea = 'transferencia';
        endif;
        
        $plano_de_contas = PlanoConta::where('ativo', '=', 1)->where('parent_id', '=', 0)->where('tipo_lancamento', '=', $tipo_lancamento)->orderBy('descricao', 'ASC')->get();
        $plano_array = array();
        foreach($plano_de_contas as $item):
            $plano_array[] = array('descricao' => $item->descricao, 'pai' => 1, 'id' => $item->id);
            $plano_de_contas_filhos = PlanoConta::where('ativo', '=', 1)->where('parent_id', '=', $item->id)->orderBy('descricao', 'ASC')->get();
            foreach($plano_de_contas_filhos as $item_filho):
                $plano_array[] = array('descricao' => $item_filho->descricao, 'pai' => 0, 'id' => $item_filho->id);
            endforeach;
        endforeach;
        

        $centro_de_custo = CentroCusto::where('ativo', '=', 1)->where('parent_id', '=', 0)->orderBy('descricao', 'ASC')->get();
        $centro_array = array();
        foreach($centro_de_custo as $item):
            $centro_array[] = array('descricao' => $item->descricao, 'pai' => 1, 'id' => $item->id);
            $centro_de_custo_filhos = CentroCusto::where('ativo', '=', 1)->where('parent_id', '=', $item->id)->orderBy('descricao', 'ASC')->get();
            foreach($centro_de_custo_filhos as $item_filho):
                $centro_array[] = array('descricao' => $item_filho->descricao, 'pai' => 0, 'id' => $item_filho->id);
            endforeach;
        endforeach;
        
        $contas_listagem = Conta::OrderBy('nome', 'ASC')->get();
        $plano_contas_listagem = PlanoConta::OrderBy('descricao', 'DESC')->get();
        $centro_custos_listagem = CentroCusto::OrderBy('descricao', 'ASC')->get();
        
        
        $plano_de_contas_receitas = PlanoConta::where('ativo', '=', 1)->where('parent_id', '=', 0)->where('tipo_lancamento', '=', 1)->orderBy('descricao', 'ASC')->get();
        $plano_receitas_array = array();
        foreach($plano_de_contas_receitas as $item):
            $plano_receitas_array[] = array('descricao' => $item->descricao, 'pai' => 1, 'id' => $item->id);
            $plano_de_contas_filhos = PlanoConta::where('ativo', '=', 1)->where('parent_id', '=', $item->id)->orderBy('descricao', 'ASC')->get();
            foreach($plano_de_contas_filhos as $item_filho):
                $plano_receitas_array[] = array('descricao' => $item_filho->descricao, 'pai' => 0, 'id' => $item_filho->id);
            endforeach;
        endforeach;
        
        $plano_de_contas_despesas = PlanoConta::where('ativo', '=', 1)->where('parent_id', '=', 0)->where('tipo_lancamento', '=', 2)->orderBy('descricao', 'ASC')->get();
        $plano_despesas_array = array();
        foreach($plano_de_contas_despesas as $item):
            $plano_despesas_array[] = array('descricao' => $item->descricao, 'pai' => 1, 'id' => $item->id);
            $plano_de_contas_filhos = PlanoConta::where('ativo', '=', 1)->where('parent_id', '=', $item->id)->orderBy('descricao', 'ASC')->get();
            foreach($plano_de_contas_filhos as $item_filho):
                $plano_despesas_array[] = array('descricao' => $item_filho->descricao, 'pai' => 0, 'id' => $item_filho->id);
            endforeach;
        endforeach;
        
        
        $contas = Conta::where(['ativo' => 1])->orderBy('nome', 'ASC')->get();
        $pessoas = Pessoa::where(['ativo' => 1])->orderBy('nome', 'ASC')->get();

        if($_POST):
            
            $periodo_fim = Request::input('dt_fim');
            $periodo_inicio = Request::input('dt_inicio');
            
            if(!empty($periodo_inicio)):
                $intervalo = "Período: de: " . $periodo_inicio . ' até: ' . $periodo_fim;
                $periodo_inicio_form = $periodo_inicio;
            endif;
            
            if(!empty($periodo_fim)):
                $periodo_fim_form = $periodo_fim;
            endif;
            
            $conta = Request::input('conta');
            $plano_conta = Request::input('plano_conta');
            $centro_custo = Request::input('centro_custo');

            $lancamentos = Lancamento::where(['operacao' => $varAreaBusca]);
            $lancamentos = $lancamentos->whereBetween('data_lancamento', [$periodo_inicio, $periodo_fim]);
            
            if(!empty($conta)):
                $lancamentos = $lancamentos->where('conta_id', '=', $conta);
                $conta_detalhe = Conta::find($conta);
                $conta_nome = $conta_detalhe->nome;
            endif;

            if(!empty($plano_conta)):
                $lancamentos = $lancamentos->where('plano_conta_id', '=', $plano_conta);
                $plano_conta_detalhe = PlanoConta::find($plano_conta);
                $plano_conta_nome = $plano_conta_detalhe->descricao;
            endif;
            
            if(!empty($centro_custo)):
                $lancamentos = $lancamentos->where('centro_custo_id', '=', $centro_custo);
                $centro_custo_detalhe = CentroCusto::find($centro_custo);
                $centro_custo_nome = $centro_custo_detalhe->descricao;
            endif;
            
            $lancamentos_result = $lancamentos->with('pessoa')->with('planoConta')->with('centroCusto')->with('conta')->orderBy('data_lancamento', 'ASC')->get();
            
        else:
            
            $hoje = Date('Y-m-d');
            $periodo_inicio_form = Date('Y-m-d');
            $periodo_fim_form = Date('Y-m-d');

            $lancamentos = Lancamento::where(['operacao' => $varAreaBusca]);
            $lancamentos = $lancamentos->whereBetween('data_lancamento', [$hoje, $hoje]);
            $lancamentos_result = $lancamentos->with('pessoa')->with('planoConta')->with('centroCusto')->with('conta')->orderBy('data_lancamento', 'ASC')->get();
            
            
        endif;
        
        
        
        return view('financeiro/lancamento/index')
                ->with('pessoas_lancamento', $pessoas)
                ->with('resultado', $lancamentos_result)
                ->with('area', $area)
                ->with('periodo_inicio_form', $periodo_inicio_form)
                ->with('periodo_fim_form', $periodo_fim_form)
                ->with('plano_de_contas', $plano_array)
                ->with('contas', $contas)
                ->with('centro_de_custo', $centro_array)
                ->with('contas_listagem', $contas_listagem)
                ->with('plano_contas_listagem', $plano_contas_listagem)
                ->with('centro_custos_listagem', $centro_custos_listagem)
                ->with('plano_de_contas_receitas', $plano_receitas_array)
                ->with('plano_de_contas_despesas', $plano_despesas_array);
            
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
        
        $usuario_id = Session::get('login.financeiro.usuario_id');
        
        $operacao = Request::input('operacao');
        
        if(Request::input('id') AND Request::input('id') > 0){
            $lancamento = Lancamento::find(Request::input('id'));
        } else {
            $lancamento = new Lancamento(); 
        }
        
        $data_lancamento = Request::input('data_lancamento');
        $data_competencia = Request::input('data_competencia');
       
        $valor = Request::input('valor');
        
        if($operacao == 'depositar'):
            $valor = $valor;
            $operador = 'C';
        elseif($operacao == 'pagar'):
            $valor = $valor*(-1);
            $operador = 'D';
        endif;
        
        
        $lancamento->operacao = $operador;
        $lancamento->conta_id = Request::input('conta_id');
        $lancamento->pessoa_id = Request::input('pessoa_id');
        $lancamento->plano_conta_id = Request::input('plano_conta_id');
        $lancamento->centro_custo_id = Request::input('centro_custo_id');
        $lancamento->historico = Request::input('historico');
        $lancamento->data_lancamento = $data_lancamento;
        $lancamento->competencia = $data_competencia;
        $lancamento->numero = Request::input('numero');
        $lancamento->valor = $valor;
        $lancamento->valor_total = $valor;
        $lancamento->obs = Request::input('obs');
        $lancamento->usuario_id = $usuario_id;
        
        if (Request::hasFile('anexo')) {
            $arquivo = Request::file('anexo'); // Aqui retornamos um objeto UploadedFile
            
            if ($arquivo->isValid()) {
                $arquivo_nome_final = $this->upload($arquivo);
                $lancamento->anexo = $arquivo_nome_final;
            }
        }
        
        
        $area = $operacao;

        if($lancamento->save()){
            Session::put('status.msg', 'Laçamento salvo com sucesso!');
            return redirect('financeiro/lancamento/'.$area);
        } else {
            Session::put('status.msg', 'Houve um erro ao salvar o registro.');
            return redirect('financeiro/lancamento/'.$area);
        }
        
    }
    
    public function salvar_transferencia(){
        
        $usuario_id = Session::get('login.financeiro.usuario_id');
         
        
        $data_lancamento = Request::input('data_lancamento');
        $data_competencia = Request::input('data_competencia');
        
        $valor = Request::input('valor');
        
        $conta_id_origem = Request::input('conta_id_origem');
        $conta_id_destino = Request::input('conta_id_destino');
        
        $conta_detalhe = Conta::find($conta_id_destino);
        
        $lancamento = new Lancamento();
        $lancamento->operacao = 'D';
        $lancamento->conta_id = $conta_id_origem;
        $lancamento->transferencia = 1;
        $lancamento->transferencia_texto = 'Para: ' . $conta_detalhe->nome;
        $lancamento->pessoa_id = 0;
        $lancamento->historico = Request::input('historico');
        $lancamento->data_lancamento = $data_lancamento;
        $lancamento->competencia = $data_competencia;
        $lancamento->numero = Request::input('numero');
        $lancamento->valor = $valor*(-1);
        $lancamento->valor_total = $valor*(-1);
        $lancamento->obs = Request::input('obs');
        $lancamento->usuario_id = $usuario_id;
        
        if (Request::hasFile('anexo')) {
            $arquivo = Request::file('anexo'); // Aqui retornamos um objeto UploadedFile
            
            if ($arquivo->isValid()) {
                $arquivo_nome_final = $this->upload($arquivo);
                $lancamento->anexo = $arquivo_nome_final;
            }
        }
        
        $lancamento->save();
        
        
        $conta_detalhe = Conta::find($conta_id_origem);
        
        $lancamento = new Lancamento();
        $lancamento->operacao = 'C';
        $lancamento->conta_id = $conta_id_destino;
        $lancamento->transferencia = 1;
        $lancamento->transferencia_texto = 'De: ' . $conta_detalhe->nome;
        $lancamento->pessoa_id = 0;
        $lancamento->historico = Request::input('historico');
        $lancamento->data_lancamento = $data_lancamento;
        $lancamento->competencia = $data_competencia;
        $lancamento->numero = Request::input('numero');
        $lancamento->valor = $valor;
        $lancamento->valor_total = $valor;
        $lancamento->obs = Request::input('obs');
        $lancamento->usuario_id = $usuario_id;
        
        if (Request::hasFile('anexo')) {
            $arquivo = Request::file('anexo'); // Aqui retornamos um objeto UploadedFile
            
            if ($arquivo->isValid()) {
                $arquivo_nome_final = $this->upload($arquivo);
                $lancamento->anexo = $arquivo_nome_final;
            }
        }
        
        $lancamento->save();
        
        $area = 'depositar';

        Session::put('status.msg', 'Transferência efetuada com sucesso!');
        return redirect('financeiro/lancamento/'.$area);
            
        
    }
    
    
    public function salvar_lancamento_programacao(){
        
        $usuario_id = Session::get('login.financeiro.usuario_id');
        
        $operacao = Request::input('operacao');
        $programacao_id = Request::input('programacao_id');
        
        $data_lancamento = Date('Y-m-d');
        
        $data_competencia = Request::input('data_competencia');
        $data_recebimento = Request::input('data_recebimento');
        
        $valor = Request::input('valor');
        $valor_multa = Request::input('multa');
        $valor_juros = Request::input('juros');
        $valor_desconto = Request::input('desconto');
        
        $valor_total = $valor + $valor_multa + $valor_juros - $valor_desconto;
        
        if($operacao == 'C'):
            $valor = $valor;
            $valor_total = $valor_total;
            $operador = 'a-receber';
            $texto = 'Recebimento';
        elseif($operacao == 'D'):
            $valor = $valor*(-1);
            $valor_total = $valor_total*(-1);
            $operador = 'a-pagar';
            $texto = 'Pagamento';
        endif;
        
        $lancamento = new Lancamento();
        $lancamento->operacao = $operacao;
        $lancamento->conta_id = Request::input('conta_id');
        $lancamento->pessoa_id = Request::input('pessoa_id');
        $lancamento->plano_conta_id = Request::input('plano_conta_id');
        $lancamento->centro_custo_id = Request::input('centro_custo_id');
        $lancamento->historico = Request::input('historico');
        $lancamento->data_lancamento = $data_recebimento;
        $lancamento->competencia = $data_competencia;
        $lancamento->numero = Request::input('numero');
        $lancamento->valor = $valor;
        $lancamento->valor_multa = $valor_multa;
        $lancamento->valor_juros = $valor_juros;
        $lancamento->valor_desconto = $valor_desconto;
        $lancamento->valor_total = $valor_total;
        $lancamento->obs = Request::input('obs');
        $lancamento->usuario_id = $usuario_id;
        
        if (Request::hasFile('anexo')) {
            $arquivo = Request::file('anexo'); // Aqui retornamos um objeto UploadedFile
            
            if ($arquivo->isValid()) {
                $arquivo_nome_final = $this->upload($arquivo);
                $lancamento->anexo = $arquivo_nome_final;
            }
        }
        
        
        $area = $operador;

        if($lancamento->save()){
            
            $programacao = Programacao::find($programacao_id);
            $programacao->status = 1;
            $programacao->data_lancamento = $data_lancamento;
            $programacao->data_recebimento = $data_recebimento;
            $programacao->lancamento_id = $lancamento->id;
            $programacao->valor_total = $valor_total;
            $programacao->save();
            
            Session::put('status.msg', $texto . ' efetuado com sucesso!');
            return redirect('financeiro/programado/'.$area);
            
        } else {
            
            Session::put('status.msg', 'Houve um erro ao salvar o registro.');
            return redirect('financeiro/programado/'.$area);
            
        }
        
    }
    
    
    public function excluir($id){
        
        $lancamento = Lancamento::find($id);
        
        $operacao = $lancamento->operacao;
        
        if($operacao == 'D'):
            $area = 'pagar';
        elseif($operacao == 'C'):
            $area = 'depositar';
        endif;
        
        $exclusao = Lancamento::find($id)->delete();
        
        Session::put('status.msg', 'Registro excluído com sucesso!');
        return redirect('financeiro/lancamento/'.$area);

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