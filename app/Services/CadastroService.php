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

    public function salvarPlano(Planos $plano): ResponseEntity{
        $response = new ResponseEntity();
        try{
            if(!$plano->validate()){
                $response->setStatus(400);
                $response->setErrors($plano->errors());
                return $response;
            }
            $plano->status = Status::ATIVO;

            if($plano->save())
                $response->setStatus(200);
            else
                throw new \Exception();

        }catch(\Exception $e){
            \Log::error("ERRO SAVE PLANO", [ $e ]);
            throw new \Exception("Não pode salvar o plano");
        }

        return $response;
    }

    public function excluirPlano($idPlano): ResponseEntity
    {
        $response = new ResponseEntity();
        try {

            \DB::beginTransaction();
            $plano = Planos::find($idPlano);
            if(!$plano){
                $response->setStatus(400);
                $response->addError("Plano não encontrado");
                return $response;
            }

            $plano->status = Status::CANCELADO;
            if($plano->save())
                $response->setStatus(200);
            else
                throw new \Exception();

            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            $response->setStatus(500);
            \Log::error("Erro ao excluir o plano", [ $e->getMessage()]);
            throw new \Exception("Não pode excluir o plano");
        }

        return $response;
    }
}
