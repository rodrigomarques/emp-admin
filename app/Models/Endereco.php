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
        'cep' => 'required',
        'bairro' => 'required',
        'endereco' => 'required',
        'cidade' => 'required',
        'estado' => 'required',
    ];

    protected $messages = [
        'cep.required' => 'CEP é obrigatório',
        'bairro.required' => 'Bairro é obrigatório',
        'endereco.required' => 'Endereço é obrigatório',
        'cidade.required' => 'Cidade é obrigatório',
        'estado.required' => 'Estado é obrigatório',
    ];
}
