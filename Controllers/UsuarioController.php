<?php

require_once '../Services/UsuarioService.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['metodo'])) {
    $metodo = $_POST['metodo'];

    if (method_exists('UsuarioController', $metodo)) {
        UsuarioController::$metodo($_POST);
    } else {
        throw new Exception("Metodo não existe");
    }
}

class UsuarioController {
        
    static function login($dados) {
        $login = $dados['login'];
        $senha = $dados['senha'];
        
        try {           
            $usuario = UsuarioService::ValidarLogin($login, $senha);
            $_SESSION['usuario'] = serialize($usuario);
            header("Location: ../Views/Menu.php");
            exit();
        } catch (Exception $e) {
            $_SESSION['erro'] = $e->getMessage();
            header("Location: ".$_SERVER['HTTP_REFERER']."");
            exit();
        } 
    }

}
