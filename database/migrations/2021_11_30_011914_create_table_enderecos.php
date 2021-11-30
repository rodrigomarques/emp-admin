<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableEnderecos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enderecos', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string("cep", 20);
            $table->string("endereco", 200);
            $table->string("numero", 20);
            $table->string("complemento", 200)->nullable();
            $table->string("bairro", 100);
            $table->string("cidade", 70);
            $table->string("estado", 2);

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
        Schema::dropIfExists('enderecos');
    }
}
