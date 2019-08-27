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

    public function getUsuarioService() {
        return $this->usuarioService;
    }

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

            $this->funcionarioService->CadastrarFuncionario($funcionario);

            $this->retorno->sucesso = "Funcionario cadastrado com sucesso";
        } catch (Exception $e) {
           $this->retorno->erro = $e->getMessage();
        }
    }

    public static function Editar($dados) {
        $id = $dados['funcionarioId'];
        $nome = $dados['nome'];

        try {
            UsuarioController::EditarUsuario($dados);

            $funcionario = new Funcionario($id, $nome);

            FuncionarioService::EditarFuncionario($funcionario);

            header("Location: ../Views/Funcionario/Listar.php");
            $_SESSION['sucesso'] = "Funcionario editado com sucesso";
            exit();
        } catch (Exception $e) {
            $_SESSION['erro'] = $e->getMessage();
            echo "<script language='javascript'>history.go(-1);</script>";
            exit();
        }
    }

    public function Listar() {
        try {
            $this->retorno->lista = $this->funcionarioService->Listar();
        } catch (Exception $e) {
            $this->retorno->erro = $e->getMessage();
        }
    }

    public static function Ordenar($dados) {
        $coluna = $dados['coluna'];
        $ordem = $dados['ordem'];

        $funcionario = FuncionarioService::ListarFuncionarioOrdenado($coluna, $ordem);

        $_SESSION['coluna'] = $coluna;
        $_SESSION['estado'] = $ordem;

        $_SESSION['ordenado'] = serialize($funcionario);
        header("Location: ../Views/Funcionario/Listar.php");
        exit();
    }

    public static function Filtrar($dados) {
        $nome = $dados['nome'];
        $nivelAcesso = $dados['nivelAcesso'];

        if ($nome === '' && $nivelAcesso === "0") {
            header("Location: ../Views/Funcionario/Listar.php");
            exit();
        }

        if ($nome !== '') {
            $valor[] = array('f.Nome', $nome);
        }

        if ($nivelAcesso !== "0") {
            $valor[] = array('u.NivelAcesso', $nivelAcesso);
        }

        $funcionarios = FuncionarioService::Filtrar($valor);

        $_SESSION['filtro'] = serialize($funcionarios);
        header("Location: ../Views/Funcionario/Listar.php");
        exit();
    }

    public static function OrdenarFiltro($dados) {
        $coluna = $dados['coluna'];
        $ordem = $dados['ordem'];

        $funcionario = FuncionarioService::FiltrarOrdenado($coluna, $ordem);

        $_SESSION['coluna'] = $coluna;
        $_SESSION['estado'] = $ordem;

        $_SESSION['filtroOrdenado'] = serialize($funcionario);
        header("Location: ../Views/Funcionario/Listar.php");
        exit();
    }

    public static function Deletar($dados) {

        $id = $dados['funcionarioId'];
        $usuarioId = $dados['usuarioId'];

        try {
            FuncionarioService::Excluir($id);

            UsuarioService::Excluir($usuarioId);

            header("Location: ../Views/Funcionario/Listar.php");
            $_SESSION['sucesso'] = "Funcionario deletado com sucesso";
            exit();
        } catch (Exception $e) {
            $_SESSION['erro'] = $e->getMessage();
            header("Location: ../Views/Funcionario/Listar.php");
            exit();
        }
    }

    public static function RetornarFuncionario($id, $usuarioId) {
        try {
            $usuario = UsuarioService::RetornarLoginId($usuarioId);
            $funcionario = FuncionarioService::RetornarFuncionario($id);

            $funcionario->setUsuario($usuario);

            return $funcionario;
        } catch (Exception $e) {
            $_SESSION['erro'] = $e->getMessage();
            echo "<script language='javascript'>history.go(-1);</script>";
            exit();
        }
    }

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
