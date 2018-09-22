<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ValorItem extends Model
{
    protected $table = 'valor_item';
    
    public $fillable = ['valor', 'pagamento_id', 'item_historico_id'];
    
    public $timestamps = false;
}
