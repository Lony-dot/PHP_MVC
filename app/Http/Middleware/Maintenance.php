<?php

namespace App\Http\Middleware;

class Maintenance
{
    /**
     * Método responsável por executar as ações do middleware
     * @param  Request $request
     * @param  Closure $next
     * @return Response
     */
    public function handle($request, $next)
    {
      echo "<pre>";
        print_r($request);
      echo "</pre>"; EXIT;
    }
}