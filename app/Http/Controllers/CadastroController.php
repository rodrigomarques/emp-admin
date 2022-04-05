<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Dto\ParamDataTable;
use App\Services\CadastroService;
use App\Models\Planos;
use App\Util\Format;
use App\Util\Html;
class CadastroController extends Controller
{
    public function planos(Request $request){
        $data = [];
        $data["plano"] = new Planos();
        return view("admin/cadastro/planos", $data);
    }

    public function savePlanos(Request $request){
        $id = $request->input("idplano", "");
        if($id != ""){
            $plano = Planos::find($id);
            if(!$plano){
                session()->flash('error', "Plano não encontrado");
                return back();
            }

            $plano->fill($request->all());
        }else{
            $plano = new Planos($request->all());
        }

        $cadastroService = new CadastroService();
        try{
            $response = $cadastroService->salvarPlano($plano);
            if($response->getStatus() === 400)
                return back()->withErrors($response->getErrors());

            if($response->getStatus() === 200)
                session()->flash('success', 'Plano salvo com sucesso!');

        }catch(\Exception $e){
            session()->flash('error', "Não pode salvar o plano");
        }

        return back();
    }

    public function editarPlano($idplano, Request $request){
        $data = [];
        $id = base64_decode($idplano);

        $data["plano"] = Planos::find($id);
        $data["idassociado"] = $id;

        return view("admin/cadastro/planos", $data);
    }

    public function excluirPlano($idPlano, Request $request){
        try{
            $user = \Auth::user();
            $service = new CadastroService;
            $response = $service->excluirPlano($idPlano);
            if($response->getStatus() === 400)
                return back()->withErrors($response->getErrors())
                    ->withInput();

            if($response->getStatus() === 200){
                session()->flash('success', 'Plano excluído com sucesso!');
            }
        }catch(\Exception $e){
            session()->flash('fail', 'Plano não podem ser excluído');
        }
        return back();
    }

    public function ajaxBuscar(Request $request){
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

        if (count($order) > 0) {
            $itemOrdem = $order[0];
            $orderField = $itemOrdem["column"];
            $orderDirection = $itemOrdem["dir"];
        }

        $paramDataTable = ParamDataTable::init($draw, $begin, $end, $orderField, $orderDirection);
        $paramDataTable->setSearch($search);

        $cadastroService = new CadastroService();
        $dataLista = $cadastroService->buscarPlanos($paramDataTable);

        $data = [];
        if(count($dataLista["data"]) > 0){
            $planoGrid = array_map(function($plano) {
                $dataLista = [
                    $plano["plano"],
                    Format::fn($plano["valor"]),
                    Format::fn($plano["joia"]),
                    Html::linkDataTable(base64_encode($plano["id"]), "fa fa-pencil", 'btn-edit', '', 'editarPlano'),
                    Html::linkDataTable($plano["id"], "fa fa-trash", 'btn-del', '', 'deletarPlano')
                ];
                return $dataLista;
            }, $dataLista["data"]->toArray());
            $data = $planoGrid;
        }

        return response()->json([
            "draw" => $draw,
            "recordsTotal" => $dataLista["count"],
            "recordsFiltered"=>  $dataLista["count"],
            "data" => $data
        ]);
    }
}
