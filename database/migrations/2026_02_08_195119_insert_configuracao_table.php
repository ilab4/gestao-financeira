<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsertConfiguracaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $configs = 
        [
          [
            'nome'          => 'ILAB4 • Financeiro',
            'email'         => 'contato@ilab4.me',
            'whatsapp'      => '55 (21)96746-1824',
            'cidade'        => 'Rio de Janeiro',
            'uf'            => 'RJ',
          ]
        ];
        
        foreach ($configs as $config) {
            \App\Model\Financeiro\Configuracao::create($config);
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
