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
          'itens'      =>  self::getTestimonyItems($request,$obPagination),
          'pagination' => parent::getPagination($request, $obPagination),
          'status' => self::getStatus($request)
        ]);

        //RETORNA A PÁGINA COMPLETA
        return parent::getPanel('Depoimentos > WDEV', $content,'testimonies');
    }

    /**
     * Método responsável por retornar o formulário de cadastro de um novo depoimento
     * @param Request $request
     * @return string
     */
    public static function getNewTestimony($request)
    {
          //CONTEÚDO DO FORMULÁRIO
          $content = View::render('admin/modules/testimonies/form', [
            'title'    => 'Cadastrar depoimento',
            'nome'     => '',
            'mensagem' => '',
            'status'   => ''
          ]);
  
          //RETORNA A PÁGINA COMPLETA
          return parent::getPanel('Cadastrar depoimento > WDEV', $content,'testimonies');
      }
      
    /**
     * Método responsável por cadastrar um depoimento no banco
     * @param Request $request
     * @return string
     */
    public static function setNewTestimony($request)
    {
        //POST VARS
        $postVars = $request->getPostVars();
        
        //NOVA INSTÂNCIA DE DEPOIMENTO
        $ObTestimony = new EntityTestimony;
        $ObTestimony->nome     = $postVars['nome'] ?? '';
        $ObTestimony->mensagem = $postVars['mensagem'] ?? '';
        $ObTestimony->cadastrar();

       //REDIRECIONA O USUÁRIO
       $request->getRouter()->redirect('/admin/testimonies/'.$ObTestimony->id.'/edit?status=created');
    }

    /**
     * Método responsável por retornar a mensagem de status
     * @param Request $request
     * @return string
     */
    private static function getStatus($request)
    {
        //QUERY PARAMS
        $queryParams = $request->getQueryParams();
        
        //STATUS
        if(!isset($queryParams['status'])) return '';

        //MENSAGENS DE STATUS
        switch ($queryParams['status']) {
            case 'created':
                return Alert::getSuccess('Depoimento criado com sucesso!');
                break;
            case 'updated':
                return Alert::getSuccess('Depoimento atualizado com sucesso!');
                 break;
            case 'deleted':
                return Alert::getSuccess('Depoimento excluído com sucesso!');
                 break;
        }
    }

    /**
     * Método responsável por retornar o formulário de edição de um depoimento
     * @param Request $request
     * @param integer $id
     * @return string
     */
    public static function getEditTestimony($request,$id)
    {
        //OBTÉM O DEPOIMENTO DO BANCO DE DADOS
        $ObTestimony = EntityTestimony::getTestimonyById($id);
        

        //VALIDA A INSTÂNCIA
        if(!$ObTestimony instanceof EntityTestimony)
        {
            $request->getRouter()->redirect('/admin/testimonies');
        }

          //CONTEÚDO DO FORMULÁRIO
          $content = View::render('admin/modules/testimonies/form', [
            'title'    => 'Editar depoimento',
            'nome'     => $ObTestimony->nome,
            'mensagem' => $ObTestimony->mensagem,
            'status'   => self::getStatus($request)
          ]);
  
          //RETORNA A PÁGINA COMPLETA
          return parent::getPanel('Editar depoimento > WDEV', $content,'testimonies');
      }

        /**
     * Método responsável por gravar a atualização de um depoimento
     * @param Request $request
     * @param integer $id
     * @return string
     */
    public static function setEditTestimony($request,$id)
    {
        //OBTÉM O DEPOIMENTO DO BANCO DE DADOS
        $ObTestimony = EntityTestimony::getTestimonyById($id);
        

        //VALIDA A INSTÂNCIA
        if(!$ObTestimony instanceof EntityTestimony)
        {
            $request->getRouter()->redirect('/admin/testimonies');
        }

        //POST VARS
        $postVars = $request->getpostVars();

        //ATUALIZA A INSTÂNCIA
        $ObTestimony->nome = $postVars['nome'] ?? $ObTestimony->nome;
        $ObTestimony->mensagem = $postVars['mensagem'] ?? $ObTestimony->mensagem;
        $ObTestimony->atualizar();

       //REDIRECIONA O USUÁRIO
       $request->getRouter()->redirect('/admin/testimonies/'.$ObTestimony->id.'/edit?status=updated');
    }

     /**
     * Método responsável por retornar o formulário de exclusão de um depoimento
     * @param Request $request
     * @param integer $id
     * @return string
     */
    public static function getDeleteTestimony($request,$id)
    {
        //OBTÉM O DEPOIMENTO DO BANCO DE DADOS
        $ObTestimony = EntityTestimony::getTestimonyById($id);

        //VALIDA A INSTÂNCIA
        if(!$ObTestimony instanceof EntityTestimony)
        {
            $request->getRouter()->redirect('/admin/testimonies');
        }

          //CONTEÚDO DO FORMULÁRIO
          $content = View::render('admin/modules/testimonies/delete', [
            'nome'     => $ObTestimony->nome,
            'mensagem' => $ObTestimony->mensagem,
          ]);
  
          //RETORNA A PÁGINA COMPLETA
          return parent::getPanel('Excluir depoimento > WDEV', $content,'testimonies');
      }

         /**
     * Método responsável por excluir um depoimento
     * @param Request $request
     * @param integer $id
     * @return string
     */
    public static function setDeleteTestimony($request,$id)
    {
        //OBTÉM O DEPOIMENTO DO BANCO DE DADOS
        $ObTestimony = EntityTestimony::getTestimonyById($id);
        

        //VALIDA A INSTÂNCIA
        if(!$ObTestimony instanceof EntityTestimony)
        {
            $request->getRouter()->redirect('/admin/testimonies');
        }

        //EXCLUIR O DEPOIMENTO
        $ObTestimony->excluir();

       //REDIRECIONA O USUÁRIO
       $request->getRouter()->redirect('/admin/testimonies?status=deleted');
    }


}
      

