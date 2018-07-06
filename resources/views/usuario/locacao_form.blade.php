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
    <h4>Dados da Locação</h4>
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
      <label for="valor">Valor (R$):</label>
      <input type="text" class="form-control" id="valor"
             value="{{$locacao->valor or old('valor')}}" placeholder="Valor" name="valor">
    </div>
    <div class="form-group">
      <label for="dataInicio">Data Início Contrato:</label>
      <input type="date" class="form-control" id="dataInicio"
             value="{{$locacao->inicioContrato or old('inicioContrato')}}" name="dataInicio">
    </div>
    <div class="form-group">
      <label for="dataTermino">Data Término Contrato:</label>
      <input type="date" class="form-control" id="dataTermino"
             value="{{$locacao->terminoContrato or old('terminoContrato')}}" name="dataTermino">
    </div>
    <hr>
    <h4>Dados do Locatário</h4>
    <div class="form-group">
      <label for="nome">Nome:</label>
      <input type="text" class="form-control" id="nome" 
             value="{{$locatario->nome or old('nome')}}" placeholder="Nome do locatário" name="nome">
    </div>
    <div class="form-group">
      <label for="email">Email:</label>
      <input type="text" class="form-control" id="email"
            value="{{$locatario->email or old('email')}}" placeholder="Email do locatário" name="email">
    </div>
    <div class="form-group">
        <label for="telefone">Telefone:</label>
        <input type="text" class="form-control" id="telefone" 
            value="{{$locatario->telefone or old('telefone')}}" placeholder="Telefone do locatário" name="telefone">
    </div>
    <div class="form-group">
        <label for="cpf">CPF:</label>
        <input type="text" class="form-control" id="cpf" 
            value="{{$locatario->cpf or old('cpf')}}" placeholder="CPF do locatário" name="cpf">
    </div>
    <div class="form-group">
        <label for="rg">RG:</label>
        <input type="text" class="form-control" id="rg" 
            value="{{$locatario->rg or old('rg')}}" placeholder="RG do locatário" name="rg">
    </div>
    @if ($opcao === 1)
        <hr>
        <h4>Dados do Pagamento</h4>
        <div class="form-group">
          <label for="dia">Dia do Vencimento:</label>
          <input type="text" class="form-control" id="dia" 
                 value="" placeholder="Dia do vencimento" name="dia">
        </div>
    @endif
    <button type="submit" class="btn btn-primary">Enviar</button>
  </form>
  &nbsp;
</div>
@endsection