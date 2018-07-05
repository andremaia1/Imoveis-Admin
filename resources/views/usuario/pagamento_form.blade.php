@extends('usuario.barraUsuario')

@section('conteudo')
<div class="container">
    &nbsp;
    <h2>Atualizar Pagamento</h2>
    &nbsp;
    <form method="POST" action="{{route('pagamentos.atualizar', $pagamento->id)}}">
        {!! method_field('put') !!}
        @csrf
        <div class="form-group">
          <label for="dataPagto">Data de Pagamento:</label>
          <input type="date" class="form-control" id="dataPagto"
                 value="{{$pagamento->dataPagamento or old('dataPagamento')}}" <?php echo $pagamento->dataPagamento == null ? "disabled" : ""; ?> name="dataPagto">
        </div>
        @if ($pagamento->dataPagamento == null)
            <div class="form-group">
                <input type="button" class="btn btn-success" value="Pago" onClick="pago()" id="btnPago">
            </div>
        @endif
        <div class="form-group">
          <label for="dataVenc">Data de Vencimento:</label>
          <input type="date" class="form-control" id="dataVenc"
                 value="{{$pagamento->dataVencimento or old('dataVencimento')}}" name="dataVenc">
        </div>
        <button type="submit" class="btn btn-primary">Enviar</button>
    </form>
  &nbsp;
</div>
<script>
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
        $("#btnPago").attr("disabled", true);
    }
</script>
@endsection