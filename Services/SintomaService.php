<?php

if (!defined('__ROOT__')) {
    define('__ROOT__', dirname(__FILE__, 2));
}

require_once(__ROOT__ . '/Models/Sintoma.php');

require_once(__ROOT__ . '/Services/Connection.php');

class SintomaService {

    private $conn;

    public function __construct() {
        $this->conn = new Connection();
    }

    public function Cadastrar(Sintoma $sintoma) {
        $query = "INSERT INTO sintoma VALUES (:id, :nome)";

        $stmt = $this->conn->Conectar()->prepare($query);
        $stmt->bindValue(':id', $sintoma->id);
        $stmt->bindValue(':nome', $sintoma->nome);

        if (!$stmt->execute()) {
            throw new Exception("Erro ao tentar cadastrar o sintoma");
        }
    }

    public function Editar(Sintoma $sintoma) {
        $query = "UPDATE sintoma SET Nome = :nome WHERE Id = :id";

        $stmt = $this->conn->Conectar()->prepare($query);
        $stmt->bindValue(':id', $sintoma->id);
        $stmt->bindValue(':nome', $sintoma->nome);

        if (!$stmt->execute()) {
            throw new Exception("Erro ao tentar editar o sintoma");
        }
    }

    public function Excluir($id) {
        $query = "DELETE FROM sintoma WHERE Id = :id";

        $stmt = $this->conn->Conectar()->prepare($query);
        $stmt->bindValue(':id', $id);

        if (!$stmt->execute()) {
            throw new Exception("Não é possivel excluir um sintoma registrado em algum atendimento");
        }
    }

    public function Listar() {
        $query = "SELECT Id, Nome FROM sintoma ORDER BY Nome";

        $stmt = $this->conn->Conectar()->prepare($query);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function ListarQuantidade() {
        $query = "SELECT a.Data "
                . "FROM sintoma s "
                . "LEFT JOIN atendimentosintoma ats ON s.Id = ats.SintomaId "
                . "INNER JOIN atendimento a ON ats.AtendimentoId = a.Id "
                . "WHERE s.Id = ats.SintomaId ";

        $stmt = $this->conn->Conectar()->prepare($query);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function ListarAgrupado($inicio, $fim) {
        $query = "SELECT s.Nome as Valor, COUNT(ats.Id) as Quantidade "
                . "FROM sintoma s "
                . "LEFT JOIN atendimentosintoma ats ON s.Id = ats.SintomaId "
                . "INNER JOIN atendimento a ON ats.AtendimentoId = a.Id "
                . "WHERE s.Id = ats.SintomaId ";

        if ($inicio !== '') {
            $query .= "AND a.Data >= :inicio ";
        }

        if ($fim !== '') {
            $query .= "AND a.Data <= :fim ";
        }

        $query .= "GROUP BY Valor "
                . "ORDER BY Quantidade DESC";

        $stmt = $this->conn->Conectar()->prepare($query);
        
        if ($inicio !== '') {
            $stmt->bindValue(':inicio', $inicio);
        }

        if ($fim !== '') {
            $stmt->bindValue(':fim', $fim);
        } 

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function GetSintoma(int $id) {
        $query = "SELECT Id, Nome FROM sintoma WHERE Id = :id";

        $stmt = $this->conn->Conectar()->prepare($query);
        $stmt->bindValue(':id', $id);

        $stmt->execute();

        $resultado = $stmt->fetch(PDO::FETCH_OBJ);

        if (empty($resultado)) {
            throw new Exception("Sintoma não encontrado");
        }

        return new Sintoma($resultado->Id, $resultado->Nome);
    }
}
