<?php

namespace App\Models;

class Categoria extends RModel
{
    protected $table = "categorias";
    public $timestamps = false;
    public $incrementing = true;
    protected $fillable = ['categoria'];

    protected $rules = [

    ];

    protected $messages = [

    ];
}
