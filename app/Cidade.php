<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cidade extends Model
{
    protected $table = 'cidade';
    
    protected $fillable = ['nome', 'idUf'];
    
    public $timestamps = false;
    
    public function uf()
    {
        return $this->belongsTo('App\Uf', 'idUf');
    }
}
