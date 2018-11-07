<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Empresa;

class EmpresaController extends Controller
{
    public function ver($id)
    {
        $empresa = Empresa::find($id);
        
        return view('usuario.empresa_view', compact('empresa'));
    }
}
