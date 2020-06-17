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
        {{ env('PATH_API')}}?token=<b style="color:#1fa1b4;">TOKEN_DE_ACESSO</b>&amp;sorteio=<b style="color:#1fa1b4;">NUMERO_SORTEIO</b>
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
      <p style="font-size: 16px;font-weight: 300;">Uma resposta típica é composta por um JSON.</p>
      <p style="font-size: 14px;font-weight: 300;"><b style="color:#ef678e;">Atenção:</b> utilize o CNPJ <b>06990590000123</b> como modo SandBox (teste) para que não seja efetuada cobrança nos créditos contratados.</p>
      <br>
      <div class="row">
        <div class="col-md-5">
          <input type="text" class="form-control" id="token-teste" placeholder="Token" value="">
          <hr>
          <input type="text" class="form-control" id="sorteio-teste" placeholder="CNPJ">
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


</div>
@endsection

@section('scripts')
<script>
function testarApi(){
 
  var token = $('#token-teste').val();
  var sorteio = $('#sorteio-teste').val();


  $.ajax(
  {
    url: '{{ env('PATH_API')}}/lotofacil?token='+token+'$sorteio='+sorteio ,
    method:'GET',
    complete: function(xhr){

      var jsonObj = JSON.parse(xhr.responseText);
      var jsonPretty = JSON.stringify(jsonObj, null, '\t');

      $('#textarea-result-teste').val(jsonPretty);

      $('#btn-testar').html("<span class='mdi mdi-play-circle' style='color:#fbbf0f;font-size:18px;'></span>&nbsp;&nbsp;Testar</button>");
      $('#btn-testar').prop("disabled",false);
    }
  });
}    
</script>
@endsection