<?php

if (!defined('__ROOT__')) {
    define('__ROOT__', dirname(__FILE__, 2));
}

require_once(__ROOT__ . '/Models/Paciente.php');

require_once(__ROOT__ . '/Services/PacienteService.php');
require_once(__ROOT__ . '/Services/FichaMedicaService.php');


if (session_id() == '') {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['metodoAtendimento'])) {
    $metodo = $_POST['metodoAtendimento'];

    if (method_exists('AtendimentoController', $metodo)) {
        AtendimentoController::$metodo($_POST);
    } else {
        throw new Exception("Metodo não existe");
    }
}

class AtendimentoController {
    
    
    
    
    public static function RetornarFichaMedica($id) {
        try {
            $fichaMedica = FichaMedicaService::RetornarFichaMedica($id);

            return $fichaMedica;
        } catch (Exception $e) {
            $_SESSION['erro'] = $e->getMessage();
            echo "<script language='javascript'>history.go(-1);</script>";
            exit();
        }
    }
    
    public static function ListarPacientes() {
        try {
            $pacientes = PacienteService::ListarPacientes();
            return $pacientes;
        } catch (Exception $e) {
            $_SESSION['erro'] = $e->getMessage();
            echo "<script language='javascript'>history.go(-1);</script>";
            exit();
        }
    }
    
    public static function FiltrarPacientes($dados) {
        $nome = $dados['nome'];
        $ra = $dados['ra'];
        $regime = $dados['regime'];

        if ($nome === '' && $regime === "0" && $ra == null) {
            header("Location: ../Views/Atendimento/ListaPacientes.php");
            exit();
        }
        
        if ($nome !== '') {
            $valor[] = array('p.Nome', $nome);
        }
        
        if ($regime !== "0") {
            $valor[] = array('e.Regime', $regime);
        }
        
        if($ra !== null) {
            $valor[] = array('p.Ra', $ra);
        }

        $pacientes = PacienteService::Filtrar($valor);
        
        $_SESSION['filtro'] = serialize($pacientes);
        header("Location: ../Views/Atendimento/ListaPacientes.php");
        exit();
    }
    
    public static function OrdenarPaciente($dados) {
        echo Ola;
        $coluna = $dados['coluna'];
        $ordem = $dados['ordem'];

        $paciente = PacienteService::ListarPacientesOrdenado($coluna, $ordem);

        $_SESSION['coluna'] = $coluna;
        $_SESSION['estado'] = $ordem;

        $_SESSION['ordenado'] = serialize($paciente);
        header("Location: ../Views/Atendimento/ListaPacientes.php");
        exit();
    }
    
    public static function OrdenarFiltroPaciente($dados) {
        $coluna = $dados['coluna'];
        $ordem = $dados['ordem'];

        $pacientes = PacienteService::FiltrarOrdenado($coluna, $ordem);

        $_SESSION['coluna'] = $coluna;
        $_SESSION['estado'] = $ordem;

        $_SESSION['filtroOrdenado'] = serialize($pacientes);
        header("Location: ../Views/Atendimento/ListaPacientes.php");
        exit();
    }
}