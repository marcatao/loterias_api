<h1>#API Loterias</h1>

<p>Esta api surgiu da necessidade de colher de forma mais estruturada os dados dos sorteios da loteria. Estamos em uma versao de testes ainda aberto a todos utilização gratuita e ilimitada.</p>

<h3>Requirements</h3>
<ul>
    <li>php >= v7.2.31  .</li>
</ul>

<hr>
<h3>Steps to run</h3>
<ul>
<li>Download the content.</li>
<li>Run the composer require  - <i>composer require</i>.</li>

<li>Configure your env file:<br>
    <i>DB_CONNECTION= - Select your connection database <br>
    MAIL_DRIVER=sendgrid <br> 
    SENDGRID_API_KEY= - Your sendgrid Api Key <br>
    MAIL_FROM= - Email to send emails from sendgrid exemple@teste.com <br>
    PATH_API=  - Yor Domain <br>
    JWT_KEY= - key of your choice<br>
    P.S.: example in .env.example
    </i>
</li>
<li>Run the migrations - <i>php artisan migrate</i>.</li>

</ul>

<h3>URL's (routes) </h3>
<h5>Without authentication</h5>
<ul>
<li> Method: <b>get   '/' </b>controller: 'EndPointController@index</li>
<li> Method: <b>get  </b> '/account'</b>controller: 'RegisterController@register_form</li>
<li> Method: <b>post </b> '/account'</b>controller:'RegisterController@store</li>
<li> Method: <b>get  </b> '/login'</b>controller:'RegisterController@login_form</li>
<li> Method: <b>post </b> '/login'</b>controller:'TokenController@gerarToken</li>
</ul>

<h5>With authentication</h5>
<p>This application uses <b>firebase/php-jwt</b> to authentication on header from request with param "Authotization".</p>
<ul>
<li> Method: <b>post  '/lotofacil/concurso'</b> controller: LotofacilControllerController@index</li>
<li> Method: <b>post  '/lotofacil/concurso/{concurso_numero}'</b> controller: LotofacilControllerController@index</li>
</ul>

<hr>
<p>Developed by Thiago Marcato</p>