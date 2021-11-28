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

    ];

    protected $messages = [

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
}
