<?php

require_once 'Connection.php';
require_once '../Models/Paciente.php';
require_once '../Models/Usuario.php';

class PacienteService {

    public static function CadastrarPaciente(Paciente $paciente) {
        $conn = Connection();

        $id = $paciente->getId();
        $nome = $paciente->getNome();
        $ra = $paciente->getRa();
        $dataNascimento = $paciente->getDataNascimento();
        $email = $paciente->getEmail();
        $telefone = $paciente->getTelefone();
        $usuarioId = $paciente->getUsuario()->getId();
       
        PacienteService::VerificarRaExiste($ra);

        $sql = "INSERT INTO paciente VALUES (:id, :nome, :ra, :dataNascimento, :email, :telefone, :usuarioId)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':ra', $ra);
        $stmt->bindParam(':dataNascimento', $dataNascimento);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telefone', $telefone);
        $stmt->bindParam(':usuarioId', $usuarioId);

        try {
            $stmt->execute();
        } catch (Exception $e) {
            throw new Exception("Erro ao tentar cadastrar o paciente");
        }
    }

    private static function VerificarRaExiste(string $ra) {
        $conn = Connection();

        $sql = "SELECT Ra FROM paciente WHERE Ra = :ra";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':ra', $ra);
        $stmt->execute();

        $resultado = $stmt->fetch();

        if (!empty($resultado)) {
            throw new Exception("O Ra {$ra} já está cadastrado no sistema");
        }
    }
    
    public static function RetornarPaciente(string $ra) {
        $conn = Connection();

        $sql = "SELECT * FROM paciente WHERE Ra = :ra";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':ra', $ra);
        $stmt->execute();

        $resultado = $stmt->fetch();
        
        if (empty($resultado)) {
            throw new Exception("Um erro inesperado aconteceu");
        } else {
            return new Paciente($resultado['Id'], $resultado['Nome'],
                    $resultado['Ra'], $resultado['DataNascimento'], $resultado['Email'], $resultado['Telefone']);
        }
    }
}
