<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Locacao;
use App\Locatario;
use App\Imovel;
use App\Pagamento;

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
        
        //Cria o novo locatário
        $locatario = Locatario::create([
            'nome' => $request->nome,
            'email' => $request->email,
            'telefone' => $request->telefone,
            'cpf' => $request->cpf,
            'rg' => $request->rg
        ]);
        
        //Cria a nova locação
        $locacao = Locacao::create([
            'valor' => $request->valor,
            'inicioContrato' => $request->dataInicio,
            'terminoContrato' => $request->dataTermino,
            'imovel_id' => $imovel->id,
            'locatario_id' => $locatario->id
        ]);
        
        $imovel->status = 'Alugado';
        
        //As linhas abaixo fazem o cálculo das datas para a geração dos pagamentos (parcelas)
        $anoInicio = explode('-', $request->dataInicio)[0];
        $mesInicio = explode('-', $request->dataInicio)[1];
        
        $anoTermino = explode('-', $request->dataTermino)[0];        
        $mesTermino = explode('-', $request->dataTermino)[1];
        
        $quantMeses = (($anoTermino - $anoInicio) * 12) + ($mesTermino - $mesInicio) + 1;
        
        $ano = $anoInicio;
        $mes = $mesInicio;
        
        if (explode('-', $request->dataInicio)[2] > $request->dia) {
            $mes++;
            $quantMeses--;
        }
        
        //Gera os pagamentos de acordo com as datas
        for ($i = 0; $i < $quantMeses; $i++) {
            
            $pagamento = Pagamento::create([
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
        
        return view('usuario.locacao_form', compact('locacao', 'locatario', 'opcao'));
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
        
        $locacao->valor = $request->valor;
        
        if ($request->dataInicio !== null) {
            $locacao->inicioContrato = $request->dataInicio;
        }
        if ($request->dataTermino !== null) {
            $locacao->terminoContrato = $request->dataTermino;
        }
        
        $locatario->nome = $request->nome;
        $locatario->email = $request->email;
        $locatario->telefone = $request->telefone;
        $locatario->cpf = $request->cpf;
        $locatario->rg = $request->rg;
        
        if ($locacao->update() && $locatario->update()) {
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
        
        $locatario = Locatario::join('locacao', 'locatario.id', 'locacao.locatario_id')
                ->where('locacao.id', $id)
                ->select('locatario.*')->get()->first();
        
        $locacao->imovel->status = 'Desocupado';
        
        if ($locacao->imovel->update() && $locacao->delete() && $locatario->delete()) {
            return redirect('/locacoes');
        }
        return redirect('/locacoes');
    }
}
