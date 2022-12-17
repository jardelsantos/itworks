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


    public function insert(object $params)
    {
        $sql = "INSERT INTO 
                extrato 
                    (valor, movimentacao, dataRegistro)
                VALUES
                    (:valor, :movimentacao, :dataRegistro)
                ";

        $sqlParams = [
            ':valor'        => $params->valor, 
            ':movimentacao' => $params->movimentacao, 
            ':dataRegistro' => date('Y-m-d H:i:s')
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



    /**
     * Retorna todos os registros da base de dados em 
     * ordem ascendente por dataRegistro
     * @return array[object]
     */
    public function getAll()
    {
        //Excrevemos a consulta SQL e atribuimos a váriavel $sql
        $sql = 'SELECT * FROM extrato ORDER BY dataRegistro ASC';
        //Executamos a consulta chamando o método da modelo. 
        //Atribuimos o resultado a variável $dt
        $dt = $this->pdo->executeQuery($sql);
        //Declara uma lista inicialmente nula
        $listaExtrato = null;
        //Percorremos todas as linhas do resultado da busca
        foreach ($dt as $dr){
            //Atribuimos a última posição do array o produto devidamente 
            //tratado
            $listaExtrato[] = $this->collection($dr);
        }
        //Retornamos a lista de produtos
        return $listaExtrato;
    }


    /**
     * Converte uma estrutura de array vinda da 
     * base de dados em um objeto devidamente tratado
     *
     * @param  array|object $param Recebe o parâmetro que 
     *  é retornado na consulta com a base de dados
     * 
     * @return object Retorna um objeto devidamente tratado 
     * com a estrutura de conta
     */
    private function collection($param)
    {
        // Operador Null Coalesce
        return (object)[
            'id'            => $param['id']             ?? null,
            'valor'         => $param['valor']          ?? null,
            'movimentacao'  => $param['movimentacao']   ?? null,
            'dataRegistro'  => $param['dataRegistro']   ?? null
        ];
    }



    /**
     * Retorna um único registro da base de dados através do ID informado
     *
     * @param  int $id ID do objeto a ser retornado
     * @return object Retorna um objeto populado com os dados do 
     * registro ou se não encontrar com seus valores nulos
     */
    public function getById(int $id)
    {
        $sql = 'SELECT * FROM extrato WHERE id = :id';

        $param = [
            ':id' => $id
        ];

        $dr = $this->pdo->executeQueryOneRow($sql, $param);

        return $this->collection($dr);
    }

}