<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    protected $table = 'endereco';
    
    protected $fillable = ['numero', 'logradouro', 'bairro_distrito'];
    
    public $timestamps = false;
}
