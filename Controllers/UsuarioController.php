<?php

if (!defined('__ROOT__')) {
    define('__ROOT__', dirname(__FILE__, 2));
}

require_once(__ROOT__ . '/Models/Usuario.php');

require_once(__ROOT__ . '/Services/UsuarioService.php');

if (session_id() == '') {
    session_start();
}

$controller = new UsuarioController();

$controller->Executar("metodoUsuario");


class UsuarioController {

    private $retorno;

    public function __construct() {
        $this->retorno = new stdClass();
        $this->retorno->erro = "";
    }

    public function Executar($idMetodo) {
        if (isset($_POST[$idMetodo])) {
            $metodo = $_POST[$idMetodo];

            if (method_exists($this, $metodo)) {
                $this->$metodo($_POST);
                echo json_encode($this->retorno);
            } else {
                $this->retorno->erro = "metodo não encontrado";

                echo json_encode($this->retorno);
            }
        }
    }

    public function Login($dados) {
        $login = $dados['login'];
        $senha = $dados['senha'];

        try {
            $usuario = UsuarioService::ValidarLogin($login, $senha);
            $_SESSION['usuario'] = serialize($usuario);
        } catch (Exception $e) {
            $this->retorno->erro = $e->getMessage();
        }
    }

    public static function Cadastrar($dados) {
        try {
            UsuarioController::CriarUsuario($dados);
            $_SESSION['sucesso'] = "Usuario cadastrado com sucesso";
            header("Location: ../Views/Usuario/Cadastrar.php");
            exit();
        } catch (Exception $e) {
            $_SESSION['erro'] = $e->getMessage();
            echo "<script language='javascript'>history.go(-1);</script>";
            exit();
        }
    }

    public static function CriarUsuario($dados) {
        $login = $dados['login'];
        $senha = $dados['senha'];
        $nivelAcesso = $dados['nivelAcesso'];

        $usuario = new Usuario(0, $login, $senha, $nivelAcesso);

        try {
            UsuarioService::CadastrarUsuario($usuario);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public static function Editar($dados) {
        $id = $dados['id'];
        $senha = $dados['senha'];

        try {
            UsuarioService::AlterarSenha($id, $senha);

            header("Location: ../Views/Usuario/Listar.php");
            $_SESSION['sucesso'] = "Senha alterada com sucesso";
            exit();
        } catch (Exception $e) {
            $_SESSION['erro'] = $e->getMessage();
            echo "<script language='javascript'>history.go(-1);</script>";
            exit();
        }
    }

    public static function EditarUsuario($dados) {
        $id = $dados['usuarioId'];
        $login = $dados['login'];
        $senha = ($dados['senha'] !== '') ? $dados['senha'] : $dados['senhaAtual'];
        $nivelAcesso = $dados['nivelAcesso'];

        $usuario = new Usuario($id, $login, $senha, $nivelAcesso);

        try {
            UsuarioService::EditarUsuario($usuario);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public static function Listar() {
        try {
            $usuario = UsuarioService::ListarUsuarios();
            return $usuario;
        } catch (Exception $e) {
            $_SESSION['erro'] = $e->getMessage();
            echo "<script language='javascript'>history.go(-1);</script>";
            exit();
        }
    }

    public static function Ordenar($dados) {
        $coluna = $dados['coluna'];
        $ordem = $dados['ordem'];

        $usuarios = UsuarioService::ListarUsuariosOrdenado($coluna, $ordem);

        $_SESSION['coluna'] = $coluna;
        $_SESSION['estado'] = $ordem;

        $_SESSION['ordenado'] = serialize($usuarios);
        header("Location: ../Views/Usuario/Listar.php");
        exit();
    }

    public static function Filtrar($dados) {
        $login = $dados['login'];
        $nivelAcesso = $dados['nivelAcesso'];

        if ($login === '' && $nivelAcesso === "0") {
            header("Location: ../Views/Usuario/Listar.php");
            exit();
        }

        if ($login !== '') {
            $valor[] = array('Login', $login);
        }

        if ($nivelAcesso !== "0") {
            $valor[] = array('NivelAcesso', $nivelAcesso);
        }

        $usuarios = UsuarioService::Filtrar($valor);

        $_SESSION['filtro'] = serialize($usuarios);
        header("Location: ../Views/Usuario/Listar.php");
        exit();
    }

    public static function OrdenarFiltro($dados) {
        $coluna = $dados['coluna'];
        $ordem = $dados['ordem'];

        $usuarios = UsuarioService::FiltrarOrdenado($coluna, $ordem);

        $_SESSION['coluna'] = $coluna;
        $_SESSION['estado'] = $ordem;

        $_SESSION['filtroOrdenado'] = serialize($usuarios);
        header("Location: ../Views/Usuario/Listar.php");
        exit();
    }

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
