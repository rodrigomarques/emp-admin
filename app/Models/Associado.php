<?php

namespace App\Models;

class Associado extends RModel
{
    protected $table = "associados";
    public $timestamps = true;
    public $incrementing = true;
    protected $fillable = ['telefone_res', 'telefone_cel', 'sexo', 'cpf', 'subcategoria_id', 'rg', 'nip', 'forma_pagamento',
        'plano', 'documento', 'usuario_id', 'status'];

    public static $dataTableViewColumns = [

    ];

    protected $rules = [

    ];

    protected $messages = [

    ];
}
