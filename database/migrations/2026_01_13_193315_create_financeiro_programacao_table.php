<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinanceiroProgramacaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('financeiro_programacao', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('parent_id')->nullable();
            $table->string('operacao', 1)->nullable();
            $table->integer('pessoa_id')->nullable();
            $table->integer('conta_id')->nullable();
            $table->integer('forma_pagamento_id')->nullable();
            $table->integer('plano_conta_id')->nullable();
            $table->integer('centro_custo_id')->nullable();
            $table->integer('documento_tipo_id')->nullable();
            $table->date('data_emissao')->nullable();
            $table->date('data_vencimento')->nullable();
            $table->date('data_competencia')->nullable();
            $table->date('data_lancamento')->nullable();
            $table->date('data_recebimento')->nullable();
            $table->string('numero', 20)->nullable();
            $table->string('frequencia', 45)->nullable();
            $table->double('valor', 7, 2)->nullable();
            $table->double('valor_total', 7, 2)->nullable();
            $table->integer('parcela')->nullable();
            $table->string('historico', 200)->nullable();
            $table->text('obs')->nullable();
            $table->string('anexo', 100)->nullable();
            $table->smallInteger('status')->nullable();
            $table->integer('lancamento_id')->nullable();
            $table->integer('usuario_id')->nullable();
            $table->smallInteger('relancar')->nullable()->default(0);
            $table->integer('parcelamento')->nullable();
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
        Schema::dropIfExists('financeiro_programacao');
    }
}
