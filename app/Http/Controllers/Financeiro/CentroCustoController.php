<?php namespace App\Http\Controllers\Financeiro;


use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Model\Financeiro\CentroCusto;
use Request;
use Session;


class CentroCustoController extends FinanceiroController {
    
    
    public function __construct()
    {
        $this->middleware('authFinanceiroMiddleware');
    }
    
    public function index(){
    
        $centro_custo0 = CentroCusto::where(['parent_id' => 0])->orderBy('descricao', 'ASC')->get();
        $array_centro_custo = array();

        $contaArray0 = 0;
        foreach ($centro_custo0 as $item) {
            $array_centro_custo['n0'][$contaArray0] = ['id' => $item->id,'titulo' => $item->descricao,'status' => $item->ativo];
            $id0 = $item->id;
            
            $centro_custo1 = CentroCusto::where(['parent_id' => $id0])->orderBy('descricao', 'ASC')->get();
            $contaArray1 = 0;

            foreach ($centro_custo1 as $item1) {
                $array_centro_custo['n1'][$item->descricao][$contaArray1] = ['id' => $item1->id,'titulo' => $item1->descricao,'status' => $item1->ativo];
                $contaArray1++;
            }
            
            $contaArray0++;
        }
        
        return view('financeiro/configuracao/centro_custo/index')->with('centro_custo', $array_centro_custo);
            
    }
    
    public function novo(){
        
        $centro_custo = CentroCusto::where(['parent_id' => 0, 'ativo' => 1])->orderBy('descricao', 'ASC')->get();
        
        
        return view('financeiro/configuracao/centro_custo/data')->with('cc', $centro_custo);
            
    }
    
    public function editar($id){
        
       
        $centro_custo = CentroCusto::find($id);
        
        $centros_de_custo = CentroCusto::where(['parent_id' => 0, 'ativo' => 1])->orderBy('descricao', 'ASC')->get();
        
        
        return view('financeiro/configuracao/centro_custo/data')->with('cc', $centros_de_custo)->with('data', $centro_custo);
            
    } 
    
    public function salvar(){


        if(Request::input('id') AND Request::input('id') > 0){
            $centro_custo = CentroCusto::find(Request::input('id'));
        } else {
            $centro_custo = new CentroCusto(); 
        }
        
        $ativo = 0;
        if(Request::input('ativo')){
            $ativo = 1;
        }
        
        $centro_custo_id = Request::input('centro_custo_id');
        if($centro_custo_id != ''):
            $centro_custo->parent_id = $centro_custo_id;
        else:
            $centro_custo->parent_id = 0;
        endif;
        
        $centro_custo->descricao = Request::input('descricao');
        $centro_custo->responsavel = Request::input('responsavel');
        $centro_custo->email = Request::input('email');
        $centro_custo->telefone = Request::input('telefone');
        $centro_custo->ramal = Request::input('ramal');
        $centro_custo->ativo = $ativo;

        if($centro_custo->save()){
            Session::put('status.msg', 'Registro salvo com sucesso!');
            return redirect('financeiro/centro-de-custo');
        } else {
            return view('financeiro/configuracao/centro_custo/data');
        }
        
    }    
    
}