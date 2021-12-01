<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Usuario extends RModel implements Authenticatable
{
    use HasFactory;
    protected $table = "usuarios";
    public $timestamps = true;
    public $incrementing = true;
    protected $fillable = ['nome', 'email', 'password', 'status', 'perfil'];

    protected $rules = [
        'password' => 'required|min:6',
        'email' => 'required',
    ];

    protected $messages = [
        'password.required' => 'Senha é obrigatória',
        'password.min' => 'Senha deve ter ao menos 6 caracter',
        'email.required' => 'E-mail é obrigatório',
    ];

    public function getAuthIdentifier()
    {
        return $this->id;
    }

    public function getAuthIdentifierName()
    {
        return "id";
    }

    public function getAuthPassword()
    {
        return $this->password;
    }

    public function getRememberToken()
    {

    }

    public function getRememberTokenName()
    {

    }

    public function setRememberToken($value)
    {

    }

    public function isRoleAdmin(){
        return in_array($this->perfil, [Perfil::ADMIN]);
    }

    public function isRoleAssociado(){
        return in_array($this->perfil, [Perfil::ADMIN, Perfil::ASSOCIADO]);
    }

    public function isRoleOnlyAssociado(){
        return in_array($this->perfil, [Perfil::ASSOCIADO]);
    }
}
