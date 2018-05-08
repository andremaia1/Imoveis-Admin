@extends('administrador.barraAdmin')

@section('conteudo')

    &nbsp;
    <div class='row'>
        <div class='col-sm-11'>
            <h2>Lista de Administradores</h2>
        </div>
        <div class='col-sm-1'>
            <a href="#" class="btn btn-primary" role="button">Novo</a>
        </div>
    </div>
    &nbsp;

    <div class="container">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Nome</th>
            <th>Email</th>
            <th>Telefone</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          @foreach($admins as $admin)
          <tr>
              <td>{{$admin->nome}}</td>
              <td>{{$admin->email}}</td>
              <td>{{$admin->telefone}}</td>
              <td>
                  <a href="#" class="btn btn-info" role="button">Ver</a>
                  <a href="#" class="btn btn-warning" role="button">Editar</a>
                  <a href="#" class="btn btn-danger" role="button">Excluir</a>
              </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
@endsection