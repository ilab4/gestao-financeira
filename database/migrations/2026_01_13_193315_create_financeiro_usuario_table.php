<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinanceiroUsuarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('financeiro_usuario', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('nome', 100)->nullable();
            $table->string('usuario', 45)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('senha', 100)->nullable();
            $table->smallInteger('admin')->nullable();
            $table->smallInteger('ativo')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('financeiro_usuario');
    }
}
