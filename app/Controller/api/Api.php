<?php

namespace App\Controller\Api;

/**
 * Método responsável por retornar os detalhes da API
 * @param Request $request
 * @return array
 */
class Api
{
    public static function getDetails($request)
    {
        return
        [
            'nome'   => 'API - WDEV',
            'versao' => 'v1.0.0',
            'autor'  => 'Loony',
            'email'  => 'loonydarck@hotmail.com',
        ];
    }

    /**
     * Método responsável por retornar os detalhes da paginação
     * @param Request $request
     * @param Pagination $$obPagination
     * @return type array
     */
    protected static function getPagination($request,$obPagination)
    {
        //QUERY PARAMS
        $queryParams = $request->getQueryParams();

        //PÁGINA
        $pages = $obPagination->getPages();

        //RETORNO
        return 
        [
            'paginaAtual'       => isset($queryParams['page']) ?  $queryParams['page'] : 1,
            'quantidadePaginas' => !empty($pages) ? count($pages) : 1
        ];

    }

}