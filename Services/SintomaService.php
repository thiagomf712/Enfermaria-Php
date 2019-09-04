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
    
    //Será editado
    public static function ListarSintomasEst() {
        $conn = Connection();

        $sql = "SELECT s.Id, s.Nome, COUNT(ats.Id) as Total "
                . "FROM sintoma s "
                . "LEFT JOIN atendimentosintoma ats ON s.Id = ats.SintomaId "
                . "WHERE s.Id = ats.SintomaId "
                . "GROUP BY s.Nome";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $resultado = $stmt->fetchAll();

        return $resultado;
    }

    //Será editado
    public static function ListarOcorrencias($sintomaId, $data = null) {
        $conn = Connection();

        $sql = "SELECT a.Id, a.Data, a.Hora, p.Nome as pNome, f.Nome as fNome "
                . "FROM atendimento a "
                . "INNER JOIN atendimentosintoma ats ON ats.AtendimentoId = a.Id "
                . "INNER JOIN sintoma s ON s.Id = ats.SintomaId "
                . "INNER JOIN paciente p ON a.PacienteId = p.Id "
                . "INNER JOIN funcionario f ON a.FuncionarioId = f.Id "
                . "WHERE :sintomaId = s.Id ";

        if ($data != null) {

            $sql .= "AND " . $data[0];

            $sql .= SintomaService::DefinirFiltroData($data);
        }

        $sql .= "ORDER BY a.data ";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam("sintomaId", $sintomaId);
        $stmt->execute();

        $resultado = $stmt->fetchAll();

        return $resultado;
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

    public static function RetornarNomesSintomas() {
        $conn = Connection();

        $sql = "SELECT Id, Nome FROM sintoma ORDER BY Nome";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $resultado = $stmt->fetchAll();

        return $resultado;
    }

}
