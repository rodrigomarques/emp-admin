<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubCategoria;
use App\Models\Usuario;
use App\Models\Endereco;
use App\Models\Associado;
use App\Models\Planos;
use App\Util\Html;
use App\Util\Format;
use App\Models\Status;
use App\Dto\ParamDataTable;
use App\Services\AssociadoService;
use App\Services\DependenteService;
use App\Models\Perfil;
class AssociadoController extends Controller
{
    public function passo1(){
        $data = [];
        $data["listSubCategoria"] = SubCategoria::all();
        $data["listPlanos"] = Planos::where("status", Status::ATIVO)->get();
        return view("associado/passo1", $data);
    }

    public function passo1Save(Request $request){
        $service = new AssociadoService();
        try{
            $response = $service->salvarPasso1($request);
            if($response->getStatus() === 400)
                return back()->withErrors($response->getErrors())
                    ->withInput();

            if($response->getStatus() === 200){
                $entity = $response->getEntity();
                $associado = $entity["associado"];
                $idAssociado = base64_encode($associado->id);
                return redirect()->route('associado.passo2', [ 'idassociado' => $idAssociado]);
            }

        }catch(\Exception $e){
            session()->flash('error', "Não pode salvar o associado");
        }
        return back()
            ->withInput();
    }

    public function passo2($idassociado){
        $data = [];
        $data["idassociado"] = $idassociado;
        return view("associado/passo2", $data);
    }

    public function passo2Save($idassociado, Request $request){
        $service = new AssociadoService();
        try{

            $paramIdAssociado = base64_decode($idassociado);
            $endereco = new Endereco($request->all());
            $response = $service->salvarPasso2($endereco, $paramIdAssociado);
            if($response->getStatus() === 400)
                return back()->withErrors($response->getErrors())
                    ->withInput();

            if($response->getStatus() === 200){
                return redirect()->route('associado.passo3', [ 'idassociado' => $idassociado]);
            }

        }catch(\Exception $e){
            session()->flash('error', "Não pode salvar o endereço");
        }
        return back()
            ->withInput();
    }

    public function passo3($idassociado){
        $data = [];
        $data["idassociado"] = $idassociado;
        return view("associado/passo3", $data);
    }

    public function passo3Save($idassociado, Request $request) {
        $service = new AssociadoService();
        try {
            $paramIdAssociado = base64_decode($idassociado);
            $response = $service->salvarPasso3($request, $paramIdAssociado);
            if ($response->getStatus() === 400) {
                return back()->withErrors($response->getErrors())
                    ->withInput();
            }

            if ($response->getStatus() === 200) {
                session()->flash('success', "Dependente salvo com sucesso!");
                return back();
            }

        } catch (\Exception $e) {
            session()->flash('error', "Não pode salvar o dependente");
        }
        return back()
            ->withInput();

    }

    public function passo4($idassociado){
        $data = [];
        $service = new AssociadoService();
        try {
            $paramIdAssociado = base64_decode($idassociado);
            $response = $service->salvarPasso4($paramIdAssociado);
            if ($response->getStatus() === 400) {
                return back()->withErrors($response->getErrors())
                    ->withInput();
            }

            if ($response->getStatus() === 200) {
                return view("associado/passo4", $data);
            }

        } catch (\Exception $e) {
            session()->flash('error', "Não pode salvar o dependente");
        }
        session()->flash('error', "Associado não pode ser sucesso!");
        return back();
    }

    public function adminBuscar(){
        $data = [];
        return view("admin/associado/buscar", $data);
    }

    public function adminAjaxBuscar(Request $request){
        $value = $request->input("search", []);
        $order = $request->input("order", []);

        $draw = $request->query("draw", 1);

        $begin = $request->input("start", 0);
        $end = $request->input("length", 10);
        $orderField = "";
        $orderDirection = "ASC";

        $search = "";
        if(isset($value["value"])){
            $search = $value["value"];
        }

        $paramDataTable = ParamDataTable::init($draw, $begin, $end, $orderField, $orderDirection);
        $paramDataTable->setSearch($search);

        $associadoService = new AssociadoService();
        $dataLista = $associadoService->buscar($paramDataTable);

        $data = [];
        if(count($dataLista["data"]) > 0){
            $associadoGrid = array_map(function($associado) use($associadoService){
                $dataLista = [
                    Html::status($associado["statusassoc"]),
                    $associado["categoria"],
                    Html::linkDataTable($associado["idassociado"], '', ' btn-ver ', $associado["nome"], 'verDetalhes'),
                    $associado["email"],
                    $associado["telefone_cel"],
                    $associado["cpf"],
                    Format::fnDateView($associado["created_at"], true),
                    Html::linkDataTable(base64_encode($associado["idassociado"]), "fa fa-pencil", 'btn-edit', '', 'editarAssociado'),
                    Html::linkDataTable($associado["idassociado"], "fa fa-trash", 'btn-del', '', 'deletarAssociado')
                ];
                return $dataLista;
            }, $dataLista["data"]->toArray());
            $data = $associadoGrid;
        }

        return response()->json([
            "draw" => $draw,
            "recordsTotal" => $dataLista["count"],
            "recordsFiltered"=>  $dataLista["count"],
            "data" => $data
        ]);
    }

    public function adminAguardandoAprovacao(){
        $data = [];
        return view("admin/associado/aguardando-aprovacao", $data);
    }

    public function adminAjaxAguardandoAprovacao(Request $request){
        $value = $request->input("search", []);
        $order = $request->input("order", []);

        $draw = $request->query("draw", 1);

        $begin = $request->input("start", 0);
        $end = $request->input("length", 10);
        $orderField = "";
        $orderDirection = "ASC";

        $search = "";
        if(isset($value["value"])){
            $search = $value["value"];
        }

        $paramDataTable = ParamDataTable::init($draw, $begin, $end, $orderField, $orderDirection);
        $paramDataTable->setCondicional([
            'associados.status' => Status::AGUARDANDO_LIBERACAO
        ]);
        $paramDataTable->setSearch($search);

        $associadoService = new AssociadoService();
        $dataLista = $associadoService->buscar($paramDataTable);

        $data = [];
        if(count($dataLista["data"]) > 0){
            $associadoGrid = array_map(function($associado) use($associadoService){
                $dataLista = [
                    Html::linkDataTable($associado["idassociado"], "fa fa-check", 'btn-aprovar', '', 'aprovarAssociado'),
                    Html::status($associado["statusassoc"]),
                    $associado["categoria"],
                    Html::linkDataTable($associado["idassociado"], '', ' btn-ver ', $associado["nome"], 'verDetalhes'),
                    $associado["email"],
                    $associado["telefone_cel"],
                    $associado["cpf"],
                    Format::fnDateView($associado["created_at"], true),
                    Html::linkDataTable(base64_encode($associado["idassociado"]), "fa fa-pencil", 'btn-edit', '', 'editarAssociado'),
                    Html::linkDataTable($associado["idassociado"], "fa fa-trash", 'btn-del', '', 'deletarAssociado')
                ];
                return $dataLista;
            }, $dataLista["data"]->toArray());
            $data = $associadoGrid;
        }

        return response()->json([
            "draw" => $draw,
            "recordsTotal" => $dataLista["count"],
            "recordsFiltered"=>  $dataLista["count"],
            "data" => $data
        ]);
    }

    public function adminDependentes(){
        $data = [];
        return view("admin/associado/dependente", $data);
    }

    public function adminAjaxDependentes(Request $request){
        $value = $request->input("search", []);
        $order = $request->input("order", []);

        $draw = $request->query("draw", 1);

        $begin = $request->input("start", 0);
        $end = $request->input("length", 10);
        $isAssociado = $request->input("isAssociado", 0);

        $orderField = "";
        $orderDirection = "ASC";

        $search = "";
        if(isset($value["value"])){
            $search = $value["value"];
        }

        $paramDataTable = ParamDataTable::init($draw, $begin, $end, $orderField, $orderDirection);
        $paramDataTable->setSearch($search);

        $dependenteService = new DependenteService();
        $dataLista = $dependenteService->buscar($paramDataTable);

        $data = [];
        if(count($dataLista["data"]) > 0){
            $associadoGrid = array_map(function($dependente) use($isAssociado){

                $dataLista = [];

                if($isAssociado != 1) {
                    array_push($dataLista,  Html::status($dependente["statusassoc"]));
                    array_push($dataLista,  Html::linkDataTable($dependente["idassociado"], '', ' btn-ver ', $dependente["nomeusu"], 'verDetalhes'));
                }

                array_push($dataLista,
                        $dependente["nome"],
                        $dependente["email"],
                        Format::fnDateView($dependente["dt_nascimento"]),
                        $dependente["cpf"],
                        $dependente["parentesco"],
                        Format::fnDateView($dependente["created_at"], true),
                        Html::linkDataTable(base64_encode($dependente["id"]), "fa fa-pencil", 'btn-edit', '', 'editarDependente'),
                        Html::linkDataTable(base64_encode($dependente["id"]), "fa fa-trash", 'btn-del', '', 'deletarDependente')
                    );

                return $dataLista;
            }, $dataLista["data"]->toArray());
            $data = $associadoGrid;
        }

        return response()->json([
            "draw" => $draw,
            "recordsTotal" => $dataLista["count"],
            "recordsFiltered"=>  $dataLista["count"],
            "data" => $data
        ]);
    }

    public function adminAjaxDetalhes($idassociado, Request $request){
        $service = new AssociadoService();
        $serviceDep = new DependenteService();

        $associado = $service->getAssociadoById($idassociado);
        $deps = $serviceDep->getIdAssociado($idassociado);

        $data = [];
        $data["associado"] = $associado;
        $data["deps"] = $deps;

        return view("admin/associado/ajax-detalhes", $data);
    }

    public function adminAjaxAprovar($idassociado, Request $request){
        $service = new AssociadoService();
        $result = $service->alterarAssociado($idassociado, Status::ATIVO);

        if ($result->getStatus() === 200) {
            session()->flash('success', "Associado aprovado com sucesso!");
            return response()->json([
                'status' => 'ok'
            ]);
        }

        session()->flash('error', "Não pode aprovar o associado");
        return response()->json([
            'status' => 'erro',
            'msg' => implode("<br>", $result->getErrors())
        ]);
    }

    public function adminAjaxExcluir($idassociado, Request $request){
        $service = new AssociadoService();
        $result = $service->alterarAssociado($idassociado, Status::INATIVO);

        if ($result->getStatus() === 200) {
            session()->flash('success', "Associado alterado com sucesso!");
            return response()->json([
                'status' => 'ok'
            ]);
        }

        session()->flash('error', "Não pode alterado o associado");
        return response()->json([
            'status' => 'erro',
            'msg' => implode("<br>", $result->getErrors())
        ]);
    }

    public function meusDependentes(Request $request){
        $data = [];

        return view("admin/associado/meus-dependentes", $data);
    }

    public function editar($id, Request $request){
        $data = [];
        $idAssoc = base64_decode($id);
        $associadoService = new AssociadoService();

        $data["listSubCategoria"] = SubCategoria::all();
        $data["associado"] = $associadoService->getAssociadoById($idAssoc);
        $data["idassociado"] = $id;

        return view("admin/associado/editar", $data);
    }

    public function editarAssociadoSave($id, Request $request){
        try{

            $idAssoc = base64_decode($id);
            $user = Usuario::join("associados", "associados.usuario_id", "=", "usuarios.id")
                                ->where("associados.id", $idAssoc)
                                ->first(["usuarios.id"]);
            $associadoService = new AssociadoService();
            $response = $associadoService->editarAssociado($user->id, $request);
            if($response->getStatus() === 400)
                return back()->withErrors($response->getErrors())
                    ->withInput();

            if($response->getStatus() === 200){
                session()->flash('success', 'Dados salvos com sucesso!');
            }
        }catch(\Exception $e){
            session()->flash('fail', 'Dados não podem ser alterados');
        }
        return back();
    }

    public function editarDependente($iddependente, Request $request){
        $data = [];
        $id = base64_decode($iddependente);
        $service = new DependenteService;
        $dependente = $service->getId($id);
        $data["dependente"] = $dependente;
        $data["iddependente"] = $iddependente;

        $user = \Auth::user();
        $idAssociado = 0;

        if($user->perfil == Perfil::ASSOCIADO){
            $associado = Associado::where("usuario_id", $user->id)->first();
            if($dependente->associado_id != $associado->id){
                session()->flash('fail', 'Dependente não pode ser alterado por este usuário');
                return back();
            }
        }

        return view("admin/associado/editar-dependente", $data);
    }

    public function editarDependenteSave($iddependente, Request $request){
        try{
            $user = \Auth::user();
            $idAssociado = 0;

            if($user->perfil == Perfil::ASSOCIADO){
                $associado = Associado::where("usuario_id", $user->id)->first();
                $idAssociado = $associado->id;
            }

            $idDep = base64_decode($iddependente);
            $service = new DependenteService;
            $response = $service->editarDependente($idDep, $request, $idAssociado);
            if($response->getStatus() === 400)
                return back()->withErrors($response->getErrors())
                    ->withInput();

            if($response->getStatus() === 200){
                session()->flash('success', 'Dados salvos com sucesso!');
            }
        }catch(\Exception $e){
            session()->flash('fail', 'Dados não podem ser alterados');
        }
        return back();
    }

    public function excluirDependente($iddependente, Request $request){
        try{
            $user = \Auth::user();
            $idAssociado = 0;

            if($user->perfil == Perfil::ASSOCIADO){
                $associado = Associado::where("usuario_id", $user->id)->first();
                $idAssociado = $associado->id;
            }

            $idDep = base64_decode($iddependente);
            $service = new DependenteService;
            $response = $service->excluirDependente($idDep, $idAssociado);
            if($response->getStatus() === 400)
                return back()->withErrors($response->getErrors())
                    ->withInput();

            if($response->getStatus() === 200){
                session()->flash('success', 'Dados excluído com sucesso!');
            }
        }catch(\Exception $e){
            session()->flash('fail', 'Dados não podem ser excluído');
        }
        return back();
    }
}
