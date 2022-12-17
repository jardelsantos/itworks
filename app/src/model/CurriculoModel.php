<?php

namespace Itworks\src\model;
use Itworks\core\Model;

class CurriculoModel
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = new Model();
    }


    public function insertForm(object $params)
    {
        $sql = "INSERT INTO 
                curriculo 
                    (nome)
                VALUES
                    (:nome)
                ";

        $sqlParams = [
            ':nome'         => $params->nome
        ];

        $handle = $this->pdo->executeNonQuery($sql, $sqlParams);

        if( !$handle )
        {
            return -1; // Código de erro
        }
        else
        {
            return $this->pdo->GetLastID();
        }
    }

    public function insertUpload(object $params)
    {
       
        $sql = "INSERT INTO 
                arquivo 
                    (`filename`, `curriculo_id`)
                VALUES
                    (:filename, :curriculo_id)
                ";

        $sqlParams = [
            ':filename'         => $params->filename,
            ':curriculo_id'     => $params->curriculo_id
        ];

        $handle = $this->pdo->executeNonQuery($sql, $sqlParams);

        if( !$handle )
        {
            return -1; // Código de erro
        }
        else
        {
            return $this->pdo->GetLastID();
        }
    }

}