@extends('usuario.barraUsuario')

@php
    $indiceValor = 0;
@endphp

@section('conteudo')

    &nbsp;
    <div class='row'>
        <div class='col-sm-12'>
            <h2>Ver Pagamento</h2>
        </div>
    </div>

    <div class="container">
        <hr style="background-color:gainsboro">
        <p><b>Status:&nbsp;</b>{{$pagamento->status}}</p>
        <p><b>Data de Pagamento:&nbsp;</b><?php echo $pagamento->dataPagamento == null ? '---' : date_format(new DateTime($pagamento->dataPagamento), 'd/m/Y')?></p>
        <p><b>Data de Vencimento:&nbsp;</b>{{date_format(new DateTime($pagamento->dataVencimento), 'd/m/Y')}}</p>
        @foreach($itens as $item)
            <p><b>{{$item->nome_item.'(R$): '.$valores[$indiceValor]->valor}}</b></p>
        @php
            $indiceValor++;
        @endphp
        @endforeach
        <hr style="background-color:gainsboro">
    </div>
@endsection
