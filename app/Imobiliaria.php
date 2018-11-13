<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Imobiliaria extends Model
{
    protected $table = 'imobiliaria';
    
    protected $fillable = ['nome', 'email', 'telefone', 'enderecoSite', 'endereco_id'];
    
    public $timestamps = false;
    
    public function endereco()
    {
        return $this->belongsTo('App\Endereco', 'endereco_id');
    }
}
