<?php namespace App\Http\Controllers\Financeiro;


use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Request;
use Session;
use App\Model\Financeiro\Lancamento;
use App\Model\Financeiro\Conta;
use App\Model\Financeiro\Programacao;
use App\Model\Financeiro\Pessoa;
use App\Model\Financeiro\PlanoConta;
use App\Model\Financeiro\CentroCusto;

class RelatorioController extends FinanceiroController {
    
    public function __construct()
    {
        $this->middleware('authFinanceiroMiddleware');
        
    }
    
    public function saldo_contas(){
        
        $hoje = Date('Y-m-d');
        
        $usuario_id = Session::get('login.financeiro.usuario_id');
        
        $contas_listagem = Conta::OrderBy('nome', 'DESC')->get();
        
        $conta_nome = '';
                
        if($_POST):
            
            $periodo_inicio_form = '';
            $periodo_fim = Request::input('dt_fim');
            $periodo_fim_form = Request::input('dt_fim');
            $conta = Request::input('conta');
            
            if(!empty($periodo_fim)):
                $intervalo = "Saldo Até: $periodo_fim";
            endif;
            
            
            if(!empty($conta)):
                
                $conta_detalhe = Conta::find($conta); 
            
                $lancamentos = Lancamento::where('conta_id', '=', $conta);
            
                if(!empty($periodo_fim)):
                    $lancamentos = $lancamentos->where('data_lancamento', '<=', $periodo_fim);
                endif;

                $lancamentos_result = $lancamentos->select(DB::raw('sum(valor_total) as valor_total'))->first();

                $contas_arr[$conta_detalhe->id]['nome'] = $conta_detalhe->nome;  
                $contas_arr[$conta_detalhe->id]['saldo'] = $lancamentos_result->valor_total + $conta_detalhe->valor;
                $contas_saldo = $lancamentos_result->valor_total + $conta_detalhe->valor;
                
                $conta_nome = $conta_detalhe->nome;
            else:
                
                $contas = Conta::OrderBy('nome', 'ASC')->get();
                $contas_arr = array();
                $contas_saldo = 0;

                foreach ($contas as $conta):
                    $contas_arr[$conta->id]['nome'] = $conta->nome;
                    
                    if(!empty($periodo_fim)):
                        $lancamentos = Lancamento::where(['conta_id' => $conta->id])->where('data_lancamento', '<=', $periodo_fim)->select(DB::raw('sum(valor_total) as valor_total'))->first();
                    else:
                        $lancamentos = Lancamento::where(['conta_id' => $conta->id])->select(DB::raw('sum(valor_total) as valor_total'))->first();
                    endif;
                    
                    $contas_arr[$conta->id]['saldo'] = $lancamentos->valor_total + $conta->valor;
                    $contas_saldo = $contas_saldo + $lancamentos->valor_total + $conta->valor;
                endforeach;
                
            endif;
            
        else:
            
            $periodo_inicio_form = '';
            $periodo_fim_form = '';
            $conta = '';
            
            // SALDO CONTAS E TOTAL
            $contas = Conta::OrderBy('nome', 'ASC')->get();
            $contas_arr = array();
            $contas_saldo = 0;
            $intervalo = "Saldo Até: " . Date('d/m/Y');
            
            foreach ($contas as $conta):
                $contas_arr[$conta->id]['nome'] = $conta->nome;
                $lancamentos = Lancamento::where(['conta_id' => $conta->id])->select(DB::raw('sum(valor_total) as valor_total'))->first();
                $contas_arr[$conta->id]['saldo'] = $lancamentos->valor_total + $conta->valor;
                $contas_saldo = $contas_saldo + $lancamentos->valor_total + $conta->valor;
            endforeach;
            
        endif;
        

        return view('financeiro/relatorio/saldo-contas')
                ->with('contas', $contas_arr)
                ->with('contas_saldo', $contas_saldo)
                ->with('contas_listagem', $contas_listagem)
                ->with('periodo_inicio_form', $periodo_inicio_form)
                ->with('periodo_fim_form', $periodo_fim_form)
                ->with('conta', $conta)
                ->with('conta_nome', $conta_nome)
                ->with('intervalo', $intervalo);
        
    }
    
    public function demonstrativo(){
        
        return view('financeiro/relatorio/demonstrativo');
        
    }
    
    public function demonstrativo_excel(){
        
        
        $demonstrativo = array();
        $meses = array();        
        $data_previsao = array();        
        
        
        $ano = Session::get('demonstrativo_financeiro_ano');
        $data_previsao = Session::get('demonstrativo_financeiro');
        $tipo_demonstrativo = Session::get('demonstrativo_tipo');
        $contas = Session::get('demonstrativo_contas');
            
        
        
        if(count($contas) == 1 AND $contas[0] == ''):
            if($tipo_demonstrativo == 'previsto'):
                $programacao = Programacao::whereIn(DB::raw('MONTH(data_vencimento)'), $data_previsao)->whereYear('data_vencimento', '=', $ano)->with('planoConta','formaPagamento')->get()->sortBy('planoConta.descricao',SORT_REGULAR,true);
            else:    
                $programacao = Lancamento::where('plano_conta_id', '!=', NULL)->whereIn(DB::raw('MONTH(data_lancamento)'), $data_previsao)->whereYear('data_lancamento', '=', $ano)->with('planoConta')->get()->sortBy('planoConta.descricao',SORT_REGULAR,true);
            endif;
        else:
            if($tipo_demonstrativo == 'previsto'):
                $programacao = Programacao::whereIn(DB::raw('MONTH(data_vencimento)'), $data_previsao)->whereIn('conta_id', $contas)->whereYear('data_vencimento', '=', $ano)->with('planoConta','formaPagamento')->get()->sortBy('planoConta.descricao',SORT_REGULAR,true);
            else:    
                $programacao = Lancamento::where('plano_conta_id', '!=', NULL)->whereIn(DB::raw('MONTH(data_lancamento)'), $data_previsao)->whereIn('conta_id', $contas)->whereYear('data_lancamento', '=', $ano)->with('planoConta')->get()->sortBy('planoConta.descricao',SORT_REGULAR,true);
            endif;
        endif;


        $demonstrativo = array();


        $demonstrativo['entrada_saida']['Entradas'] = array();
        $demonstrativo['entrada_saida']['Saídas'] = array();

        foreach($programacao as $item_operacional):

            $tipo_lancamento = $item_operacional['operacao'];

            if($tipo_lancamento == 'C'):
                $varTipoLancamento = 'Entradas';
                $varTipoSinal = '[+]';
            elseif($tipo_lancamento == 'D'):
                $varTipoLancamento = 'Saidas';
                $varTipoSinal = '[-]';
            endif;

            $plano_contas_detalhe = $item_operacional['planoConta']['descricao'];
            $plano_contas = $item_operacional['planoConta']['descricao'];
            $plano_contas_parent_id = $item_operacional['planoConta']['parent_id'];
            $plano_contas_id = $item_operacional['planoConta']['id'];
            if($plano_contas_parent_id != 0):
                $plano_contas_arr = PlanoConta::where(["id" => $plano_contas_parent_id])->first();
                $plano_contas = $plano_contas_arr['descricao'];
                $plano_contas_id = $plano_contas_arr['id'];
            endif;

            if($tipo_demonstrativo == 'realizado'):
                $vencimento_data = $item_operacional['data_lancamento'];
                if(!empty($vencimento_data)):
                    $vencimento_data_arr = explode("-", $vencimento_data);
                    $vencimento_mes = $vencimento_data_arr[1];
                endif;
            else: 
                $vencimento_data = $item_operacional['data_vencimento'];
                if(!empty($vencimento_data)):
                    $vencimento_data_arr = explode("-", $vencimento_data);
                    $vencimento_mes = $vencimento_data_arr[1];
                endif;
            endif;

            $lancamento_valor = $item_operacional['valor_total'];

            $acumulado = 0;
            if(isset($demonstrativo['entrada_saida'][$varTipoLancamento]['plano_conta'][$plano_contas][$vencimento_mes])):
                $acumulado = $demonstrativo['entrada_saida'][$varTipoLancamento]['plano_conta'][$plano_contas][$vencimento_mes];
            endif;

            $acumulado_detalhe = 0;
            if(isset($demonstrativo['entrada_saida'][$varTipoLancamento]['plano_conta'][$plano_contas]['detalhe'][$plano_contas_detalhe][$vencimento_mes])):
                $acumulado_detalhe = $demonstrativo['entrada_saida'][$varTipoLancamento]['plano_conta'][$plano_contas]['detalhe'][$plano_contas_detalhe][$vencimento_mes];
            endif;

            $acumulado_tipoplano_tipolancamento = 0;
            if(isset($demonstrativo['entrada_saida'][$varTipoLancamento]['subtotal'][$vencimento_mes])):
                $acumulado_tipoplano_tipolancamento = $demonstrativo['entrada_saida'][$varTipoLancamento]['subtotal'][$vencimento_mes];
            endif;

            $acumulado_tipoplano = 0;
            if(isset($demonstrativo['subtotal'][$vencimento_mes])):
                $acumulado_tipoplano = $demonstrativo['subtotal'][$vencimento_mes];
            endif;

            $acumulado_subtotal = 0;
            if(isset($demonstrativo['subtotal'][$vencimento_mes])):
                $acumulado_subtotal = $demonstrativo['subtotal'][$vencimento_mes];
            endif;

            $acumulado_linha = 0;
            if(isset($demonstrativo['entrada_saida'][$varTipoLancamento]['plano_conta'][$plano_contas]['subtotal'])):
                $acumulado_linha = $demonstrativo['entrada_saida'][$varTipoLancamento]['plano_conta'][$plano_contas]['subtotal'];
            endif;

            $acumulado_linha_detalhe = 0;
            if(isset($demonstrativo['entrada_saida'][$varTipoLancamento]['plano_conta'][$plano_contas]['detalhe'][$plano_contas_detalhe]['subtotal'])):
                $acumulado_linha_detalhe = $demonstrativo['entrada_saida'][$varTipoLancamento]['plano_conta'][$plano_contas]['detalhe'][$plano_contas_detalhe]['subtotal'];
            endif;

            $acumulado_tipoplano_total = 0;
            if(isset($demonstrativo['entrada_saida'][$varTipoLancamento]['subtotal1'])):
                $acumulado_tipoplano_total = $demonstrativo['entrada_saida'][$varTipoLancamento]['subtotal1'];
            endif;

            $acumulado_tipoplano_linha = 0;
            if(isset($demonstrativo['tipo_conta']['subtotal1'])):
                $acumulado_tipoplano_linha = $demonstrativo['tipo_conta']['subtotal1'];
            endif;

            $acumulado_subtotal_linha = 0;
            if(isset($demonstrativo['subtotal1'])):
                $acumulado_subtotal_linha = $demonstrativo['subtotal1'];
            endif;

            $demonstrativo['entrada_saida'][$varTipoLancamento]['plano_conta'][$plano_contas]['id'] = $plano_contas_id;
            $demonstrativo['entrada_saida'][$varTipoLancamento]['tipo'] = $varTipoLancamento;
            $demonstrativo['entrada_saida'][$varTipoLancamento]['nome'] = $varTipoSinal . ' ' .$varTipoLancamento;

            $demonstrativo['entrada_saida'][$varTipoLancamento]['plano_conta'][$plano_contas]['nome'] = $plano_contas;
            $demonstrativo['entrada_saida'][$varTipoLancamento]['plano_conta'][$plano_contas][$vencimento_mes] = $acumulado + $lancamento_valor;
            $demonstrativo['entrada_saida'][$varTipoLancamento]['plano_conta'][$plano_contas]['subtotal'] = $acumulado_linha + $lancamento_valor;


            $demonstrativo['entrada_saida'][$varTipoLancamento]['plano_conta'][$plano_contas]['detalhe'][$plano_contas_detalhe]['nome'] = $plano_contas_detalhe;
            $demonstrativo['entrada_saida'][$varTipoLancamento]['plano_conta'][$plano_contas]['detalhe'][$plano_contas_detalhe][$vencimento_mes] = $acumulado_detalhe + $lancamento_valor;
            $demonstrativo['entrada_saida'][$varTipoLancamento]['plano_conta'][$plano_contas]['detalhe'][$plano_contas_detalhe]['subtotal'] = $acumulado_linha_detalhe + $lancamento_valor;

            $demonstrativo['entrada_saida'][$varTipoLancamento]['subtotal'][$vencimento_mes] = $acumulado_tipoplano_tipolancamento + $lancamento_valor;
            $demonstrativo['subtotal'][$vencimento_mes] = $acumulado_subtotal + $lancamento_valor;
            $demonstrativo['subtotal1'] = $acumulado_subtotal_linha + $lancamento_valor;
            $demonstrativo['subtotal']['nome'] = 'Saldo Final';
            $demonstrativo['entrada_saida'][$varTipoLancamento]['subtotal1'] = $acumulado_tipoplano_total + $lancamento_valor;

        endforeach;


        $meses['01'] = "Jan";
        $meses['02'] = "Fev";
        $meses['03'] = "Mar";
        $meses['04'] = "Abr";
        $meses['05'] = "Mai";
        $meses['06'] = "Jun";
        $meses['07'] = "Jul";
        $meses['08'] = "Ago";
        $meses['09'] = "Set";
        $meses['10'] = "Out";
        $meses['11'] = "Nov";
        $meses['12'] = "Dez";

        
        return view('financeiro/relatorio/demonstrativo-excel')->with('demonstrativo', $demonstrativo)->with('meses', $meses)->with('data_previsao', $data_previsao);
        
    }
    
    
    public function extrato_contas(){
        
        $hoje = Date('Y-m-d');
        
        $usuario_id = Session::get('login.financeiro.usuario_id');
        
        $contas_listagem = Conta::OrderBy('nome', 'DESC')->get();
        
        $conta_nome = '';
        
        if($_POST):
            
            $periodo_fim = Request::input('dt_fim');
            $periodo_inicio = Request::input('dt_inicio');
            
            if(!empty($periodo_inicio)):
                $intervalo = "Saldo Até: $periodo_inicio";
                $periodo_inicio_form = $periodo_inicio;
            endif;
            
            if(!empty($periodo_fim)):
                $periodo_fim_form = $periodo_fim;
            endif;
            
            $conta = Request::input('conta');
            
            if(!empty($conta)):
                
                $conta_detalhe = Conta::find($conta);
            
                $lancamentos = Lancamento::where('conta_id', '=', $conta);
            
                if(!empty($periodo_fim)):
                    $lancamentos = $lancamentos->whereBetween('data_lancamento', [$periodo_inicio, $periodo_fim]);
                endif;
                
                $lancamentos_result = $lancamentos->with('planoConta')->with('pessoa')->orderBy('data_lancamento', 'ASC')->get();

                $lancamentos_inicial = Lancamento::select(DB::raw('sum(valor_total) as saldo'))->where('conta_id', '=', $conta)->where('data_lancamento', '<', $periodo_inicio)->get();
                
                $contas_arr[$conta_detalhe->nome][] = $lancamentos_result;
                $contas_arr[$conta_detalhe->nome][1] = $lancamentos_inicial[0]['saldo'];
                
            else:
                
                $contas = Conta::OrderBy('nome', 'ASC')->get();
                $contas_arr = array();
                $contas_saldo = 0;

                foreach ($contas as $conta):
                    $lancamentos = Lancamento::where(['conta_id' => $conta->id, 'inicial' => 0])->whereBetween('data_lancamento', [$periodo_inicio, $periodo_fim])->with('planoConta')->with('pessoa')->orderBy('data_lancamento', 'ASC')->get();
                    $lancamentos_inicial = Lancamento::select(DB::raw('sum(valor_total) as saldo'))->where('conta_id', '=', $conta->id)->where('data_lancamento', '<', $periodo_inicio)->get();
                    $contas_arr[$conta->nome][] = $lancamentos;
                    $contas_arr[$conta->nome][1] = $lancamentos_inicial[0]['saldo'];
                endforeach;
                
            endif;
            
        else:
            
            $periodo_fim = Date('Y-m-d');
            $periodo_inicio = date('Y-m-d', strtotime("-6 months",strtotime($periodo_fim)));
            
            if(!empty($periodo_inicio)):
                $periodo_inicio_arr = explode("-", $periodo_inicio);
                $periodo_inicio_form = $periodo_inicio_arr[2].'/'.$periodo_inicio_arr[1].'/'.$periodo_inicio_arr[0];
            endif;
            
            if(!empty($periodo_fim)):
                $periodo_fim_arr = explode("-", $periodo_fim);
                $periodo_fim_form = $periodo_fim_arr[2].'/'.$periodo_fim_arr[1].'/'.$periodo_fim_arr[0];
            endif;
                
            $conta = '';
            
            // SALDO CONTAS E TOTAL
            $contas = Conta::OrderBy('nome', 'ASC')->get();
            $contas_arr = array();
            $contas_saldo = 0;
            $intervalo = "Período: de: " . $periodo_inicio_form . ' até: ' . $periodo_fim_form;
            
            foreach ($contas as $conta):
                $lancamentos = Lancamento::where(['conta_id' => $conta->id, 'inicial' => 0])->whereBetween('data_lancamento', [$periodo_inicio, $periodo_fim])->with('planoConta')->with('pessoa')->orderBy('data_lancamento', 'ASC')->get();
                $lancamentos_inicial = Lancamento::select(DB::raw('sum(valor_total) as saldo'))->where('conta_id', '=', $conta->id)->where('data_lancamento', '<', $periodo_inicio)->get();

                $contas_arr[$conta->nome][] = $lancamentos;
                $contas_arr[$conta->nome][1] = $lancamentos_inicial[0]['saldo'];
            endforeach;
            
        endif;
        

        return view('financeiro/relatorio/extrato-contas')
                ->with('contas', $contas_arr)
                ->with('contas_listagem', $contas_listagem)
                ->with('periodo_inicio_form', $periodo_inicio_form)
                ->with('periodo_fim_form', $periodo_fim_form)
                ->with('conta', $conta)
                ->with('conta_nome', $conta_nome)
                ->with('intervalo', $intervalo);
        
    }
    
    
    public function fluxo_caixa(){
        
        $hoje = Date('Y-m-d');
        
        $usuario_id = Session::get('login.financeiro.usuario_id');
        
        $contas_listagem = Conta::OrderBy('nome', 'DESC')->get();
        
        $conta_nome = '';
        
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
            
            if(!empty($conta)):
                
                $conta_detalhe = Conta::find($conta);
            
                $programadas = Programacao::where('conta_id', '=', $conta);
            
                if(!empty($periodo_fim)):
                    $programadas = $programadas->whereBetween('data_vencimento', [$periodo_inicio, $periodo_fim]);
                endif;
                
                $programadas = $programadas->whereHas('pessoa', function ($query) {
                    return $query->where('ativo', '=', 1);
                });

                $programadas_result = $programadas->with('planoConta')->with('pessoa')->with('conta')->get();

                $contas_arr = $programadas_result;
                
            else:
                
                $programadas = Programacao::whereBetween('data_vencimento', [$periodo_inicio, $periodo_fim]);
                $programadas = $programadas->whereHas('pessoa', function ($query) {
                    return $query->where('ativo', '=', 1);
                });
                $programadas = $programadas->with('planoConta')->with('conta')->with('pessoa')->orderBy('data_vencimento', 'ASC')->get();
                $contas_arr = $programadas;
                
            endif;
            
            $lancamentos = Lancamento::select(DB::raw('sum(valor_total) as valor_total'))->first();
            $saldo_atual = $lancamentos->valor_total;
            
        else:
            
            $periodo_inicio = Date('Y-m-d');
            $periodo_fim = date('Y-m-d', strtotime("+7 days",strtotime($periodo_inicio)));
            
            if(!empty($periodo_inicio)):
                $periodo_inicio_arr = explode("-", $periodo_inicio);
                $periodo_inicio_form = $periodo_inicio_arr[2].'/'.$periodo_inicio_arr[1].'/'.$periodo_inicio_arr[0];
            endif;
            
            if(!empty($periodo_fim)):
                $periodo_fim_arr = explode("-", $periodo_fim);
                $periodo_fim_form = $periodo_fim_arr[2].'/'.$periodo_fim_arr[1].'/'.$periodo_fim_arr[0];
            endif;
                
            $conta = '';
            
            // SALDO CONTAS E TOTAL
            $contas_arr = array();
            $contas_saldo = 0;
            $intervalo = "Período: de: " . $periodo_inicio_form . ' até: ' . $periodo_fim_form;
            
            $programadas = Programacao::whereBetween('data_vencimento', [$periodo_inicio, $periodo_fim]);
            $programadas = $programadas->whereHas('pessoa', function ($query) {
                    return $query->where('ativo', '=', 1);
                });
            $programadas = $programadas->with('planoConta')->with('conta')->with('pessoa')->orderBy('data_vencimento', 'ASC')->get();
        
            $contas_arr = $programadas;
            
            $lancamentos = Lancamento::select(DB::raw('sum(valor_total) as valor_total'))->first();
            $saldo_atual = $lancamentos->valor_total;
            
        endif;
        

        return view('financeiro/relatorio/fluxo-caixa')
                ->with('contas', $contas_arr)
                ->with('contas_listagem', $contas_listagem)
                ->with('periodo_inicio_form', $periodo_inicio_form)
                ->with('periodo_fim_form', $periodo_fim_form)
                ->with('saldo_atual', $saldo_atual)
                ->with('intervalo', $intervalo);
        
    }
    
    
    public function receitas_despesas(){
        
        $hoje = Date('Y-m-d');
        
        $usuario_id = Session::get('login.financeiro.usuario_id');
        
        $contas_listagem = Conta::OrderBy('nome', 'ASC')->get();
        $pessoas_listagem = Pessoa::OrderBy('nome', 'ASC')->get();
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
        

        $centro_de_custo = CentroCusto::where('ativo', '=', 1)->where('parent_id', '=', 0)->orderBy('descricao', 'ASC')->get();
        $centro_array = array();
        foreach($centro_de_custo as $item):
            $centro_array[] = array('descricao' => $item->descricao, 'pai' => 1, 'id' => $item->id);
            $centro_de_custo_filhos = PlanoConta::where('ativo', '=', 1)->where('parent_id', '=', $item->id)->orderBy('descricao', 'ASC')->get();
            foreach($centro_de_custo_filhos as $item_filho):
                $centro_array[] = array('descricao' => $item_filho->descricao, 'pai' => 0, 'id' => $item_filho->id);
            endforeach;
        endforeach;
        
        
        $conta_nome = '';
        $pessoa_nome = '';
        $plano_conta_nome = '';
        $centro_custo_nome = '';
        
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
            $cliente = Request::input('cliente');
            $plano_conta = Request::input('plano_conta');
            $centro_custo = Request::input('centro_custo');
            
            
            $lancamentos = Lancamento::where('id', '>', 0);
            $lancamentos = $lancamentos->whereBetween('data_lancamento', [$periodo_inicio, $periodo_fim]);
            
            
            if(!empty($conta)):
                $lancamentos = $lancamentos->where('conta_id', '=', $conta);
                $conta_detalhe = Conta::find($conta);
                $conta_nome = $conta_detalhe->nome;
            endif;
            
            if(!empty($cliente)):
                $lancamentos = $lancamentos->where('pessoa_id', '=', $cliente);
                $pessoa_detalhe = Pessoa::find($cliente);
                $pessoa_nome = $pessoa_detalhe->nome;
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

            
            $lancamentos_result = $lancamentos->with('planoConta')->with('pessoa')->with('conta')->orderBy('data_lancamento', 'ASC')->get();
            $contas_arr = $lancamentos_result;
            
            
        else:
            
            $contas_arr = array();
            $periodo_inicio_form = '';
            $periodo_fim_form = '';
            $saldo_atual = '';
            $intervalo = '';
            
        endif;
        

        return view('financeiro/relatorio/receita-despesa-pessoa')
                ->with('contas', $contas_arr)
                ->with('contas_listagem', $contas_listagem)
                ->with('pessoas_listagem', $pessoas_listagem)
                ->with('plano_contas_listagem', $plano_contas_listagem)
                ->with('centro_custos_listagem', $centro_custos_listagem)
                ->with('periodo_inicio_form', $periodo_inicio_form)
                ->with('periodo_fim_form', $periodo_fim_form)
                ->with('conta_nome', $conta_nome)
                ->with('pessoa_nome', $pessoa_nome)
                ->with('plano_conta_nome', $plano_conta_nome)
                ->with('centro_custo_nome', $centro_custo_nome)
                ->with('plano_de_contas_receitas', $plano_receitas_array)
                ->with('plano_de_contas_despesas', $plano_despesas_array)
                ->with('centro_de_custo', $centro_array)
                ->with('intervalo', $intervalo);
        
    }
    
}