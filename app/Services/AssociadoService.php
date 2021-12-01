<?php

namespace App\Services;

use App\Models\Associado;
use App\Models\Usuario;
use App\Models\Status;
use App\Models\SubCategoria;
use App\Responses\ResponseEntity;
use Illuminate\Http\Request;

class AssociadoService
{
    public function salvarPasso1(Request $request): ResponseEntity
    {
        $response = new ResponseEntity();
        try {
            \DB::beginTransaction();

            $associado = new Associado($request->all());
            $usuario = new Usuario($request->all());

            $dbUser = Usuario::where("email", $usuario->email)->first();
            if($dbUser){
                $response->setStatus(400);
                $response->addError("E-mail já cadastrado");
                return $response;
            }

            if (!$usuario->validate()) {
                $response->setStatus(400);
                $response->setErrors($usuario->errors());
                return $response;
            }

            if(!$associado->validate()){
                $response->setStatus(400);
                $response->setErrors($associado->errors());
                return $response;
            }


            \DB::commit();
            $response->setStatus(200);
        } catch (\Exception $e) {
            \DB::rollback();
            $response->setStatus(500);
            \Log::error("Erro ao salvar associado", [ $e->getMessage()]);
            throw new \Exception("Não pode salvar o associado");
        }

        return $response;
    }

}
