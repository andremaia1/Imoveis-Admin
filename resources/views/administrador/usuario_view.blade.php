@extends('administrador.barraAdmin')

@section('conteudo')

    &nbsp;
    <div class='row'>
        <div class='col-sm-12'>
            <h2>Ver Usuário</h2>
        </div>
    </div>
    &nbsp;

    <div class="container">
        <p><b>Id: </b>{{$reg->id}}</p>
        <p><b>Nome: </b>{{$reg->nome}}</p>
        <p><b>Email: </b>{{$reg->email}}</p>
        <p><b>Telefone: </b>{{$reg->telefone}}</p>
        <p><b>Ativo: </b><?php echo ($reg->ativo === 1) ? 'Sim' : 'Não'; ?></p>
        <p><b>Nº de Imóveis Cadastrados: </b></p>
    </div>
@endsection