<?php

namespace App\Services;
use App\Responses\ResponseEntity;
use App\Models\Cupom;
use App\Models\SubCategoria;
use App\Models\Status;
use App\Dto\ParamDataTable;
use App\Repositories\CupomRepository;

class CupomService
{
    public function salvar(Cupom $cupom): ResponseEntity{
        $response = new ResponseEntity();
        try{

            if($cupom->categorias != ""){
                $categorias = explode(",", $cupom->categorias);
                $ids = SubCategoria::select("id")->whereIn("subcategoria", $categorias)->pluck('id')->toArray();
                $cupom->categorias = implode(",", $ids);
            }

            if(!$cupom->validate()){
                $response->setStatus(400);
                $response->setErrors($cupom->errors());
                return $response;
            }
            $cupom->status = Status::ATIVO;

            if($cupom->save())
                $response->setStatus(200);
            else
                throw new \Exception();

        }catch(\Exception $e){
            throw new \Exception("Não pode salvar o cupom");
        }

        return $response;
    }

    public function buscar(ParamDataTable $param): array{
        $repository = new CupomRepository();
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

    public function getCategoria($categoria, $pattern = ","){
        $categorias = preg_replace('/[^0-9,]/', '', $categoria);

        if($categorias != ""){
            $idsCategorias = explode(",", $categorias);
            $subcategoria = SubCategoria::select("subcategoria")->whereIn("id", $idsCategorias)->pluck('subcategoria')->toArray();
            $categorias = implode($pattern, $subcategoria);
        }

        return $categorias;
    }

}
