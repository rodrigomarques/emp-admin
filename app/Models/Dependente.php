<?php

namespace App\Models;

class Dependente extends RModel
{
    protected $table = "dependentes";
    public $timestamps = true;
    public $incrementing = true;
    protected $fillable = ['nome', 'email', 'dt_nascimento', 'cpf', 'sexo', 'parentesco', 'documento', 'associado_id'];

    public static $dataTableViewColumns = [

    ];

    protected $rules = [

    ];

    protected $messages = [

    ];
}
