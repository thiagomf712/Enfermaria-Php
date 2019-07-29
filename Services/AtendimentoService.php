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

            if ($stmt->rowCount() == 0) {
                throw new Exception("Erro ao tentar cadastrar o atendimento");
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public static function EditarAtendimento(Atendimento $atendimento) {
        $conn = Connection();

        $id = $atendimento->getId();
        $data = $atendimento->getData();
        $hora = $atendimento->getHora();
        $procedimento = $atendimento->getProcedimento();
        $funcionarioId = $atendimento->getFuncionario();

        $sql = "UPDATE atendimento SET Data = :data, Hora = :hora, Procedimento = :procedimento, FuncionarioId = :funcionarioId WHERE Id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':data', $data);
        $stmt->bindParam(':hora', $hora);
        $stmt->bindParam(':procedimento', $procedimento);
        $stmt->bindParam(':funcionarioId', $funcionarioId);

        try {
            $stmt->execute();
        } catch (Exception $e) {
            throw new Exception("Erro ao tentar editar o atendiemnto");
        }
    }
    
    public static function Excluir($id) {
        $conn = Connection();

        $sql = "DELETE FROM atendimento WHERE Id = :id";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);

        try {
            $stmt->execute();
            if($stmt->rowCount() == 0){
                throw new Exception("Não foi possivel deletar esse atendimento");
            }
        } catch (Exception $e) {
            throw new Exception("Não foi possivel deletar esse atendimento");
        }
    }

    public static function ListarAtendimentos($pacienteId = null) {
        $conn = Connection();
    
        $sql = "SELECT a.Id, a.Data, a.Hora, p.Nome, p.Id, f.Nome, f.Id "
                . "FROM atendimento a "
                . "INNER JOIN paciente p ON a.PacienteId = p.Id "
                . "INNER JOIN funcionario f ON a.FuncionarioId = f.Id ";
        
        if($pacienteId != null) {
            $sql .= "WHERE a.PacienteId = :pacienteId ";
        }
                
        $sql .= "ORDER BY a.Id";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam("pacienteId", $pacienteId);
        $stmt->execute();

        $resultado = $stmt->fetchAll();

        return $resultado;
    }

    public static function ListarAtendimentosOrdenado($coluna, $ordem, $pacienteId = null) {
        $conn = Connection();

        $sql = "SELECT a.Id, a.Data, a.Hora, p.Nome, p.Id, f.Nome, f.Id "
                . "FROM atendimento a "
                . "INNER JOIN paciente p ON a.PacienteId = p.Id "
                . "INNER JOIN funcionario f ON a.FuncionarioId = f.Id ";
        
        if($pacienteId != null) {
            $sql .= "WHERE a.PacienteId = :pacienteId ";
        }
        
        $sql .= "ORDER BY " . $coluna . " " . $ordem;

        $stmt = $conn->prepare($sql);
        $stmt->bindParam("pacienteId", $pacienteId);
        $stmt->execute();

        $resultado = $stmt->fetchAll();

        return $resultado;
    }

    public static function Filtrar($valor, $pacienteId = null) {
        $conn = Connection();

        $sql = "SELECT a.Id, a.Data, a.Hora, p.Nome, p.Id, f.Nome, f.Id "
                . "FROM atendimento a "
                . "INNER JOIN paciente p ON a.PacienteId = p.Id "
                . "INNER JOIN funcionario f ON a.FuncionarioId = f.Id "
                . "WHERE ";

        if($pacienteId != null) {
            $sql .= "a.PacienteId = :pacienteId AND ";
        }
        
        if (count($valor) >= 2) {
            for ($i = 0; $i < count($valor); $i++) {
                $sql .= $valor[$i][0];

                if ($valor[$i][0] == "a.Data") {
                    $sql .= AtendimentoService::DefinirFiltroData($valor[$i]);
                } else {
                    $sql .= " LIKE '%" . $valor[$i][1] . "%'";
                }

                if ($i !== count($valor) - 1) {
                    $sql .= ' AND ';
                }
            }
        } else {
            $sql .= $valor[0][0];

            if ($valor[0][0] == "a.Data") {
                $sql .= AtendimentoService::DefinirFiltroData($valor[0]);
            } else {
                $sql .= " LIKE '%" . $valor[0][1] . "%'";
            }
        }

        $_SESSION['valorFiltrado'] = $sql;

        $stmt = $conn->prepare($sql);
        $stmt->bindParam("pacienteId", $pacienteId);
        $stmt->execute();

        $resultado = $stmt->fetchAll();

        return $resultado;
    }

    public static function FiltrarOrdenado($coluna, $ordem) {
        $conn = Connection();

        $sql = $_SESSION['valorFiltrado'] . " ORDER BY " . $coluna . " " . $ordem;

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $resultado = $stmt->fetchAll();

        return $resultado;
    }

    private static function DefinirFiltroData($valor) {
        if ($valor['ope'] == 'entre') {
            $sql = " BETWEEN '" . $valor[1] . "' AND '" . $valor[2] . "'";
        } else if ($valor['ope'] == 'maior') {
            $sql = " >= '" . $valor[1] . "'";
        } else {
            $sql = " <= '" . $valor[1] . "'";
        }

        return $sql;
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

    public static function RetornarAtendimentoCompleto(int $id) {
        $conn = Connection();

        $sql = "SELECT * FROM atendimento WHERE Id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $resultado = $stmt->fetch();

        if (empty($resultado)) {
            throw new Exception("atendimento não encontrado");
        }

        return new Atendimento($resultado['Id'], $resultado['Data'], $resultado['Hora'], $resultado['Procedimento'], $resultado['PacienteId'], $resultado['FuncionarioId']);
    }

}
