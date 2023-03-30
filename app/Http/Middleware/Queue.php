<?php

namespace App\Http\Middleware;

class Queue
{

    /**
     * Mapeamento de middlewares
     * @var array
     */
    private static $map = [];
    
    /**
     * Fila de middlewares a serem executados
     * @var array
     */
    private $middlewares = [];

    /**
     * Função de execução do controlador
     * @var Closure
     */
    private $controller;

    /**
     * Argumentos da função do controlador
     * @var array
     */
    private $controllerArgs = [];

    /**
     * Método responsável por contruir a classe de fila de middlewares
     * @param array $middlewares
     * @param Closure $controller
     * @param array $controllerArgs
     */
    public function __construct($middlewares, $controller, $controllerArgs)
    {
        $this->middlewares    = $middlewares;
        $this->controller     = $controller;
        $this->controllerArgs = $controllerArgs;
    }

    /**
     * Método responsável por definir o mapeamento de middlewares
     * @param array $map
     */
    public static function setMap($map)
    {
        self::$map = $map;
    }


    /**
     * Método responsável por executar o próximo nível da fila de middlewares
     * @param Request $request
     * @return Response
     */
    public function next($requet)
    {
        //Valida instancia de controller
        if (!is_callable($this->controller)) {
            throw new \Exception("Tipo esperado 'callable'. Mas veio  '...\Middleware\Closure'");
        }

      //VERIFICA SE A FILA ESTÁ VAZIA
      if(empty($this->middlewares)) return call_user_func_array($this->controller, $this->controllerArgs);
      
   
      //MIDDLEWARE
      $middleware = array_shift($this->middlewares);

      
      //VERIFICA O MAPEAMENTO
      if(!isset(self::$map[$middleware]))
      {
        throw new \Exception("Problemas ao processar o middleware da requisição", 500);
      }
    
      //NEXT

    }

}