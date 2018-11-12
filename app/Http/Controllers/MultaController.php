<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Multa;
use App\Locacao;
use App\Pagamento;

class MultaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $idUsuario = auth()->guard('usuario')->getUser()->id;
        
        $multas = Multa::join('locacao', 'locacao_id', 'locacao.id')
                  ->join('imovel', 'locacao.imovel_id', 'imovel.id')
                  ->where('imovel.usuario_id', $idUsuario)
                  ->select('multa.*')->get();
        
        return view('usuario.multas_list', compact('multas'));
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
        
        $locacoes = Locacao::join('imovel', 'imovel_id', 'imovel.id')
                ->where('imovel.usuario_id', $idUsuario)
                ->select('locacao.*')->get();
        
        $pagamentos = Pagamento::join('locacao', 'locacao_id', 'locacao.id')
                ->join('imovel', 'locacao.imovel_id', 'imovel.id')
                ->where('imovel.usuario_id', $idUsuario)
                ->select('pagamento.*')->get();
        
        return view('usuario.multa_form', compact('locacoes', 'pagamentos', 'opcao'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $multa = Multa::create([
            'valor' => $request->valor,
            'status' => 1,
            'dataPagamento' => null,
            'locacao_id' => $request->idLocacao,
            'pagamento_id' => $request->idPagamento
        ]);
        
        if ($multa) {
            return redirect('/multas');
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
        
        $multa = Multa::find($id);
        
        return view('usuario.multa_form', compact('multa', 'opcao'));
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
        $multa = Multa::find($id);
        
        $multa->dataPagamento = $request->dataPagto;
        
        $multa->status = ($multa->dataPagamento == null) ? 1 : 2;
        
        $multa->valor = $request->valor;
        
        if ($multa->update()) {
            return redirect('/multas');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $multa = Multa::find($id);
        
        if ($multa->delete()) {
            return redirect('/multas');
        }
    }
}
