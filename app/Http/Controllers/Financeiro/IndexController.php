<?php namespace App\Http\Controllers\Financeiro;


use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Request;
use Session;


class IndexController extends FinanceiroController {
    
    public function index(){
        
        return view('financeiro/index');
            
    }
    
}