<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubCategoria;
use App\Models\Usuario;
use App\Models\Endereco;
use App\Models\Associado;
use App\Util\Html;
use App\Util\Format;
use App\Models\Status;
use App\Dto\ParamDataTable;
use App\Services\AssociadoService;
use App\Services\DependenteService;
class AssociadoController extends Controller
{
    public function passo1(){
        $data = [];
        $data["listSubCategoria"] = SubCategoria::all();
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
                    Html::linkDataTable($associado["idassociado"], "fa fa-pencil", 'btn-edit'),
                    Html::linkDataTable($associado["idassociado"], "fa fa-trash", 'btn-del')
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
                    Html::linkDataTable($associado["idassociado"], "fa fa-check", 'btn-aprovar'),
                    Html::status($associado["statusassoc"]),
                    $associado["categoria"],
                    $associado["nome"],
                    $associado["email"],
                    $associado["telefone_cel"],
                    $associado["cpf"],
                    Format::fnDateView($associado["created_at"], true),
                    Html::linkDataTable($associado["idassociado"], "fa fa-pencil", 'btn-edit'),
                    Html::linkDataTable($associado["idassociado"], "fa fa-trash", 'btn-del')
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
            $associadoGrid = array_map(function($dependente){
                $dataLista = [
                    Html::status($dependente["statusassoc"]),
                    Html::linkDataTable($dependente["idassociado"], '', '', $dependente["nomeusu"]),
                    $dependente["nome"],
                    $dependente["email"],
                    Format::fnDateView($dependente["dt_nascimento"]),
                    $dependente["cpf"],
                    $dependente["parentesco"],
                    Format::fnDateView($dependente["created_at"], true),
                    Html::linkDataTable($dependente["idassociado"], "fa fa-pencil", 'btn-edit'),
                    Html::linkDataTable($dependente["idassociado"], "fa fa-trash", 'btn-del')
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
}
