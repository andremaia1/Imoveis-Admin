<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Uf extends Model
{
    Protected $table = 'uf';
    
    protected $fillable = ['nome', 'sigla'];
    
    public $timestamps = false;
}
