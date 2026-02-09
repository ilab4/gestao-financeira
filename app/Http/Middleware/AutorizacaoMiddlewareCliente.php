<?php

namespace App\Http\Middleware;

use Closure;
use Request;
use Session;
use App\Tutor;

class AutorizacaoMiddlewareCliente
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $usuario_logado = Session::get('login.cliente.logado');
        
        
        if(!isset($usuario_logado) OR $usuario_logado != 1){
            
            Session::forget('login.cliente.id');
            Session::forget('login.cliente.nome');
            Session::forget('login.cliente.email');
            Session::forget('login.cliente.logado');
            Session::forget('login.cliente.cpf');
            Session::forget('login.cliente.tipo');
            Session::put('status.msg', 'Acesso Negado!');
            return redirect('cliente');
        
        } 
            
//            $tutor_id = Session::get('login.cliente.id');
//            
//            $tutor = Tutor::find($tutor_id);
//            
//            $alterou_senha_padrao = $tutor->alterou_senha_padrao;
//            
//            if(!isset($tela_mudar_senha)){
//                if(empty($alterou_senha_padrao) OR $alterou_senha_padrao == 0){
//                    Session::put('status.msg', 'Favor alterar a senha padrão enviada!');
//                    return redirect('cliente/senha');
//                }
//            }
            
            
            
        
        return $next($request);
    }
}
