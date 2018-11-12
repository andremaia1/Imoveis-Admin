@extends('administrador.barraAdmin')

@section('conteudo')

    &nbsp;
    <div class='row'>
        <div class='col-sm-12'>
            <h2>Ver Relatório de Erro</h2>
        </div>
    </div>

    <div class="container">
        <hr style="background-color:gainsboro">
        <p><b>Id: </b>{{$relatorio->id}}</p>
        <p><b>Status: </b><?php echo ($relatorio->status === 1) ? 'Não Resolvido' : 'Resolvido'; ?></p>
        <p><b>Usuário: </b>{{$relatorio->usuario->nome}}</p>
        <p><b>Descrição: </b>{{$relatorio->descricao}}</p>
        <hr style="background-color:gainsboro">
    </div>
@endsection