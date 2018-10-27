<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imobiliaria;

class ImobiliariaController extends Controller
{
    public function ver($id)
    {
        $imobiliaria = Imobiliaria::find($id);
        
        return view('usuario.imobiliaria_view', compact('imobiliaria'));
    }
}
