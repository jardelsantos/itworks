<?php

namespace Itworks\core;

class Controller
{
    /***
     * Carregar a View
     * 
     * @param string $view Tela
     * @param array $params Parametros para serem impressos na Tela
     * 
     * @return string
     */
    protected function load(string $view, $params = [])
    {
        //Carrega Arquivos
        $twig = new \Twig\Environment(
            new \Twig\Loader\FilesystemLoader('../app/src/view/')
        );
        //Defini URL
        $twig->addGlobal('BASE', BASE);

        //Imprime a renderização
        echo $twig->render($view . '.twig.php', $params);
    }


    public function showMessage(
        string $titulo, 
        string $descricao, 
        string $link = null, 
        int $httpCode = 200
    ){
        http_response_code($httpCode);

        $this->load('partials/message', [
            'titulo'    => $titulo,
            'descricao' => $descricao,
            'link'      => $link
        ]);
    }
}