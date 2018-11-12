@extends('administrador.barraAdmin')

@section('conteudo')

<?php

function corStatus($status)
{
    if ($status == 1) {
        return "";
    } else {
        return "green";
    }
}

?>
&nbsp;
<div class="row">
    <div class="col-sm-12">
        <h2>Lista de Relatórios de Erros</h2>
    </div>
</div>
&nbsp;

<div class="container">
  <table class="table table-striped">
    <thead>
      <tr>
          <th>Status</th>
          <th>Usuário</th>
          <th>Ações</th>
      </tr>
    </thead>
    <tbody>
      @foreach($relatorios as $relatorio)
      <tr>
          <td style="color:<?php echo corStatus($relatorio->status);?>"><input type="checkbox" value="" id="<?=$relatorio->id?>"
                         onclick="window.location.href='{{route('relatErros.alterar_status', $relatorio->id)}}'"><b>&nbsp;&nbsp;<?php echo ($relatorio->status === 1) ? 'Não Resolvido' : 'Resolvido'?></b></td>
          <script>
                document.getElementById(<?=$relatorio->id?>).checked = (<?=$relatorio->status === 2?>);
          </script>
          <td><a href="{{route('users.show', $relatorio->usuario->id)}}">{{$relatorio->usuario->nome}}</a></td>
          <td>
            <a href="{{route('relatErros.show', $relatorio->id)}}" class="btn btn-info">Ver</a>
            <form style="display : inline-block"
                    method="POST"
                    action="{{route('relatErros.destroy', $relatorio->id)}}"
                    onsubmit="return confirm('Tem certeza que deseja excluir esta relatório?')">
                    {{ method_field('delete') }}
                    @csrf
                    <button type="submit"
                            class="btn btn-danger">Excluir</button>
              </form>
          </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>

@endsection
