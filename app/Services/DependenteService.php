<?php

namespace App\Services;

use App\Responses\ResponseEntity;
use Illuminate\Http\Request;
use App\Models\Dependente;
use App\Repositories\DependenteRepository;
use App\Dto\ParamDataTable;

class DependenteService
{
    public function buscar(ParamDataTable $param): array{
        $repository = new DependenteRepository();
        $total = $repository->searchCount($param);
        $data = [
            'count' => $total,
            'data' => []
        ];

        if($total > 0){
            $data['data'] = $repository->search($param)->get(["dependentes.*", "associados.id as idassociado", "associados.status as statusassoc",
                "usuarios.nome as nomeusu"]);
        }

        return $data;
    }
}
