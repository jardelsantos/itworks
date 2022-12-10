<?php

namespace Itworks\src\model;
use Itworks\core\Model;

/**
 * Classe responsável por gerenciar a conexão com a tabela conta.
 */
class ContaModel
{
    //Instância da classe model
    private $pdo;

    /**
     * Método construtor
     *
     * @return void
     */
    public function __construct()
    {
        $this->pdo = new Model();
    }
}