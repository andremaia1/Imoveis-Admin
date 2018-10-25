<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Condominio extends Model
{
    protected $table = 'condominio';
    
    protected $fillable = ['imovel_id', 'imobiliaria_id'];
    
    public $timestamps = false;
    
    public function imovel()
    {
        return $this->belongsTo('App\Imovel', 'imovel_id');
    }
    
    public function imobiliaria()
    {
        return $this->belongsTo('App\Imobiliaria', 'imobiliaria_id');
    }
}
