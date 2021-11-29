<?php

namespace App\Models;

class PasswordReset extends RModel
{
    protected $table = "password_resets";
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = ['email','token','status','token_validate','created_at'];

    protected $rules = [

    ];

    protected $messages = [

    ];
}
