@extends('usuario.barraUsuario')

@section('conteudo')
<div class="container">
    &nbsp;
    @if ($opcao === 1)
        <h2>Nova Despesa</h2>
        &nbsp;
        <form method="POST" action="{{route('despesas.store')}}">
    @else
        <h2>Alterar Despesa</h2>
        &nbsp;
        <form method="POST" action="{{route('despesas.update', $despesa->id)}}">
            {!! method_field('put') !!}
    @endif
        @csrf
    <div class="form-group">
      <label for="imovel">Imóvel:</label>
      <?php
        
        if ($opcao === 1) {
            echo "<select class='form-control' id='imovel' name='imovel'>";
            foreach ($imoveis as $imovel) {
                echo "<option>" . $imovel->nome_apelido . "</option>";
            }
        } else {
            echo "<select disabled='disabled' class='form-control' id='imovel' name='imovel'>";
            echo "<option>" . $despesa->imovel->nome_apelido . "</option>";
        }
        
        echo "</select>";
      ?>
    </div>
    <div class="form-group">
      <label for="descricao">Descrição:</label>
      <input type="text" class="form-control" id="descricao"
             value="{{$despesa->descricao or old('descricao')}}" placeholder="Descrição" name="descricao">
    </div>
    <div class="form-group">
      <label for="valor">Valor:</label>
      <input type="text" class="form-control" id="valor"
             value="{{$despesa->valor or old('valor')}}" placeholder="Valor" name="valor">
    </div>
    <button type="submit" class="btn btn-primary">Enviar</button>
  </form>
  &nbsp;
</div>
@endsection
