<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    use Notifiable;
    
    protected $table = 'usuario';
    
    protected $fillable = ['nome', 'email', 'password', 'telefone', 'ativo'];
    
    public $timestamps = false;
}
