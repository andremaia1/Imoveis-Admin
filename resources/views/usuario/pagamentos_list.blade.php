@extends('usuario.barraUsuario')

@section('conteudo')

<?php

function corStatus($status)
{
    if ($status == "A Pagar") {
        return "";
    } else if ($status == "Pago") {
        return "green";
    } else if ($status == "Atrasado") {
        return "red";
    } else if ($status == "Pago (Com Atraso)") {
        return "orange";
    }
}

?>
&nbsp;
<div class="row">
    <div class="col-sm-7">
        <h2>Pagamentos de {{$locacao->imovel->nome_apelido}}</h2>
    </div>
    <div class="col-sm-5">
        <form method="POST" action="{{route("pagamentos.gerar", $locacao->id)}}">
            @csrf
            <div class="input-group">
              <label for="numParc">Gerar Parcelas:&nbsp;</label>
              <input type="text" class="form-control" id="numParc"
                     value="" placeholder="Quantidade" name="numParc">&nbsp;
              <button type="submit" class="btn btn-success">Gerar</button>
            </div>
        </form>
    </div>
</div>
&nbsp;

<div class="container">
  <table class="table table-striped">
    <thead>
      <tr>
          <th>Status</th>
          <th>Data de Pagamento</th>
          <th>Data de Vencimento</th>
          <th>Ações</th>
      </tr>
    </thead>
    <tbody>
      @foreach($pagamentos as $pagamento)
        <tr>
            <td style="color:<?php echo corStatus($pagamento->status); ?>"><b>{{$pagamento->status}}</b></td>
            @if ($pagamento->dataPagamento == null)
                <td>---</td>
            @else
                <td>{{date_format(new dateTime($pagamento->dataPagamento), 'd/m/Y')}}</td>
            @endif
            <td>{{date_format(new dateTime($pagamento->dataVencimento), 'd/m/Y')}}</td>
            <td>
                <a href="{{route('pagamentos.ver', $pagamento->id)}}" class="btn btn-info"><i class="fas fa-eye"></i></a>
                <a href="{{route('pagamentos.editar', $pagamento->id)}}" class="btn btn-warning"><i class="fas fa-edit"></i></a>
            </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection