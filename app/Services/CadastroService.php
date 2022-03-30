<?php

namespace App\Services;
use App\Responses\ResponseEntity;
use App\Models\Planos;
use App\Models\Status;
use App\Dto\ParamDataTable;
use App\Repositories\CadastroRepository;

class CadastroService
{
    public function buscarPlanos(ParamDataTable $param): array{
        $repository = new CadastroRepository();
        $total = $repository->searchCount($param);
        $data = [
            'count' => $total,
            'data' => []
        ];

        if($total > 0){
            $data['data'] = $repository->search($param)->get();
        }

        return $data;
    }
}
