<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Hash;
use App\Models\Status;
use App\Util\Format;
use App\Models\Usuario;
use App\Services\UsuarioService;
use App\Responses\ResponseEntity;

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

    public function esqueceuSenha(Request $request){
        $data = [];

        return view("esqueceusenha", $data);
    }

    public function sendEsqueceuSenha(Request $request){
        try{
            $usuario = new Usuario($request->all());
            $service = new UsuarioService();
            $response = $service->esqueceuSenha($usuario);

            if($response->getStatus() === 200){
                $request->session()->flash('success', 'E-mail para alteração de senha enviado para ' . Format::hideEmail($usuario->email));
            }else{
                $request->session()->flash('error', implode("<br>", $response->getErrors()));
            }

        }catch(\Exception $e){
            \Log::error("Erro send esqueceu senha", [ $e->getMessage() ]);
            $request->session()->flash('error', 'Erro ao enviar o e-mail');
        }

        return back();
    }
}
