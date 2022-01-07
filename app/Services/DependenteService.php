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

    public function getIdAssociado($idAssociado){
        $dep = Dependente::where("associado_id", $idAssociado);
        return $dep->get();
    }

    public function getId($id){
        $dep = Dependente::find($id);
        return $dep;
    }

    public function editarDependente($idDependente, Request $request): ResponseEntity
    {
        $response = new ResponseEntity();
        try {

            $file = $request->file("arquivo");
            if ($file != null) {
                $ext = strtolower($file->getClientOriginalExtension());
                $size = $file->getSize();

                if (!in_array($ext, File::VALID_EXT)) {
                    $response->setStatus(400);
                    $response->addError("Arquivo inválido");
                    return $response;
                }

                if ($size > File::LIMIT_SIZE) {
                    $response->setStatus(400);
                    $response->addError("Tamanho do arquivo inválido");
                    return $response;
                }
            }

            \DB::beginTransaction();
            $dependente = Dependente::find($idDependente);
            if(!$dependente){
                $response->setStatus(400);
                $response->addError("Dependente não encontrado");
                return $response;
            }

            $dependente->fill($request->all());
            if (!$dependente->validate()) {
                $response->setStatus(400);
                $response->setErrors($dependente->errors());
                return $response;
            }

            if($file != null){
                $doc = $dependente->documento;
                $ext = $file->getClientOriginalExtension();
                $filename = date('YmdHis') . uniqid() . "." . $ext;
                $file->move('associados', $filename);
                $dependente->documento = 'associados/' . $filename;
                @unlink($doc);
            }

            $dependente->save();
            \DB::commit();
            $response->setEntity([
                'dependente' => $dependente,
            ]);
            $response->setStatus(200);
        } catch (\Exception $e) {
            \DB::rollback();
            $response->setStatus(500);
            \Log::error("Erro ao salvar dependente", [ $e->getMessage()]);
            throw new \Exception("Não pode salvar o dependente");
        }

        return $response;
    }
}
