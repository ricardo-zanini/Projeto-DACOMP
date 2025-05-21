<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use HasFactory;

    use Notifiable;

    public $timestamps = false;

    protected $primaryKey = 'usuario_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $hidden = [
        'password',
    ];

    public function getAuthIdentifierName()
    {
        return 'usuario_id';
    }

    public function getAuthIdentifier()
    {
        return $this->usuario_id;
    }

    public function getAuthPassword()
    {
        return $this->password;
    }

    public function getRememberToken()
    {
        return $this->remember_token;
    }

    public function setRememberToken($set_token)
    {
        $this->remember_token = $set_token;
    }

    public function getRememberTokenName()
    {
        return 'remember_token';
    }
}