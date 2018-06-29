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
          <th>Locatário</th>
          <th>Valor</th>
          <th>Data Início Contrato</th>
          <th>Data Término Contrato</th>
          <th>Ações</th>
      </tr>
    </thead>
    <tbody>
      @foreach($locacoes as $locacao)
      <tr>
          <td><a href="{{route('imoveis.show', $locacao->imovel->id)}}">{{$locacao->imovel->nome_apelido}}</a></td>
          <td>--</td>
          <td>{{$locacao->valor}}</td>
          <td>{{date_format(new DateTime($locacao->inicioContrato), 'd/m/y')}}</td>
          <td>{{date_format(new DateTime($locacao->terminoContrato), 'd/m/y')}}</td>
          <td>
            <a href="#" class="btn btn-info"><i class="fas fa-eye"></i></a>
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
