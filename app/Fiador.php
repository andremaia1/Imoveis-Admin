<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fiador extends Model
{
    protected $table = 'fiador';
    
    protected $fillable = ['nome', 'email', 'telefone', 'cpf', 'rg'];
    
    public $timestamps = false;
}
