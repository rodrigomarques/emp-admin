<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Associado;
use App\Models\Dependente;
use App\Models\Status;
use Log;
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
}
