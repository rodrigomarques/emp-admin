<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Associado;
use App\Models\Dependente;
use App\Models\Status;
use App\Models\SubCategoria;
use Log;
use Auth;
use App\Services\AssociadoService;
class AdminController extends Controller
{
    public function home(){
        $data = [];
        try{
            $associados = Associado::get();
            $dependente = Dependente::all();

            $data["total"] = $associados->count();
            $data["totalDependente"] = $dependente->count();

            $data["totalAtivos"] = array_filter($associados->toArray(), function($associado){
                return in_array($associado["status"], [Status::ATIVO]);
            });
            $data["totalInativos"] = array_filter($associados->toArray(), function($associado){
                return in_array($associado["status"], [Status::INATIVO]);
            });
        }catch(\Exception $e){
            Log::error("Erro relatório admin", [$e->getMessage()]);
        }

        return view("admin/home", $data);
    }

    public function meusDados(){
        $data = [];
        $associadoService = new AssociadoService();
        $user = Auth::user();
        $data["listSubCategoria"] = SubCategoria::all();
        $data["associado"] = $associadoService->getAssociadoByUsuario($user->id);
        return view("admin/meus-dados", $data);
    }

    public function ajaxPlanos(Request $request){
        $associadoService = new AssociadoService();
        $lista = $associadoService->getCountPlanos([ ]);
        $planosGrid = array_map(function($plano){
            return [$plano->planos, $plano->TOTAL];
        }, $lista);

        return response()->json([
            "data" => $planosGrid
        ]);
    }

    public function ajaxCategorias(Request $request){
        $associadoService = new AssociadoService();
        $lista = $associadoService->getCountCategorias([ ]);
        $categoriasGrid = array_map(function($cat){
            return [$cat->categoria, $cat->TOTAL];
        }, $lista);

        return response()->json([
            "data" => $categoriasGrid
        ]);
    }

    public function ajaxAssociadosAtivos(Request $request){
        $associadoService = new AssociadoService();
        $values = [];
        for($mes = 5; $mes >= 0; $mes--){
            $mesAtual = date('m');

            $lista = $associadoService->getCountAssociadosAtivos($mes);
            $mesExt = \App\Util\Format::getMonth(($mesAtual - $mes));
            array_push($values, [$mesExt, $lista->total, '#6d9cf3']);
        }

        return response()->json([
            "data" => $values
        ]);
    }

    public function ajaxAssociadosAtivosInativos(Request $request){
        $associadoService = new AssociadoService();
        $lista = $associadoService->getCountAssociadosAtivosInativos();

        $values = [];
        foreach($lista as $item){
            $dt = $item->data;
            $total = $item->total;
            $status = $item->status;

            if(!array_key_exists($dt, $values)){
                $values[$dt] = [$dt, 0, 0];
            }
            if($status == "ATIVO"){
                $values[$dt][1] = $total;
            }else{
                $values[$dt][2] = $total;
            }
        }

        return response()->json([
            "data" => array_values($values)
        ]);
    }
}
