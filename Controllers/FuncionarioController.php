<?php

if (!defined('__ROOT__')) {
    define('__ROOT__', dirname(__FILE__, 2));
}

require_once(__ROOT__ . '/Models/Funcionario.php');

require_once(__ROOT__ . '/Controllers/UsuarioController.php');

require_once(__ROOT__ . '/Services/UsuarioService.php');
require_once(__ROOT__ . '/Services/FuncionarioService.php');

if (session_id() == '') {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['metodoFuncionario'])) {
    $metodo = $_POST['metodoFuncionario'];

    if (method_exists('FuncionarioController', $metodo)) {
        FuncionarioController::$metodo($_POST);
    } else {
        throw new Exception("Metodo não existe");
    }
}

class FuncionarioController {

    static function Cadastrar($dados) {
        $nome = $dados['nome'];
        $login = $dados['login'];

        try {
            UsuarioController::CriarUsuario($dados);

            $usuario = UsuarioService::RetornarLogin($login);

            $funcionario = new Funcionario(0, $nome, $usuario);

            FuncionarioService::CadastrarFuncionario($funcionario);

            header("Location: ../Views/Funcionario/Cadastrar.php");
            $_SESSION['sucesso'] = "Funcionario cadastrado com sucesso";
            exit();
        } catch (Exception $e) {
            $_SESSION['erro'] = $e->getMessage();
            echo "<script language='javascript'>history.go(-1);</script>";
            exit();
        }
    }
    
    public static function Editar($dados) {
        $id = $dados['funcionarioId'];
        $nome = $dados['nome'];
        $login = $dados['login'];

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

    public static function Listar() {
        try {
            $funcionarios = FuncionarioService::ListarFuncionarios();
            return $funcionarios;
        } catch (Exception $e) {
            $_SESSION['erro'] = $e->getMessage();
            echo "<script language='javascript'>history.go(-1);</script>";
            exit();
        }
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
            echo "<script language='javascript'>history.go(-1);</script>";
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

}
