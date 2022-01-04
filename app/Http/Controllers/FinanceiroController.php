<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FinanceiroController extends Controller
{
    public function index(Request $request){
        $data = [];

        return view("admin/financeiro/index", $data);
    }

    public function meusPagamentos(Request $request){
        $data = [];

        return view("admin/financeiro/meus-pagamentos", $data);
    }
}
