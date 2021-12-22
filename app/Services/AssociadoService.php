<?php

namespace App\Services;

use App\Models\Associado;
use App\Models\Usuario;
use App\Models\Status;
use App\Models\Perfil;
use App\Models\File;
use App\Models\Endereco;
use App\Models\SubCategoria;
use App\Models\HistoricoAlteracaoStatus;
use App\Responses\ResponseEntity;
use Illuminate\Http\Request;
use Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Dependente;
use App\Repositories\AssociadoRepository;
use App\Dto\ParamDataTable;

class AssociadoService
{
    public function salvarPasso1(Request $request): ResponseEntity
    {
        $response = new ResponseEntity();
        try {

            $associado = new Associado($request->all());
            $usuario = new Usuario($request->all());
            $usuario->password = $request->input("senha");
            $pagamento = $request->input("pagamentoNIP");
            if($pagamento == ""){
                $pagamento = $request->input("pagamento");
            }
            $associado->forma_pagamento = $pagamento;

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

            $file = $request->file("arquivo");
            if($file != null){
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

                $ext = $file->getClientOriginalExtension();
                $filename = date('YmdHis') . uniqid() . "." . $ext;
                $file->move('associados', $filename);
                $associado->documento = 'associados/' . $filename;
            }

            \DB::beginTransaction();
            $usuario->status = Status::EM_PROCESSO;
            $usuario->perfil = Perfil::ASSOCIADO;
            $senha = Hash::make($request->input("senha"));
            $usuario->password = $senha;
            $usuario->save();

            $associado->status  = Status::EM_PROCESSO;
            $associado->usuario_id = $usuario->id;
            $associado->save();

            \DB::commit();
            $response->setEntity([
                'user' => $usuario,
                'associado' => $associado
            ]);
            $response->setStatus(200);
        } catch (\Exception $e) {
            \DB::rollback();
            $response->setStatus(500);
            \Log::error("Erro ao salvar associado", [ $e->getMessage()]);
            throw new \Exception("Não pode salvar o associado");
        }

        return $response;
    }

    public function salvarPasso2(Endereco $endereco, $idAssociado): ResponseEntity
    {
        $response = new ResponseEntity();
        try {

            $associado = Associado::find($idAssociado);
            if(!$associado){
                $response->setStatus(400);
                $response->addError("Associado não encontrado");
                return $response;
            }

            if (!$endereco->validate()) {
                $response->setStatus(400);
                $response->setErrors($endereco->errors());
                return $response;
            }

            \DB::beginTransaction();
            $endereco->associado_id = $associado->id;
            $endereco->save();
            \DB::commit();
            $response->setStatus(200);
        } catch (\Exception $e) {
            \DB::rollback();
            $response->setStatus(500);
            \Log::error("Erro ao salvar endereço", [ $e->getMessage()]);
            throw new \Exception("Não pode salvar o endereço");
        }

        return $response;
    }

    public function salvarPasso3(Request $request, $idAssociado): ResponseEntity
    {
        $response = new ResponseEntity();
        try {

            $associado = Associado::find($idAssociado);
            if(!$associado){
                $response->setStatus(400);
                $response->addError("Associado não encontrado");
                return $response;
            }

            $dependente = new Dependente($request->all());
            if (!$dependente->validate()) {
                $response->setStatus(400);
                $response->setErrors($dependente->errors());
                return $response;
            }

            $file = $request->file("arquivo");
            if($file != null){
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

                $ext = $file->getClientOriginalExtension();
                $filename = 'dep_' . date('YmdHis') . uniqid() . "." . $ext;
                $file->move('associados', $filename);
                $dependente->documento = 'associados/' . $filename;
            }

            \DB::beginTransaction();
            $dependente->associado_id = $associado->id;
            $dependente->status = Status::AGUARDANDO_LIBERACAO;
            $dependente->save();
            \DB::commit();
            $response->setStatus(200);
        } catch (\Exception $e) {
            \DB::rollback();
            $response->setStatus(500);
            \Log::error("Erro ao salvar dependente", [ $e->getMessage()]);
            throw new \Exception("Não pode salvar o dependente");
        }

        return $response;
    }

    public function salvarPasso4($idAssociado): ResponseEntity
    {
        $response = new ResponseEntity();
        try {

            $associado = Associado::where("id", $idAssociado)
                                ->whereIn("status", [Status::EM_PROCESSO, Status::AGUARDANDO_LIBERACAO, Status::INATIVO])
                                ->first();
            if(!$associado){
                $response->setStatus(400);
                $response->addError("Associado não encontrado");
                return $response;
            }
            $usuario = Usuario::find($associado->usuario_id);

            \DB::beginTransaction();
            $associado->status = Status::AGUARDANDO_LIBERACAO;
            $associado->save();

            $usuario->status = Status::AGUARDANDO_LIBERACAO;
            $usuario->save();
            \DB::commit();
            $response->setStatus(200);
        } catch (\Exception $e) {
            \DB::rollback();
            $response->setStatus(500);
            \Log::error("Erro ao finalizar cadastro do associado", [ $e->getMessage()]);
            throw new \Exception("Não pode salvar o associado");
        }

        return $response;
    }

    public function getCountPlanos($status = []){
        $sql = "SELECT COUNT(*) TOTAL, CONCAT(plano, ' meses') planos FROM associados WHERE 1 = 1 ";

        if(count($status) > 0){
            $sql .= " AND status in ('" . implode("','", $status). "') ";
        }

        $sql .= " GROUP BY plano ";
        return \DB::select($sql);
    }

    public function getCountCategorias($status = []){
        $sql = "SELECT COUNT(*) TOTAL, categoria FROM categorias c
                inner join subcategorias sc ON c.id = sc.categoria_id
                INNER JOIN associados a ON sc.id = a.subcategoria_id
                WHERE 1 = 1 ";

        if(count($status) > 0){
            $sql .= " AND status in ('" . implode("','", $status). "') ";
        }

        $sql .= " GROUP BY c.id ";
        return \DB::select($sql);
    }

    public function buscar(ParamDataTable $param): array{
        $repository = new AssociadoRepository();
        $total = $repository->searchCount($param);
        $data = [
            'count' => $total,
            'data' => []
        ];

        if($total > 0){
            $data['data'] = $repository->search($param)->get(["*", "associados.id as idassociado", "associados.status as statusassoc"]);
        }

        return $data;
    }

    public function getAssociadoById($id) : Associado{
        $associado = Associado::join("usuarios", "usuarios.id", "=", "associados.usuario_id")
                            ->leftJoin("enderecos", "enderecos.associado_id", "=", "associados.id")
                            ->leftJoin("subcategorias", "subcategorias.id", "=", "associados.subcategoria_id")
                            ->leftJoin("categorias", "subcategorias.categoria_id", "=", "categorias.id");
        $associado = $associado->where("associados.id", $id);
        return $associado->first();
    }

    public function getAssociadoByUsuario($id) : Associado{
        $associado = Associado::join("usuarios", "usuarios.id", "=", "associados.usuario_id")
                            ->leftJoin("enderecos", "enderecos.associado_id", "=", "associados.id")
                            ->leftJoin("subcategorias", "subcategorias.id", "=", "associados.subcategoria_id")
                            ->leftJoin("categorias", "subcategorias.categoria_id", "=", "categorias.id");
        $associado = $associado->where("usuarios.id", $id);
        return $associado->first();
    }

    public function alterarAssociado($idAssociado, $status): ResponseEntity
    {
        $response = new ResponseEntity();
        try {

            $associado = Associado::find($idAssociado);
            if(!$associado){
                $response->setStatus(400);
                $response->addError("Associado não encontrado");
                return $response;
            }
            $usuario = Usuario::find($associado->usuario_id);

            \DB::beginTransaction();
            $associado->status = $status;
            $associado->save();

            $usuario->status = $status;
            $usuario->save();

            $historico = new HistoricoAlteracaoStatus;
            $historico->dt_operacao = \Carbon\Carbon::now()->format("Y-m-d");
            $historico->status = $status;
            $historico->tipo = Perfil::ASSOCIADO;
            $historico->referencia_id = $associado->id;
            $historico->save();

            \DB::update("UPDATE dependentes SET status = ? WHERE associado_id = ?", [$status, $associado->id]);

            \DB::commit();
            $response->setStatus(200);
        } catch (\Exception $e) {
            \DB::rollback();
            $response->setStatus(500);
            \Log::error("Erro ao aprovar o associado", [ $e->getMessage()]);
            $response->addError("Erro ao aprovar o Associado");
            throw new \Exception("Não pode aprovar o associado");
        }

        return $response;
    }
}
