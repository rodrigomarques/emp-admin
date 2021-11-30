<?php

namespace App\Services;

use App\Models\Associado;
use App\Models\Usuario;
use App\Models\Status;
use App\Models\SubCategoria;
use App\Responses\ResponseEntity;

class AssociadoService
{
    public function salvarPasso1(Associado $associado, Usuario $usuario): ResponseEntity
    {
        $response = new ResponseEntity();
        try {


        } catch (\Exception $e) {
            throw new \Exception("Não pode salvar o associado");
        }

        return $response;
    }

}
