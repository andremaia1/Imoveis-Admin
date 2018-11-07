@extends('usuario.barraUsuario')

@section('conteudo')

@php
    $indiceItem = 1;
@endphp

<div class="container">
  &nbsp;
  @if ($opcao === 1)
    <h2>Novo Imóvel</h2>
    &nbsp;
    <form method="POST" action="{{route('imoveis.store')}}" id="form">
  @else
    <h2>Alterar Imóvel</h2>
    &nbsp;
    <form method="POST" action="{{route('imoveis.update', $imovel->id)}}" id="form">
        {!! method_field('put') !!}
  @endif
      @csrf
    <hr><hr>
    <div class="form-group">
      <label for="nome">Nome (Apelido):</label>
      <input type="text" class="form-control" id="nome"
             value="{{$imovel->nome_apelido or old('nome_apelido')}}" placeholder="Digite o nome (apelido)" name="nome">
    </div>
    <div class="form-group">
      <label for="descricao">Descrição:</label>
      <textarea type="text" class="form-control" id="descricao" rows="6"
             placeholder="Descrição do imóvel" name="descricao">{{$imovel->descricao or ""}}</textarea>
    </div>
    <div class="form-group">
      <label for="tipo">Tipo:</label>
      <select class="form-control" id="tipo" name="tipo" onChange="carregarForm()">
          <?php
            $array = ["<option>Casa</option>",
                      "<option>Apartamento</option>",
                      "<option>Chácara</option>",
                      "<option>Sítio</option>",
                      "<option>Fazenda</option>",
                      "<option>Imóvel Comercial</option>"];
            
            if ($opcao === 2) {
                $array[$imovel->getTipo()-1] = "<option selected>" . $imovel->tipo . "</option>";
            }
            
            foreach ($array as $option) {
                echo $option;
            }
          ?>
      </select>
    </div>
    @if ($opcao == 1 || ($opcao == 2 && $imovel->tipo != 'Apartamento'))
        <div style="display : none" id="formCondominio">
    @else
        <div id="formCondominio">
    @endif
        <hr>
        <h4>Condomínio</h4>
        <hr>
        <h5>Dados da Imobiliária Responsável</h5>
        <div class="form-group">
          <label for="nomeImob">Nome:</label>
          <input type="text" class="form-control" id="nomeImob"
                 value="{{$imobiliaria->nome or old('nome')}}" placeholder="Digite o nome da imobiliária" name="nomeImob">
        </div>
        <div class="form-group">
          <label for="emailImob">Email:</label>
          <input type="text" class="form-control" id="emailImob"
                 value="{{$imobiliaria->email or old('email')}}" placeholder="Digite o email da imobiliária" name="emailImob">
        </div>
        <div class="form-group">
          <label for="telefoneImob">Telefone:</label>
          <input type="text" class="form-control" id="telefoneImob"
                 value="{{$imobiliaria->telefone or old('telefone')}}" placeholder="Digite o telefone da imobiliária" name="telefoneImob">
        </div>
        <div class="form-group">
          <label for="enderecoSiteImob">Endereço do Site:</label>
          <input type="text" class="form-control" id="enderecoSiteImob"
                 value="{{$imobiliaria->enderecoSite or old('enderecoSite')}}" placeholder="Digite o endereco do site da imobiliária (www...)" name="enderecoSiteImob">
        </div>
        <hr>
        <h5>Dados do Pagamento</h5>
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
        <hr id="hrRef">
        <h4>Dados do Imóvel (continuação)</h4>
    </div>
    <div class="form-group" id="divRef">
      <label for="status">Status:</label>
      <select class="form-control" id="status" name="status">
          <?php
            $array = ["<option>Desocupado</option>",
                      "<option>Por Alugar</option>",
                       "<option disabled>Alugado</option>"];
            
            if ($opcao === 2) {
                $array[$imovel->getStatus()-1] = "<option selected>" . $imovel->status . "</option>";
            }
            
            foreach ($array as $option) {
                echo $option;
            }
          ?>
      </select>
    </div>
    <div class="form-group">
      <label for="areaConstr">Área Construída (m²):</label>
      <input type="text" class="form-control" id="areaConstr"
             value="{{$imovel->areaConstr or old('areaConstr')}}" placeholder="Área Construída" name="areaConstr">
    </div>
    <div class="form-group">
      <label for="areaTotal">Área Total (m²):</label>
      <input type="text" class="form-control" id="areaTotal"
             value="{{$imovel->areaTotal or old('areaTotal')}}" placeholder="Área Total" name="areaTotal">
    </div>
    <div class="form-group">
      <label for="dataCompra">Data da Compra do Imóvel:</label>
      <input type="date" class="form-control" id="dataCompra" <?php if ($opcao === 2) echo "disabled";?>
             value="" name="dataCompra">
    </div>
    <input type="hidden" name="auxCondom" id="auxCondom" value="off">
    <button type="submit" class="btn btn-primary">Enviar</button>
  </form>
  &nbsp;
</div>
<script>
    
    var selectTipo = document.getElementById("tipo");
    var divFormCondominio = document.getElementById("formCondominio");
    var auxCondom = document.getElementById("auxCondom");
    
    var elementoRef;
    var indiceItem = 1;
    
    function carregarForm() {
        if (selectTipo.selectedIndex === 1) {
            divFormCondominio.style.display = "block";
            auxCondom.value = "on";
        } else {
            divFormCondominio.style.display = "none";
            auxCondom.value = "off";
        }
    }
    
    if ({{$opcao}} === 1) {
        elementoRef = document.getElementById("formDadosPagto");
    } else {
        elementoRef = document.getElementById("hrRef");
        indiceItem = {{$indiceItem}};
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