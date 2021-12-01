<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubCategoria;
use App\Models\Usuario;
use App\Models\Associado;

use App\Services\AssociadoService;
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

            if($response->getStatus() === 200)
                return redirect()->route('associado.passo2');

        }catch(\Exception $e){
            session()->flash('error', "Não pode salvar o cupom");
        }
        return back()
            ->withInput();
    }

    public function passo2(){
        $data = [];

        return view("associado/passo2", $data);
    }

    public function passo3(){
        $data = [];

        return view("associado/passo3", $data);
    }

    public function passo4(){
        $data = [];

        return view("associado/passo4", $data);
    }
}
