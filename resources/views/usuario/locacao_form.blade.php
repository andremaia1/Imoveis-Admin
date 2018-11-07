@extends('usuario.barraUsuario')

@section('conteudo')

@php
    $indiceItem = 1;
@endphp

<div class="container">
    &nbsp;
    @if ($opcao === 1)
        <h2>Nova Locação</h2>
        &nbsp;
        <form method="POST" action="{{route('locacoes.store')}}">
    @else
        <h2>Alterar/Renovar Locação</h2>
        &nbsp;
        <form method="POST" action="{{route('locacoes.update', $locacao->id)}}">
            {!! method_field('put') !!}
    @endif
    @csrf
    <hr>
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
            echo "<select class='form-control' id='imovel' name='imovel' disabled>";
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
      <input type="date" class="form-control" id="dataInicio" <?php if ($opcao === 2) echo "disabled";?>
             value="{{$locacao->inicioContrato or old('inicioContrato')}}" name="dataInicio">
    </div>
    <div class="form-group">
      <label for="prazoMinContrato">Prazo Mínimo do Contrato (meses):</label>
      <input type="text" class="form-control" id="prazoMinContrato"
             value="{{$locacao->prazoMinContrato or old('prazoMinContrato')}}" placeholder="Prazo Mínimo" name="prazoMinContrato">
    </div>
    @if ($opcao === 2)
        <div class="form-group">
          <label for="ultimaRenov">Data Última Renovação:</label>
          <input type="date" class="form-control" id="ultimaRenov" name="ultimaRenov" disabled>
        </div>
        <div class="col-sm-3">
            <div class="input-group">
              <label for="isRenov">Isto é uma Renovação:</label>
              <input type="checkbox" class="form-control" id="isRenov" name="isRenov">
            </div>
        </div>
    @endif
    <hr>
    <h4>Dados do Locatário</h4>
    <div class="form-group">
        <label for="tipo">Tipo de Locatário:</label>
        <select class="form-control" id="tipo" name="tipo" onChange="alterarForm()">
            <option>Pessoa Física</option>
            <option>Pessoa Jurídica (empresa)</option>
        </select>
    </div>
    @if ($opcao === 1 || ($opcao === 2 && $locacao->locatario !== null))
        <div id="formPessoa">
    @else
        <div style="display : none" id="formPessoa">
    @endif
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
        <hr>
        <h4>Dados do Fiador</h4>
        <div class="form-group">
          <label for="nomeF">Nome:</label>
          <input type="text" class="form-control" id="nomeF" 
                 value="{{$fiador->nome or old('nome')}}" placeholder="Nome do fiador" name="nomeF">
        </div>
        <div class="form-group">
          <label for="emailF">Email:</label>
          <input type="text" class="form-control" id="emailF" 
                value="{{$fiador->email or old('email')}}" placeholder="Email do fiador" name="emailF">
        </div>
        <div class="form-group">
            <label for="telefoneF">Telefone:</label>
            <input type="text" class="form-control" id="telefoneF" 
                value="{{$fiador->telefone or old('telefone')}}" placeholder="Telefone do fiador" name="telefoneF">
        </div>
        <div class="form-group">
            <label for="cpfF">CPF:</label>
            <input type="text" class="form-control" id="cpfF" 
                value="{{$fiador->cpf or old('cpf')}}" placeholder="CPF do fiador" name="cpfF">
        </div>
        <div class="form-group">
            <label for="rgF">RG:</label>
            <input type="text" class="form-control" id="rgF" 
                value="{{$fiador->rg or old('rg')}}" placeholder="RG do fiador" name="rgF">
        </div>
    </div>
    @if ($opcao === 1 || ($opcao === 2 && $locacao->empresa === null))
        <div style="display : none" id="formEmpresa">
    @else
        <div id="formEmpresa">
    @endif
        <div class="form-group">
          <label for="nomeEmpresa">Nome:</label>
          <input type="text" class="form-control" id="nomeEmpresa" 
                 value="{{$empresa->nome or old('nome')}}" placeholder="Nome da empresa" name="nomeEmpresa">
        </div>
        <div class="form-group">
          <label for="emailEmpresa">Email:</label>
          <input type="text" class="form-control" id="emailEmpresa"
                value="{{$empresa->email or old('email')}}" placeholder="Email da empresa" name="emailEmpresa">
        </div>
        <div class="form-group">
            <label for="telefoneEmpresa">Telefone:</label>
            <input type="text" class="form-control" id="telefoneEmpresa" 
                value="{{$empresa->telefone or old('telefone')}}" placeholder="Telefone da empresa" name="telefoneEmpresa">
        </div>
        <div class="form-group">
            <label for="enderecoSite">Endereço do Site:</label>
            <input type="text" class="form-control" id="enderecoSite" 
                value="{{$empresa->enderecoSite or old('enderecoSite')}}" placeholder="Endereço do Site" name="enderecoSite">
        </div>
        <div class="form-group">
            <label for="cnpj">CNPJ:</label>
            <input type="text" class="form-control" id="cnpj" 
                value="{{$empresa->cnpj or old('cnpj')}}" placeholder="CNPJ da empresa" name="cnpj">
        </div>
    </div>
    <hr>
    <h4>Dados do Pagamento</h4>
    <div class="row">
        <div class="col-sm-11">
            <h5>Itens</h5>
        </div>
        <div class="col-sm-1">
            <button type="button" class="btn btn-primary" onClick="adicionarItem()"><i class="fas fa-plus"></i></button>
        </div>
    </div>
    @if ($opcao === 2)
        @foreach($itens as $item)
            <div class="form-group">
                <label for="item_{{$item->id}}">Item {{$indiceItem}}:</label>
                <input class="form-control" name="item_{{$item->id}}"
                       value="{{$item->nome_item or old('nome_item')}}">
            </div>
        @php
            $indiceItem++;
        @endphp
        @endforeach
    @else
        <div class="form-group" id="formDadosPagto">
          <label for="dia">Dia do Vencimento:</label>
          <input type="text" class="form-control" id="dia" 
                 value="" placeholder="Dia do vencimento" name="dia">
        </div>
        <div class="form-group">
          <label for="numParc">Número de Parcelas (Inicial):</label>
          <input type="text" class="form-control" id="numParc" 
                 value="6" placeholder="Número de Parcelas" name="numParc">
        </div>
    @endif
    <input type="hidden" name="auxLocat" id="auxLocat" value="p">
    <button type="submit" class="btn btn-primary" id="btEnviar">Enviar</button>
  </form>
  &nbsp;
</div>
<script>
    
    var selectTipo = document.getElementById("tipo");
    var formPessoa = document.getElementById("formPessoa");
    var formEmpresa = document.getElementById("formEmpresa");
    var auxLocat = document.getElementById("auxLocat");
    
    var elementoRef;
    var indiceItem = 1;
    
    if ({{$opcao}} === 1) {
        elementoRef = document.getElementById("formDadosPagto");
    } else {
        elementoRef = document.getElementById("btEnviar");
        indiceItem = {{$indiceItem}};
    }
    
    function alterarForm() {
        
        if (selectTipo.selectedIndex === 0) {
            formPessoa.style.display = "block";
            formEmpresa.style.display = "none";
            auxLocat.value = "p";
        } else {
            formEmpresa.style.display = "block";
            formPessoa.style.display = "none";
            auxLocat.value = "e";
        }
    }
    
    function adicionarItem() {
        
        var div = document.createElement("div");
        div.classList.add("form-group");
        elementoRef.parentElement.insertBefore(div, elementoRef);
            
        var label = document.createElement("label");
        label.innerHTML = "Item "+indiceItem+":";
        div.appendChild(label);
        
        var input = document.createElement("input");
        input.classList.add("form-control");
        input.name = "item"+indiceItem;
        div.appendChild(input);
        
        indiceItem++;
    }
</script>
@endsection