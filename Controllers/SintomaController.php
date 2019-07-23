<?php

if (!defined('__ROOT__')) {
    define('__ROOT__', dirname(__FILE__, 2));
}

require_once(__ROOT__ . '/Models/Sintoma.php');

require_once(__ROOT__ . '/Services/SintomaService.php');

if (session_id() == '') {
    session_start();
}

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

        $sintoma = new Sintoma(0, $nome);

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
    
    public static function Editar($dados) {
        $id = $dados['id'];
        $nome = $dados['nome'];

        try {
            $sintoma = new Sintoma($id, $nome);

            SintomaService::EditarSintoma($sintoma);

            header("Location: ../Views/Sintoma/Listar.php");
            $_SESSION['sucesso'] = "Sintoma editado com sucesso";
            exit();
        } catch (Exception $e) {
            $_SESSION['erro'] = $e->getMessage();
            echo "<script language='javascript'>history.go(-1);</script>";
            exit();
        }
    }
    
    public static function Deletar($dados) {     
        $id = $dados['id'];
        
        try {
            SintomaService::Excluir($id);

            header("Location: ../Views/Sintoma/Listar.php");
            $_SESSION['sucesso'] = "sintoma deletado com sucesso";
            exit();
        } catch (Exception $e) {
            $_SESSION['erro'] = $e->getMessage();
            echo "<script language='javascript'>history.go(-1);</script>";
            exit();
        }
    }

    public static function Ordenar($dados) {
        $coluna = $dados['coluna'];
        $ordem = $dados['ordem'];

        $sintomas = SintomaService::ListarSintomasOrdenado($coluna, $ordem);

        $_SESSION['coluna'] = $coluna;
        $_SESSION['estado'] = $ordem;

        $_SESSION['ordenado'] = serialize($sintomas);
        header("Location: ../Views/Sintoma/Listar.php");
        exit();
    }

    public static function Listar() {
        try {
            $sintomas = SintomaService::ListarSintomas();
            return $sintomas;
        } catch (Exception $e) {
            $_SESSION['erro'] = $e->getMessage();
            echo "<script language='javascript'>history.go(-1);</script>";
            exit();
        }
    }

    public static function RetornarSintoma($id) {
        try {
            $sintoma = SintomaService::RetornarSintoma($id);
            
            return $sintoma;
        } catch (Exception $e) {
            $_SESSION['erro'] = $e->getMessage();
            echo "<script language='javascript'>history.go(-1);</script>";
            exit();
        }
    }
}
