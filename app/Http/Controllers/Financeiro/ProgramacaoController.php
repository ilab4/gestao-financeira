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
use App\Model\Financeiro\DocumentoTipo;
use App\Model\Financeiro\FormaPagamento;
use Request;
use Session;


class ProgramacaoController extends FinanceiroController {
    
    
    public function __construct()
    {
        $this->middleware('authFinanceiroMiddleware');
    }
    
    public function index(){
        
        return view('financeiro/programado/index');
            
    }
    
}