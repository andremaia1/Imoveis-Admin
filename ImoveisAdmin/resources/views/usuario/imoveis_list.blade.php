@extends('usuario.barraUsuario')

@section('conteudo')

&nbsp;
<h4>Olá {{Auth::user()->nome}}, seja bem-vindo(a)!</h4>
&nbsp;
<h2>Lista de Imóveis</h2>
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
      
    </tbody>
  </table>
</div>

@endsection