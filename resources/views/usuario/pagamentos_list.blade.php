@extends('usuario.barraUsuario')

@section('conteudo')

&nbsp;
<div class="row">
    <div class="col-sm-12">
        <h2>Pagamentos de {{$locacao->imovel->nome_apelido}}</h2>
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
            <td>{{$pagamento->status}}</td>
            @if ($pagamento->dataPagamento == null)
                <td>---</td>
            @else
                <td>{{date_format(new dateTime($pagamento->dataPagamento), 'd/m/y')}}</td>
            @endif
            <td>{{date_format(new dateTime($pagamento->dataVencimento), 'd/m/y')}}</td>
            <td>
                <a href="{{route('pagamentos.editar', $pagamento->id)}}" class="btn btn-warning"><i class="fas fa-edit"></i></a>
            </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>

@endsection