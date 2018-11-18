@extends('usuario.barraUsuario')

@section('conteudo')

@php
    $indiceItem = 1;
@endphp

<div class="container">
  &nbsp;
  @if ($opcao == 1)
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
    <hr>
    <h4 style="margin-bottom:10px">Dados do Imóvel</h4>
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
      <select class="form-control" id="tipo" name="tipo" onChange="carregarForm()" <?php if ($opcao == 2) echo "disabled";?>>
          <?php
            $array = ["<option>Casa</option>",
                      "<option>Apartamento</option>",
                      "<option>Chácara</option>",
                      "<option>Sítio</option>",
                      "<option>Fazenda</option>",
                      "<option>Imóvel Comercial</option>"];
            
            if ($opcao == 2) {
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
        <h5>Dados do Endereço da Imobiliária</h5>
        <div class="form-group">
            <label for="ufImob">Unidade Federativa (estado):</label>
            <select class='form-control' id='ufImob' name='ufImob' onChange='setIdUf(2)'>
                <option>-</option>
                @if ($opcao == 1)
                    @foreach($ufs as $uf)
                        <option>{{$uf->nome}}</option>
                    @endforeach
                @else
                    @if ($imovel->tipo == 'Apartamento')
                        @foreach($ufs as $uf)
                            @if ($imobiliaria->endereco->cidade->uf->id == $uf->id)
                                <option selected>{{$uf->nome}}</option>
                            @else
                                <option>{{$uf->nome}}</option>
                            @endif
                        @endforeach
                    @endif
                @endif
            </select>
        </div>
        <div class="form-group">
            <label for="cidadeImob">Cidade:</label>
            <select class='form-control' id='cidadeImob' name='cidadeImob' onChange='setIdCidade(2)'>
                <option>-</option>
            </select>
        </div>
        <input type="hidden" id="idCidadeImob" name="idCidadeImob" value="">
        <div class="form-group">
          <label for="numeroImob">Número:</label>
          <input type="text" class="form-control" id="numeroImob"
                 value="{{$imobiliaria->endereco->numero or old('numero')}}" placeholder="Número" name="numeroImob">
        </div>
        <div class="form-group">
          <label for="logradouroImob">Logradouro:</label>
          <input type="text" class="form-control" id="logradouroImob"
                 value="{{$imobiliaria->endereco->logradouro or old('logradouro')}}" placeholder="Logradouro" name="logradouroImob">
        </div>
        <div class="form-group">
          <label for="bairro_distrito_imob">Bairro (ou distrito):</label>
          <input type="text" class="form-control" id="bairro_distrito_imob"
                 value="{{$imobiliaria->endereco->bairro_distrito or old('bairro_distrito')}}" placeholder="Bairro (ou distrito)" name="bairro_distrito_imob">
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
        @if ($opcao == 2)
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
            
            if ($opcao == 2) {
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
      <input type="date" class="form-control" id="dataCompra" <?php if ($opcao == 2) echo "disabled";?>
             value="" name="dataCompra">
    </div>
    <hr>
    <h4>Dados do Endereço</h4>
    <div class="form-group">
        <label for="uf">Unidade Federativa (estado):</label>
        <select class='form-control' id='uf' name='uf' onChange='setIdUf(1)'>
            <option>-</option>
            @if ($opcao == 1)
                @foreach($ufs as $uf)
                    <option>{{$uf->nome}}</option>
                @endforeach
            @else
                @foreach($ufs as $uf)
                    @if ($imovel->endereco->cidade->uf->id == $uf->id)
                        <option selected>{{$uf->nome}}</option>
                    @else
                        <option>{{$uf->nome}}</option>
                    @endif
                @endforeach
            @endif
        </select>
    </div>
    <div class="form-group">
        <label for="cidade">Cidade:</label>
        <select class='form-control' id='cidade' name='cidade' onChange='setIdCidade(1)'>
            <option>-</option>
        </select>
    </div>
    <input type="hidden" id="idCidade" name="idCidade" value="">
    <div class="form-group">
      <label for="numero">Número:</label>
      <input type="text" class="form-control" id="numero"
             value="{{$imovel->endereco->numero or old('numero')}}" placeholder="Número" name="numero">
    </div>
    <div class="form-group">
      <label for="logradouro">Logradouro:</label>
      <input type="text" class="form-control" id="logradouro"
             value="{{$imovel->endereco->logradouro or old('logradouro')}}" placeholder="Logradouro" name="logradouro">
    </div>
    <div class="form-group">
      <label for="bairro_distrito">Bairro (ou distrito):</label>
      <input type="text" class="form-control" id="bairro_distrito"
             value="{{$imovel->endereco->bairro_distrito or old('bairro_distrito')}}" placeholder="Bairro (ou distrito)" name="bairro_distrito">
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
    var selectUf = document.getElementById("uf");
    var selectCidade = document.getElementById("cidade");
    var inputIdCidade = document.getElementById("idCidade");
    var selectUfImob = document.getElementById("ufImob");
    var selectCidadeImob = document.getElementById("cidadeImob");
    var inputIdCidadeImob = document.getElementById("idCidadeImob");
    
    var elementoRef;
    var indiceItem = 1;
    
    var idsUfs = [];
    var cidades = [];
    var cidadesUfAtual = [];
    var cidadesUfAtualImob = [];
    
    <?php
        $indiceAtualUf = 1;

        foreach ($ufs as $uf) {
            
            echo 'idsUfs['.$indiceAtualUf.'] = '.$uf->id.';';
            
            $indiceAtualUf++;
        }

        $indiceAtualCidade = 1;

        foreach ($cidades as $cidade) {

            echo 'cidades['.$indiceAtualCidade.'] = '.$cidade->id.'+"_"+'.$cidade->idUf.'+"_'.$cidade->nome.'";';

            $indiceAtualCidade++;
        }
        
        if ($opcao == 2) {
            
            echo "setIdUf(1);";
            
            if ($imovel->tipo == "Apartamento") {
                echo "setIdUf(2);";
                echo "inputIdCidadeImob.value = ".$imobiliaria->endereco->cidade->id.";";
            }
            
            echo "inputIdCidade.value = ".$imovel->endereco->cidade->id.";";
        }
    ?>
    
    function setIdUf(opcao) {
        
        if (opcao == 1) {
            var idUf = idsUfs[selectUf.selectedIndex];
        } else {
            var idUf = idsUfs[selectUfImob.selectedIndex];
        }
        
        listarCidades(idUf, opcao);
    }
    
    function listarCidades(idUf, opcao) {
        
        if (opcao == 1) {
            var selectCidadeAtual = selectCidade;
            cidadesUfAtual = [];
        } else {
            var selectCidadeAtual = selectCidadeImob;
            cidadesUfAtualImob = [];
        }
        
        var j = 0;
        
        selectCidadeAtual.options.length = 0;
        
        if ({{$opcao}} == 1) {
            
            for (var i=1; i<cidades.length; i++) {

                if (cidades[i].split("_")[1] == idUf) {

                    selectCidadeAtual.options[selectCidadeAtual.options.length] = new Option(cidades[i].split("_")[2], "");

                    cidadesUfAtual[j] = cidades[i];

                    j++;
                }
            }
        } else {
            
            for (var i=1; i<cidades.length; i++) {

                if (cidades[i].split("_")[1] == idUf) {

                    selectCidadeAtual.options[selectCidadeAtual.options.length] = new Option(cidades[i].split("_")[2], "");

                    if ((opcao == 1 && cidades[i].split("_")[0] == <?php echo ($opcao == 2) ? $imovel->endereco->cidade->id : 0;?>) || (opcao == 2 && cidades[i].split("_")[0] == <?php echo ($opcao == 2 && $imovel->tipo == "Apartamento") ? $imobiliaria->endereco->cidade->id : 0;?>)) {
                        selectCidadeAtual.options[selectCidadeAtual.options.length-1].selected = true;
                    }
                    
                    if (opcao == 1) {
                        cidadesUfAtual[j] = cidades[i];
                    } else {
                        cidadesUfAtualImob[j] = cidades[i];
                    }
                    
                    j++;
                }
            }
        }
        
        setIdCidade(opcao);
    }
    
    function setIdCidade(opcao) {
        
        if (opcao == 1) {
            var idCidade = cidadesUfAtual[selectCidade.selectedIndex].split("_")[0];
            inputIdCidade.value = idCidade;
        } else {
            var idCidade = cidadesUfAtualImob[selectCidadeImob.selectedIndex].split("_")[0];
            inputIdCidadeImob.value = idCidade;
        }
    }
    
    function carregarForm() {
        
        if (selectTipo.selectedIndex == 1) {
            divFormCondominio.style.display = "block";
            auxCondom.value = "on";
        } else {
            divFormCondominio.style.display = "none";
            auxCondom.value = "off";
        }
    }
    
    if ({{$opcao}} == 1) {
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
