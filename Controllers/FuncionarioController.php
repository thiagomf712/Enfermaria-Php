<?php

require_once 'UsuarioController.php';
require_once '../Services/UsuarioService.php';
require_once '../Services/FuncionarioService.php';
require_once '../Models/Funcionario.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['metodo2'])) {
    $metodo = $_POST['metodo2'];

    if (method_exists('FuncionarioController', $metodo)) {
        FuncionarioController::$metodo($_POST);
    } else {
        throw new Exception("Metodo não existe");
    }
}

session_start();

class FuncionarioController {

    static function Cadastrar($dados) {
        $nome = $dados['nome'];
        $login = $dados['login'];
    
        try {
            UsuarioController::CriarUsuario($dados);    
            
            $usuario = UsuarioService::RetornarLogin($login);
            
            $funcionario = new Funcionario(0, $nome, $usuario);
            
            FuncionarioService::CadastrarFuncionario($funcionario);
            
            header("Location: ../Views/Menu.php");
            exit();
        } catch (Exception $e) {
            $_SESSION['erro'] = $e->getMessage();
            echo "<script language='javascript'>history.go(-1);</script>";
            exit();
        }        
    }

}
