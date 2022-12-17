<?php

namespace Itworks\src\controller;

use Itworks\core\Controller;
use Itworks\src\model\ContaModel;
use Itworks\classes\Input;

class ContaController extends Controller{

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

        $this->load('conta/main', ['listaExtrato' => $listaExtrato] );
    }

    public function novo()
    {
        $this->load('conta/novo');
    }


    public function salvar(){
        $registro = $this->getInputPost();
        
        $result = $this->contaModel->insert($registro);  
        
        if ($result <= 0) {
            echo 'Erro';
        }
        else {
            redirect(BASE . 'conta-editar?id=' . $result);
        }
       
    }

    /**
     * Retorna os dados do formulário em uma classe padrão stdObject
     *
     * @return object
     */
    private function getInputPost()
    {

        return (object)[
            'valor'        => Input::post(  
                                            'txtValor', 
                                            FILTER_SANITIZE_NUMBER_FLOAT,
                                            FILTER_FLAG_ALLOW_FRACTION
                                        ),
            'movimentacao' => Input::post(
                                            'selMovimentacao',
                                            FILTER_UNSAFE_RAW
                                        )
        ];
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
/**
     * Carrega a página com o formulário para editar um registro
     *
     * @return void
     */
    public function editar()
    {
        $id = Input::get('id');

        $conta = $this->contaModel->getById( (int)$id );

        $this->load(
                'conta/editar', 
                [ 
                    'conta' => $conta 
                ] 
        );
    }



}