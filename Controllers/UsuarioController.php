<?php

require_once '../Services/UsuarioService.php';
require_once '../Models/Usuario.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['metodoUsuario'])) {
    $metodo = $_POST['metodoUsuario'];

    if (method_exists('UsuarioController', $metodo)) {
        UsuarioController::$metodo($_POST);
    } else {
        throw new Exception("Metodo não existe");
    }
}

class UsuarioController {

    public static function Login($dados) {
        $login = $dados['login'];
        $senha = $dados['senha'];

        try {
            $usuario = UsuarioService::ValidarLogin($login, $senha);
            $_SESSION['usuario'] = serialize($usuario);
            header("Location: ../Views/Geral/Home.php");
            exit();
        } catch (Exception $e) {
            $_SESSION['erro'] = $e->getMessage();
            echo "<script language='javascript'>history.go(-1);</script>";
            exit();
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

}
