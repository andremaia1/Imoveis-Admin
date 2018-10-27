<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Locacao;
use App\Locatario;
use App\Imovel;
use App\Pagamento;
use App\ItemHistorico;
use App\Fiador;

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
        
        //Busca as locações do usuário atual
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
        
        //Busca os imóveis que não estão alugados
        $imoveis = Imovel::whereNotIn('imovel.id', function($q) {
            $q->join('locacao', 'imovel.id', 'locacao.imovel_id')
                ->select('imovel.id')
                ->from('imovel');})->where('imovel.usuario_id', $idUsuario)->get();
        
        return view('usuario.locacao_form', compact('opcao', 'imoveis'));
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
        
        //Cria o fiador do locatário
        $fiador = Fiador::create([
            'nome' => $request->nomeF,
            'email' => $request->emailF,
            'telefone' => $request->telefoneF,
            'cpf' => $request->cpfF,
            'rg' => $request->rgF
        ]);
        
        //Cria o novo locatário
        $locatario = Locatario::create([
            'nome' => $request->nome,
            'email' => $request->email,
            'telefone' => $request->telefone,
            'cpf' => $request->cpf,
            'rg' => $request->rg,
            'fiador_id' => $fiador->id
        ]);
        
        //Cria a nova locação
        $locacao = Locacao::create([
            'valor' => $request->valor,
            'inicioContrato' => $request->dataInicio,
            'prazoMinContrato' => $request->prazoMinContrato,
            'imovel_id' => $imovel->id,
            'locatario_id' => $locatario->id
        ]);
        
        $imovel->status = 'Alugado';
        
        $dados = $request->all();
        
        foreach ($dados as $n => $c) {
            if (strpos($n, 'item') !== false) {
                $item = ItemHistorico::create([
                    'nome_item' => $c,
                    'locacao_id' => $locacao->id
                ]);
            }
        }
        
        $ano = explode('-', $request->dataInicio)[0];
        $mes = explode('-', $request->dataInicio)[1];
        
        $quantMeses = $request->numParc;
        
        if (explode('-', $request->dataInicio)[2] > $request->dia) {
            $mes++;
        }
        
        for ($i = 0; $i < $quantMeses; $i++) {
            
            $pagamento = Pagamento::create([
                'valor_total' => $locacao->valor,
                'dataVencimento' => $ano . '-' . $mes . '-' . $request->dia,
                'dataPagamento' => null,
                'status' => 'A Pagar',
                'locacao_id' => $locacao->id
            ]);
            
            $mes++;
            
            if ($mes > 12) {
                $mes = 1;
                $ano++;
            }
        }
        
        if ($locatario && $locacao && $imovel->update()) {
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
        $locacao = Locacao::find($id);
        
        return view('usuario.locacao_view', compact('locacao'));
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
        
        $locatario = Locatario::find($locacao->locatario_id);
        
        $fiador = Fiador::find($locatario->fiador_id);
        
        $itens = ItemHistorico::where('locacao_id', $locacao->id)->get();
        
        return view('usuario.locacao_form', compact('locacao', 'locatario', 'fiador', 'itens', 'opcao'));
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
        
        $locatario = Locatario::find($locacao->locatario_id);
        
        $fiador = Fiador::find($locatario->fiador_id);
        
        $locacao->valor = $request->valor;
        
        if ($request->isRenov) {
            $locacao->ultimaRenovacao = date('Y-m-d');
        }
        
        $locatario->nome = $request->nome;
        $locatario->email = $request->email;
        $locatario->telefone = $request->telefone;
        $locatario->cpf = $request->cpf;
        $locatario->rg = $request->rg;
        
        $fiador->nome = $request->nomeF;
        $fiador->email = $request->emailF;
        $fiador->telefone = $request->telefoneF;
        $fiador->cpf = $request->cpfF;
        $fiador->rg = $request->rgF;
        
        $itens = ItemHistorico::where('locacao_id', $locacao->id)->get();
        
        $numItens = count($itens);
        
        $contItens = 0;
        
        $dados = $request->all();
        
        foreach ($dados as $n => $c) {
            if (strpos($n, 'item') !== false) {
                if ($contItens < $numItens) {
                    $item_id = explode('_', $n)[1];
                    $item = ItemHistorico::find($item_id);
                    $item->nome_item = $c;
                    $item->update();
                } else {
                    $item = ItemHistorico::create([
                        'nome_item' => $c,
                        'locacao_id' => $locacao->id
                    ]);
                }
                $contItens++;
            }
        }
        
        if ($locacao->update() && $locatario->update() && $fiador->update()) {
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
        
        $locatario = Locatario::find($locacao->locatario_id);
        
        $fiador = Fiador::find($locatario->fiador_id);
        
        $locacao->imovel->status = 'Desocupado';
        
        if ($locacao->imovel->update() && $locacao->delete() && $locatario->delete() && $fiador->delete()) {
            return redirect('/locacoes');
        }
        return redirect('/locacoes');
    }
}
