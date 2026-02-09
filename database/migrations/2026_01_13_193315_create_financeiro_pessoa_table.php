<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinanceiroPessoaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('financeiro_pessoa', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('nome', 100)->nullable();
            $table->string('nome_fantasia', 100)->nullable();
            $table->string('razao_social', 100)->nullable();
            $table->string('cnpj_cpf', 14)->nullable();
            $table->string('ie', 20)->nullable();
            $table->string('rg', 20)->nullable();
            $table->integer('cargo_id')->nullable();
            $table->date('nascimento')->nullable();
            $table->string('sexo', 1)->nullable();
            $table->string('tipo_pessoa', 20)->nullable()->comment('PF-Fisica | PJ-Juridica');
            $table->string('tipo_cadastro', 45)->nullable();
            $table->integer('categoria_id')->nullable();
            $table->string('telefone1', 20)->nullable();
            $table->string('telefone2', 20)->nullable();
            $table->string('celular', 20)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('endereco_tipo', 20)->nullable()->comment('correio | cobranca | ambos');
            $table->string('endereco', 100)->nullable();
            $table->string('numero', 10)->nullable();
            $table->string('complemento', 40)->nullable();
            $table->string('bairro', 50)->nullable();
            $table->string('cidade', 50)->nullable();
            $table->string('uf', 2)->nullable();
            $table->string('cep', 8)->nullable();
            $table->string('endereco2', 100)->nullable();
            $table->string('numero2', 10)->nullable();
            $table->string('complemento2', 40)->nullable();
            $table->string('bairro2', 50)->nullable();
            $table->string('cidade2', 50)->nullable();
            $table->string('uf2', 2)->nullable();
            $table->string('cep2', 8)->nullable();
            $table->string('conta_tipo', 45)->nullable();
            $table->string('conta_banco', 100)->nullable();
            $table->string('conta_agencia', 10)->nullable();
            $table->string('conta_numero', 20)->nullable();
            $table->text('conta_obs')->nullable();
            $table->text('obs')->nullable();
            $table->smallInteger('ativo')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('financeiro_pessoa');
    }
}
