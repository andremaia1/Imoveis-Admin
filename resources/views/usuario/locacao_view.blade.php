@extends('usuario.barraUsuario')

@section('conteudo')

    &nbsp;
    <div class='row'>
        <div class='col-sm-12'>
            <h2>Ver Locação</h2>
        </div>
    </div>

    <div class="container">
        <hr style="background-color:gainsboro">
        <p><b>Imóvel: </b>{{$locacao->imovel->nome_apelido}}</p>
        <p><b>Locatário: </b>{{$locacao->locatario->nome}}</p>
        <p><b>Valor (R$): </b>{{$locacao->valor}}</p>
        <p><b>Data de Início do Contrato: </b>{{date_format(new DateTime($locacao->inicioContrato), 'd/m/Y')}}</p>
        <p><b>Data da Última Renovação do Contrato: </b>{{date_format(new DateTime($locacao->ultimaRenovacao), 'd/m/Y')}}</p>
        <hr style="background-color:gainsboro">
    </div>
@endsection