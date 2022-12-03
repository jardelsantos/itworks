<?php

namespace Itworks\core;

localhost/home

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
        
        $uri_initial = $_SERVER['REQUEST_URI'];
        
        if (strpos($uri_initial, '?'))
            $uri_initial = mb_substr($uri_initial, 0, strpos($uri_initial, '?'));
        
            $ex = explode('/', $uri_initial);

        $uri = array_values(array_filter($ex));
        
        for ($i = 0; $i < UNSET_URI_COUNT; $i++) {
            unset($uri[$i]);
        }
        
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
            (new \app\src\controller\MessageController)->message('Dados inválidos', 'Controller ou método não encontrado: ' . $get, 404);
            return;
        }

        $cont = 'app\\src\\controller\\' . $ex[0];
        if (!class_exists($cont)) {
            (new \app\src\controller\MessageController)->message('Dados inválidos', 'Controller não encontrada: ' . $get, 404);
            return;
        }


        if (!method_exists($cont, $ex[1])) {
            (new \app\src\controller\MessageController)->message('Dados inválidos', 'Método não encontrado: ' . $get, 404);
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
