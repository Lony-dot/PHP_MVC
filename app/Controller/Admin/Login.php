<?php

namespace App\Controller\Admin;

use App\Utils\View;

class Login extends Page
{
    /**
     * Método responsável por retornar a renderização da página de login
     * @param Request $request
     * @return string 
     */
    public static function getLogin($request)
    {
        //CONTEÚDO DA PÁGINA DE LOGIN
        $content = View::render('admin/login',[]);

        //RETORNA A PÁGINA COMPLETA
        return parent::getPage('Login > WDEV', $content);
    }

    /**
     * Método responsável por definir o login do usuário
     * @param Request $request
     */
    public static function setLogin($request)
    {
        //POST VARS
        $postVars = $request->getPostVars();
        $email    = $postVars['email'] ?? '';
        $senha    = $postVars['senha'] ?? '';
    }
}