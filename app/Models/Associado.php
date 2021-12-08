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
        'status',
        'subcategoria_id',
        'nome',
        'email',
        'celular',
        'cpf',
        'created_at'
    ];

    protected $rules = [
        'cpf' => 'required',
        'forma_pagamento' => 'required',
        'plano' => 'required',
    ];

    protected $messages = [
        'cpf.required' => 'CPF é obrigatório',
        'forma_pagamento.required' => 'Forma de pagamento é obrigatório',
        'plano.required' => 'Plano é obrigatório',
    ];

    public function usuario(){
        return $this->belongsTo(Usuario::class, "usuario_id");
    }

    public function subcategoria(){
        return $this->belongsTo(SubCategoria::class, "subcategoria_id");
    }

    public function endereco(){
        return $this->hasOne(Endereco::class, "associado_id");
    }

    public function dependentes(){
        return $this->hasMany(Dependente::class, "associado_id");
    }
}
