<?php

if (!defined('__ROOT__')) {
    define('__ROOT__', dirname(__FILE__, 2));
}

require_once(__ROOT__ . '/Models/Paciente.php');
require_once(__ROOT__ . '/Models/Endereco.php');
require_once(__ROOT__ . '/Models/FichaMedica.php');
require_once(__ROOT__ . '/Models/Usuario.php');

require_once(__ROOT__ . '/Services/UsuarioService.php');
require_once(__ROOT__ . '/Services/PacienteService.php');
require_once(__ROOT__ . '/Services/EnderecoService.php');
require_once(__ROOT__ . '/Services/FichaMedicaService.php');



if (isset($_POST["metodoPaciente"])) {
    $controller = new PacienteController();

    $controller->Executar("metodoPaciente");
}

class PacienteController {

    public $retorno;
    private $pacienteService;
    private $usuarioService;
    private $enderecoService;
    private $fichaMedicaService;

    public function __construct() {
        $this->retorno = new stdClass();

        $this->pacienteService = new PacienteService();
        $this->usuarioService = new UsuarioService();
        $this->enderecoService = new EnderecoService();
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
        //Informações gerais
        $nome = $dados['nome'];
        $ra = $dados['ra'];
        $dataNascimento = $dados['dataNascimento'];
        $email = $dados['email'];
        $telefone = $dados['telefone'];

        //Ficha médica
        $planoSaude = $dados['planoSaude'];
        $problemaSaude = $dados['problemaSaude'];
        $medicamento = $dados['medicamento'];
        $alergia = $dados['alergia'];
        $cirurgia = $dados['cirurgia'];

        //Endereço
        $regime = $dados['regime'];
        $logradouro = $dados['rua'];
        $numero = $dados['numero'];
        $complemento = $dados['complemento'];
        $bairro = $dados['bairro'];
        $cidade = $dados['cidade'];
        $estado = $dados['estado'];
        $cep = $dados['cep'];

        $paciente = new Paciente(null, $nome, $ra, $dataNascimento, $email, $telefone);

        $usuario = new Usuario(null);
        $usuario->DefinirUsuarioPadrao($paciente);

        try {
            $this->usuarioService->CadastrarUsuario($usuario);

            $paciente->setUsuario($this->usuarioService->GetId($usuario->login));

            $this->pacienteService->Cadastrar($paciente);

            $pacienteId = $this->pacienteService->GetId($paciente->ra);

            $fichaMedica = new FichaMedica(null, $planoSaude, $problemaSaude, $medicamento, $alergia, $cirurgia, $pacienteId);
            $endereco = new Endereco(null, $regime, $logradouro, $numero, $complemento, $bairro, $cidade, $estado, $cep, $pacienteId);

            $this->fichaMedicaService->Cadastrar($fichaMedica);
            $this->enderecoService->Cadastrar($endereco);

            $this->retorno->sucesso = "Paciente cadastrado com sucesso";
        } catch (Exception $e) {
            $this->retorno->erro = $e->getMessage();
        }
    }

    public function Editar($dados) {
        //Informações gerais
        $id = $dados['paciente'];
        $nome = $dados['nome'];
        $ra = $dados['ra'];
        $dataNascimento = $dados['dataNascimento'];
        $email = $dados['email'];
        $telefone = $dados['telefone'];

        //Ficha médica
        $fichaMedicaId = $dados['ficha'];
        $planoSaude = $dados['planoSaude'];
        $problemaSaude = $dados['problemaSaude'];
        $medicamento = $dados['medicamento'];
        $alergia = $dados['alergia'];
        $cirurgia = $dados['cirurgia'];

        //Endereço
        $enderecoId = $dados['endereco'];
        $regime = $dados['regime'];
        $logradouro = $dados['rua'];
        $numero = $dados['numero'];
        $complemento = $dados['complemento'];
        $bairro = $dados['bairro'];
        $cidade = $dados['cidade'];
        $estado = $dados['estado'];
        $cep = $dados['cep'];

        try {
            $paciente = new Paciente($id, $nome, $ra, $dataNascimento, $email, $telefone);
            $this->pacienteService->Editar($paciente);

            $fichaMedica = new FichaMedica($fichaMedicaId, $planoSaude, $problemaSaude, $medicamento, $alergia, $cirurgia);
            $this->fichaMedicaService->Editar($fichaMedica);

            $endereco = new Endereco($enderecoId, $regime, $logradouro, $numero, $complemento, $bairro, $cidade, $estado, $cep);
            $this->enderecoService->Editar($endereco);

            $this->retorno->sucesso = "Paciente editado com sucesso";
        } catch (Exception $e) {
            $this->retorno->erro = $e->getMessage();
        }
    }

    public function Deletar($dados) {

        $id = $dados['paciente'];
        $usuarioId = $dados['usuario'];

        try {
            $this->pacienteService->Excluir($id);

            $this->usuarioService->Excluir($usuarioId);

            $this->retorno->sucesso = "Paciente deletado com sucesso";
        } catch (Exception $e) {
            $this->retorno->erro = $e->getMessage();
        }
    }

    public function Listar() {
        try {
            $this->retorno->lista = $this->pacienteService->Listar();
        } catch (Exception $e) {
            $this->retorno->erro = $e->getMessage();
        }
    }

    public function GetPaciente($dados) {
        $id = $dados["paciente"];
        $enderecoId = $dados["endereco"];
        $fichaId = $dados["ficha"];

        try {
            $paciente = $this->pacienteService->GetPaciente($id);
            $endereco = $this->enderecoService->GetEndereco($enderecoId);
            $ficha = $this->fichaMedicaService->GetFicha($fichaId);

            $paciente->setEndereco($endereco);
            $paciente->setFichaMedica($ficha);

            $this->retorno->resultado = $paciente;
        } catch (Exception $e) {
            $this->retorno->erro = $e->getMessage();
        }
    }

    public function GetPacientePessoal($dados) {
        $usuario = $dados['usuario'];
        
        try {       
            $paciente = $this->pacienteService->GetPacientePessoal($usuario);
            $endereco = $this->enderecoService->GetEndereco($paciente->id, true);
            $ficha = $this->fichaMedicaService->GetFicha($paciente->id, true);
            
            $paciente->setEndereco($endereco);
            $paciente->setFichaMedica($ficha);

            $this->retorno->resultado = $paciente;
        } catch (Exception $e) {
            $this->retorno->erro = $e->getMessage();
        }
    }

}
