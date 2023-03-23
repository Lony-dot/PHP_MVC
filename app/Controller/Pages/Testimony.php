<?php

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Model\Entity\Testimony as EntityTestimony;


class Testimony extends Page{

    /**
     * Método responsável por retornar o conteúdo (view) de depoimentos
     * @return string
     */
    public static function getTestimonies(){
   
        /*echo "<pre>";
        print_r($obOrganization);
        echo "</pre>"; exit;*/
        
        //VIEW DE DEPOIMENTOS
      $content =  View::render('pages/testimonies',
        [
           
        ]);

        //RETORNA A VIEW DA PÁGINA
        return parent::getPage('DEPOIMENTOS > WDEV', $content);

    }

    /**
     * Método responsável por cadastrar um depoimento
     * @param Request $request
     * @return string
     */
    public static function insertTestimony($request)
    {
      //DADOS DO POST
      $postVars = $request->getPostVars();

      //NOVA INSTÂNCIA DE DEPOIMENTO
      $obTestimony = new EntityTestimony;
      $obTestimony->nome = $postVars['nome'];
      $obTestimony->mensagem = $postVars['mensagem'];
      $obTestimony->cadastrar();

      return self::getTestimonies();
    }
}
