<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Locacao extends Model
{
    protected $table = 'locacao';
    
    protected $fillable = ['valor', 'inicioContrato', 'ultimaRenovacao', 'prazoMinContrato', 'imovel_id', 'locatario_id', 'empresa_id'];
    
    public $timestamps = false;
    
    public function imovel()
    {
        return $this->belongsTo('App\Imovel', 'imovel_id');
    }
    
    public function locatario()
    {
        return $this->belongsTo('App\Locatario', 'locatario_id');
    }
    
    public function empresa()
    {
        return $this->belongsTo('App\Empresa', 'empresa_id');
    }
}
