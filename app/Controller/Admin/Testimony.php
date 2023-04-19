<?php

namespace App\Controller\Admin;

use \App\Utils\View;
use \App\Model\Entity\Testimony as EntityTestimony;
use \WilliamCosta\DatabaseManager\Pagination;

class Testimony extends Page
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
        $itens = '';

        //QUANTIDADE TOTAL DE REGISTRO
        $quantidadeTotal = EntityTestimony::getTestimonies(null,null,null,'COUNT(*) as qtd')->fetchObject()->qtd;
       
        //PÁGINA ATUAL
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;
        
        //INSTÂNCIA DE PAGINAÇÃO
        $obPagination = new Pagination($quantidadeTotal,$paginaAtual,5);
        /*echo "<pre>";
        print_r($obPagination);
        echo "<pre>"; exit;*/

        //RESULTADOS DA PÁGINA
        $results = EntityTestimony::getTestimonies(null,'id DESC',$obPagination->getLimit());

        //RENDERIZA O ITEM
        while($ObTestimony = $results->fetchObject(EntityTestimony::class))
        {
            //VIEW DE DEPOIMENTOS
            $itens .= View::render('admin/modules/testimonies/item',[
                'id'     => $ObTestimony->id,
                'nome'     => $ObTestimony->nome,
                'mensagem' => $ObTestimony->mensagem,
                'data'     => date('d/m/Y H:i:s', strtotime($ObTestimony->data))
            ]);
        }

        //RETORNA OS DEPOIMENTOS
        return $itens;
    }

    /**
     * Método responsável por renderizar a view de listagem de depoimentos
     * @param Request $request
     * @return string
     */
    public static function getTestimonies($request)
    {
        //CONTEÚDO DA HOME
        $content = View::render('admin/modules/testimonies/index', [
          'itens' =>  self::getTestimonyItems($request,$obPagination)
        ]);

        //RETORNA A PÁGINA COMPLETA
        return parent::getPanel('Depoimentos > WDEV', $content,'testimonies');
    }
}
