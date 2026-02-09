<?php namespace App\Http\Controllers\Financeiro;


use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Request;
use Session;
use App\Model\Financeiro\Usuario;


class UsuarioController extends FinanceiroController {
    
    
    public function __construct()
    {
        $this->middleware('authFinanceiroMiddleware');
    }
    
    public function index(){
        
        $usuarios = Usuario::orderBy('nome', 'ASC')->get();
        return view('financeiro/usuario/index')->with('usuarios', $usuarios);
         
    }
    
    public function novo(){
        
        return view('financeiro/usuario/data');
            
    }
    
    public function editar($id){
        
        $usuario = Usuario::where(['id' => $id])->first();

        return view('financeiro/usuario/data')->with('u', $usuario);
            
    } 
    
    public function excluir($id){
        
        Usuario::where('id', $id)->delete();
        
        Session::put('status.msg', 'Usuário excluído com sucesso!');
        return redirect('financeiro/usuarios');
            
    }
    
    public function salvar(){
        
        if(Request::input('id') AND Request::input('id') > 0){
            $usuario = Usuario::find(Request::input('id'));
        } else {
            $usuario = new Usuario(); 
        }
        
        $ativo = 0;
        if(Request::input('ativo')){
            $ativo = 1;
        }
        
        $admin = 0;
        if(Request::input('admin')){
            $admin = 1;
        }
        
        $senha = Request::input('senha');
        if(!empty($senha)):
            $usuario->senha = hash('sha1', $senha);
        endif;
        
        $usuario->nome = Request::input('nome');
        $usuario->email = Request::input('email');
        $usuario->usuario = Request::input('login');
        $usuario->ativo = $ativo;
        $usuario->admin = $admin;

        $error = 1;
        if($usuario->save()){
            
            Session::put('status.msg', 'Usuário salvo com sucesso!');
            return redirect('financeiro/usuarios');
            
        } else {
            
            return view('financeiro/usuario/data');
            
        }
        
    }

    
    
    public function _ajax_email(){
        
        $email = Request::input('email');
        
        $usuario = Usuario::where(['email' => $email])->get();
        
        if(count($usuario)){
            return 2;
        } else {
            return 1;
        }
            
    }
    
    public function _ajax_login(){
        
        $login = Request::input('login');
        
        $usuario = Usuario::where(['usuario' => $login])->get();
        
        if(count($usuario)){
            return 2;
        } else {
            return 1;
        }
            
    }
    
}