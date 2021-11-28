<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableCupons extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cupons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('titulo', 150);
            $table->string('codigo', 50);
            $table->decimal('valor', 10,4)->nullable();
            $table->string('tipo', 10)->nullable();
            $table->date('dt_inicio')->nullable();
            $table->date('dt_termino')->nullable();
            $table->string('categorias', 255)->nullable();
            $table->string('status', 20);
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
        Schema::dropIfExists('cupons');
    }
}
