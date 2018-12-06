@extends('usuario.barraUsuario')

@section('conteudo')

<div class='col-sm-12'>
    <h2 style="margin-top:10px">Gráfico de Despesas</h2>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Nome (apelido) do Imóvel', 'Total de Despesas'],
@foreach ($imoveis as $imovel)
{!! "['$imovel->nomeImovel', $imovel->somaDespesas]," !!}          
@endforeach
        ]);
        var options = {
          title: 'Imóveis por Total de Despesas',
          is3D: true,
        };
        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
        chart.draw(data, options);
      }
    </script>

    <div id="piechart_3d" style="width: 900px; height: 500px;"></div>
    
</div>

@endsection