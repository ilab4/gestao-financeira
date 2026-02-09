<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsertUsuarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $usuarios = 
        [
          [
            'nome'          => 'ADMNISTRADOR',
            'usuario'       => 'admin',
            'senha'         => '89e495e7941cf9e40e6980d14a16bf023ccd4c91',
            'admin'         => 1,
            'ativo'         => 1,
          ]
        ];
        
        foreach ($usuarios as $usuario) {
            \App\Model\Financeiro\Usuario::create($usuario);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
