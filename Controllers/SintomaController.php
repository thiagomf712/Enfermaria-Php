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

    public static function Filtrar($dados) {
        $nome = $dados['nome'];

        if ($nome === '') {
            header("Location: ../Views/Sintoma/Listar.php");
            exit();
        }

        $sintomas = SintomaService::Filtrar($nome);
        
        $_SESSION['filtro'] = serialize($sintomas);
        header("Location: ../Views/Sintoma/Listar.php");
        exit();
    }
    
    public static function OrdenarFiltro($dados) {
        $coluna = $dados['coluna'];
        $ordem = $dados['ordem'];

        $sintomas = SintomaService::FiltrarOrdenado($coluna, $ordem);

        $_SESSION['coluna'] = $coluna;
        $_SESSION['estado'] = $ordem;

        $_SESSION['filtroOrdenado'] = serialize($sintomas);
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
    
    public static function ListarEst() {
        try {
            $sintomas = SintomaService::ListarSintomasEst();
            return $sintomas;
        } catch (Exception $e) {
            $_SESSION['erro'] = $e->getMessage();
            echo "<script language='javascript'>history.go(-1);</script>";
            exit();
        }
    }

    public static function OrdenarEst($dados) {
        $coluna = $dados['coluna'];
        $ordem = $dados['ordem'];

        $sintomas = SintomaService::ListarSintomasOrdenadoEst($coluna, $ordem);

        $_SESSION['coluna'] = $coluna;
        $_SESSION['estado'] = $ordem;

        $_SESSION['ordenado'] = serialize($sintomas);
        header("Location: ../Views/Sintoma/Estatistica.php");
        exit();
    }
    
    public static function FiltrarEst($dados) {
        $sintoma = $dados['sintoma'];
        $inicio = $dados['inicio'];
        $fim = $dados['fim'];

        if ($sintoma === "" && $inicio == null && $fim == null) {
            header("Location: ../Views/Sintoma/Estatistica.php");
            exit();
        }
        
        if ($sintoma !== '') {
            $valor[] = array('s.Nome', $sintoma);
        }

        if ($inicio != null && $fim != null) {
            $valor[] = array('a.Data', $inicio, $fim, 'ope' => 'entre');
        } else if ($inicio != null) {
            $valor[] = array('a.Data', $inicio, 'ope' => 'maior');
        } else if ($fim != null) {
            $valor[] = array('a.Data', $fim, 'ope' => 'menor');
        }

        $sintomas = SintomaService::FiltrarEst($valor);
        
        $sintomas['Filtro'] = array('sintoma' => $sintoma, 'inicio' => $inicio, 'fim' => $fim);
        
        $_SESSION['filtro'] = serialize($sintomas);
        header("Location: ../Views/Sintoma/Estatistica.php");
        exit();
    }
    
    public static function OrdenarFiltroEst($dados) {
        $coluna = $dados['coluna'];
        $ordem = $dados['ordem'];

        $sintomas = SintomaService::FiltrarOrdenado($coluna, $ordem);

        $_SESSION['coluna'] = $coluna;
        $_SESSION['estado'] = $ordem;
        
        $_SESSION['filtroOrdenado'] = serialize($sintomas);
        header("Location: ../Views/Sintoma/Estatistica.php");
        exit();
    }
    
    public static function ListarOcorrencias($sintoma, $inicio, $fim) {      
        
        if ($inicio != null && $fim != null) {
            $data = array('a.Data', $inicio, $fim, 'ope' => 'entre');
        } else if ($inicio != null) {
            $data = array('a.Data', $inicio, 'ope' => 'maior');
        } else if ($fim != null) {
            $data = array('a.Data', $fim, 'ope' => 'menor');
        }
        
        if ($inicio != null || $fim != null) {
            $atendimentos = SintomaService::ListarOcorrencias($sintoma, $data);
        } else {
            $atendimentos = SintomaService::ListarOcorrencias($sintoma);
        }  
        
        return $atendimentos;
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
    
    public static function RetornarNomesSintomas(){
        try {
            $sintomas = SintomaService::RetornarNomesSintomas();

            return $sintomas;
        } catch (Exception $e) {
            $_SESSION['erro'] = $e->getMessage();
            echo "<script language='javascript'>history.go(-1);</script>";
            exit();
        }
    }
}
