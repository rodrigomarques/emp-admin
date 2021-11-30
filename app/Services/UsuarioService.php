<?php

namespace App\Services;
use App\Responses\ResponseEntity;
use App\Models\Usuario;
use App\Models\Status;
use App\Repositories\CupomRepository;
use App\Models\PasswordReset;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UsuarioService
{
    public function esqueceuSenha(Usuario $usuario): ResponseEntity{
        date_default_timezone_set('America/Sao_Paulo');
        $response = new ResponseEntity();
        try{
            $dbUser = Usuario::where("email", $usuario->email)
                            ->where("status", Status::ATIVO)
                            ->first();

            if(!$dbUser){
                $response->setStatus(404);
                $response->addError("Usuário não encontrado!");
                return $response;
            }

            $token = Str::random(64);
            \DB::beginTransaction();

            \DB::update("update password_resets SET status = ? WHERE email = ? AND status = ?", [ Status::INATIVO, $usuario->email, Status::ATIVO]);
            $hoje = \Carbon\Carbon::now();
            $validate = \Carbon\Carbon::now();

            $validate = $validate->addHours(2);

            $reset = new PasswordReset([
                'email' => $usuario->email,
                'token' => $token,
                'status' => Status::ATIVO,
                'token_validate' => $validate->format("Y-m-d H:i:s"),
                'created_at' => $hoje->format("Y-m-d H:i:s")
            ]);
            $reset->save();
            $link = env('APP_URL') . '/alterar-senha/' . $token . '?email=' . urlencode($usuario->email);

            Mail::send('forgot_password', ['validade' => $validate->format("Y-m-d H:i:s"), 'link' => $link], function ($message) use($usuario) {
                $message->to($usuario->email);
                $message->subject('Recuperação de senha');
            });

            \DB::commit();
            $response->setStatus(200);
        }catch(\Exception $e){
            \DB::rollback();
            $response->setStatus(500);
            \Log::error("Erro recuperar senha", [ $e->getMessage()]);
            throw new \Exception("Não pode recuperar a senha");
        }

        return $response;
    }

    public function validateToken($token, $email): bool{
        date_default_timezone_set('America/Sao_Paulo');
        try{
            $hoje = \Carbon\Carbon::now();

            $passReset = PasswordReset::where("email", $email)
                            ->where("status", Status::ATIVO)
                            ->where("token", $token)
                            ->where("token_validate", ">=", $hoje->format("Y-m-d H:i:s"))
                            ->first();
            if(!$passReset)
                return false;
            return true;
        }catch(\Exception $e){
            return false;
        }
    }
}
