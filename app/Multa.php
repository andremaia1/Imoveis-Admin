<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Multa extends Model
{
    protected $table = 'multa';
    
    protected $fillable = ['valor', 'status', 'dataPagamento', 'locacao_id', 'pagamento_id'];
    
    public $timestamps = false;
    
    public function getStatusAttribute($value)
    {
        if ($value === 1) {
            return 'A Pagar';
        } else {
            return 'Pago';
        }
    }
}
