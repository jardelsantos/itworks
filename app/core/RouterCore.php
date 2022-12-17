<?php

namespace Itworks\core;

class RouterCore
{
    private $uri;
    private $method;
    private $getArr = [];

    public function __construct(){
        $this->initial();
        require_once('../app/config/router.php');
        $this->execute();

    }  

    private function initial(){
        $this->method = $_SERVER['REQUEST_METHOD'];
        
        //http://localhost:8081/home?nome=pedro&sobrenome=santos
        $uri_initial = $_SERVER['REQUEST_URI'];
        
        //TRUE
        if (strpos($uri_initial, '?')){
            //http://localhost:8081/home/
            $uri_initial = mb_substr(
                $uri_initial, 
                0, 
                strpos($uri_initial, '?')
            );
        }
        //http://localhost:8081/home
        $ex = explode('/', $uri_initial);

        //[0] => http: [1] =>localhost:8081 [2] =>home
        $uri = array_values(array_filter($ex));
        
         //[0] =>home
        for ($i = 0; $i < UNSET_URI_COUNT; $i++) {
            unset($uri[$i]);
        }
        //IMPLODE TRANSFORMA O ARRAY EM STRING
        //[0] => HOME [1]=>CASA_E_DECORACAO
        //HOME/CASA_E_DECORACAO

        //home
        $this->uri = implode('/', $this->normalizeURI($uri));

        if (DEBUG_URI){
            echo '<pre>';
                print_r($this->uri);
            echo '</pre>';
        }
    }

    private function normalizeURI($arr)
    {
        return array_values(array_filter($arr));
    }

    private function execute()
    {
        switch ($this->method) {
            case 'GET':
                $this->executeGet();
                break;
            case 'POST':
                $this->executePost();
                break;
        }
    }

    private function executeGet()
    {
        foreach ($this->getArr as $get) {
            $r = substr($get['router'], 1);

            if (substr($r, -1) == '/') {
                $r = substr($r, 0, -1);
            }
            if ($r == $this->uri) {
                if (is_callable($get['call'])) {
                    $get['call']();
                    break;
                } else {
                    $this->executeController($get['call']);
                }
            }
        }
    }

    private function executePost()
    {
        foreach ($this->getArr as $get) {
            $r = substr($get['router'], 1);

            if (substr($r, -1) == '/') {
                $r = substr($r, 0, -1);
            }

            if ($r == $this->uri) {
                if (is_callable($get['call'])) {
                    $get['call']();
                    return;
                }

                $this->executeController($get['call']);
            }
        }
    }

    private function executeController($get)
    {
        $ex = explode('@', $get);
        if (!isset($ex[0]) || !isset($ex[1])) {
            (new \Itworks\core\Controller)->showMessage(
                'Dados inválidos', 
                'Controller ou método não encontrado: ' . $get, 
                null, 
                404
            );
            return;
        }

        $cont = 'Itworks\\src\\controller\\' . $ex[0];
        if (!class_exists($cont)) {
            (new \Itworks\core\Controller)->showMessage(
                'Dados inválidos', 
                'Controller não encontrada: ' . $get, 
                null,
                404
            );
            return;
        }


        if (!method_exists($cont, $ex[1])) {
            (new \Itworks\core\Controller)->showMessage(
                'Dados inválidos', 
                'Método não encontrado: ' . $get, 
                null,
                404
            );
            return;
        }

        call_user_func_array([
            new $cont,
            $ex[1]
        ], []);
    }

    private function get($router, $call)
    {
        $this->getArr[] = [
            'router' => $router,
            'call' => $call
        ];
    }

    private function post($router, $call)
    {
        $this->getArr[] = [
            'router' => $router,
            'call' => $call
        ];
    }

}
