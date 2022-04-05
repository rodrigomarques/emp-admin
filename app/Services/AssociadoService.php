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

            $confirmar_email = $request->input("confirmar_email", "");
            $email = $request->input("email", "");

            if($email != $confirmar_email){
                $response->setStatus(400);
                $response->addError("E-mails devem ser iguais");
                return $response;
            }

            $senha = $request->input("senha");
            $csenha = $request->input("csenha");

            if($senha != $csenha){
                $response->setStatus(400);
                $response->addError("As senhas devem ser iguais");
                return $response;
            }

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

            $dbAssoc = Associado::where("cpf", $associado->cpf)->first();
            if($dbAssoc){
                $response->setStatus(400);
                $response->addError("Cpf já cadastrado");
                return $response;
            }

            if(!$associado->validate()){
                $response->setStatus(400);
                $response->setErrors($associado->errors());
                return $response;
            }

            $file = $request->file("arquivo");
            $fileVerso = $request->file("arquivo_verso");
            $fileAmn = $request->file("arquivo_amn");
            if($file == null && $fileVerso == null){
                $response->setStatus(400);
                $response->addError("Arquivo é obrigatório");
                return $response;
            }

            if($associado->amn == "S" && $fileAmn == null){
                $response->setStatus(400);
                $response->addError("Arquivo AMN é obrigatório");
                return $response;
            }

            if($file != null && $fileVerso != null){
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

                $extVerso = strtolower($fileVerso->getClientOriginalExtension());
                $sizeVerso = $fileVerso->getSize();

                if (!in_array($extVerso, File::VALID_EXT)) {
                    $response->setStatus(400);
                    $response->addError("Arquivo inválido");
                    return $response;
                }

                if ($sizeVerso > File::LIMIT_SIZE) {
                    $response->setStatus(400);
                    $response->addError("Tamanho do arquivo Verso inválido");
                    return $response;
                }

                if($fileAmn != null){
                    $extAmn = strtolower($fileAmn->getClientOriginalExtension());
                    $sizeAmn = $fileAmn->getSize();

                    if (!in_array($extAmn, File::VALID_EXT)) {
                        $response->setStatus(400);
                        $response->addError("Arquivo inválido");
                        return $response;
                    }

                    if ($sizeAmn > File::LIMIT_SIZE) {
                        $response->setStatus(400);
                        $response->addError("Tamanho do arquivo AMN inválido");
                        return $response;
                    }

                    $extAmn = $fileAmn->getClientOriginalExtension();
                    $filenameAmn = "amn_" . date('YmdHis') . uniqid() . "." . $extAmn;
                    $fileAmn->move('associados', $filenameAmn);
                    $associado->documento_amn = 'associados/' . $filenameAmn;
                }

                $ext = $file->getClientOriginalExtension();
                $filename = date('YmdHis') . uniqid() . "." . $ext;
                $file->move('associados', $filename);
                $associado->documento = 'associados/' . $filename;

                $extVerso = $fileVerso->getClientOriginalExtension();
                $filenameVerso = "verso_" . date('YmdHis') . uniqid() . "." . $extVerso;
                $fileVerso->move('associados', $filenameVerso);
                $associado->documento_verso = 'associados/' . $filenameVerso;
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

            $plano = Planos::find($associado->plano_id);
            if($plano){
                $meses = $plano->meses;
                if($meses != null){
                    $dtFimPlano = \Carbon\Carbon::now();
                    $dtFimPlano = $dtFimPlano->addMonths($meses);
                    $associado->dt_fim_plano = $dtFimPlano->format("Y-m-d");
                }
            }

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

    public function getCountAssociadosAtivos($montPast = 0) : object{
        $select = \DB::select("select count(*) total
                                from historico_alteracao_status ha inner join associados a on a.id = ha.referencia_id
                                where DATE_FORMAT(dt_operacao, '%Y%m') <=  DATE_FORMAT(DATE_SUB(now(), INTERVAL " . $montPast . " MONTH), '%Y%m')
                                and ha.status = 'ATIVO' and tipo = 'ASSOCIADO'");
        return $select[0];
    }

    public function getCountAssociadosAtivosInativos() : array{
        $select = \DB::select("select count(*) total, DATE_FORMAT(dt_operacao, '%Y%m') 'data', status
                                from historico_alteracao_status
                                where DATE_FORMAT(dt_operacao, '%Y%m') >=  DATE_FORMAT(DATE_SUB(now(), INTERVAL 6 MONTH), '%Y%m')  and tipo = 'ASSOCIADO'
                                group by status, DATE_FORMAT(dt_operacao, '%Y%m') order by DATE_FORMAT(dt_operacao, '%Y%m') ASC;");
        return $select;
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

    public function editarAssociado($idUser, Request $request): ResponseEntity
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

            if($request->input("senha") != "" && $request->input("senha") != $request->input("csenha")){
                $response->setStatus(400);
                $response->addError("As senhas devem ser iguais");
                return $response;
            }

            \DB::beginTransaction();
            $associado = Associado::where("usuario_id", $idUser)->first();
            if(!$associado){
                $response->setStatus(400);
                $response->addError("Asociado não encontrado");
                return $response;
            }

            $user = Usuario::find($idUser);
            if(!$user){
                $response->setStatus(400);
                $response->addError("Usuário não encontrado");
                return $response;
            }

            $associado->fill($request->all());

            $user->fill($request->all());
            if($request->input("senha") != ""){
                $senha = Hash::make($request->input("senha"));
                $user->password = $senha;
            }

            $dbUser = Usuario::where("email", $user->email)->where("id", "!=", $idUser)->first();
            if($dbUser){
                $response->setStatus(400);
                $response->addError("E-mail já cadastrado");
                return $response;
            }

            if (!$user->validate()) {
                $response->setStatus(400);
                $response->setErrors($user->errors());
                return $response;
            }

            if(!$associado->validate()){
                $response->setStatus(400);
                $response->setErrors($associado->errors());
                return $response;
            }

            $endereco = Endereco::where("associado_id", $associado->id)->first();
            if(!$endereco) $endereco = new Endereco();

            $endereco->fill($request->all());
            if (!$endereco->validate()) {
                $response->setStatus(400);
                $response->setErrors($endereco->errors());
                return $response;
            }

            if($file != null){
                $doc = $associado->documento;
                $ext = $file->getClientOriginalExtension();
                $filename = date('YmdHis') . uniqid() . "." . $ext;
                $file->move('associados', $filename);
                $associado->documento = 'associados/' . $filename;
                @unlink($doc);
            }

            $associado->save();
            $user->save();

            $endereco->associado_id = $associado->id;
            $endereco->save();
            \DB::commit();
            $response->setEntity([
                'user' => $user,
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
}
