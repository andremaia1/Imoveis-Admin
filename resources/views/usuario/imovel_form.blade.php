@extends('usuario.barraUsuario')

@section('conteudo')
<div class="container">
  &nbsp;
  @if ($opcao === 1)
    <h2>Novo Imóvel</h2>
    &nbsp;
    <form method="POST" action="{{route('imoveis.store')}}">
  @else
    <h2>Alterar Imóvel</h2>
    &nbsp;
    <form method="POST" action="{{route('imoveis.update', $imovel->id)}}">
        {!! method_field('put') !!}
  @endif
      @csrf
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
      <select class="form-control" id="tipo" name="tipo">
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
    <div class="form-group">
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
    <button type="submit" class="btn btn-primary">Enviar</button>
  </form>
  &nbsp;
</div>
@endsection