@extends('usuario.barraUsuario')

@section('conteudo')

<?php

function corStatus($status)
{
    if ($status == "A Pagar") {
        return "";
    } else if ($status == "Pago") {
        return "green";
    }
}
?>
&nbsp;
<div class="row">
    <div class="col-sm-11">
        <h2>Lista de Multas</h2>
    </div>
    <div class="col-sm-1">
        <a href="{{route('multas.create')}}" class="btn btn-primary"><i class="fas fa-plus"></i></a>
    </div>
</div>
&nbsp;

<div class="container">
  <table class="table table-striped">
    <thead>
      <tr>
          <th>Status</th>
          <th>Tipo (motivo)</th>
          <th>Valor (R$)</th>
          <th>Data do Pagamento</th>
          <th>Ações</th>
      </tr>
    </thead>
    <tbody>
      @foreach($multas as $multa)
      <tr>
          <td style="color:<?php echo corStatus($multa->status); ?>"><b>{{$multa->status}}</b></td>
          @if ($multa->pagamento_id == null)
            <td>Cancelamento de Contrato</td>
          @else
            <td>Atraso de Pagamento</td>
          @endif
          <td>{{$multa->valor}}</td>
          @if ($multa->dataPagamento == null)
            <td>---</td>
          @else
            <td>{{date_format(new DateTime($multa->dataPagamento), 'd/m/Y')}}</td>
          @endif
          <td>
              <a href="{{route('multas.edit', $multa->id)}}" class="btn btn-warning"><i class="fas fa-edit"></i></a>
            <form style="display : inline-block"
                    method="POST"
                    action="{{route('multas.destroy', $multa->id)}}"
                    onsubmit="return confirm('Tem certeza que deseja excluir esta multa?')">
                    {{ method_field('delete') }}
                    @csrf
                    <button type="submit"
                            class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>
              </form>
          </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>

@endsection
