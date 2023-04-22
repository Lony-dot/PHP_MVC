<?php

use \App\Http\Response;
use \App\Controller\Api;

//ROTA DE LISTAGEM DE DEPOIMENTOS
$obRouter->get('/api/v1/testimonies',[
    function($request)
    {
        return new Response(200,Api\Testimony::getTestimonies($request), 'application/json');
    }
]);