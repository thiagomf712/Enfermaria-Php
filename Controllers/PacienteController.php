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

if (session_id() == '') {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['metodoPaciente'])) {
    $metodo = $_POST['metodoPaciente'];

    if (method_exists('PacienteController', $metodo)) {
        PacienteController::$metodo($_POST);
    } else {
        throw new Exception("Metodo não existe");
    }
}

class PacienteController {

    public static function Cadastrar($dados) {
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

        $paciente = new Paciente(0, $nome, $ra, $dataNascimento, $email, $telefone);

        $usuario = new Usuario(0);
        $usuario->DefinirUsuarioPadrao($paciente);

        try {
            UsuarioService::CadastrarUsuario($usuario);
            $usuariobd = UsuarioService::RetornarLogin($usuario->getLogin());

            $paciente->setUsuario($usuariobd);
            PacienteService::CadastrarPaciente($paciente);

            $pacientebd = PacienteService::RetornarPaciente($paciente->getRa());
            $fichaMedica = new FichaMedica(0, $planoSaude, $problemaSaude, $medicamento, $alergia, $cirurgia, $pacientebd);
            $endereco = new Endereco(0, $regime, $logradouro, $numero, $complemento, $bairro, $cidade, $estado, $cep, $pacientebd);

            FichaMedicaService::CadastrarFichaMedica($fichaMedica);
            EnderecoService::CadastrarEndereco($endereco);

            $_SESSION['sucesso'] = "Paciente cadastrado com sucesso";
            header("Location: ../Views/Paciente/Cadastrar.php");
            exit();
        } catch (Exception $e) {
            $_SESSION['erro'] = $e->getMessage();
            echo "<script language='javascript'>history.go(-1);</script>";
            exit();
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
        $fichaMedicaId = $dados['fichaMedicaId'];
        $enderecoId = $dados['enderecoId'];

        try {
            FichaMedicaService::Excluir($fichaMedicaId);

            EnderecoService::Excluir($enderecoId);

            PacienteService::Excluir($id);

            UsuarioService::Excluir($usuarioId);

            header("Location: ../Views/Paciente/Listar.php");
            $_SESSION['sucesso'] = "Paciente deletado com sucesso";
            exit();
        } catch (Exception $e) {
            $_SESSION['erro'] = $e->getMessage();
            echo "<script language='javascript'>history.go(-1);</script>";
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

    public static function RetornarIdPaciente($usuarioId) {
        try {
            $pacienteId = PacienteService::RetornarId($usuarioId);
            
            return $pacienteId[0];
        } catch (Exception $e) {
            $_SESSION['erro'] = $e->getMessage();
            echo "<script language='javascript'>history.go(-1);</script>";
            exit();
        }
    }

}
