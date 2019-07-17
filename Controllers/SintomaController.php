<?php

require_once '../Services/SintomaService.php';

require_once '../Models/Sintoma.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['metodoSintoma'])) {
    $metodo = $_POST['metodoSintoma'];

    if (method_exists('SintomaController', $metodo)) {
        SintomaController::$metodo($_POST);
    } else {
        throw new Exception("Metodo não existe");
    }
}
class SintomaController {
    
    static function Cadastrar($dados) {
        $nome = $dados['nome'];
        $procedimento = $dados['procedimento'];
    
        $sintoma = new Sintoma(0, $nome, $procedimento);
        
        try {
            SintomaService::CadastrarSintoma($sintoma);
            
            header("Location: ../Views/Sintoma/Cadastrar.php");
            $_SESSION['sucesso'] = "Sintoma cadastrado com sucesso";
            exit();
        } catch (Exception $e) {
            $_SESSION['erro'] = $e->getMessage();
            echo "<script language='javascript'>history.go(-1);</script>";
            exit();
        }        
    }
    
}
