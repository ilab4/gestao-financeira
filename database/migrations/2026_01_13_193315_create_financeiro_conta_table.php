<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinanceiroContaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('financeiro_conta', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('nome', 100)->nullable();
            $table->integer('conta_tipo_id')->nullable();
            $table->integer('banco_id')->nullable();
            $table->string('agencia', 10)->nullable();
            $table->string('numero', 20)->nullable();
            $table->date('abertura')->nullable();
            $table->float('valor', 10, 0)->nullable();
            $table->string('contato', 100)->nullable();
            $table->string('telefone', 20)->nullable();
            $table->string('email', 100)->nullable();
            $table->text('obs')->nullable();
            $table->smallInteger('ativo')->nullable();
            $table->smallInteger('dashboard')->nullable();
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
        Schema::dropIfExists('financeiro_conta');
    }
}
