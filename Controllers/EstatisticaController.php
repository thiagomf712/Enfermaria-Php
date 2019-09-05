<?php

if (!defined('__ROOT__')) {
    define('__ROOT__', dirname(__FILE__, 2));
}

require_once(__ROOT__ . '/Services/SintomaService.php');
require_once(__ROOT__ . '/Services/AtendimentoService.php');
require_once(__ROOT__ . '/Services/PacienteService.php');


if (isset($_POST["metodoEstatistica"])) {
    $controller = new EstatisticaController();

    $controller->Executar("metodoEstatistica");
}

class EstatisticaController {

    public $retorno;
    private $sintomaService;
    private $atendimentoService;
    private $pacienteService;

    public function __construct() {
        $this->retorno = new stdClass();

        $this->sintomaService = new SintomaService();
        $this->atendimentoService = new AtendimentoService();
        $this->pacienteService = new PacienteService();
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

    public function GerarNumeros() {
        try {
            $sintomas = $this->sintomaService->ListarQuantidade();
            $atendimentos = $this->atendimentoService->ListarQuantidade();

            $this->retorno->sintomas = $sintomas;
            $this->retorno->atendimentos = $atendimentos;
        } catch (Exception $e) {
            $this->retorno->erro = $e->getMessage();
        }
    }

    public function GerarTabelaSintomas($dados) {
        $inicio = $dados['inicio'];
        $fim = $dados['fim'];
        
        try {
            $this->retorno->lista = $this->sintomaService->ListarAgrupado($inicio, $fim);
        } catch (Exception $e) {
            $this->retorno->erro = $e->getMessage();
        }
    }
    
    public function GerarTabelaPacientes($dados) {
        $inicio = $dados['inicio'];
        $fim = $dados['fim'];
        
        try {
            $this->retorno->lista = $this->pacienteService->ListarAgrupado($inicio, $fim);
        } catch (Exception $e) {
            $this->retorno->erro = $e->getMessage();
        }
    }
    
    public function GerarTabelaAtendimentos($dados) {
        $inicio = $dados['inicio'];
        $fim = $dados['fim'];
        
        try {
            $this->retorno->lista = $this->atendimentoService->ListarAgrupado($inicio, $fim);
        } catch (Exception $e) {
            $this->retorno->erro = $e->getMessage();
        }
    }
}
