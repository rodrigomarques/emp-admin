<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubCategoria;
class AssociadoController extends Controller
{
    public function passo1(){
        $data = [];
        $data["listSubCategoria"] = SubCategoria::all();
        return view("associado/passo1", $data);
    }

    public function passo1Save(Request $request){

        //return back()->withErrors($response->getErrors());
        return redirect()->route('associado.passo2');
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
