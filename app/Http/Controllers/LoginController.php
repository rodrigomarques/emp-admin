<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Hash;
use App\Models\Status;
class LoginController extends Controller
{
    public function login(){
        $data = [];

        return view("login", $data);
    }

    public function logar(Request $request){
        if($request->isMethod("POST")){
            $username = $request->input("email", "");
            $password = $request->input("senha", "");

            if (Auth::attempt(['email' => $username, 'password' => $password, 'status' => Status::ATIVO])) {
                $request->session()->regenerate();
                $user = \Auth::user();
                return redirect()->route('admin.home');
            }else{
                $request->session()->flash('error', 'Login / Senha inválidos');
            }
        }
        return back();
    }

    public function sair(Request $request){
        \Auth::logout();
        $request->session()->flush();
        return redirect()->route('login');
    }
}
