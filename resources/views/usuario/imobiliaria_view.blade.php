@extends('usuario.barraUsuario')

@section('conteudo')

    &nbsp;
    <div class='row'>
        <div class='col-sm-12'>
            <h2>Ver Imobiliária</h2>
        </div>
    </div>

    <div class="container">
        <hr style="background-color:gainsboro">
        <p><b>Nome: </b>{{$imobiliaria->nome}}</p>
        <p><b>Email: </b>{{$imobiliaria->email}}</p>
        <p><b>Telefone: </b>{{$imobiliaria->telefone}}</p>
        <p><b>Endereço do Site: </b>{{$imobiliaria->enderecoSite}}</p>
        <hr style="background-color:gainsboro">
    </div>
@endsection