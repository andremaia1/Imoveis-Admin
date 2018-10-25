<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Locacao;
use App\Pagamento;
use App\Condominio;
use App\ItemHistorico;
use App\ValorItem;

class PagamentoController extends Controller
{
    public function lista($id, $opcao)
    {
        $varRetorno = '';
        
        if ($opcao == 1) {
            $locacao = Locacao::find($id);
            $pagamentos = Pagamento::where('locacao_id', $id)->get();
            $varRetorno = 'locacao';
        } else {
            $condominio = Condominio::find($id);
            $pagamentos = Pagamento::where('condominio_id', $id)->get();
            $varRetorno = 'condominio';
        }
        
        $data = date('Y-m-d');
        
        foreach ($pagamentos as $pagamento) {
            if ($pagamento->dataPagamento == null && $pagamento->status == 'A Pagar' && $this->dataMaior($data, $pagamento->dataVencimento) == 1) {
                $pagamento->status = 'Atrasado';
                $pagamento->update();
            }
        }
        
        return view('usuario.pagamentos_list', compact('pagamentos', 'opcao', $varRetorno));
    }
    
    public function ver($id)
    {
        $pagamento = Pagamento::find($id);
        
        $itens = ItemHistorico::where('locacao_id', $pagamento->locacao->id)->get();
        
        $valores = ValorItem::where('pagamento_id', $id)->get();
        
        return view('usuario.pagamento_view', compact('pagamento', 'itens', 'valores'));
    }
    
    public function editar($id, $opcao)
    {
        $pagamento = Pagamento::find($id);
        
        $valores = ValorItem::where('pagamento_id', $id)->get();

        if ($opcao == 1) {
            $itens = ItemHistorico::where('locacao_id', $pagamento->locacao->id)->get();
        } else {
            $itens = ItemHistorico::where('condominio_id', $pagamento->condominio->id)->get();
        }
        
        return view('usuario.pagamento_form', compact('pagamento', 'itens', 'valores', 'opcao'));
    }
    
    public function atualizar(Request $request, $id, $opcao)
    {
        $pagamento = Pagamento::find($id);
        
        $pagamento->dataPagamento = $request->dataPagto;
        
        if ($request->dataVenc != null) {
            $pagamento->dataVencimento = $request->dataVenc;
        }
        
        if ($pagamento->dataPagamento == null) {
            $data = date('Y-m-d');
            if ($this->dataMaior($data, $pagamento->dataVencimento) == 1) {
                $pagamento->status = 'Atrasado';
            } else {
                $pagamento->status = 'A Pagar';
            }
        } else {
            if ($this->dataMaior($pagamento->dataPagamento, $pagamento->dataVencimento) == 1) {
                $pagamento->status = 'Pago (Com Atraso)';
            } else {
                $pagamento->status = 'Pago';
            }
        }
        
        $valores = ValorItem::where('pagamento_id', $id)->get();
        
        if (count($valores) === 0) {
            
            $dados = $request->all();
            
            foreach ($dados as $n => $c) {
                if (strpos($n, 'item') !== false) {
                    $valor = ValorItem::create([
                        'valor' => $c,
                        'pagamento_id' => $pagamento->id,
                        'item_historico_id' => explode('_', $n)[1]
                    ]);
                }
            }
        } else {
            
            $dados = $request->all();
            
            foreach ($dados as $n => $c) {
                if (strpos($n, 'item') !== false) {
                    $item_id = explode('_', $n)[1];
                    $valor = ValorItem::where('pagamento_id', $pagamento->id)
                            ->where('item_historico_id', $item_id)->get()->first();
                    $valor->valor = $c;
                    $valor->update();
                }
            }
        }
        
        if ($opcao == 1) {
            $pagamento->valor_total = $pagamento->locacao->valor + ValorItem::where('pagamento_id', $pagamento->id)->sum('valor');
        } else {
            $pagamento->valor_total = $pagamento->condominio->valor + ValorItem::where('pagamento_id', $pagamento->id)->sum('valor');
        }
        
        if ($pagamento->update()) {
            if ($opcao == 1) {
                return redirect('/pagamentos/'.$pagamento->locacao_id.'/'.$opcao);
            } else {
                return redirect('/pagamentos/'.$pagamento->condominio_id.'/'.$opcao);
            }
        }
    }
    
    public function gerar(Request $request, $id, $opcao)
    {
        $varFK = ($opcao == 1) ? 'locacao_id' : 'condominio_id';
        
        $pagamentos = Pagamento::where($varFK, $id)->get();
        
        $ultimo = $pagamentos->last();
        
        $ano = explode('-', $ultimo->dataVencimento)[0];
        $mes = explode('-', $ultimo->dataVencimento)[1];
        $dia = explode('-', $ultimo->dataVencimento)[2];
        
        for ($i = 0; $i < $request->numParc; $i++) {
            
            $mes++;
            
            if ($mes > 12) {
                $mes = 1;
                $ano++;
            }
            
            if ($opcao == 1) {
                $pagamento = Pagamento::create([
                    'dataVencimento' => $ano . '-' . $mes . '-' . $dia,
                    'dataPagamento' => null,
                    'status' => 'A Pagar',
                    'locacao_id' => $ultimo->locacao->id
                ]);
            } else {
                $pagamento = Pagamento::create([
                    'dataVencimento' => $ano . '-' . $mes . '-' . $dia,
                    'dataPagamento' => null,
                    'status' => 'A Pagar',
                    'condominio_id' => $ultimo->condominio->id
                ]);
            }
        }
        if ($opcao == 1) {
            return redirect('/pagamentos/'.$pagamento->locacao_id.'/'.$opcao);
        } else {
            return redirect('/pagamentos/'.$pagamento->condominio_id.'/'.$opcao);
        }
    }
    
    public function dataMaior($data1, $data2)
    {
        $ano1 = explode('-', $data1)[0];
        $mes1 = explode('-', $data1)[1];
        $dia1 = explode('-', $data1)[2];
        
        $ano2 = explode('-', $data2)[0];
        $mes2 = explode('-', $data2)[1];
        $dia2 = explode('-', $data2)[2];
        
        if ($ano1 > $ano2) {
            return 1;
        } else if ($ano2 > $ano1) {
            return 2;
        }
        
        if ($mes1 > $mes2) {
            return 1;
        } else if ($mes2 > $mes1) {
            return 2;
        }
        
        if ($dia1 > $dia2) {
            return 1;
        }
        
        return 2;
    }
}
