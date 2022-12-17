<?php
#http://localhost:8081/
#http://localhost:8081/home
#http://localhost:8081/home?nome=pedro&sobrenome=santos

$this->get('/','ContaController@index');
$this->get('/novo','ContaController@novo');
$this->post('/conta-salvar','ContaController@salvar');
$this->get('/conta-editar','ContaController@editar');