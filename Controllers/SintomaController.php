<?php

if (!defined('__ROOT__')) {
    define('__ROOT__', dirname(__FILE__, 2));
}

require_once(__ROOT__ . '/Models/Sintoma.php');
require_once(__ROOT__ . '/Services/SintomaService.php');


if (isset($_POST["metodoSintoma"])) {
    $controller = new SintomaController();

    $controller->Executar("metodoSintoma");
}

class SintomaController {

    public $retorno;
    private $sintomaService;

    public function __construct() {
        $this->retorno = new stdClass();

        $this->sintomaService = new SintomaService();
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

    public function Cadastrar($dados) {
        $nome = $dados['nome'];

        $sintoma = new Sintoma(null, $nome);

        try {
            $this->sintomaService->Cadastrar($sintoma);

            $this->retorno->sucesso = "Sintoma cadastrado com sucesso";
        } catch (Exception $e) {
            $this->retorno->erro = $e->getMessage();
        }
    }

    public function Editar($dados) {
        $id = $dados['sintoma'];
        $nome = $dados['nome'];

        $sintoma = new Sintoma($id, $nome);
        
        try {         
            $this->sintomaService->Editar($sintoma);

            $this->retorno->sucesso = "Sintoma editado com sucesso";
        } catch (Exception $e) {
            $this->retorno->erro = $e->getMessage();
        }
    }

    public function Deletar($dados) {
        $id = $dados['sintoma'];

        try {
            $this->sintomaService->Excluir($id);

            $this->retorno->sucesso = "Sintoma deletado com sucesso";
        } catch (Exception $e) {
            $this->retorno->erro = $e->getMessage();
        }
    }

    public function Listar() {
        try {
            $this->retorno->lista = $this->sintomaService->Listar();
        } catch (Exception $e) {
            $this->retorno->erro = $e->getMessage();
        }
    }

    //Será modificado
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

    //Será modificado
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

    public function GetSintoma($dados) {
        $id = $dados['sintoma'];
        
        try {
            $this->retorno->resultado = $this->sintomaService->GetSintoma($id);
        } catch (Exception $e) {
            $this->retorno->erro = $e->getMessage();
        }
    }

    //Será modificado
    public static function RetornarNomesSintomas() {
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
