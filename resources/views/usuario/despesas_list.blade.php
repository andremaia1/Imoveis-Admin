@extends('usuario.barraUsuario')

@section('conteudo')

&nbsp;
<div class="row">
    <div class="col-sm-11">
        <h2>Lista de Despesas</h2>
    </div>
    <div class="col-sm-1">
        <a href="{{route('despesas.create')}}" class="btn btn-primary"><i class="fas fa-plus"></i></a>
    </div>
</div>
&nbsp;

<div class="container">
  <table class="table table-striped">
    <thead>
      <tr>
          <th>Imóvel</th>
          <th>Descrição</th>
          <th>Valor (R$)</th>
          <th>Ações</th>
      </tr>
    </thead>
    <tbody>
      @foreach($despesas as $despesa)
      <tr>
          <td><a href="{{route('imoveis.show', $despesa->imovel->id)}}">{{$despesa->imovel->nome_apelido}}</a></td>
          <td>{{$despesa->descricao}}</td>
          <td>{{$despesa->valor}}</td>
          <td>
            <a href="{{route('despesas.edit', $despesa->id)}}" class="btn btn-warning"><i class="fas fa-edit"></i></a>
            <form style="display : inline-block"
                    method="POST"
                    action="{{route('despesas.destroy', $despesa->id)}}"
                    onsubmit="return confirm('Tem certeza que deseja excluir esta despesa?')">
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
