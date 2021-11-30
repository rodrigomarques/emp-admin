<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableAssociados extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('associados', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("telefone_res", 20)->nullable();
            $table->string("telefone_cel", 20)->nullable();
            $table->string("sexo", 3)->nullable();
            $table->string("cpf", 11)->unique();
            $table->string("rg", 20);
            $table->string("nip", 50)->nullable();
            $table->string("forma_pagamento", 50)->nullable();
            $table->string("plano", 50)->nullable();
            $table->string("documento", 150)->nullable();
            $table->string("status", 20);

            $table->bigInteger("subcategoria_id")->unsigned();
            $table->bigInteger("usuario_id")->unsigned();

            $table->foreign('subcategoria_id')
                ->references('id')->on('subcategorias');
            $table->foreign('usuario_id')
                ->references('id')->on('usuarios');

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
        Schema::dropIfExists('associados');
    }
}
