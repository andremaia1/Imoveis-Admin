@extends('usuario.barraUsuario')

@section('conteudo')

    &nbsp;
    <div class='row'>
        <div class='col-sm-12'>
            <h2>Ver Empresa</h2>
        </div>
    </div>

    <div class="container">
        <hr style="background-color:gainsboro">
        <p><b>Nome: </b>{{$empresa->nome}}</p>
        <p><b>Email: </b>{{$empresa->email}}</p>
        <p><b>Telefone: </b>{{$empresa->telefone}}</p>
        <p><b>Endereço do Site: </b>{{$empresa->enderecoSite}}</p>
        <p><b>CNPJ: </b>{{$empresa->cnpj}}</p>
        <hr style="background-color:gainsboro">
    </div>
@endsection