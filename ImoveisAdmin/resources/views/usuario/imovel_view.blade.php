@extends('administrador.barraAdmin')

@section('conteudo')

    &nbsp;
    <div class='row'>
        <div class='col-sm-12'>
            <h2>Ver Imóvel</h2>
        </div>
    </div>
    &nbsp;

    <div class="container">
        <p><b>Nome (Apelido): </b>{{$imovel->nome_apelido}}</p>
        <p><b>Descrição: </b>{{$imovel->descricao}}</p>
        <p><b>Tipo: </b>{{$imovel->tipo}}</p>
        <p><b>Status: </b>{{$imovel->status}}</p>
        <p><b>Área Construída (m²): </b>{{$imovel->areaConstr}}</p>
        <p><b>Área Total (m²): </b>{{$imovel->areaTotal}}</p>
    </div>
@endsection