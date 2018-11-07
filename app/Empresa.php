<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $table = 'empresa';
    
    protected $fillable = ['nome', 'email', 'telefone', 'enderecoSite', 'cnpj'];
    
    public $timestamps = false;
}
