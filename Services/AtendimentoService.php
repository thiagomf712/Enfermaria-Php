<?php

if (!defined('__ROOT__')) {
    define('__ROOT__', dirname(__FILE__, 2));
}

require_once(__ROOT__ . '/Models/Atendimento.php');

require_once(__ROOT__ . '/Services/Connection.php');

class AtendimentoService {

    public static function CadastrarAtendimento(Atendimento $atendimento) {
        $conn = Connection();

        $id = $atendimento->getId();
        $data = $atendimento->getData();
        $hora = $atendimento->getHora();
        $procedimento = $atendimento->getProcedimento();
        $pacienteId = $atendimento->getPaciente();
        $funcionarioId = $atendimento->getFuncionario();

        $sql = "INSERT INTO atendimento VALUES (:id, :data, :hora, :procedimento, :pacienteId, :funcionarioId)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':data', $data);
        $stmt->bindParam(':hora', $hora);
        $stmt->bindParam(':procedimento', $procedimento);
        $stmt->bindParam(':pacienteId', $pacienteId);
        $stmt->bindParam(':funcionarioId', $funcionarioId);

        try {
            $stmt->execute();
            
            if($stmt->rowCount() == 0){
                throw new Exception("Erro ao tentar cadastrar o atendimento");
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public static function RetornarAtendimento(Atendimento $atendimento) {
        $conn = Connection();

        $data = $atendimento->getData();
        $hora = $atendimento->getHora();
        $pacienteId = $atendimento->getPaciente();
        $funcionarioId = $atendimento->getFuncionario();   
        
        $sql = "SELECT Id FROM atendimento WHERE Data = :data AND Hora = :hora AND PacienteId = :pacienteId AND FuncionarioId = :funcionarioId";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':data', $data);
        $stmt->bindParam(':hora', $hora);
        $stmt->bindParam(':pacienteId', $pacienteId);
        $stmt->bindParam(':funcionarioId', $funcionarioId);
        $stmt->execute();

        $resultado = $stmt->fetch();

        if (empty($resultado)) {
            throw new Exception("Um erro inesperado aconteceu");
        }

        $atendimento->setId($resultado['Id']);
        
        return $atendimento;
    }

}
