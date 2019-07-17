<?php

require_once '../Services/UsuarioService.php';
require_once '../Services/PacienteService.php';
require_once '../Services/EnderecoService.php';
require_once '../Services/FichaMedicaService.php';

require_once '../Models/Paciente.php';
require_once '../Models/Endereco.php';
require_once '../Models/FichaMedica.php';
require_once '../Models/Usuario.php';

session_start();

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

            FichaMedicaService::CadastrarEndereco($fichaMedica);
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

}
