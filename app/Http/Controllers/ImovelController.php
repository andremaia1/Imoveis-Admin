<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imovel;
use App\Condominio;
use App\Imobiliaria;
use App\Pagamento;
use App\ItemHistorico;

class ImovelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $opcao = 1;
        
        return view('usuario.imovel_form', compact('opcao'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $imovel = Imovel::create([
            'nome_apelido' => $request->nome,
            'descricao' => $request->descricao,
            'tipo' => $request->tipo,
            'status' => $request->status,
            'areaConstr' => $request->areaConstr,
            'areaTotal' => $request->areaTotal,
            'dataCompra' => $request->dataCompra,
            'usuario_id' => auth()->guard('usuario')->getUser()->id
        ]);
        
        if ($request->auxCondom == "on") {
            
            $imob = Imobiliaria::create([
                'nome' => $request->nomeImob,
                'email' => $request->emailImob,
                'telefone' => $request->telefoneImob,
                'enderecoSite' => $request->enderecoSiteImob
            ]);
            
            $condominio = Condominio::create([
                'imovel_id' => $imovel->id,
                'imobiliaria_id' => $imob->id
            ]);
            
            $dados = $request->all();
            
            foreach ($dados as $n => $c) {
                if (strpos($n, 'item') !== false) {
                    $item = ItemHistorico::create([
                        'nome_item' => $c,
                        'condominio_id' => $condominio->id
                    ]);
                }
            }
            
            $ano = explode('-', $request->dataCompra)[0];
            $mes = explode('-', $request->dataCompra)[1];

            $quantMeses = $request->numParc;

            if (explode('-', $request->dataCompra)[2] > $request->dia) {
                $mes++;
            }

            for ($i = 0; $i < $quantMeses; $i++) {

                $pagamento = Pagamento::create([
                    'dataVencimento' => $ano . '-' . $mes . '-' . $request->dia,
                    'dataPagamento' => null,
                    'status' => 'A Pagar',
                    'condominio_id' => $condominio->id
                ]);

                $mes++;

                if ($mes > 12) {
                    $mes = 1;
                    $ano++;
                }
            }
        }
        
        if ($imovel) {
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
        $imovel = Imovel::find($id);
        
        return view('imovel_view', compact('imovel'));
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
        
        $imovel = Imovel::find($id);
        
        if ($imovel->tipo == 'Apartamento') {
            $condominio = Condominio::where('imovel_id', $id)->get()->first();
            $imobiliaria = Imobiliaria::find($condominio->imobiliaria_id);
            $itens = ItemHistorico::where('condominio_id', $condominio->id)->get();
        } else {
            $itens = [];
        }
        
        return view('usuario.imovel_form', compact('imovel', 'imobiliaria', 'itens', 'opcao'));
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
        $imovel = Imovel::find($id);
        
        $dados = $request->all();
        
        if ($imovel->update($dados)) {
            return redirect('/usuario');
        }
        return redirect('/usuario');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $imovel = Imovel::find($id);
        
        if ($imovel->delete()) {
            return redirect('/usuario');
        }
        return redirect('/usuario');
    }
}
