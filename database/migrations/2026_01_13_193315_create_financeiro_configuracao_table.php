<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinanceiroConfiguracaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('financeiro_configuracao', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('nome', 100)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('cnpj', 14)->nullable();
            $table->string('url', 200)->nullable();
            $table->string('telefone', 20)->nullable();
            $table->string('whatsapp', 20)->nullable();
            $table->string('cep', 10)->nullable();
            $table->string('endereco', 100)->nullable();
            $table->string('numero', 20)->nullable();
            $table->string('bairro', 50)->nullable();
            $table->string('cidade', 50)->nullable();
            $table->string('uf', 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('financeiro_configuracao');
    }
}
