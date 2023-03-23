<?php

require __DIR__ . '/includes/app.php';

use \App\Http\Router;

/*echo "<pre>";
print_r(getenv('URL'));
echo "</pre>"; exit;*/


//INICIA O ROUTER
$obRouter = new Router(URL);

//INCLUI AS ROTAS DE PÁGINA
include __DIR__ . '/routes/pages.php';

//IMPRIME O RESPONSE DA ROTA
$obRouter->run()
         ->sendResponse();

