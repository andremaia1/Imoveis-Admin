@extends('administrador.barraAdmin')

@section('conteudo')

    &nbsp;
    <div class='row'>
        <div class='col-sm-11'>
            <h2>Lista de Administradores</h2>
        </div>
        @if (Auth::user()->id === 1)
        <div class='col-sm-1'>
            <a href="{{route('admins.create')}}" class="btn btn-primary" role="button">Novo</a>
        </div>
        @endif
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
              @if (Auth::user()->id == 1)
              <td>
                  @if ($admin->id != 1)
                  <a href="{{route('admins.edit', $admin->id)}}" class="btn btn-warning" role="button">Editar</a>
                  <form style="display : inline-block"
                        method="POST"
                        action="{{route('admins.destroy', $admin->id)}}"
                        onsubmit="return confirm('Tem certeza que deseja excluir {{$admin->nome}}?')">
                        {{ method_field('delete') }}
                        @csrf
                        <button type="submit"
                                class="btn btn-danger">Deletar</button>
                  </form>
                  @endif
              </td>
              @else
                <td></td>
              @endif
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
@endsection