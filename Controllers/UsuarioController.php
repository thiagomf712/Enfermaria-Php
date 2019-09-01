<?php

if (!defined('__ROOT__')) {
    define('__ROOT__', dirname(__FILE__, 2));
}

require_once(__ROOT__ . '/Models/Usuario.php');
require_once(__ROOT__ . '/Services/UsuarioService.php');

if (session_id() == '') {
    session_start();
}

if (isset($_POST["metodoUsuario"])) {
    $controller = new UsuarioController();

    $controller->Executar("metodoUsuario");
}

class UsuarioController {

    private $retorno;
    private $usuarioService;

    public function getUsuarioService() {
        return $this->usuarioService;
    }

    public function __construct() {
        $this->retorno = new stdClass();

        $this->usuarioService = new UsuarioService();
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

    public function Login($dados) {
        $login = $dados['login'];
        $senha = $dados['senha'];

        try {
            $usuario = $this->usuarioService->ValidarLogin($login, $senha);
            $_SESSION['usuario'] = serialize($usuario);
        } catch (Exception $e) {
            $this->retorno->erro = $e->getMessage();
        }
    }

    public function CriarUsuario($dados) {
        $login = $dados['login'];
        $senha = $dados['senha'];
        $nivelAcesso = $dados['nivelAcesso'];

        $usuario = new Usuario(null, $login, $senha, $nivelAcesso);

        $this->usuarioService->CadastrarUsuario($usuario);
    }

    public function AlterarSenha($dados) {
        $id = $dados['usuario'];
        $senha = $dados['senha'];

        try {
            $this->usuarioService->AlterarSenha($id, $senha);

            $this->retorno->sucesso = "Senha alterada com sucesso";
        } catch (Exception $e) {
            $this->retorno->erro = $e->getMessage();
        }
    }

    public function Editar($dados) {
        $id = $dados['usuario'];
        $login = $dados['login'];
        $nivelAcesso = $dados['nivelAcesso'];

        $usuario = new Usuario($id, $login, null, $nivelAcesso);

        $this->usuarioService->Editar($usuario);
    }

    public function Listar() {
        try {
            $this->retorno->lista = $this->usuarioService->Listar();
        } catch (Exception $e) {
            $this->retorno->erro = $e->getMessage();
        }
    }

    //Não sei aonde está sendo usado
    public static function RetornarUsuario($id) {
        try {
            $usuario = UsuarioService::RetornarLoginId($id);

            return $usuario;
        } catch (Exception $e) {
            $_SESSION['erro'] = $e->getMessage();
            echo "<script language='javascript'>history.go(-1);</script>";
            exit();
        }
    }

}
