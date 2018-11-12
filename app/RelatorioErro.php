<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RelatorioErro extends Model
{
    protected $table = 'relatorio_erro';
    
    protected $fillable = ['descricao', 'status', 'usuario_id'];
    
    public $timestamps = false;
    
    public function usuario()
    {
        return $this->belongsTo('App\Usuario', 'usuario_id');
    }
}
