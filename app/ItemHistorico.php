<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemHistorico extends Model
{
    protected $table = 'item_historico';
    
    public $fillable = ['nome_item', 'locacao_id', 'condominio_id'];
    
    public $timestamps = false;
}
