<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Locatario extends Model
{
    protected $table = 'locatario';
    
    protected $fillable = ['nome', 'email', 'telefone', 'cpf', 'rg', 'fiador_id'];
    
    public $timestamps = false;
    
    public function fiador()
    {
        return $this->belongsTo('App\Fiador', 'fiador_id');
    }
}
