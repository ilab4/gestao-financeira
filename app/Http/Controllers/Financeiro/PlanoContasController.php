<?php namespace App\Http\Controllers\Financeiro;


use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Model\Financeiro\PlanoConta;
use Request;
use Session;


class PlanoContasController extends FinanceiroController {
    
    
    public function __construct()
    {
        $this->middleware('authFinanceiroMiddleware');
    }
    
    public function index(){
    
        $planos_conta0 = PlanoConta::where(['parent_id' => 0, 'tipo_lancamento' => 1])->orderBy('descricao', 'ASC')->get();
        $array_paginas_receita = array();

        $contaArray0 = 0;
        foreach ($planos_conta0 as $item) {
            $array_paginas_receita['n0'][$contaArray0] = ['id' => $item->id,'titulo' => $item->descricao,'status' => $item->ativo];
            $id0 = $item->id;
            
            $planos_conta1 = PlanoConta::where(['parent_id' => $id0])->orderBy('descricao', 'ASC')->get();
            $contaArray1 = 0;

            foreach ($planos_conta1 as $item1) {
                $array_paginas_receita['n1'][$item->descricao][$contaArray1] = ['id' => $item1->id,'titulo' => $item1->descricao,'status' => $item1->ativo];
                $contaArray1++;
            }
            
            $contaArray0++;
        }
        
        
        
        $planos_conta0 = PlanoConta::where(['parent_id' => 0, 'tipo_lancamento' => 2])->orderBy('descricao', 'ASC')->get();
        $array_paginas_despesa = array();

        $contaArray0 = 0;
        foreach ($planos_conta0 as $item) {
            $array_paginas_despesa['n0'][$contaArray0] = ['id' => $item->id,'titulo' => $item->descricao,'status' => $item->ativo];
            $id0 = $item->id;
            
            $planos_conta1 = PlanoConta::where(['parent_id' => $id0])->orderBy('descricao', 'ASC')->get();
            $contaArray1 = 0;

            foreach ($planos_conta1 as $item1) {
                $array_paginas_despesa['n1'][$item->descricao][$contaArray1] = ['id' => $item1->id,'titulo' => $item1->descricao,'status' => $item1->ativo];
                $contaArray1++;
            }
            
            $contaArray0++;
        }
        
        
        return view('financeiro/configuracao/plano_contas/index')->with('paginas_receita', $array_paginas_receita)->with('paginas_despesa', $array_paginas_despesa);
            
    }
    
    public function novo($tipo){
        
        $tipo_lancamento = 1;
        if($tipo == 'despesa'):
            $tipo_lancamento = 2;
        endif;
        
        $planos_conta = PlanoConta::where(['parent_id' => 0, 'tipo_lancamento' => $tipo_lancamento, 'ativo' => 1])->orderBy('descricao', 'ASC')->get();
        
        
        return view('financeiro/configuracao/plano_contas/data')->with('pc', $planos_conta)->with('tipo_lancamento', $tipo_lancamento);
            
    }
    
    public function editar($id){
        
       
        $plano_contas = PlanoConta::find($id);
        
        $tipo_lancamento = $plano_contas->tipo_lancamento;
        
        $planos_conta = PlanoConta::where(['parent_id' => 0, 'tipo_lancamento' => $tipo_lancamento, 'ativo' => 1])->orderBy('descricao', 'ASC')->get();
        
        
        return view('financeiro/configuracao/plano_contas/data')->with('pc', $planos_conta)->with('tipo_lancamento', $tipo_lancamento)->with('data', $plano_contas);
            
    } 
    
    public function salvar(){

        if(Request::input('id') AND Request::input('id') > 0){
            $plano_contas = PlanoConta::find(Request::input('id'));
        } else {
            $plano_contas = new PlanoConta(); 
        }
        
        $ativo = 0;
        if(Request::input('ativo')){
            $ativo = 1;
        }
        
        $plano_contas_id = Request::input('plano_contas_id');
        if($plano_contas_id != ''):
            $plano_contas_data = PlanoConta::find($plano_contas_id);
            $plano_contas->parent_id = $plano_contas_id;
        else:
            $plano_contas->parent_id = 0;
        endif;
        
        $plano_contas->tipo_lancamento = Request::input('tipo_lancamento');
        $plano_contas->descricao = Request::input('descricao');
        $plano_contas->ativo = $ativo;

        if($plano_contas->save()){
            
            Session::put('status.msg', 'Registro salvo com sucesso!');
            return redirect('financeiro/plano-de-contas');
            
        } else {
            
            return view('financeiro/configuracao/plano_contas/data');
            
        }
        
    }    
    
}