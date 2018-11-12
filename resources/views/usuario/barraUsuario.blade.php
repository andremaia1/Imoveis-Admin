<!DOCTYPE html>
<html lang="en">
<head>
  <title>Imoveis Admin</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.11/css/all.css" integrity="sha384-p2jx59pefphTFIpeqCcISO9MdVfIm4pNnsL08A6v5vaQc4owkQqxMV8kg4Yvhaw/" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
</head>
<body>

<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
  <!-- Brand/logo -->
  <a class="navbar-brand" href="#">Imoveis Admin</a>
  
  <!-- Links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" href="{{route('usuario.index')}}">Imóveis</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{route('locacoes.index')}}">Locações</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{route('condominios.index')}}">Condomínios</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{route('despesas.index')}}">Despesas</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{route('multas.index')}}">Multas</a>
    </li>
  </ul>
  <ul class="navbar-nav ml-auto">
    <li class="nav-item">
        <a class="nav-link" href="{{route('relatErro.criar')}}">Relatar Erro</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#"><i class="fas fa-user"></i> {{Auth::user()->nome}}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{route('usuario.logout')}}"><i class="fas fa-arrow-right"></i> Sair</a>
    </li>
  </ul>
</nav>

<div class="container">
  @yield('conteudo')
</div>

</body>
</html>


