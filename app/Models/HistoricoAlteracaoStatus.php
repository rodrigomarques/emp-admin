<?php

namespace App\Models;

class HistoricoAlteracaoStatus extends RModel
{
    protected $table = "historico_alteracao_status";
    public $timestamps = true;
    public $incrementing = false;
    protected $fillable = ['dt_operacao', 'status', 'tipo', 'referencia_id'];

    public static $dataTableViewColumns = [
    ];

    protected $rules = [

    ];

    protected $messages = [

    ];
}
