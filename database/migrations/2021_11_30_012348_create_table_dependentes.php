<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableDependentes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dependentes', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string("nome", 150);
            $table->string("email", 150)->unique();
            $table->date("dt_nascimento");
            $table->string("sexo", 2);
            $table->string("parentesco", 50);
            $table->string("documento", 150)->nullable();

            $table->bigInteger("associado_id")->unsigned();

            $table->foreign('associado_id')
                ->references('id')->on('associados');

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
        Schema::dropIfExists('dependentes');
    }
}
