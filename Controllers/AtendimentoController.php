<?php

if (!defined('__ROOT__')) {
    define('__ROOT__', dirname(__FILE__, 2));
}

require_once(__ROOT__ . '/Models/Atendimento.php');
require_once(__ROOT__ . '/Models/AtendimentoSintoma.php');

require_once(__ROOT__ . '/Services/AtendimentoService.php');
require_once(__ROOT__ . '/Services/AtendimentoSintomaService.php');
require_once(__ROOT__ . '/Services/PacienteService.php');
require_once(__ROOT__ . '/Services/FichaMedicaService.php');


if (isset($_POST["metodoAtendimento"])) {
    $controller = new AtendimentoController();

    $controller->Executar("metodoAtendimento");
}

class AtendimentoController {

    public $retorno;
    private $pacienteService;
    private $atendimentoService;
    private $atendimentoSintomaService;
    private $fichaMedicaService;

    public function __construct() {
        $this->retorno = new stdClass();

        $this->pacienteService = new PacienteService();
        $this->atendimentoService = new AtendimentoService();
        $this->atendimentoSintomaService = new AtendimentoSintomaService();
        $this->fichaMedicaService = new FichaMedicaService();
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

        //Atendimento
        $paciente = $dados['paciente'];
        $funcionario = $dados['atendente'];
        $hora = $dados['hora'];
        $data = $dados['data'];
        $procedimento = $dados['procedimento'];

        $atendimento = new Atendimento(null, $data, $hora, $procedimento, $paciente, $funcionario);

        try {
            $this->atendimentoService->Cadastrar($atendimento);

            //Para cada sintoma registrado no formulario
            for ($i = 1; $i <= $dados['numeroSintomas']; $i++) {
                if (isset($dados["sintoma$i"])) { //Verifica se o sintoma ainda existe (no caso de excluir um sintoma no meio da lista)
                    $espec = $dados["especificacao$i"];
                    $sintoma = $dados["sintoma$i"];
                    $atendimendoCadastrado = $this->atendimentoService->GetId($atendimento);

                    $atendimentoSintoma = new AtendimentoSintoma(null, $espec, $sintoma, $atendimendoCadastrado);

                    $this->CadastarSintoma($atendimentoSintoma, $atendimendoCadastrado);
                }
            }

            $this->retorno->sucesso = "Atendimento Cadastrado com sucesso";
        } catch (Exception $e) {
            $this->retorno->erro = $e->getMessage();
        }
    }

    private function CadastarSintoma($atendimentoSintoma, $atendimento) {
        //Tentar cadastrar os sintomas
        //Se acontecer algum erro vai deletar o atendimento
        try {
            $this->atendimentoSintomaService->Cadastrar($atendimentoSintoma);
        } catch (Exception $e) {
            $this->atendimentoService->Excluir($atendimento->id);
            throw new Exception($e->getMessage());
        }
    }

    public function Editar($dados) {

        //Atendimento
        $idAtendimento = $dados['atendimento'];
        $funcionario = $dados['atendente'];
        $hora = $dados['hora'];
        $data = $dados['data'];
        $procedimento = $dados['procedimento'];

        $atendimento = new Atendimento($idAtendimento, $data, $hora, $procedimento, null, $funcionario);

        $atendimentoSintoma;

        for ($i = 1; $i <= $dados['numeroSintomas']; $i++) {
            if (isset($dados["sintoma$i"])) { //Verifica se o sintoma ainda existe (no caso de excluir um sintoma no meio da lista)
                $id = (isset($dados["id$i"])) ? $dados["id$i"] : 0;
                $espec = $dados["especificacao$i"];
                $sintoma = $dados["sintoma$i"];

                $atendimentoSintoma[] = new AtendimentoSintoma($id, $espec, $sintoma, $atendimento);
            }
        }

        try {
            $sintomasRegistrados = $this->atendimentoSintomaService->GetIds($atendimento->id);

            $sintomasSeparados = $this->SepararSintomas($atendimentoSintoma, $sintomasRegistrados);    
                  
            //Editar os sintomas         
            foreach ($sintomasSeparados['editado'] as $value) {
                $this->atendimentoSintomaService->Editar($value);
            }
            
            //Cadastrar os novos sintomas
            foreach ($sintomasSeparados['novo'] as $value) {
                $this->atendimentoSintomaService->Cadastrar($value);
            }
            
            //Excluir sintomas
            foreach ($sintomasSeparados['excluido'] as $value) {
                $this->atendimentoSintomaService->Excluir($value->Id);
            }
            
            //Editar os dados do atendimento
            $this->atendimentoService->Editar($atendimento);
            
            $this->retorno->sucesso = "Atendimento Editado com sucesso";       
        } catch (Exception $e) {
            $this->retorno->erro = $e->getMessage();
        }
    }

    //Separa os sintomas entre editado, novo, excluido
    private function SepararSintomas($editados, $cadastrados) {          
        foreach ($cadastrados as $indiceRegistrado => $registrado) {
            foreach ($editados as $indiceEditado => $editado) {
                if ($registrado->Id === $editado->id) {
                    $retorno['editado'][] = $editado;

                    unset($cadastrados[$indiceRegistrado]);
                    unset($editados[$indiceEditado]);
                }
            }
        }
        
        $retorno['novo'] = $editados;
        $retorno['excluido'] = $cadastrados;

        return $retorno;
    }

    public function Deletar($dados) {
        $id = $dados['atendimento'];

        try {
            $this->atendimentoService->Excluir($id);

            $this->retorno->sucesso = "Atendimento deletado com sucesso";
        } catch (Exception $e) {
            $this->retorno->erro = $e->getMessage();
        }
    }

    public function Listar() {
        try {
            $this->retorno->lista = $this->atendimentoService->Listar();
        } catch (Exception $e) {
            $this->retorno->erro = $e->getMessage();
        }
    }
    
    public function ListarPessoal($dados) {
        $usuario = $dados['usuario'];
        
        try {
            $this->retorno->lista = $this->atendimentoService->Listar($usuario);
        } catch (Exception $e) {
            $this->retorno->erro = $e->getMessage();
        }
    }

    public function GetFichaMedica($dados) {
        $id = $dados['ficha'];

        try {
            $this->retorno->resultado = $this->fichaMedicaService->GetFicha($id);
        } catch (Exception $e) {
            $this->retorno->erro = $e->getMessage();
        }
    }

    public function GetAtendimento($dados) {
        $id = $dados['atendimento'];

        try {
            $atendimento = $this->atendimentoService->GetAtendimento($id);

            $paciente = $this->pacienteService->GetNomeRa($atendimento->paciente);

            $sintomas = $this->atendimentoSintomaService->GetSintomas($id);

            $this->retorno->atendimento = $atendimento;
            $this->retorno->paciente = $paciente;
            $this->retorno->sintomas = $sintomas;
        } catch (Exception $e) {
            $this->retorno->erro = $e->getMessage();
        }
    }

}
