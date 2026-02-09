<?php namespace App\Http\Controllers\Financeiro;


use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Model\Financeiro\ContaTipo;
use App\Model\Financeiro\Conta;
use App\Model\Financeiro\Banco;
use Request;
use Session;


class IntegracaoController extends FinanceiroController {
    
    
    public function __construct()
    {
        $this->middleware('authFinanceiroMiddleware');
    }
    
    public function index(){
        
        return view('financeiro/integracao/index');
            
    }
    
}