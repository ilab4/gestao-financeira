<?php namespace App\Http\Controllers\Financeiro;

use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

use Request;
use Session;


abstract class FinanceiroController extends Controller
{
  
    public function upload($arquivo) {
        // 1. Definições
        $extensoesPermitidas = ['jpg', 'png', 'pdf', 'jpeg'];
        $extensao = strtolower($arquivo->getClientOriginalExtension());

        // 2. Validação
        if (!in_array($extensao, $extensoesPermitidas)) {
            abort(403, "O tipo de arquivo (" . $extensao . ") não é permitido.");
        }

        // 3. Upload via Storage
        $path = $arquivo->store('upload/anexo', 'public');

        return basename($path);
    }
    
}