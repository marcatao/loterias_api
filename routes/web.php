<?php


$router->get('/', 'EndPointController@index');                          
$router->get('/account', 'RegisterController@register_form');           
$router->post('/account','RegisterController@store');                   
$router->get('/login','RegisterController@login_form');                 
$router->post('/login','TokenController@gerarToken');                   
          
$router->post('/lotofacil/create', 'LotofacilController@create'); 

$router->get('/lotofacil', 'LotofacilController@index_get');


//Autenticade routes
$router->group(['middleware' => 'autenticador'], function () use ($router) {
    $router->post('/lotofacil/concurso', 'LotofacilController@index');
    $router->post('/lotofacil/concurso/{id}', 'LotofacilController@index');
});

 