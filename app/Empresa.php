<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $table = 'empresa';
    
    protected $fillable = ['nome_fantasia', 'email', 'telefone', 'enderecoSite', 'cnpj', 'locacao_id'];
    
    public $timestamps = false;
}
