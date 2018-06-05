@extends('usuario.barraUsuario')

@section('conteudo')

&nbsp;
<h4>Olá {{Auth::user()->nome}}, seja bem-vindo(a)!</h4>
&nbsp;
<div class="row">
    <div class="col-sm-11">
        <h2>Lista de Imóveis</h2>
    </div>
    <div class="col-sm-1">
        <a href="#" class="btn btn-primary"><i class="fas fa-plus"></i></a>
    </div>
</div>
&nbsp;

<div class="container">
  <table class="table table-striped">
    <thead>
      <tr>
          <th>Nome (Apelido)</th>
          <th>Tipo</th>
          <th>Status</th>
          <th>Área Construída</th>
          <th>Área Total</th>
          <th>Ações</th>
      </tr>
    </thead>
    <tbody>
      @foreach($imoveis as $imovel)
        <tr>
            <td>{{$imovel->nome_apelido}}</td>
            <td>{{$imovel->tipo}}</td>
            <td>{{$imovel->status}}</td>
            <td>{{$imovel->areaConstr}}</td>
            <td>{{$imovel->areaTotal}}</td>
            <td>
                <a href="#" class="btn btn-info"><i class="fas fa-eye"></i></a>
                <a href="#" class="btn btn-warning"><i class="fas fa-edit"></i></a>
                <a href="#" class="btn btn-danger"><i class="fas fa-trash-alt"></i></a>
            </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>

@endsection