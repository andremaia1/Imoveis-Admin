<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Despesa;
use App\Imovel;

class DespesaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $idUsuario = auth()->guard('usuario')->getUser()->id;
        
        $despesas = Despesa::join('imovel', 'imovel_id', 'imovel.id')
                ->where('imovel.usuario_id', $idUsuario)
                ->select('despesa.*')->get();
        
        return view('usuario.despesas_list', compact('despesas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $opcao = 1;
        
        $idUsuario = auth()->guard('usuario')->getUser()->id;
        
        $imoveis = Imovel::where('usuario_id', $idUsuario)->get();
        
        return view('usuario.despesa_form', compact('opcao', 'imoveis'));
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
        
        $imovel = Imovel::where('nome_apelido', $request->imovel)
                ->where('usuario_id', $idUsuario)->get()->first();
        
        $novo = Despesa::create([
            'descricao' => $request->descricao,
            'valor' => $request->valor,
            'imovel_id' => $imovel->id
        ]);
        
        if ($novo) {
            return redirect('/despesas');
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $opcao = 2;
        
        $despesa = Despesa::find($id);
        
        return view('usuario.despesa_form', compact('despesa', 'opcao'));
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
        $despesa = Despesa::find($id);
        
        $dados = $request->all();
        
        if ($despesa->update($dados)) {
            return redirect('/despesas');
        }
        return redirect('/despesas');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $despesa = Despesa::find($id);
        
        if ($despesa->delete()) {
            return redirect('/despesas');
        }
        return redirect('/despesas');
    }
}
