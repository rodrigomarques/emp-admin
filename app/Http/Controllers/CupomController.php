<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubCategoria;
use App\Models\Cupom;
use App\Services\CupomService;
use App\Dto\ParamDataTable;
use App\Util\Format;
use App\Util\Html;
class CupomController extends Controller
{
    public function index(Request $request){
        $data = [];
        $data["subcategoria"] = SubCategoria::all();

        return view("admin/cupom/index", $data);
    }

    public function save(Request $request){
        $cupom = new Cupom($request->all());
        $cupomService = new CupomService();
        try{
            $response = $cupomService->salvar($cupom);
            if($response->getStatus() === 400)
                return back()->withErrors($response->getErrors());

            if($response->getStatus() === 200)
                session()->flash('success', 'Cupom salvo com sucesso!');

        }catch(\Exception $e){

            session()->flash('error', "Não pode salvar o cupom");
        }

        //return redirect()->route('admin.cupom.index');
        return back();
    }

    public function buscar(Request $request){
        $data = [];
        return view("admin/cupom/buscar", $data);
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

        $cupomService = new CupomService();
        $dataLista = $cupomService->buscar($paramDataTable);

        $data = [];
        if(count($dataLista["data"]) > 0){
            $cupomGrid = array_map(function($cupom) use($cupomService){
                $dataLista = [
                    $cupom["titulo"],
                    $cupom["codigo"],
                    Format::fnDateView($cupom["dt_inicio"]),
                    Format::fnDateView($cupom["dt_termino"]),
                    Format::fn($cupom["valor"]),
                    $cupomService->getCategoria($cupom["categorias"], "<br>"),
                    Html::status($cupom["status"])
                ];
                return $dataLista;
            }, $dataLista["data"]->toArray());
            $data = $cupomGrid;
        }

        return response()->json([
            "draw" => $draw,
            "recordsTotal" => $dataLista["count"],
            "recordsFiltered"=>  $dataLista["count"],
            "data" => $data
        ]);
    }
}
