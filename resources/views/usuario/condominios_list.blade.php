@extends('usuario.barraUsuario')

@section('conteudo')

&nbsp;
<div class="row">
    <div class="col-sm-11">
        <h2>Lista de Condomínios</h2>
    </div>
    <div class="col-sm-1">
        <a href="{{route('condominios.create')}}" class="btn btn-primary"><i class="fas fa-plus"></i></a>
    </div>
</div>
&nbsp;

<div class="container">
  <table class="table table-striped">
    <thead>
      <tr>
          <th>Imóvel</th>
          <th>Imobiliária</th>
          <th>Pagamento</th>
          <th>Ações</th>
      </tr>
    </thead>
    <tbody>
      @foreach($condominios as $condominio)
      <tr>
          <td><a href="{{route('imoveis.show', $condominio->imovel->id)}}">{{$condominio->imovel->nome_apelido}}</a></td>
          <td><a href="{{route('imobiliaria.ver', $condominio->imobiliaria->id)}}">{{$condominio->imobiliaria->nome}}</a></td>
          <td><a href="{{route('pagamentos.lista', ['id' => $condominio->id, 'opcao' => 2])}}">Ver Pagamentos</a></td>
          <td>
            <a href="#" class="btn btn-info"><i class="fas fa-eye"></i></a>
            <a href="#" class="btn btn-warning"><i class="fas fa-edit"></i></a>
          </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>

@endsection

