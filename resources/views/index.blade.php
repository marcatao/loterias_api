@extends('app.main')
@section('content')
<div class="container">

<div class="card media">
    <div class="card-header"><h2>(BETA) Documentação da API</h2></div>
 
    <div class="card-body">

    <div class="row">
      <div class="col-md-12">
        <p>Esta api surgiu da necessidade de colher de forma mais estruturada os dados dos sorteios da loteria. Estamos em uma versao de testes ainda aberto a todos utilização gratuita e ilimitada.</p>
      </div>
    </div>

      <h3>Recuperar dados de um soreteio da <strong>LOTOFÁCIL</strong></h3>
      <p style="">Método para recuperar as informações, incluindo a <strong>inscrição estadual</strong> de uma empresa brasileira através do seu CNPJ. <br>As informações são exatamente as mesmas retornadas pelo site do <strong>SINTEGRA</strong>.</p>
      <div style="background-color:#f6f6f6;">
        <div style="background-color:#eaeaea;padding:6px;">
          <h4>&nbsp;&nbsp;<button class="btn btn-space btn-warning hover btn-xs">GET</button><b> &nbsp;URL para requisição</b></h4>
        </div>
        <div style="position:relative;top:10px;left:10px;padding:10px;font-size: 16px;font-weight: 300;height:60px;">
        {{ env('PATH_API')}}/lotofacil?token=<b style="color:#1fa1b4;">TOKEN_DE_ACESSO</b>&amp;sorteio=<b style="color:#1fa1b4;">NUMERO_SORTEIO</b>
        </div>
      </div>
      <br>

      <h4 style="color:#aeb0c2;font-size:14px;"><b>Parâmetros</b> passados na API do LOTORÁPIDO</h4>

      <hr>

      <div class="row">
        <div class="col-md-1">
          <p style="font-size: 14px;font-weight: 300;"><strong>token</strong></p>
          <p style="font-size: 12px;font-weight: 300;color:#b4babd;">string</p>
        </div>
        <div class="col-md-11">
          <p class="text-danger"><b>OBRIGATÓRIO</b></p>
          <p style="font-size: 12px;font-weight: 300;">Após seu cadastro seu token está localizado em: Nossas APIs &gt; <a href="/login"> <b>Meu Token</b></a>.</p>
        </div>
      </div>

      <hr>

      <div class="row">
        <div class="col-md-1">
          <p style="font-size: 14px;font-weight: 300;"><strong>sorteio</strong></p>
          <p style="font-size: 12px;font-weight: 300;color:#b4babd;">string</p>
        </div>
        <div class="col-md-11">
          <p class="text-warning"><b>OPCIONAL</b></p>
          <p style="font-size: 12px;font-weight: 300;">Se nao for informado este campo a consulta retornara o ultimo sorteio lotofácil realizado .</p>
        </div>
      </div>

      <hr>

 

    </div>
  </div>
<br>
  <div class="card media">
    <div class="card-header"><h2>Exemplo de <strong>resposta</strong> da API</h2></div>
    <hr>
    <div class="card-body">
      <p style="font-size: 16px;font-weight: 300;">A resposta é composta por um JSON.</p>
      
      <br>
      <div class="row">
        <div class="col-md-5">
          <input type="text" class="form-control" id="token-teste" placeholder="Token" value="">
          <hr>
          <input type="text" class="form-control" id="sorteio-teste" placeholder="N° Sorteio (opcional)">
          <hr>
          
          <hr>
          <button class="btn btn-space btn-secondary btn-xl" id="btn-testar" onclick="testarApi()" style="width:100%"><span class="mdi mdi-play-circle" style="color:#fbbf0f;font-size:18px;"></span>&nbsp;&nbsp;Testar</button>
        </div>
        <div class="col-md-7">
          <textarea id="textarea-result-teste" class="form-control" style="background-color:#333840;border-color:#333840;color:#c5c8c6;height:270px;"></textarea>
        </div>

      </div>
      
    </div>
  </div>



<br>
<div class="card media">
      <div class="card-header">Campos de retorno da API <strong>LOTOFÁCIL</strong></div>
      <div class="card-body">
        <table class="table table-sm table-hover table-bordered table-striped">
          <thead>
            <tr>
              <th>Campo</th>
              <th>Tipo</th>
              <th>Descrição</th>
            </tr>
          </thead>
          <tbody>
               <tr><td><strong>concurso</td><td>INT</td><td>Numero do concurso</td></tr>
               <tr><td><strong>dt_sorteio</td><td>DATE</td><td> data do concurso</td></tr>
               <tr><td><strong>bola_1</td><td>INT</td><td> numero 1 sorteado</td></tr>
               <tr><td><strong>bola_2</td><td>INT</td><td> numero 2 sorteado</td></tr>
               <tr><td><strong>bola_3</td><td>INT</td><td> numero 3 sorteado</td></tr>
               <tr><td><strong>bola_4</td><td>INT</td><td> numero 4 sorteado</td></tr>
               <tr><td><strong>bola_5</td><td>INT</td><td> numero 5 sorteado</td></tr>
               <tr><td><strong>bola_6</td><td>INT</td><td> numero 6 sorteado</td></tr>
               <tr><td><strong>bola_7</td><td>INT</td><td> numero 7 sorteado</td></tr>
               <tr><td><strong>bola_8</td><td>INT</td><td> numero 8 sorteado</td></tr>
               <tr><td><strong>bola_9</td><td>INT</td><td> numero 9 sorteado</td></tr>
               <tr><td><strong>bola_10</td><td>INT</td><td> numero 10 sorteado</td></tr>
               <tr><td><strong>bola_11</td><td>INT</td><td> numero 11 sorteado</td></tr>
               <tr><td><strong>bola_12</td><td>INT</td><td> numero 12 sorteado</td></tr>
               <tr><td><strong>bola_13</td><td>INT</td><td> numero 13 sorteado</td></tr>
               <tr><td><strong>bola_14</td><td>INT</td><td> numero 14 sorteado</td></tr>
               <tr><td><strong>bola_15</td><td>INT</td><td> numero 15 sorteado</td></tr>
               <tr><td><strong>arrecadacao_total</td><td>DOUBLE</td><td> Valor arrecadado pelo concurso</td></tr>
               <tr><td><strong>ganhadores_15_numeros</td><td>INT</td><td> Quantidade de ganhadores 15 pontos</td></tr>
               <tr><td><strong>ganhadores_14_numeros</td><td>INT</td><td> Quantidade de ganhadores 14 pontos</td></tr>
               <tr><td><strong>ganhadores_13_numeros</td><td>INT</td><td> Quantidade de ganhadores 13 pontos</td></tr>
               <tr><td><strong>ganhadores_12_numeros</td><td>INT</td><td> Quantidade de ganhadores 12 pontos</td></tr>
               <tr><td><strong>ganhadores_11_numeros</td><td>INT</td><td> Quantidade de ganhadores 11 pontos</td></tr>
               <tr><td><strong>valor_rateio_15_numeros</td><td>DOUBLE</td><td> Valor ganho com 15 pontos</td></tr>
               <tr><td><strong>valor_rateio_14_numeros</td><td>DOUBLE</td><td> Valor ganho com 14 pontos</td></tr>
               <tr><td><strong>valor_rateio_13_numeros</td><td>DOUBLE</td><td> Valor ganho com 13 pontos</td></tr>
               <tr><td><strong>valor_rateio_12_numeros</td><td>DOUBLE</td><td> Valor ganho com 12 pontos</td></tr>
               <tr><td><strong>valor_rateio_11_numeros</td><td>DOUBLE</td><td> Valor ganho com 11 pontos</td></tr>
               <tr><td><strong>acumulado_15_numeros</td><td>DOUBLE</td><td> Valor acumulado com 15 pontos</td></tr>
               <tr><td><strong>estimativa_premio</td><td>DOUBLE</td><td> Premio estimado </td></tr>
               <tr><td><strong>valor_acumulado_especial</td><td>DOUBLE</td><td> Valor acumulado especial</td></tr>
        </tbody>
        </table>
      </div>
    </div>



</div>






@endsection

@section('scripts')
<script>
function testarApi(){
  var token = $('#token-teste').val();
  var sorteio = $('#sorteio-teste').val();
  $.ajax(
  {
    url: "{{ env('PATH_API') }}/lotofacil?token="+token+"&sorteio="+sorteio,
    method:'get',
    crossDomain: true,
    success: function (response) {
            $('#textarea-result-teste').html(response);
        },
        error: function (error) {
            $('#textarea-result-teste').html("['error' => '"+error.statusText+"']");
        }
  });
}    
</script>
@endsection