<?php
namespace Itworks\src\controller;
use Itworks\core\Controller;

use Itworks\src\model\CurriculoModel;
use Itworks\classes\Input;

class CurriculoController extends Controller{

    private $curriculoModel;

    public function __construct(){
        $this->curriculoModel = new CurriculoModel();
    }

    public function criarCurriculo(){
        $this->load('curriculo\form');
    }

    public function salvarCurriculo(){
        $dados = $this->getInputPost();
        $resultado = $this->curriculoModel->insertForm($dados);
        if($resultado <= 0){
            $this->showMessage(
                                'Erro', 
                                'Ocorreu um erro ao inserir o curriculo', 
                                null, 
                                404
                            );
        }else{
            redirect( BASE . 'envio-arquivo?id=' . $resultado);
        }
    }

    public function upload(){
        $id = $_GET['id'];
        $this->load(
            'curriculo\upload', 
            [
                'id' => $id
            ]
        );
    }

    public function salvarUpload(){
        $nome_atual = explode('.', $_FILES['curriculo']['name'] ); 	
		$nome_novo = uniqid() . '.' .end($nome_atual);

		if(move_uploaded_file($_FILES['curriculo']['tmp_name'], DIR_UPLOAD . $nome_novo ) )
		{	
			$arquivo_nome_antigo = $_FILES['curriculo']['name'];
			$arquivo = DIR_UPLOAD . $nome_novo;

            //Enviar ao banco de dados
            $dados =  (object)[
                'filename' => $arquivo,
                'curriculo_id' => $_POST['id']
            ];

            $resultado = $this->curriculoModel->insertUpload($dados);

            if($resultado <= 0){
                $this->showMessage(
                    'Erro',
                    'Não foi possível salvar o arquivo em banco de dados',
                    null,
                    404
                );
            }else{
                redirect( BASE . 'cadastro-concluido');
            }



		}else{
			$this->showMessage(
                'Erro', 
                'Falha ao enviar o arquivo', 
                null, 
                404
            );
		}



        
    }
    public function sucesso(){
        $this->load('curriculo\sucesso');
    }
    private function getInputPost()
    {
        return (object)[
            'nome'        => Input::post(  
                                            'nome',
                                            FILTER_UNSAFE_RAW
                                        )
        ];
    }
}