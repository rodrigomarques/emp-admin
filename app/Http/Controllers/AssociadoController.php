<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AssociadoController extends Controller
{
    public function passo1(){
        $data = [];

        return view("associado/passo1", $data);
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
