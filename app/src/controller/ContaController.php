<?php

namespace Itworks\src\controller;

use Itworks\src\model\ContaModel;

class ContaController{

    private $contaModel;

    public function __construct()
    {
        $this->contaModel = new ContaModel();
    }

    /**
     * Carrega a página principal
     *
     * @return void
     */
    public function index(){

        $listaExtrato = $this->contaModel->getAll();

        require('../app/src/view/conta/main.php');
    }
    public function extrato(){
        echo "Extrato da Conta";

        $obj = new \stdClass();
        $obj->valor = 10.99;
        $obj->movimentacao = 'CREDITO';
        $obj->dataRegistro = date('Y-m-d H:i:s');

        $result = $this->contaModel->insert($obj);  
        
        if ($result <= 0) {
            echo 'Erro';
        }
        else {
            echo 'Sucesso';
        }
        
    }
}