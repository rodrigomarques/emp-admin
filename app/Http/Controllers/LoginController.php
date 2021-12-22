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
use Illuminate\Support\Str;

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

                if($user->isRoleAdmin()){
                    return redirect()->route('admin.home');
                }else{
                    return redirect()->route('admin.meus-dados');
                }
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

    public function alterarSenha($token, Request $request){
        $email = $request->query("email");

        $service = new UsuarioService();
        $valid = $service->validateToken($token, $email);

        if(!$valid){
            $request->session()->flash('error', "Token / E-mail inválido!");
            \Log::error("Token inválido to reset password", [ $token, $email ]);
            return redirect()->route('login');
        }

        $tokenRequest = Str::random(30);
        $request->session()->put('tokenInput', $tokenRequest);

        $data["token"] = $token;
        $data["email"] = $email;
        $data["validate"] = $tokenRequest;
        return view("alterar_senha", $data);
    }

    public function confirmAlterarSenha($token, Request $request){
        $email = $request->input("email");
        $tokenValidate = $request->input("validate");
        $senha = $request->input("senha");

        $tokenInput = $request->session()->get('tokenInput', '');
        $request->session()->forget('tokenInput');

        if($tokenInput != $tokenValidate){
            $request->session()->flash('error', "Token inválido!");
            \Log::error("Token inválido input", [$tokenInput, $tokenValidate]);
            return redirect()->route('login');
        }

        $service = new UsuarioService();
        $valid = $service->validateToken($token, $email);

        if (!$valid) {
            $request->session()->flash('error', "Token / E-mail inválido!");
            \Log::error("Token inválido to reset password", [$token, $email]);
            return redirect()->route('login');
        }

        $usuario = Usuario::where('email', $email)->first();
        $usuario->password = $senha;
        if(!$usuario->validate()){
            return redirect()->route('alterar-senha', ['token' => $token, 'email' => $email])->withErrors($usuario->errors());
        }
        $usuario->password = Hash::make($senha);
        $usuario->save();

        $request->session()->flash('success', "Senha alterada com sucesso!");
        return redirect()->route('login');
    }
}
