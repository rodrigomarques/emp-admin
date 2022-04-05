<?php

namespace App\Models;

class Associado extends RModel
{
    protected $table = "associados";
    public $timestamps = true;
    public $incrementing = true;
    protected $fillable = ['telefone_res', 'telefone_cel', 'sexo', 'cpf', 'subcategoria_id', 'rg', 'nip', 'forma_pagamento',
        'plano_id', 'documento', 'documento_verso', 'usuario_id', 'status', 'dt_fim_plano', 'amn', 'documento_amn'];

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
        'plano_id' => 'required',
        'telefone_cel' => 'required'
    ];

    protected $messages = [
        'cpf.required' => 'CPF é obrigatório',
        'forma_pagamento.required' => 'Forma de pagamento é obrigatório',
        'plano_id.required' => 'Plano é obrigatório',
        'telefone_cel.required' => 'Celular é obrigatório',
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

    public function plano(){
        return $this->belongsTo(Planos::class, "plano_id");
    }

    public function setCpfAttribute($value) {
        $this->attributes["cpf"] = preg_replace("/[^0-9]/", "", $value);
    }
}
