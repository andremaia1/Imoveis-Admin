@extends('administrador.barraAdmin')

@section('conteudo')

    &nbsp;
    <div class='row'>
        <div class='col-sm-12'>
            <h2>Lista de Usuários</h2>
        </div>
    </div>
    &nbsp;

    <div class="container">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Ativo</th>
            <th>Nome</th>
            <th>Email</th>
            <th>Telefone</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          @foreach($usuarios as $usuario)
          <tr>
              <td><input type="checkbox" value="" id="<?=$usuario->id?>"
                         onclick="window.location.href='{{route('usuarios.alterar_status', $usuario->id)}}'"></td>
              <script>
                    document.getElementById(<?=$usuario->id?>).checked = (<?=$usuario->ativo === 1?>);
              </script>
              <td>{{$usuario->nome}}</td>
              <td>{{$usuario->email}}</td>
              <td>{{$usuario->telefone}}</td>
              <td>
                  <a href="{{route('users.show', $usuario->id)}}" class="btn btn-info" role="button">Ver</a>
                  <a href="{{route('usuarios.listar_imoveis', $usuario->id)}}" class="btn btn-info" role="button">Ver Imóveis</a>
              </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
@endsection