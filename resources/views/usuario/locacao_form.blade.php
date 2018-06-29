@extends('usuario.barraUsuario')

@section('conteudo')
<div class="container">
    &nbsp;
    @if ($opcao === 1)
        <h2>Nova Locação</h2>
        &nbsp;
        <form method="POST" action="{{route('locacoes.store')}}">
    @else
        <h2>Alterar Locação</h2>
        &nbsp;
        <form method="POST" action="{{route('locacoes.update', $locacao->id)}}">
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
            echo "<option>" . $locacao->imovel->nome_apelido . "</option>";
        }
        
        echo "</select>";
      ?>
    </div>
    <div class="form-group">
      <label for="valor">Valor:</label>
      <input type="valor" class="form-control" id="valor"
             value="{{$locacao->valor or old('valor')}}" placeholder="Valor" name="valor">
    </div>
    <div class="form-group">
      <label for="dataInicio">Data Início Contrato:</label>
      <input type="date" class="form-control" id="dataInicio"
             value="{{$locacao->inicioContrato or old('inicioContrato')}}" placeholder="Data de início" name="dataInicio">
    </div>
    <div class="form-group">
      <label for="dataTermino">Data Término Contrato:</label>
      <input type="date" class="form-control" id="dataTermino"
             value="{{$locacao->terminoContrato or old('terminoContrato')}}" placeholder="Data de término" name="dataTermino">
    </div>
    <button type="submit" class="btn btn-primary">Enviar</button>
  </form>
  &nbsp;
</div>
@endsection