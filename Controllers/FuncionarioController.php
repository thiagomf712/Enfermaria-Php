<?php

if (!defined('__ROOT__')) {
    define('__ROOT__', dirname(__FILE__, 2));
}

require_once(__ROOT__ . '/Models/Funcionario.php');
require_once(__ROOT__ . '/Services/FuncionarioService.php');

require_once(__ROOT__ . '/Controllers/UsuarioController.php');

if (isset($_POST["metodoFuncionario"])) {
    $controller = new FuncionarioController();

    $controller->Executar("metodoFuncionario");
}

class FuncionarioController {

    public $retorno;
    private $funcionarioService;
    private $usuarioController;

    public function __construct() {
        $this->retorno = new stdClass();

        $this->funcionarioService = new FuncionarioService();
        $this->usuarioController = new UsuarioController();
    }

    //Executa um metodo da class baseado no que foi passado por post
    public function Executar($idMetodo) {
        $metodo = $_POST[$idMetodo];

        if (method_exists($this, $metodo)) {
            $this->$metodo($_POST);
        } else {
            $this->retorno->erro = "metodo não encontrado";
        }

        //Retorn
        echo json_encode($this->retorno);
    }

    
    public function Cadastrar($dados) {
        $nome = $dados['nome'];
        $login = $dados['login'];

        try {
            $this->usuarioController->CriarUsuario($dados);

            $usuario = $this->usuarioController->getUsuarioService()->GetId($login);

            $funcionario = new Funcionario(null, $nome, $usuario);

            $this->funcionarioService->Cadastrar($funcionario);

            $this->retorno->sucesso = "Funcionario cadastrado com sucesso";
        } catch (Exception $e) {
            $this->retorno->erro = $e->getMessage();
        }
    }
    
    public function Editar($dados) {
        $id = $dados['funcionario'];
        $nome = $dados['nome'];

        try {
            $this->usuarioController->Editar($dados);

            $funcionario = new Funcionario($id, $nome);

            $this->funcionarioService->Editar($funcionario);

            $this->retorno->sucesso = "Funcionario editado com sucesso";
        } catch (Exception $e) {
            $this->retorno->erro = $e->getMessage();
        }
    }

    public function Listar() {
        try {
            $this->retorno->lista = $this->funcionarioService->Listar();
        } catch (Exception $e) {
            $this->retorno->erro = $e->getMessage();
        }
    }

    public function Deletar($dados) {
        $id = $dados['funcionario'];
        $usuarioId = $dados['usuario'];

        try {
            $this->funcionarioService->Excluir($id);

            $this->usuarioController->getUsuarioService()->Excluir($usuarioId);

            $this->retorno->sucesso = "Funcionario deletado com sucesso";
        } catch (Exception $e) {
            $this->retorno->erro = $e->getMessage();
        }
    }

    public function GetFuncionario($dados) {
        $id = $dados['funcionario'];
        $usuarioId = $dados['usuario'];

        try {
            $usuario = $this->usuarioController->getUsuarioService()->GetUsuario($usuarioId);

            $funcionario = $this->funcionarioService->GetFuncionario($id);

            $funcionario->setUsuario($usuario);

            $this->retorno->resultado = $funcionario;
        } catch (Exception $e) {
            $this->retorno->erro = $e->getMessage();
        }
    }

    //Será editado
    public static function RetornarNomeFuncionarios() {
        try {
            $funcionarios = FuncionarioService::RetornarNomesFuncionarios();

            return $funcionarios;
        } catch (Exception $e) {
            $_SESSION['erro'] = $e->getMessage();
            echo "<script language='javascript'>history.go(-1);</script>";
            exit();
        }
    }

}
