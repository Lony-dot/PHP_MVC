<?php

namespace App\Controller\Api;

use \App\Model\Entity\Testimony as EntityTestimony;
use \WilliamCosta\DatabaseManager\Pagination;
/**
 * Método responsável por retornar os depoimentos cadastrados
 * @param Request $request
 * @return array
 */
class Testimony extends Api
{
    /**
     * Método responsável por obter a renderização dos itens de depoimentos para a página
     * @param Request $request
     * @param Pagination $obPagination
     * @return string
     */
    private static function getTestimonyItems($request,&$obPagination)
    {
        //DEPOIMENTOS
        $itens = []; //deixaram de ser uma string '' para virarem um array [] para retornar os dados e não uma view renderizada.

        //QUANTIDADE TOTAL DE REGISTRO
        $quantidadeTotal = EntityTestimony::getTestimonies(null,null,null,'COUNT(*) as qtd')->fetchObject()->qtd;
       
        //PÁGINA ATUAL
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;
        
        //INSTÂNCIA DE PAGINAÇÃO
        $obPagination = new Pagination($quantidadeTotal,$paginaAtual,5);

        //RESULTADOS DA PÁGINA
        $results = EntityTestimony::getTestimonies(null,'id DESC',$obPagination->getLimit());

        //RENDERIZA O ITEM
        while($ObTestimony = $results->fetchObject(EntityTestimony::class))
        {
            //VIEW DE DEPOIMENTOS
            $itens[] = [
                'id'       => $ObTestimony->id,
                'nome'     => $ObTestimony->nome,
                'mensagem' => $ObTestimony->mensagem,
                'data'     => $ObTestimony->data
            ];
        }

        //RETORNA OS DEPOIMENTOS
        return $itens;
    }

    public static function getTestimonies($request)
    {
        return
        [
            'depoimentos' => self::getTestimonyItems($request,$obPagination),
            'pagination' => parent::getPagination($request, $obPagination)
        ];
    }

    /**
     * Método responsável por  retornar os detalhes de um depoimento
     * @param Request $request
     * @param integer $id
     * @return array
     */
    public static function getTestimony($request,$id)
    {
        //VALIDA O ID DO DEPOIMENTO
        if(!is_numeric($id))
        throw new \Exception("O id '".$id."' não é válido", 400);

        //BUSCA DEPOIMENTO
        $obTestimony = EntityTestimony::getTestimonyById($id);

        //VALIDA SE O DEPOIMENTO EXISTE
        if (!$obTestimony instanceof EntityTestimony) 
        {
            throw new \Exception("O depoimento ".$id." não foi encontrado", 404);
            
        }

        //RETORNA OS DETALHES DO DEPOIMENTO
        return [
            'id'       => $obTestimony->id,
            'nome'     => $obTestimony->nome,
            'mensagem' => $obTestimony->mensagem,
            'data'     => $obTestimony->data
        ];
    }

    /**
     * Método responsável por cadastrar um novo depoimento
     * @param Request $request
     */
    public static function setNewTestimony($request)
    {
        return
        [
            'sucesso' => true
        ];
    }
    

} 