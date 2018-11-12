@extends('usuario.barraUsuario')

@section('conteudo')
<div class="container">
    &nbsp;
    @if ($opcao == 1)
        <h2>Nova Multa</h2>
        &nbsp;
        <form method="POST" action="{{route('multas.store')}}">
    @else
        <h2>Alterar Multa</h2>
        &nbsp;
        <form method="POST" action="{{route('multas.update', $multa->id)}}">
            {!! method_field('put') !!}
    @endif
        @csrf
    @if ($opcao == 1)
        <div class="form-group">
          <label for="tipo">Tipo (motivo):</label>
          <select class='form-control' id='tipo' name='tipo' onChange='mudarTipoMulta()'>
              <option>Cancelamento de Contrato</option>
              <option>Atraso de Pagamento</option>
          </select>
        </div>
        <div class="form-group">
          <label for="locacao">Locação (Contrato):</label>
          <select class='form-control' id='locacao' name='locacao' onChange='setIdLocacao()'>
          @foreach($locacoes as $locacao)
            <option>{{$locacao->imovel->nome_apelido}}</option>
          @endforeach
          </select>
          <input type="hidden" id="idLocacao" name="idLocacao" value="{{$locacoes[0]->id}}">
        </div>
        <div style="display : none" class="form-group" id="divPagamento">
          <label for="pagamento">Pagamento:</label>
          <select class='form-control' id='pagamento' name='pagamento' onChange='setIdPagamento()'>
          </select>
          <input type="hidden" id="idPagamento" name="idPagamento" value="">
        </div>
    @else
        <div class="form-group">
          <label for="dataPagto">Data de Pagamento:</label>
          <input type="date" class="form-control" id="dataPagto"
                 value="{{$multa->dataPagamento or old('dataPagamento')}}" <?php echo $multa->dataPagamento == null ? "disabled" : ""; ?> name="dataPagto">
        </div>
        @if ($multa->dataPagamento == null)
        <div class="form-group">
            <input type="button" class="btn btn-success" value="Pago" onClick="pago()" id="btPago">
        </div>
        @endif
    @endif
    <div class="form-group">
      <label for="valor">Valor:</label>
      <input type="text" class="form-control" id="valor"
             value="{{$multa->valor or old('valor')}}" placeholder="Valor" name="valor">
    </div>
    <button type="submit" class="btn btn-primary">Enviar</button>
  </form>
  &nbsp;
</div>
<script>
    
    var selectTipo = document.getElementById("tipo");
    var selectLocacao = document.getElementById("locacao");
    var inputIdLocacao = document.getElementById("idLocacao");
    var divPagamento = document.getElementById("divPagamento");
    var selectPagamento = document.getElementById("pagamento");
    var inputIdPagamento = document.getElementById("idPagamento");
    
    var idsLocacoes = [];
    var pagamentos = [];
    var pagamentosLocacaoAtual = [];
    
    <?php
        if ($opcao == 1) {
            
            $indiceAtualLocacao = 0;

            foreach ($locacoes as $locacao) {
                echo 'idsLocacoes['.$indiceAtualLocacao.'] = '.$locacao->id.';';
                $indiceAtualLocacao++;
            }
            
            $indiceAtualPagamento = 0;

            foreach ($pagamentos as $pagamento) {
                
                $mesVenc = explode('-', $pagamento->dataVencimento)[1];
                $anoVenc = explode('-', $pagamento->dataVencimento)[0];
                
                echo 'pagamentos['.$indiceAtualPagamento.'] = '.$pagamento->id.'+" "+'.$pagamento->locacao_id.'+" "+'.$mesVenc.'+"/"+'.$anoVenc.';';
                
                $indiceAtualPagamento++;
            }
        }
    ?>
    
    function mudarTipoMulta() {
        
        if (selectTipo.selectedIndex === 1) {
            divPagamento.style.display = "block";
            setIdLocacao();
        } else {
            divPagamento.style.display = "none";
            inputIdPagamento.value = "";
        }
    }
    
    function setIdLocacao() {
        
        var idLocacao = idsLocacoes[selectLocacao.selectedIndex];
        
        if (selectTipo.selectedIndex === 1) {
            listarPagamentosDeLocacao(idLocacao);
        }
        
        inputIdLocacao.value = idLocacao;
    }
    
    function listarPagamentosDeLocacao(idLocacao) {
        
        var j = 0;
        
        selectPagamento.options.length = 0;
        
        pagamentosLocacaoAtual = [];
        
        for (var i=0; i<pagamentos.length; i++) {
            
            if (pagamentos[i].split(" ")[1] == idLocacao) {
                
                selectPagamento.options[selectPagamento.options.length] = new Option(pagamentos[i].split(" ")[2], "");
                
                pagamentosLocacaoAtual[j] = pagamentos[i];
                
                j++;
            }
        }
        
        setIdPagamento();
    }
    
    function setIdPagamento() {
        
        var idPagamento = pagamentosLocacaoAtual[selectPagamento.selectedIndex].split(" ")[0];
        
        inputIdPagamento.value = idPagamento;
    }
    
    function pago() {
        
        var data = new Date();
        
        var dia = data.getDate();
        var mes = data.getMonth()+1;
        var ano = data.getFullYear();
        
        if (dia < 10) {
            dia = "0"+dia;
        }
        
        if (mes < 10) {
            mes = "0"+mes;
        }
        
        $("#dataPagto").val(ano+"-"+mes+"-"+dia);
        $("#dataPagto").attr("disabled", false);
        $("#btPago").attr("disabled", true);
    }
</script>
@endsection
