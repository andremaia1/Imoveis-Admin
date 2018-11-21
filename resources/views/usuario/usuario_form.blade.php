@extends('usuario.barraUsuario')

@section('conteudo')
<div class="container">
    &nbsp;
    <div class="row">
        <div class="col-sm-11">
            <h2>Alterar sua Conta</h2>
        </div>
        <div class="col-sm-1">
            <form style="display : inline-block"
                        method="POST"
                        action="{{route('usuario.destroy', $usuario->id)}}"
                        onsubmit="return confirm('Tem certeza que deseja excluir a sua conta no Imóveis Admin?')">
                        {{ method_field('delete') }}
                        @csrf
                        <button type="submit"
                                class="btn btn-danger">Deletar Conta</button>
                  </form>
        </div>
    </div>
    &nbsp;
    <form method="POST" action="{{route('usuario.update', $usuario->id)}}">
        {!! method_field('put') !!}
        @csrf
    <div class="form-group">
      <label for="nome">Nome:</label>
      <input type="text" class="form-control" id="nome"
             value="{{$usuario->nome or old('nome')}}" placeholder="Nome" name="nome">
    </div>
    <div class="form-group">
      <label for="email">Email:</label>
      <input type="text" class="form-control" id="email"
             value="{{$usuario->email or old('email')}}" placeholder="Email" name="email">
    </div>
    <div class="form-group">
      <label for="telefone">Telefone:</label>
      <input type="text" class="form-control" id="telefone"
             value="{{$usuario->telefone or old('telefone')}}" placeholder="Telefone" name="telefone">
    </div>
    <button type="submit" class="btn btn-primary">Enviar</button>
  </form>
  &nbsp;
</div>
@endsection
