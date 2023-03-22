<?php

require __DIR__ . '/vendor/autoload.php';

use \App\Http\Router;
use App\Utils\View;
use \WilliamCosta\DotEnv\Environment;

//CARREGA VARIÁVEIS DE AMBIENTE
Environment::load(__DIR__);

//DEFIBE A CONSTANTE DE URL DO PROJETO
define('URL', getenv('URL'));


/*echo "<pre>";
print_r(getenv('URL'));
echo "</pre>"; exit;*/

//DEFINE O VALOR PADRÃO DAS VARIÁVEIS
View::init([
        'URL' =>URL
]);

//INICIA O ROUTER
$obRouter = new Router(URL);

//INCLUI AS ROTAS DE PÁGINA
include __DIR__ . '/routes/pages.php';

//IMPRIME O RESPONSE DA ROTA
$obRouter->run()
        ->sendResponse();

