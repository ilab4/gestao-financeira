<?php namespace App\Http\Controllers\Financeiro;


use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Request;
use Session;
use App\Model\Financeiro\Lancamento;
use App\Model\Financeiro\Conta;
use App\Model\Financeiro\Programacao;

class DashboardController extends FinanceiroController {
    
    public function __construct()
    {
        $this->middleware('authFinanceiroMiddleware');
        
    }
    
    public function index(){
        
        $hoje = Date('Y-m-d');
        
        $usuario_id = Session::get('login.financeiro.usuario_id');
        
        // SALDO CONTAS E TOTAL
        $contas = Conta::where('dashboard', '=', 1)->OrderBy('nome', 'DESC')->get();
        $contas_arr = array();
        $contas_saldo = 0;
        
        foreach ($contas as $conta):
            $contas_arr[$conta->id]['nome'] = $conta->nome;
            $lancamentos = Lancamento::where(['conta_id' => $conta->id])->select(DB::raw('sum(valor_total) as valor_total'))->first();
            $contas_arr[$conta->id]['saldo'] = $lancamentos->valor_total;
            $contas_saldo = $contas_saldo + $lancamentos->valor_total;
        endforeach;

        // DESPESAS NO MES
        $ano_atual = Date('Y');
        $mes_atual = Date('m');
        $despesas_mes = Programacao::with('planoConta')->whereYear('data_vencimento', '=', $ano_atual)->whereMonth('data_vencimento', '=', $mes_atual)->where('operacao', '=', 'D')->get();
        
        $despesas_mes_arr = array();
        $conta_total_despesa_mes = 0;
        
        foreach($despesas_mes as $despesa):
            if(isset($despesas_mes_arr[$despesa->plano_conta_id]['valor'])):
                $despesas_mes_arr[$despesa->plano_conta_id]['valor'] = $despesas_mes_arr[$despesa->plano_conta_id]['valor'] + $despesa->valor_total;
            else:
                $despesas_mes_arr[$despesa->plano_conta_id]['valor'] = $despesa->valor_total;
            endif;
            $despesas_mes_arr[$despesa->plano_conta_id]['nome'] = $despesa->planoConta->descricao;
            $conta_total_despesa_mes = $conta_total_despesa_mes + $despesa->valor_total;
        endforeach;
        
        // RECEITAS x DESPESAS
        $mes_atual = date('m');
        $ano_atual = date('Y');

        for($i = 0; $i < 6; $i++):
            if($i != 0):
                $mes_atual = $mes_atual - 1;
                if($mes_atual == 0):
                    $mes_atual = 12;
                    $ano_atual = $ano_atual - 1;
                endif;
            endif;
            $resultado = DB::select("SELECT SUM(valor_total) as valor_total, operacao FROM financeiro_programacao WHERE MONTH(data_vencimento) = '$mes_atual' AND YEAR(data_vencimento) = '$ano_atual' GROUP BY operacao ORDER BY operacao");
            
          
            if(count($resultado)):
                if(isset($resultado[1])):

                    if(isset($resultado[0]->operacao) AND $resultado[0]->operacao == 'C'):
                        $receitas_despesas[$mes_atual.'_'.$ano_atual]['R'] = $resultado[0]->valor_total;
                    else:
                        $receitas_despesas[$mes_atual.'_'.$ano_atual]['R'] = 0;
                    endif;

                    if(isset($resultado[1]->operacao) AND $resultado[1]->operacao == 'D'):
                        $receitas_despesas[$mes_atual.'_'.$ano_atual]['D'] = $resultado[1]->valor_total;
                    else:
                        $receitas_despesas[$mes_atual.'_'.$ano_atual]['D'] = 0;
                    endif;

                else:

                   if(isset($resultado[0]->operacao) AND $resultado[0]->operacao == 'C'): 
                       $receitas_despesas[$mes_atual.'_'.$ano_atual]['R'] = $resultado[0]->valor_total;
                       $receitas_despesas[$mes_atual.'_'.$ano_atual]['D'] = 0;
                   endif;

                   if(isset($resultado[0]->operacao) AND $resultado[0]->operacao == 'D'): 
                       $receitas_despesas[$mes_atual.'_'.$ano_atual]['D'] = $resultado[0]->valor_total;
                       $receitas_despesas[$mes_atual.'_'.$ano_atual]['R'] = 0;
                   endif;

                endif;
            else:
                $receitas_despesas[$mes_atual.'_'.$ano_atual]['D'] = 0;
                $receitas_despesas[$mes_atual.'_'.$ano_atual]['R'] = 0;
            endif;
            
        endfor;
        
        $receitas_despesas = array_reverse($receitas_despesas);
        
        
        
        //PROXIMAS CONTAS PROGRAMADAS
        $contas_programadas = Programacao::where('data_vencimento', '>=', $hoje)->with('planoConta')->with('conta')->orderBy('data_vencimento', 'ASC')->take(20)->get();
        
        //ULTIMOS LANCAMENTOS
        $ultimos_lancamentos = Lancamento::with('planoConta')->with('conta')->orderBy('data_lancamento', 'DESC')->take(20)->get();
        
        
        // FLUXO DE CAIXA - ÚLTIMOS 6 MESES (Baseado em Lançamentos Reais)
        $labels_grafico = [];
        $dados_receitas = [];
        $dados_despesas = [];

        for ($i = 5; $i >= 0; $i--) {
            $data_ponto = date('Y-m-d', strtotime("-$i months"));
            $mes = date('m', strtotime($data_ponto));
            $ano = date('Y', strtotime($data_ponto));

            // Nome do mês para o label do gráfico
            $labels_grafico[] = date('M/y', strtotime($data_ponto));

            // Busca Receitas (Operação 'C' ou conforme definido no seu sistema)
            $receita = Lancamento::whereMonth('data_lancamento', $mes)
                ->whereYear('data_lancamento', $ano)
                ->where('operacao', 'C')
                ->sum('valor_total');

            // Busca Despesas (Operação 'D')
            $despesa = Lancamento::whereMonth('data_lancamento', $mes)
                ->whereYear('data_lancamento', $ano)
                ->where('operacao', 'D')
                ->sum('valor_total');

            $dados_receitas[] = $receita;
            $dados_despesas[] = abs($despesa);
        }
        
        return view('financeiro/dashboard/dashboard')
                ->with('contas', $contas_arr)
                ->with('contas_saldo', $contas_saldo)
                ->with('despesas_mes', $despesas_mes_arr)
                ->with('total_despesas_mes', $conta_total_despesa_mes)
                ->with('contas_programadas', $contas_programadas)
                ->with('ultimos_lancamentos', $ultimos_lancamentos)
                ->with('receitas_despesas', $receitas_despesas)
                ->with('labels_grafico', json_encode($labels_grafico))
                ->with('dados_receitas', json_encode($dados_receitas))
                ->with('dados_despesas', json_encode($dados_despesas));
        
    }
    
}