@extends('administrador.barraAdmin')

@section('conteudo')
<div class="container">
  &nbsp;
  @if ($opcao === 1)
    <h2>Novo Administrador</h2>
    &nbsp;
    <form method="POST" action="{{route('admins.store')}}">
  @else
    <h2>Alterar Administrador</h2>
    &nbsp;
    <form method="POST" action="{{route('admins.update', $registro->id)}}">
        {!! method_field('put') !!}
  @endif
      @csrf
    <div class="form-group">
      <label for="nome">Nome:</label>
      <input type="text" class="form-control" id="nome" 
             value="{{$registro->nome or old('nome')}}" placeholder="Digite o nome" name="nome">
    </div>
    <div class="form-group">
      <label for="email">Email:</label>
      <input type="text" class="form-control" id="email"
            value="{{$registro->email or old('email')}}" placeholder="Digite o email" name="email">
    </div>
      @if ($opcao === 1)
        <div class="form-group">
          <label for="senha">Senha:</label>
          <input type="password" class="form-control" id="senha" placeholder="Digite a senha" name="senha">
        </div>
      @endif
      <div class="form-group">
        <label for="telefone">Telefone:</label>
        <input type="text" class="form-control" id="telefone" 
            value="{{$registro->telefone or old('telefone')}}" placeholder="Digite o telefone" name="telefone">
      </div>
    <button type="submit" class="btn btn-primary">Enviar</button>
  </form>
</div>
@endsection