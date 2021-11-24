<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubCategoria;

class CupomController extends Controller
{
    public function index(Request $request){
        $data = [];
        $data["subcategoria"] = SubCategoria::all();

        return view("admin/cupom/index", $data);
    }

    public function save(Request $request){

        return redirect()->route('admin.cupom.index');
    }

    public function buscar(Request $request){
        $data = [];
        if($request->isMethod("POST")){

        }
        return view("admin/cupom/buscar", $data);
    }
}
