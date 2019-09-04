<?php

if (!defined('__ROOT__')) {
    define('__ROOT__', dirname(__FILE__, 2));
}

require_once(__ROOT__ . '/Models/Atendimento.php');

require_once(__ROOT__ . '/Services/Connection.php');

class AtendimentoService {

    private $conn;

    public function __construct() {
        $this->conn = new Connection();
    }

    public function Cadastrar(Atendimento $atendimento) {
        $query = "INSERT INTO atendimento VALUES (:id, :data, :hora, :procedimento, :paciente, :funcionario)";

        $stmt = $stmt = $this->conn->Conectar()->prepare($query);
        $stmt->bindValue(':id', $atendimento->id);
        $stmt->bindValue(':data', $atendimento->data);
        $stmt->bindValue(':hora', $atendimento->hora);
        $stmt->bindValue(':procedimento', $atendimento->procedimento);
        $stmt->bindValue(':paciente', $atendimento->paciente);
        $stmt->bindValue(':funcionario', $atendimento->funcionario);

        if (!$stmt->execute()) {
            throw new Exception("Não é possivel cadastrar o mesmo atendimento duas vezes");
        }
    }

    public function Editar(Atendimento $atendimento) {
        $query = "UPDATE atendimento SET Data = :data, Hora = :hora, Procedimento = :procedimento, FuncionarioId = :funcionario WHERE Id = :id";
        
        $stmt = $stmt = $this->conn->Conectar()->prepare($query);
        $stmt->bindValue(':id', $atendimento->id);
        $stmt->bindValue(':data', $atendimento->data);
        $stmt->bindValue(':hora', $atendimento->hora);
        $stmt->bindValue(':procedimento', $atendimento->procedimento);
        $stmt->bindValue(':funcionario', $atendimento->funcionario);

        if (!$stmt->execute()) {
            throw new Exception("Erro ao tentar editar o atendimento");
        }
    }

    public function Excluir($id) {
        $query = "DELETE FROM atendimento WHERE Id = :id";

        $stmt = $stmt = $this->conn->Conectar()->prepare($query);
        $stmt->bindValue(':id', $id);

        if (!$stmt->execute()) {
            throw new Exception("Não é possivel deletar esse atendimento");
        }
    }

    public function Listar() {
        $query = "SELECT a.Id, a.Data, a.Hora, p.Nome as Paciente, f.Nome as Funcionario "
                . "FROM atendimento a "
                . "LEFT JOIN paciente p ON a.PacienteId = p.Id "
                . "INNER JOIN funcionario f ON a.FuncionarioId = f.Id ";


        $stmt = $this->conn->Conectar()->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function GetId(Atendimento $atendimento) {
        $query = "SELECT Id FROM atendimento WHERE Data = :data AND Hora = :hora AND PacienteId = :pacienteId AND FuncionarioId = :funcionarioId";

        $stmt = $this->conn->Conectar()->prepare($query);
        $stmt->bindValue(':data', $atendimento->data);
        $stmt->bindValue(':hora', $atendimento->hora);
        $stmt->bindValue(':pacienteId', $atendimento->paciente);
        $stmt->bindValue(':funcionarioId', $atendimento->funcionario);

        $stmt->execute();

        $resultado = $stmt->fetch(PDO::FETCH_OBJ);

        if (empty($resultado)) {
            throw new Exception("Atendimento não encontrado");
        }

        return new Atendimento($resultado->Id);
    }

    public function GetAtendimento(int $id) {
        $query = "SELECT Id, Data, Hora, Procedimento, PacienteId, FuncionarioId FROM atendimento WHERE Id = :id";
        
        $stmt = $this->conn->Conectar()->prepare($query);
        $stmt->bindValue(':id', $id);
        
        
        $stmt->execute();

        $resultado = $stmt->fetch(PDO::FETCH_OBJ);

        if (empty($resultado)) {
            throw new Exception("Atendimento não encontrado");
        }

        return new Atendimento($resultado->Id, $resultado->Data, $resultado->Hora, $resultado->Procedimento, $resultado->PacienteId, $resultado->FuncionarioId);
    }

}
