<?php

namespace App\Models;

class Endereco extends RModel
{
    protected $table = "enderecos";
    public $timestamps = true;
    public $incrementing = true;
    protected $fillable = ['cep', 'endereco', 'numero', 'complemento', 'bairro', 'cidade', 'estado', 'associado_id'];

    public static $dataTableViewColumns = [

    ];

    protected $rules = [

    ];

    protected $messages = [

    ];
}
