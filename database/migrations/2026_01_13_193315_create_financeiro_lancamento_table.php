<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinanceiroLancamentoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('financeiro_lancamento', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('operacao', 20)->nullable();
            $table->integer('conta_id')->nullable();
            $table->integer('pessoa_id')->nullable();
            $table->integer('plano_conta_id')->nullable();
            $table->integer('centro_custo_id')->nullable();
            $table->double('valor', 10, 2)->nullable();
            $table->double('valor_multa', 7, 2)->nullable();
            $table->double('valor_juros', 7, 2)->nullable();
            $table->double('valor_desconto', 7, 2)->nullable();
            $table->double('valor_total', 10, 2)->nullable();
            $table->date('data_lancamento')->nullable();
            $table->string('numero', 50)->nullable();
            $table->date('competencia')->nullable();
            $table->string('historico', 200)->nullable();
            $table->text('obs')->nullable();
            $table->string('anexo', 200)->nullable();
            $table->integer('usuario_id')->nullable();
            $table->smallInteger('transferencia')->nullable();
            $table->string('transferencia_texto', 200)->nullable();
            $table->smallInteger('inicial')->nullable()->default(0);
            $table->string('transacao_id', 150)->nullable();
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
        Schema::dropIfExists('financeiro_lancamento');
    }
}
