<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Imovel extends Model
{
    protected $table = 'imovel';
    
    protected $fillable = ['nome_apelido', 'descricao', 'tipo', 'status', 'areaConstr', 'areaTotal', 'usuario_id'];

    public function usuario()
    {
        return $this->belongsTo('App\Usuario', 'usuario_id');
    }
    
    public function getTipoAttribute($value)
    {
        if ($value === 1) {
            return 'Apartamento';
        } else if ($value === 2) {
            return 'Casa';
        } else if ($value === 3) {
            return 'Terreno';
        } else if ($value === 4) {
            return 'Chácara';
        } else if ($value === 5) {
            return 'Sítio';
        } else if ($value === 6) {
            return 'Fazenda';
        } else if ($value === 7) {
            return 'Imóvel Comercial';
        }
    }
    
    public function getStatusAttribute($value)
    {
        if ($value === 1) {
            return 'Alugado';
        } else if ($value === 2) {
            return 'Por alugar';
        } else if ($value === 3) {
            return 'Desocupado';
        }
    }
}
