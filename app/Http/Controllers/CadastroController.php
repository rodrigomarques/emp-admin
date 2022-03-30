<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Dto\ParamDataTable;
use App\Services\CadastroService;

class CadastroController extends Controller
{
    public function planos(Request $request){
        $data = [];

        return view("admin/cadastro/planos", $data);
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
