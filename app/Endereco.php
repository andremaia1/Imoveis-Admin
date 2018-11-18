<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    protected $table = 'endereco';
    
    protected $fillable = ['numero', 'logradouro', 'bairro_distrito', 'cidade_id'];
    
    public $timestamps = false;
    
    public function cidade()
    {
        return $this->belongsTo('App\Cidade', 'cidade_id');
    }
}
