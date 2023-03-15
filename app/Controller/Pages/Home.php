<?php

namespace App\Controller\Pages;

use \App\Utils\View;

class Home extends Page{

    /**
     * Método responsável por retornar o conteúdo (view) da nossa home
     * @return string
     */
    public static function getHome(){
        //VIEW DA HOME
      $content =  View::render('pages/home',
        [
            'name' => 'WDEV - Canal',
            'description' => 'Canal do youtube: https://youtube.com.br/wdevoficial',
            'site' => 'https://youtube.com.br/wdevoficial',
        ]);

        //RETORNA A VIEW DA PÁGINA
        return parent::getPage('WDEV - Canal - HOME', $content);

    }
}