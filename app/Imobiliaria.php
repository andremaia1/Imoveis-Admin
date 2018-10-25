<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Imobiliaria extends Model
{
    protected $table = 'imobiliaria';
    
    protected $fillable = ['nome', 'email', 'telefone', 'enderecoSite'];
    
    public $timestamps = false;
}
