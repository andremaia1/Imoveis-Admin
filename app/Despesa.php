<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Despesa extends Model
{
    protected $table = 'despesa';
    
    protected $fillable = ['descricao', 'valor', 'imovel_id'];
    
    public $timestamps = false;
    
    public function imovel()
    {
        return $this->belongsTo('App\Imovel', 'imovel_id');
    }
}
