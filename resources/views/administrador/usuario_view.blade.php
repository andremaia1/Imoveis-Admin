@extends('administrador.barraAdmin')

@section('conteudo')

    &nbsp;
    <div class='row'>
        <div class='col-sm-12'>
            <h2>Ver Usuário</h2>
        </div>
    </div>

    <div class="container">
        <hr style="background-color:gainsboro">
        <p><b>Id: </b>{{$usuario->id}}</p>
        <p><b>Nome: </b>{{$usuario->nome}}</p>
        <p><b>Email: </b>{{$usuario->email}}</p>
        <p><b>Telefone: </b>{{$usuario->telefone}}</p>
        <p><b>Ativo: </b><?php echo ($usuario->ativo === 1) ? 'Sim' : 'Não'; ?></p>
        <p><b>Nº de Imóveis Cadastrados: </b>{{$numImoveis}}</p>
        <hr style="background-color:gainsboro">
    </div>
@endsection