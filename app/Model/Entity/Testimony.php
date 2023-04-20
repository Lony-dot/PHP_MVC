<?php

namespace App\Model\Entity;

use \WilliamCosta\DatabaseManager\Database;

class Testimony
{
    /**
     * ID do depoimento
     * @var integer
     */
    public $id;

    /**
     * Nome do usuário que fez o  depoimento
     * @var string
     */
    public $nome;

    /**
     * Mensagem do depoimento
     * @var string
     */
    public $mensagem;

    /**
     * Data de publicação do depoimento
     * @var string
     */
    public $data;

    /**
     * Método responsável por cadastrar a instância atual no banco de dados
     * @return boolean
     */
    public function cadastrar()
    {

        //Configura horário de Brasília como horário padrão
        date_default_timezone_set('America/Sao_Paulo');

        //DEFINE A DATA
        $this->data = date('Y-m-d H:i:s');

        //INSERE O DEPOIMENTO NO BANCO DE DADOS
        $this->id = (new Database('depoimentos'))->insert([
            'nome' => $this->nome,
            'mensagem' => $this->mensagem,
            'data' => $this->data
           
        ]);
            
        //SUCESSO
        return true;
    }

    /**
     * Método responsável por atualizar os dados do banco com a instância atual
     * @return boolean
     */
    public function atualizar()
    {
        //ATUALIZA O DEPOIMENTO NO BANCO DE DADOS
         return (new Database('depoimentos'))->update('id = '.$this->id,[
            'nome' => $this->nome,
            'mensagem' => $this->mensagem
        ]);
    }

    /**
     * Método responsável por retornar um depoimento com base no seu ID
     * @param integer $id
     * @return Testimony
     */
    public static function getTestimonyById($id)
    {
        return self::getTestimonies('id = '.$id)->fetchObject(self::class);
    }

    /**
     *Método responsável por retornar Depoimentos
     *@param string $where
     *@param string $$order
     *@param string $limit 
     *@param string $field
     *@return PDOStatement
     */
    public static function getTestimonies($where = null, $order = null, $limit = null, $fields = '*')
    {
        return (new Database('depoimentos'))->select($where,$order,$limit,$fields);
    }

}