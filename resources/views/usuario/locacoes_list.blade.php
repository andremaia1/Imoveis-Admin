@extends('usuario.barraUsuario')

@section('conteudo')
&nbsp;
<div class="row">
    <div class="col-sm-11">
        <h2>Lista de Locações</h2>
    </div>
    <div class="col-sm-1">
        <a href="{{route('locacoes.create')}}" class="btn btn-primary"><i class="fas fa-plus"></i></a>
    </div>
</div>
&nbsp;

<div class="container">
  <table class="table table-striped">
    <thead>
      <tr>
          <th>Imóvel</th>
          <th>Pagamento</th>
          <th>Locatário</th>
          <th>Valor (R$)</th>
          <th>Data Início Contrato</th>
          <th>Última Renovação</th>
          <th>Ações</th>
      </tr>
    </thead>
    <tbody>
      @foreach($locacoes as $locacao)
      <tr>
          <td><a href="{{route('imoveis.show', $locacao->imovel->id)}}">{{$locacao->imovel->nome_apelido}}</a></td>
          <td><a href="{{route('pagamentos.lista', ['id' => $locacao->id, 'opcao' => 1])}}">Ver Pagamentos</a></td>
          @if ($locacao->locatario != null)
            <td><a href="{{route('locatario.ver', $locacao->locatario->id)}}">{{$locacao->locatario->nome}}</a></td>
          @else
            <td><a href="{{route('empresa.ver', $locacao->empresa->id)}}">{{$locacao->empresa->nome}}</a></td>
          @endif
          <td>{{$locacao->valor}}</td>
          <td>{{date_format(new DateTime($locacao->inicioContrato), 'd/m/Y')}}</td>
          @if ($locacao->ultimaRenovacao == null)
            <td>---</td>
          @else
            <td>{{date_format(new DateTime($locacao->ultimaRenovacao), 'd/m/Y')}}</td>
          @endif
          <td>
            <a href="{{route('locacoes.show', $locacao->id)}}" class="btn btn-info"><i class="fas fa-eye"></i></a>
            <a href="{{route('locacoes.edit', $locacao->id)}}" class="btn btn-warning"><i class="fas fa-edit"></i></a>
            <form style="display : inline-block"
                    method="POST"
                    action="{{route('locacoes.destroy', $locacao->id)}}"
                    onsubmit="return confirm('Tem certeza que deseja excluir esta locação?')">
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
