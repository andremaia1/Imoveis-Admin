<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Locatario;

class LocatarioController extends Controller
{
    //Exibe um locatário através do Id
    public function show($id)
    {
        $locatario = Locatario::find($id);
        
        return view('usuario.locatario_view', compact('locatario'));
    }
}
