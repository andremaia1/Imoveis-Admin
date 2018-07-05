<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Locacao;
use App\Pagamento;

class PagamentoController extends Controller
{
    public function lista($id)
    {
        $locacao = Locacao::find($id);
        
        $pagamentos = Pagamento::where('locacao_id', $id)->get();
        
        $data = date('Y-m-d');
        
        foreach ($pagamentos as $pagamento) {
            if ($pagamento->dataPagamento == null && $pagamento->status == 'A Pagar' && $this->dataMaior($data, $pagamento->dataVencimento) == 1) {
                $pagamento->status = 'Atrasado';
                $pagamento->update();
            }
        }
        
        return view('usuario.pagamentos_list', compact('pagamentos', 'locacao'));
    }
    
    public function editar($id)
    {
        $pagamento = Pagamento::find($id);
        
        return view('usuario.pagamento_form', compact('pagamento'));
    }
    
    public function atualizar(Request $request, $id)
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
        
        if ($pagamento->update()) {
            return redirect('/pagamentos/'.$pagamento->locacao_id);
        }
        return redirect('/pagamentos/'.$pagamento->locacao_id);
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
