<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pagamento extends Model
{
    protected $table = 'pagamento';
    
    protected $fillable = ['valor_total', 'dataVencimento', 'dataPagamento', 'status', 'locacao_id', 'condominio_id'];
    
    public $timestamps = false;
    
    public function locacao()
    {
        return $this->belongsTo('App\Locacao', 'locacao_id');
    }
    
    public function condominio()
    {
        return $this->belongsTo('App\Condominio', 'condominio_id');
    }
    
    public function getStatusAttribute($value)
    {
        if ($value === 1) {
            return 'A Pagar';
        } else if ($value === 2) {
            return 'Pago';
        } else if ($value === 3) {
            return 'Atrasado';
        } else if ($value === 4) {
            return 'Pago (Com Atraso)';
        }
    }
    
    public function setStatusAttribute($value)
    {
        if ($value === 'A Pagar') {
            $this->attributes['status'] = 1;
        } else if ($value === 'Pago') {
            $this->attributes['status'] = 2;
        } else if ($value === 'Atrasado') {
            $this->attributes['status'] = 3;
        } else if ('Pago (Com Atraso)') {
            $this->attributes['status'] = 4;
        }
    }
}
