@extends('usuario.barraUsuario')

@section('conteudo')
<div class="container">
    &nbsp;
    <h2>Novo Relatório de Erro</h2>
    &nbsp;
    <form method="POST" action="{{route('relatErro.salvar')}}">
    @csrf
    <div class="form-group">
      <label for="descricao">Descrição:</label>
      <textarea type="text" class="form-control" id="descricao" rows="6"
             placeholder="Descrição do erro" name="descricao"></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Enviar</button>
  </form>
  &nbsp;
</div>
@endsection
