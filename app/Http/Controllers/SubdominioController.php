<?php namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;
use Illuminate\Http\Request;


class SubdominioController extends Controller {
 
    
    public function index(Request $request){
        
        $url_array = explode('.', parse_url($request->url(), PHP_URL_HOST));
        $subdomain = $url_array[0];
        $subdomain = strtolower($subdomain);
        $subdomain = str_replace(' ', '', $subdomain);
        
        
        $url = getenv('APP_URL');
        $url_redir = getenv('APP_URL').'/financeiro';
        
        Session::put('url_base', $url);  
        
        return redirect($url_redir);
            
    }
    
}