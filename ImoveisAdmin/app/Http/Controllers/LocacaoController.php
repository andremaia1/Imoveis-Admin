<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Locacao;
use App\Imovel;

class LocacaoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $idUsuario = auth()->guard('usuario')->getUser()->id;
        
        $locacoes = Locacao::join('imovel', 'imovel_id', 'imovel.id')
                ->where('imovel.usuario_id', $idUsuario)
                ->select('locacao.*')->get();
        
        return view('usuario.locacoes_list', compact('locacoes'));
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
        
        $imoveis = Imovel::whereNotIn('imovel.id', function($q) {
            $q->join('locacao', 'imovel.id', 'locacao.imovel_id')
                ->select('imovel.id')
                ->from('imovel');})->where('imovel.usuario_id', $idUsuario)->get();
        
        return view('usuario.locacao_form', compact('imoveis', 'opcao'));
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
        
        $novo = Locacao::create([
            'valor' => $request->valor,
            'inicioContrato' => $request->dataInicio,
            'terminoContrato' => $request->dataTermino,
            'imovel_id' => $imovel->id
        ]);
        
        $imovel->status = 'Alugado';
        
        if ($novo && $imovel->update()) {
            return redirect('/locacoes');
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
        
        $locacao = Locacao::find($id);
        
        return view('usuario.locacao_form', compact('locacao', 'opcao'));
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
        $locacao = Locacao::find($id);
        
        $locacao->valor = $request->valor;
        
        if ($request->dataInicio !== null) {
            $locacao->inicioContrato = $request->dataInicio;
        }
        if ($request->dataTermino !== null) {
            $locacao->terminoContrato = $request->dataTermino;
        }
        
        if ($locacao->update()) {
            return redirect('/locacoes');
        }
        return redirect('/locacoes');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $locacao = Locacao::find($id);
        
        if ($locacao->delete()) {
            return redirect('/locacoes');
        }
        return redirect('/locacoes');
    }
}
