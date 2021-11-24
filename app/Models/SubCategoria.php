<?php

namespace App\Models;

class SubCategoria extends RModel
{
    protected $table = "subcategorias";
    public $timestamps = false;
    public $incrementing = true;
    protected $fillable = ['subcategoria','tipo','categoria_id'];

    protected $rules = [

    ];

    protected $messages = [

    ];
}
