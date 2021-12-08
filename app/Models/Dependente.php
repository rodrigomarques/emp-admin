<?php

namespace App\Models;

class Dependente extends RModel
{
    protected $table = "dependentes";
    public $timestamps = true;
    public $incrementing = true;
    protected $fillable = ['nome', 'email', 'dt_nascimento', 'cpf', 'sexo', 'parentesco', 'documento', 'associado_id', 'status'];

    public static $dataTableViewColumns = [
        'nome',
        'email',
        'dt_nascimento',
        'cpf',
        'sexo',
        'parentesco'
    ];

    protected $rules = [
        'cpf' => 'required',
        'email' => 'required|email',
        'dt_nascimento' => 'nullable|date_format:Y-m-d',
        'parentesco' => 'required',
    ];

    protected $messages = [
        'cpf.required' => 'CPF é obrigatório',
        'email.required' => 'E-mail é obrigatório',
        'email.email' => 'E-mail inválido',
        'dt_nascimento.date_format' => 'Data de Nascimento é inválida',
        'parentesco.required' => 'Parentesco é obrigatório',
    ];
}
