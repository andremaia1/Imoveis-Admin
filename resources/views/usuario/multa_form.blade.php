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
          <select class='form-control' id='tipo' name='tipo'>
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
        <div style="display : none" class="form-group">
          <label for="pagamento">Pagamento:</label>
          <select class='form-control' id='pagamento' name='pagamento'>
          </select>
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
    
    var selectLocacao = document.getElementById("locacao");
    var inputIdLocacao = document.getElementById("idLocacao");
    var idsLocacoes = [];
    
    <?php
        if ($opcao == 1) {
            
            $indiceAtualLocacao = 0;

            foreach ($locacoes as $locacao) {
                echo 'idsLocacoes['.$indiceAtualLocacao.'] = '.$locacao->id.';';
                $indiceAtualLocacao++;
            }
        }
    ?>
    
    function setIdLocacao() {
        inputIdLocacao.value = idsLocacoes[selectLocacao.selectedIndex];
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
