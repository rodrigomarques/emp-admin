<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use App\Models\Usuario;
use App\Models\Status;
use App\Models\Perfil;

class InitController extends Controller
{
    public function load(){
        try{
            $usuario = new Usuario([
                'nome' => 'Administrador',
                'email' => 'admin@admin',
                'password' => Hash::make("1q2w3e4r"),
                'status' => Status::ATIVO,
                'perfil' => Perfil::ADMIN
            ]);

            $usuario->save();

            return response()->json([
                'msg' => 'user created',
            ]);
        }catch(\Exception $e){
            \Log::error("Erro to init system", [ $e->getMessage()]);
            return response()->json([
                'msg' => 'error to init system'
            ]);
        }
    }
}
