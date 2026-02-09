<?php

namespace App\Http\Middleware;

use Closure;
use Request;
use Session;

class AutorizacaoMiddleware
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
        $usuario_logado = Session::get('login.logado');
        
        if(!isset($usuario_logado) OR $usuario_logado != 1){
            Session::forget('login.id');
            Session::forget('login.nome');
            Session::forget('login.email');
            Session::forget('login.logado');
            Session::forget('login.cpf');
            Session::forget('login.tipo');
            Session::put('status.msg', 'Acesso Negado!');
            return redirect('painel');
        }
        
        return $next($request);
    }
}
