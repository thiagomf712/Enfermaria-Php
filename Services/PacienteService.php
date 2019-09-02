<?php

if (!defined('__ROOT__')) {
    define('__ROOT__', dirname(__FILE__, 2));
}

require_once(__ROOT__ . '/Models/Paciente.php');
require_once(__ROOT__ . '/Models/Usuario.php');

require_once(__ROOT__ . '/Services/Connection.php');

class PacienteService {

    private $conn;

    public function __construct() {
        $this->conn = new Connection();
    }

    public function Cadastrar(Paciente $paciente) {
        $this->VerificarRa($paciente->ra);

        $query = "INSERT INTO paciente VALUES (:id, :nome, :ra, :dataNascimento, :email, :telefone, :usuarioId)";

        $stmt = $this->conn->Conectar()->prepare($query);
        $stmt->bindValue(':id', $paciente->id);
        $stmt->bindValue(':nome', $paciente->nome);
        $stmt->bindValue(':ra', $paciente->ra);
        $stmt->bindValue(':dataNascimento', $paciente->dataNascimento);
        $stmt->bindValue(':email', $paciente->email);
        $stmt->bindValue(':telefone', $paciente->telefone);
        $stmt->bindValue(':usuarioId', $paciente->usuario->id);

        if (!$stmt->execute()) {
            throw new Exception("Erro ao tentar cadastrar o paciente");
        }
    }

    public function Editar(Paciente $paciente) {
        $query = "UPDATE paciente SET Nome = :nome, Ra = :ra, DataNascimento = :dataNascimento, Email = :email, Telefone = :telefone WHERE Id = :id";
        
        $stmt = $this->conn->Conectar()->prepare($query);
        $stmt->bindValue(':id', $paciente->id);
        $stmt->bindValue(':nome', $paciente->nome);
        $stmt->bindValue(':ra', $paciente->ra);
        $stmt->bindValue(':dataNascimento', $paciente->dataNascimento);
        $stmt->bindValue(':email', $paciente->email);
        $stmt->bindValue(':telefone', $paciente->telefone);

        if (!$stmt->execute()) {
            throw new Exception("Erro ao tentar editar o paciente");
        }
    }

    public function Excluir($id) {
        $query = "DELETE FROM paciente WHERE Id = :id";

        $stmt = $this->conn->Conectar()->prepare($query);
        $stmt->bindValue(':id', $id);

        if (!$stmt->execute()) {
            throw new Exception("Não é possivel excluir um paciente com atendimentos registrados");
        }
    }

    public function Listar() {
        $query = "SELECT e.Id as EnderecoId, f.Id as FichamedicaId, p.Id, p.UsuarioId, p.Nome, p.Ra, e.Regime FROM paciente p "
                . "LEFT JOIN endereco e ON e.PacienteId = p.Id "
                . "LEFT JOIN fichamedica f ON f.PacienteId = p.Id";

        $stmt = $this->conn->Conectar()->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    private function VerificarRa(string $ra) {
        $query = "SELECT Ra FROM paciente WHERE Ra = :ra";

        $stmt = $this->conn->Conectar()->prepare($query);
        $stmt->bindValue(':ra', $ra);

        $stmt->execute();

        $resultado = $stmt->fetch(PDO::FETCH_OBJ);

        if (!empty($resultado)) {
            throw new Exception("O Ra $ra já está cadastrado no sistema");
        }
    }

    public function GetId(string $ra) {
        $query = "SELECT Id FROM paciente WHERE Ra = :ra";

        $stmt = $this->conn->Conectar()->prepare($query);
        $stmt->bindValue(':ra', $ra);

        $stmt->execute();

        $resultado = $stmt->fetch(PDO::FETCH_OBJ);

        if (empty($resultado)) {
            throw new Exception("Paciente não encontrado"); //Esse erro só acontece se falhar no cadastro do paciente
        }

        return new Paciente($resultado->Id);
    }

    public function GetPaciente(int $id) {
        $query = "SELECT Id, Nome, Ra, DataNascimento, Email, Telefone FROM paciente WHERE Id = :id";
        
        $stmt = $this->conn->Conectar()->prepare($query);
        $stmt->bindValue(':id', $id);
        
        $stmt->execute();

        $resultado = $stmt->fetch(PDO::FETCH_OBJ);

        if (empty($resultado)) {
            throw new Exception("Paciente não encontrado");
        }

        return new Paciente($resultado->Id, $resultado->Nome, $resultado->Ra, $resultado->DataNascimento, $resultado->Email, $resultado->Telefone);
    }

    public static function RetornarNomeRa(int $id) {
        $conn = Connection();

        $sql = "SELECT Nome, Ra FROM paciente WHERE Id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $resultado = $stmt->fetch();

        if (empty($resultado)) {
            throw new Exception("Paciente não encontrado");
        }

        return $resultado;
    }

    public static function RetornarId(int $usuarioId, bool $cadastro) {
        $conn = Connection();

        if ($cadastro) {
            $sql = "SELECT p.Id, e.Id, f.Id "
                    . "FROM paciente p "
                    . "INNER JOIN endereco e ON e.PacienteId = p.Id "
                    . "INNER JOIN fichamedica f ON f.PacienteId = p.Id "
                    . "WHERE p.UsuarioId = :usuarioId";
        } else {
            $sql = "SELECT Id FROM paciente WHERE UsuarioId = :usuarioId";
        }

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':usuarioId', $usuarioId);
        $stmt->execute();

        $resultado = $stmt->fetch();

        if (empty($resultado)) {
            throw new Exception("Paciente não encontrado");
        }

        return $resultado;
    }

}
