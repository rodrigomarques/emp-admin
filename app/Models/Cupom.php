<?php

namespace App\Models;

class Cupom extends RModel
{
    protected $table = "cupons";
    public $timestamps = true;
    public $incrementing = true;
    protected $fillable = ['titulo', 'codigo', 'valor', 'tipo', 'dt_inicio', 'dt_termino', 'categorias'];

    protected $rules = [
        'codigo' => 'required|min:6',
        'valor' => 'required|decimal',
        'dt_inicio' => 'nullable|date_format:d/m/Y',
        'dt_termino' => 'nullable|date_format:d/m/Y'
    ];

    protected $messages = [
        'codigo.required' => 'Preencha o campo código',
        'codigo.min' => 'Código deve ter ao menos 6 caracter',
        'valor.required' => 'Preencha o campo valor',
        'valor.decimal' => 'O campo valor é inválido',
        'dt_inicio.date_format' => 'Data início é inválida',
        'dt_termino.date_format' => 'Data término é inválida'
    ];
}
