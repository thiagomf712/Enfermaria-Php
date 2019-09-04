<?php

if (!defined('__ROOT__')) {
    define('__ROOT__', dirname(__FILE__, 2));
}

require_once(__ROOT__ . '/Models/Funcionario.php');
require_once(__ROOT__ . '/Models/Usuario.php');

require_once(__ROOT__ . '/Services/Connection.php');

class FuncionarioService {

    private $conn;

    public function __construct() {
        $this->conn = new Connection();
    }

    public function Cadastrar(Funcionario $funcionario) {
        $query = "INSERT INTO funcionario VALUES (:id, :nome, :usuarioId)";
        
        $stmt = $this->conn->Conectar()->prepare($query);
        $stmt->bindValue(':id', $funcionario->id);
        $stmt->bindValue(':nome', $funcionario->nome);
        $stmt->bindValue(':usuarioId', $funcionario->usuario->id);

        if (!$stmt->execute()) {
            throw new Exception("Erro ao tentar cadastrar o funcionario");
        }
    }

    public function Editar(Funcionario $funcionario) {
        $query = "UPDATE funcionario SET Nome = :nome WHERE Id = :id";
        
        $stmt = $this->conn->Conectar()->prepare($query);
        $stmt->bindValue(':id', $funcionario->id);
        $stmt->bindValue(':nome', $funcionario->nome);

        if (!$stmt->execute()) {
            throw new Exception("Erro ao tentar editar o funcionario");
        }
    }

    public function Listar() {
        $query = "SELECT "
                . "f.Id, f.Nome, f.UsuarioId, u.NivelAcesso "
                . "FROM funcionario f "
                . "LEFT JOIN usuario u ON f.UsuarioId = u.Id";

        $stmt = $this->conn->Conectar()->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function Excluir($id) {
        $query = "DELETE FROM funcionario WHERE Id = :id";

        $stmt = $this->conn->Conectar()->prepare($query);
        $stmt->bindValue(':id', $id);

        if (!$stmt->execute()) {
            throw new Exception("Não é possivel excluir um funcionario com atendimentos registrados");
        }
    }

    public function GetFuncionario(int $id) {
        $query = "SELECT Id, Nome FROM funcionario WHERE Id = :id";
        
        $stmt = $this->conn->Conectar()->prepare($query);
        $stmt->bindValue(':id', $id);
        
        $stmt->execute();

        $resultado = $stmt->fetch(PDO::FETCH_OBJ);

        if (empty($resultado)) {
            throw new Exception("Funcionario não encontrado");
        }

        return new Funcionario($resultado->Id, $resultado->Nome);
    }

    public function ListarNomes() {
        $query = "SELECT Id, Nome, UsuarioId FROM funcionario ORDER BY Nome";

        $stmt = $this->conn->Conectar()->prepare($query);
        
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

}
