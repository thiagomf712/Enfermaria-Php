<?php

if (!defined('__ROOT__')) {
    define('__ROOT__', dirname(__FILE__, 2));
}

/*
  if (session_id() == '') {
  session_start();
  }
 */

require_once(__ROOT__ . '/Models/Funcionario.php');
require_once(__ROOT__ . '/Models/Usuario.php');

require_once(__ROOT__ . '/Services/Connection.php');

class FuncionarioService {

    private $conn;

    public function __construct() {
        $this->conn = new Connection();
    }

    public function CadastrarFuncionario(Funcionario $funcionario) {
        $query = "INSERT INTO funcionario VALUES (:id, :nome, :usuarioId)";
        
        $stmt = $this->conn->Conectar()->prepare($query);
        $stmt->bindValue(':id', $funcionario->id);
        $stmt->bindValue(':nome', $funcionario->nome);
        $stmt->bindValue(':usuarioId', $funcionario->usuario->id);

        if (!$stmt->execute()) {
            throw new Exception("Erro ao tentar cadastrar o funcionario");
        }
    }

    public static function EditarFuncionario(Funcionario $funcionario) {
        $conn = Connection();

        $id = $funcionario->getId();
        $nome = $funcionario->getNome();

        $sql = "UPDATE funcionario SET Nome = :nome WHERE Id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nome', $nome);

        try {
            $stmt->execute();
        } catch (Exception $e) {
            throw new Exception("Erro ao tentar editar o funcionario");
        }
    }

    public static function ListarFuncionarios() {
        $conn = Connection();

        $sql = "SELECT f.Id, f.Nome, f.UsuarioId, u.NivelAcesso FROM funcionario f "
                . "INNER JOIN usuario u ON f.UsuarioId = u.Id";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $resultado = $stmt->fetchAll();

        return $resultado;
    }

    public static function ListarFuncionarioOrdenado($coluna, $ordem) {
        $conn = Connection();

        $sql = "SELECT f.Id, f.Nome, f.UsuarioId, u.NivelAcesso FROM funcionario f "
                . "INNER JOIN usuario u ON f.UsuarioId = u.Id ORDER BY " . $coluna . " " . $ordem;

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $resultado = $stmt->fetchAll();

        return $resultado;
    }

    public static function Filtrar($valor) {
        $conn = Connection();

        if (count($valor) >= 2) {
            $sql = "SELECT f.Id, f.Nome, f.UsuarioId, u.NivelAcesso FROM funcionario f INNER JOIN usuario u"
                    . " ON f.UsuarioId = u.Id WHERE ";

            for ($i = 0; $i < count($valor); $i++) {
                $sql .= $valor[$i][0];

                if ($valor[$i][0] == "u.NivelAcesso") {
                    $sql .= " = " . $valor[$i][1];
                } else {
                    $sql .= " LIKE '%" . $valor[$i][1] . "%'";
                }

                if ($i !== count($valor) - 1) {
                    $sql .= ' AND ';
                }
            }
        } else {
            $sql = "SELECT f.Id, f.Nome, f.UsuarioId, u.NivelAcesso FROM funcionario f INNER JOIN usuario u "
                    . " ON f.UsuarioId = u.Id WHERE " . $valor[0][0];

            if ($valor[0][0] == "NivelAcesso") {
                $sql .= " = " . $valor[0][1];
            } else {
                $sql .= " LIKE '%" . $valor[0][1] . "%'";
            }
        }

        $_SESSION['valorFiltrado'] = $sql;

        $stmt = $conn->prepare($sql);
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

    public static function Excluir($id) {
        $conn = Connection();

        $sql = "DELETE FROM funcionario WHERE Id = :id";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);

        try {
            $stmt->execute();
            if ($stmt->rowCount() == 0) {
                throw new Exception("Não é possivel excluir um funcionario com atendimentos registrados");
            }
        } catch (Exception $e) {
            throw new Exception("Não é possivel excluir um funcionario com atendimentos registrados");
        }
    }

    public static function RetornarFuncionario(int $id) {
        $conn = Connection();

        $sql = "SELECT * FROM funcionario WHERE Id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $resultado = $stmt->fetch();

        if (empty($resultado)) {
            throw new Exception("Funcionario não encontrado");
        }

        return new Funcionario($resultado['Id'], $resultado['Nome']);
    }

    public static function RetornarNomesFuncionarios() {
        $conn = Connection();

        $sql = "SELECT Id, Nome, UsuarioId FROM funcionario ORDER BY Nome";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $resultado = $stmt->fetchAll();

        return $resultado;
    }

}
