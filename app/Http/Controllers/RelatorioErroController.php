<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RelatorioErro;

class RelatorioErroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $relatorios = RelatorioErro::all();
        
        return view('administrador.relatorios_erros_list', compact('relatorios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('usuario.relatorio_erro_form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $idUsuario = auth()->guard('usuario')->getUser()->id;
        
        $relatErro = RelatorioErro::create([
            'descricao' => $request->descricao,
            'status' => 1,
            'usuario_id' => $idUsuario
        ]);
        
        if ($relatErro) {
            return redirect('/usuario');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $relatorio = RelatorioErro::find($id);
        
        return view('administrador.relatorio_erro_view', compact('relatorio'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $relatorio = RelatorioErro::find($id);
        
        if ($relatorio->delete()) {
            return redirect('/relatErros');
        }
    }
    
    public function alterarStatus($id)
    {
        $relatorio = RelatorioErro::find($id);
        
        $relatorio->status = ($relatorio->status === 1) ? 2 : 1;
        
        if ($relatorio->update()) {
            return redirect('/relatErros');
        }
    }
}
