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

    public static function Editar($dados) {
        //Informações gerais
        $id = $dados['id'];
        $nome = $dados['nome'];
        $ra = $dados['ra'];
        $dataNascimento = $dados['dataNascimento'];
        $email = $dados['email'];
        $telefone = $dados['telefone'];

        //Ficha médica
        $fichaMedicaId = $dados['fichaMedicaId'];
        $planoSaude = $dados['planoSaude'];
        $problemaSaude = $dados['problemaSaude'];
        $medicamento = $dados['medicamento'];
        $alergia = $dados['alergia'];
        $cirurgia = $dados['cirurgia'];

        //Endereço
        $enderecoId = $dados['enderecoId'];
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
            PacienteService::EditarPaciente($paciente);

            $fichaMedica = new FichaMedica($fichaMedicaId, $planoSaude, $problemaSaude, $medicamento, $alergia, $cirurgia);
            FichaMedicaService::EditarFichaMedica($fichaMedica);

            $endereco = new Endereco($enderecoId, $regime, $logradouro, $numero, $complemento, $bairro, $cidade, $estado, $cep);
            EnderecoService::EditarEndereco($endereco);

            header("Location: ../Views/Paciente/Listar.php");
            $_SESSION['sucesso'] = "Paciente editado com sucesso";
            exit();
        } catch (Exception $e) {
            $_SESSION['erro'] = $e->getMessage();
            echo "<script language='javascript'>history.go(-1);</script>";
            exit();
        }
    }

    public static function Deletar($dados) {

        $id = $dados['pacienteId'];
        $usuarioId = $dados['usuarioId'];

        try {
            PacienteService::Excluir($id);

            UsuarioService::Excluir($usuarioId);

            header("Location: ../Views/Paciente/Listar.php");
            $_SESSION['sucesso'] = "Paciente deletado com sucesso";
            exit();
        } catch (Exception $e) {
            $_SESSION['erro'] = $e->getMessage();
            header("Location: ../Views/Paciente/Listar.php");
            exit();
        }
    }

    public static function Listar() {
        try {
            $pacientes = PacienteService::ListarPacientes();
            return $pacientes;
        } catch (Exception $e) {
            $_SESSION['erro'] = $e->getMessage();
            echo "<script language='javascript'>history.go(-1);</script>";
            exit();
        }
    }

    public static function Ordenar($dados) {
        $coluna = $dados['coluna'];
        $ordem = $dados['ordem'];

        $paciente = PacienteService::ListarPacientesOrdenado($coluna, $ordem);

        $_SESSION['coluna'] = $coluna;
        $_SESSION['estado'] = $ordem;

        $_SESSION['ordenado'] = serialize($paciente);
        header("Location: ../Views/Paciente/Listar.php");
        exit();
    }

    public static function Filtrar($dados) {
        $nome = $dados['nome'];
        $ra = $dados['ra'];
        $regime = $dados['regime'];

        if ($nome === '' && $regime === "0" && $ra == null) {
            header("Location: ../Views/Paciente/Listar.php");
            exit();
        }

        if ($nome !== '') {
            $valor[] = array('p.Nome', $nome);
        }

        if ($regime !== "0") {
            $valor[] = array('e.Regime', $regime);
        }

        if ($ra !== null) {
            $valor[] = array('p.Ra', $ra);
        }

        $pacientes = PacienteService::Filtrar($valor);


        $_SESSION['filtro'] = serialize($pacientes);
        header("Location: ../Views/Paciente/Listar.php");
        exit();
    }

    public static function OrdenarFiltro($dados) {
        $coluna = $dados['coluna'];
        $ordem = $dados['ordem'];

        $pacientes = PacienteService::FiltrarOrdenado($coluna, $ordem);

        $_SESSION['coluna'] = $coluna;
        $_SESSION['estado'] = $ordem;

        $_SESSION['filtroOrdenado'] = serialize($pacientes);
        header("Location: ../Views/Paciente/Listar.php");
        exit();
    }

    public static function RetornarPaciente($id, $enderecoId, $fichaMedicaId) {
        try {
            $paciente = PacienteService::RetornarPacienteCompleto($id);
            $endereco = EnderecoService::RetornarEndereco($enderecoId);
            $fichaMedica = FichaMedicaService::RetornarFichaMedica($fichaMedicaId);

            $paciente->setEndereco($endereco);
            $paciente->setFichaMedica($fichaMedica);

            return $paciente;
        } catch (Exception $e) {
            $_SESSION['erro'] = $e->getMessage();
            echo "<script language='javascript'>history.go(-1);</script>";
            exit();
        }
    }

    public static function RetornarIdPaciente($usuarioId, bool $cadastro = false) {
        try {
            $pacienteId = PacienteService::RetornarId($usuarioId, $cadastro);

            if ($cadastro) {
                return $pacienteId;
            } else {
                return $pacienteId[0];
            }
        } catch (Exception $e) {
            $_SESSION['erro'] = $e->getMessage();
            echo "<script language='javascript'>history.go(-1);</script>";
            exit();
        }
    }

}
