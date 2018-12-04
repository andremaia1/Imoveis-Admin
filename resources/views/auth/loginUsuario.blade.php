<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <title>Imoveis Admin</title>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
    <body>

        <div class="container">
            <div class="row">
                <div class="col-sm-8">
                    <div class="div_logo">
                        <img style="width:100%; margin-top:20%; margin-left:-5%" src="/imagens/logoMarcaSistema.png" alt="logoMarca">
                        <blockquote class="blockquote-reverse">
                            <p style="font-size:120%">Controle seus alugueis de forma simples e de qualquer lugar</p>
                        </blockquote>
                    </div>
                </div>
                <div style="margin-top:5%" class="col-sm-4 panel panel-default div_tab">
                    <h3 align="center">Entre ou Inscreva-se</h3>

                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#entrar">Entrar</a></li>
                        <li><a data-toggle="tab" href="#inscrever">Inscrever-se</a></li>
                    </ul>

                    <div class="tab-content">
                        <br/>
                        <div id="entrar" class="tab-pane fade in active">
                            <form action="{{route('usuario.logar')}}" method="POST">
                                @csrf

                                <!-- Mensagem do sitema -->
                                @if ($errors->has('mensagem')) 
                                <div class="col-sm-12 text-center alert alert-danger  fade in form-group{{ $errors->has('mensagem') ? ' has-error' : '' }}">
                                    <!-- Mesagem de ERRO -->
                                    <span>
                                        <strong>{{ $errors->first('mensagem') }}</strong>
                                    </span>
                                </div>
                                @endif
                                    @if (session('sucess'))
                                        <div class="alert alert-success">
                                            {{ session('sucess') }}
                                        </div>
                                    @endif

                                <div class="form-group email">
                                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                        <label for="email">E-mail:</label>
                                        <input type="text" class="form-control" id="email"  name="email" value="{{ old('email') }}" required autofocus"/>
                                               @if ($errors->has('email'))
                                               <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group password">
                                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                        <label for="password">Senha:</label>
                                        <input type="password" class="form-control" id="password" name="password"/>
                                        @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="form-group{{ $errors->has('erroLogin') ? ' has-error' : '' }} text-center">
                                    @if ($errors->has('erroLogin'))
                                        <strong style='color : red'>{{ $errors->first('erroLogin') }}</strong>
                                    @endif
                                </div>
                                
                                <div class="form-group text-center">
                                    <button style="padding-left:10%; padding-right:10%" type="submit" class="btn btn-primary"> Entrar </button>
                                </div>


                            </form>
                            
                        </div>

                        <div id="inscrever" class="tab-pane fade">
                            <form method="POST" action="{{route('usuario.cadastrar')}}">
                                @csrf

                                <!-- Mensagem do sitema -->
                                @if ($errors->has('mensagem')) 
                                <!-- Mesagem de ERRO -->
                                <div class="col-sm-12 text-center alert alert-danger  fade in form-group{{ $errors->has('mensagem') ? ' has-error' : '' }}">
                                    <span>
                                        <strong>{{ $errors->first('mensagem') }}</strong>
                                    </span>
                                </div>
                                @endif
                                <div class="form-group">
                                    <label for="nome">Nome:</label>
                                    <input type="text" class="form-control" id="nome"  name="nome" placeholder="Nome Completo"/>
                                </div>
                                <div class="form-group">
                                    <label for="email">E-mail:</label>
                                    <input type="text" class="form-control" id="email"  name="email" placeholder="Email"/>
                                </div>
                                <div class="form-group">
                                    <label for="password">Senha:</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Senha"/>
                                </div>
                                <div class="form-group">
                                    <label for="telefone">Telefone:</label>
                                    <input type="telefone" class="form-control" id="telefone" name="telefone" placeholder="Nº Telefone"/>
                                </div>
                                <div class="form-group text-center">
                                    <button style="padding-left:10%; padding-right:10%" type="submit" class="btn btn-primary"> Inscrever </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="navbar-fixed-bottom">

        </div>
    </body>
</html>
