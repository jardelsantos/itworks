<?php

/**
 * Redireciona um usuário para a URL informada e finaliza a aplicação
 *
 * @param  string $url URL a ser redirecionada
 * @return void
 */
function redirect(string $url)
{
    header('Location: ' . $url);
    exit;
}