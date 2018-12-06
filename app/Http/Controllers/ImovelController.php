<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Imovel;
use App\Condominio;
use App\Imobiliaria;
use App\Pagamento;
use App\ItemHistorico;
use App\Endereco;
use App\Uf;
use App\Cidade;

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
        
        $ufs = Uf::all();
        
        $cidades = Cidade::all();
        
        return view('usuario.imovel_form', compact('ufs', 'cidades', 'opcao'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nome_apelido' => 'required|min:2|max:60',
            'descricao' => 'required|min:10|max:300',
            'areaConstr' => 'required|numeric|min:0',
            'areaTotal' => 'required|numeric|min:0',
            
            'numero' => 'required|numeric|min:0',
            'logradouro' => 'required|min:3',
            'bairro_distrito' => 'required|min:3',
        ]);
        
        $dados = $request->all();
        
        if ($request->auxCondom == "on") {
            
            $this->validate($request, [
                'nomeImob' => 'required|min:2|max:60',
                'emailImob' => 'required|email',
                'telefoneImob' => 'required|min:8',
                'enderecoSiteImob' => 'required|min:5',

                'numeroImob' => 'required|numeric|min:0',
                'logradouroImob' => 'required|min:3',
                'bairro_distrito_imob' => 'required|min:3',

                'dia' => 'required|numeric|min:1|max:31',
                'numParc' => 'required|min:1'
            ]);
        }
        
        $endereco = Endereco::create([
            'numero' => $request->numero,
            'logradouro' => $request->logradouro,
            'bairro_distrito' => $request->bairro_distrito,
            'cidade_id' => $request->idCidade
        ]);
        
        $imovel = Imovel::create([
            'nome_apelido' => $request->nome_apelido,
            'descricao' => $request->descricao,
            'tipo' => $request->tipo,
            'status' => $request->status,
            'areaConstr' => $request->areaConstr,
            'areaTotal' => $request->areaTotal,
            'dataCompra' => $request->dataCompra,
            'usuario_id' => auth()->guard('usuario')->getUser()->id,
            'endereco_id' => $endereco->id
        ]);
        
        if ($request->auxCondom == "on") {
            
            $enderecoImob = Endereco::create([
                'numero' => $request->numeroImob,
                'logradouro' => $request->logradouroImob,
                'bairro_distrito' => $request->bairro_distrito_imob,
                'cidade_id' =>$request->idCidadeImob
            ]);

            $imob = Imobiliaria::create([
                'nome' => $request->nomeImob,
                'email' => $request->emailImob,
                'telefone' => $request->telefoneImob,
                'enderecoSite' => $request->enderecoSiteImob,
                'endereco_id' => $enderecoImob->id
            ]);
            
            $condominio = Condominio::create([
                'imovel_id' => $imovel->id,
                'imobiliaria_id' => $imob->id
            ]);
            
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
                    'valor_total' => 0,
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
        
        $ufs = Uf::all();
        
        $cidades = Cidade::all();
        
        if ($imovel->tipo == 'Apartamento') {
            $condominio = Condominio::where('imovel_id', $id)->get()->first();
            $imobiliaria = Imobiliaria::find($condominio->imobiliaria_id);
            $itens = ItemHistorico::where('condominio_id', $condominio->id)->get();
        } else {
            $itens = [];
        }
        
        return view('usuario.imovel_form', compact('imovel', 'imobiliaria', 'itens', 'ufs', 'cidades', 'opcao'));
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
        $this->validate($request, [
            'nome_apelido' => 'required|min:2|max:60',
            'descricao' => 'required|min:10|max:300',
            'areaConstr' => 'required|numeric|min:0',
            'areaTotal' => 'required|numeric|min:0',
            
            'numero' => 'required|numeric|min:0',
            'logradouro' => 'required|min:3',
            'bairro_distrito' => 'required|min:3',
        ]);
        
        $imovel = Imovel::find($id);
        
        $condominio = Condominio::where('imovel_id', $imovel->id)->get()->first();
        
        if ($condominio != null) {
            
            $this->validate($request, [
                'nome' => 'required|min:2|max:60',
                'email' => 'required|email',
                'telefone' => 'required|min:8',
                'endereco_site' => 'required|min:5',

                'numeroImob' => 'required|numeric|min:0',
                'logradouroImob' => 'required|min:3',
                'bairro_distritoImob' => 'required|min:3'
            ]);
        }
        
        $endereco = $imovel->endereco;
        $endereco->cidade_id = $request->idCidade;
        
        if ($condominio != null) {
            
            $imobiliaria = $condominio->imobiliaria;

            $imobiliaria->nome = $request->nomeImob;
            $imobiliaria->email = $request->emailImob;
            $imobiliaria->telefone = $request->telefoneImob;
            $imobiliaria->enderecoSite = $request->enderecoSiteImob;
            
            $enderecoImob = $imobiliaria->endereco;
            
            $enderecoImob->numero = $request->numeroImob;
            $enderecoImob->logradouro = $request->logradouroImob;
            $enderecoImob->bairro_distrito = $request->bairro_distrito_imob;
            $enderecoImob->cidade_id = $request->idCidadeImob;
            
            $imobiliaria->update();
            $enderecoImob->update();
        }
        
        $dados = $request->all();
        
        if ($imovel->update($dados) && $endereco->update($dados)) {
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
        
        $endereco = $imovel->endereco;
        
        $condominio = Condominio::where('imovel_id', $imovel->id)->get()->first();
        
        if ($condominio != null) {
            
            $imobiliaria = $condominio->imobiliaria;
            
            $enderecoImob = $imobiliaria->endereco;
            
            $condominio->delete();
            $imobiliaria->delete();
            $enderecoImob->delete();
        }
        
        if ($imovel->delete() && $endereco->delete()) {
            return redirect('/usuario');
        }
        return redirect('/usuario');
    }
    
    public function grafValorLocacoes()
    {
        $idUsuario = auth()->guard('usuario')->getUser()->id;
        
        $imoveis = DB::table('imovel')
            ->join('locacao', 'locacao.imovel_id', '=', 'imovel.id')
            ->where('imovel.usuario_id', '=', $idUsuario)
            ->select('imovel.nome_apelido as nomeImovel', 'locacao.valor as valorLocacao')
            ->orderBy('locacao.valor')
            ->get();
        return view('usuario.valor_locacoes_graf', compact('imoveis'));
    }
    
    public function grafDespesas()
    {
        $idUsuario = auth()->guard('usuario')->getUser()->id;
        
        $imoveis = DB::table('imovel')
            ->join('despesa', 'despesa.imovel_id', '=', 'imovel.id')
            ->where('imovel.usuario_id', '=', $idUsuario)
            ->select('imovel.id', 'imovel.nome_apelido as nomeImovel', DB::raw('SUM(despesa.valor) as somaDespesas'))
            ->groupBy('imovel.id', 'imovel.nome_apelido')
            ->orderBy('somaDespesas')
            ->get();
        return view('usuario.despesas_graf', compact('imoveis'));
    }
    
    public function grafImoveisUfToAdmin()
    {
        $ufs = DB::table('imovel')
            ->join('endereco', 'imovel.endereco_id', '=', 'endereco.id')
            ->join('cidade', 'endereco.cidade_id', '=', 'cidade.id')
            ->join('uf', 'cidade.idUf', '=', 'uf.id')
            ->select('uf.id', 'uf.nome as nomeUf', DB::raw('COUNT(*) as totalImoveis'))
            ->groupBy('uf.id', 'uf.nome')
            ->orderBy('totalImoveis')
            ->get();
        return view('administrador.imoveis_uf_graf', compact('ufs'));
    }
}
