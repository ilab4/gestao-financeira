<?php namespace App\Http\Controllers\Financeiro;


use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Model\Financeiro\Usuario;
use Request;
use Session;


class LoginController extends FinanceiroController {
    
    public function login(){
        
        $usuario = Request::input('usuario');
        $senha = Request::input('senha');
        
        if(empty($usuario) OR empty($senha)):
            return redirect('painel');
        endif;
        
        $senha = hash('sha1', $senha);
        
        $login = Usuario::where(['usuario' => $usuario, 'senha' => $senha, 'ativo' => 1])->first();
        
        if($login):
            
            Session::put('login.logado', 1);
            Session::put('login.id', $login->id);
            Session::put('login.nome', $login->nome);
            Session::put('login.email', $login->email);
            Session::put('login.cpf', $login->cpf);
            Session::put('login.perfil', $login->perfil);

            return redirect('/financeiro/dashboard');
            
        else:
            
            $erro = "Usuário ou Senha inválidos!";
            Session::put('status.msg', $erro);
                        
            return redirect('painel');
            
        endif;
        
            
    }
    
    public function sair(){
        
        Session::forget('login.id');
        Session::forget('login.nome');
        Session::forget('login.email');
        Session::forget('login.cpf');
        Session::forget('login.logado');
        Session::forget('login.tipo');
                      
        return redirect('financeiro');
            
    } 
    
}