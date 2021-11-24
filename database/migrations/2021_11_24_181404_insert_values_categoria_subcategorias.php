<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsertValuesCategoriaSubcategorias extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::insert('insert into categorias (categoria) values (?)', ['MILITAR NA ATIVA']);
        \DB::insert('insert into categorias (categoria) values (?)', ['MILITAR DA RESERVA/REFORMADO']);
        \DB::insert('insert into categorias (categoria) values (?)', ['CIVIL']);

        $categoria = \App\Models\Categoria::where("categoria", "MILITAR NA ATIVA")->first();
        \DB::insert('insert into subcategorias (subcategoria,tipo,categoria_id) values (?,?,?)', ['ALUNO ESCOLA FORMAÇÃO', 'NIP/RG', $categoria->id ]);
        \DB::insert('insert into subcategorias (subcategoria,tipo,categoria_id) values (?,?,?)', ['MILITAR DE FORÇA AUXILIAR ATIVA – CB','RG', $categoria->id ]);
        \DB::insert('insert into subcategorias (subcategoria,tipo,categoria_id) values (?,?,?)', ['MILITAR DE FORÇA AUXILIAR ATIVA– PM',	'RG', $categoria->id ]);
        \DB::insert('insert into subcategorias (subcategoria,tipo,categoria_id) values (?,?,?)', ['MILITAR EB ATIVA - de Carreira',	'RG', $categoria->id ]);
        \DB::insert('insert into subcategorias (subcategoria,tipo,categoria_id) values (?,?,?)', ['MILITAR EB ATIVA RM2/RM3',	'RG', $categoria->id ]);
        \DB::insert('insert into subcategorias (subcategoria,tipo,categoria_id) values (?,?,?)', ['MILITAR ESTRANGEIRO',	'RG', $categoria->id ]);
        \DB::insert('insert into subcategorias (subcategoria,tipo,categoria_id) values (?,?,?)', ['MILITAR FAB ATIVA - de Carreira',	'NIP/RG', $categoria->id ]);
        \DB::insert('insert into subcategorias (subcategoria,tipo,categoria_id) values (?,?,?)', ['MILITAR FAB ATIVA RM2/RM3',	'NIP/RG', $categoria->id ]);
        \DB::insert('insert into subcategorias (subcategoria,tipo,categoria_id) values (?,?,?)', ['MILITAR MB ATIVA - de Carreira',	'RG', $categoria->id ]);
        \DB::insert('insert into subcategorias (subcategoria,tipo,categoria_id) values (?,?,?)', ['MILITAR MB ATIVA RM2/RM3',	'RG', $categoria->id ]);

        $categoria = \App\Models\Categoria::where("categoria", "MILITAR DA RESERVA/REFORMADO")->first();
        \DB::insert('insert into subcategorias (subcategoria,tipo,categoria_id) values (?,?,?)', ['MILITAR DE FORÇA AUXILIAR RES/REF – CB', 'RG', $categoria->id]);
        \DB::insert('insert into subcategorias (subcategoria,tipo,categoria_id) values (?,?,?)', ['MILITAR DE FORÇA AUXILIAR RES/REF– PM',	'RG', $categoria->id]);
        \DB::insert('insert into subcategorias (subcategoria,tipo,categoria_id) values (?,?,?)', ['MILITAR EB RESERVA /REFORMADO',	'RG', $categoria->id]);
        \DB::insert('insert into subcategorias (subcategoria,tipo,categoria_id) values (?,?,?)', ['MILITAR FAB RESERVA /REFORMADO',	'RG', $categoria->id]);
        \DB::insert('insert into subcategorias (subcategoria,tipo,categoria_id) values (?,?,?)', ['MILITAR MB RESERVA RM1 e REFORMADO',	'NIP/RG', $categoria->id]);
        \DB::insert('insert into subcategorias (subcategoria,tipo,categoria_id) values (?,?,?)', ['MILITAR MB RESERVA RM2',	'RG', $categoria->id]);

        $categoria = \App\Models\Categoria::where("categoria", "CIVIL")->first();
        \DB::insert('insert into subcategorias (subcategoria,tipo,categoria_id) values (?,?,?)', ['CONTRATADO ACANTHUS',	'RG', $categoria->id ]);
        \DB::insert('insert into subcategorias (subcategoria,tipo,categoria_id) values (?,?,?)', ['CONVIDADO',	'RG', $categoria->id ]);
        \DB::insert('insert into subcategorias (subcategoria,tipo,categoria_id) values (?,?,?)', ['SERVIDOR CIVIL DA MB',	'RG', $categoria->id ]);
        \DB::insert('insert into subcategorias (subcategoria,tipo,categoria_id) values (?,?,?)', ['SERVIDOR DE AUTARQUIA VINCULADA A MB',	'RG', $categoria->id ]);
        \DB::insert('insert into subcategorias (subcategoria,tipo,categoria_id) values (?,?,?)', ['SERVIDOR DE ESTATAL VINCULADA A MB',	'RG', $categoria->id ]);


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
