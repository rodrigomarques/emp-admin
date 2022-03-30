<?php

namespace App\Models;

class Planos extends RModel
{
    protected $table = "planos";
    public $timestamps = true;
    public $incrementing = true;
    protected $fillable = ['plano', 'valor', 'joia', 'status'];

    public static $dataTableViewColumns = [

    ];

    protected $rules = [
        'plano' => 'required',
        'valor' => 'required',
    ];

    protected $messages = [
        'plano.required' => 'Plano é obrigatório',
        'valor.required' => 'Valor é obrigatório',
    ];
}
