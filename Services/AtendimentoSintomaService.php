<?php

if (!defined('__ROOT__')) {
    define('__ROOT__', dirname(__FILE__, 2));
}

require_once(__ROOT__ . '/Models/AtendimentoSintoma.php');

require_once(__ROOT__ . '/Services/Connection.php');

class AtendimentoSintomaService {   

    private $conn;

    public function __construct() {
        $this->conn = new Connection();
    }
    
    public function Cadastrar(AtendimentoSintoma $atendimentoSintoma) {
        $query = "INSERT INTO atendimentosintoma VALUES (:id, :atendimento, :sintoma, :especificacao)";
        
        $stmt = $stmt = $this->conn->Conectar()->prepare($query);
        $stmt->bindValue(':id', $atendimentoSintoma->id);
        $stmt->bindValue(':atendimento', $atendimentoSintoma->atendimento->id);
        $stmt->bindValue(':sintoma', $atendimentoSintoma->sintoma);
        $stmt->bindValue(':especificacao', $atendimentoSintoma->especificacao);

        if (!$stmt->execute()) {
            throw new Exception("Não é possivel registrar o mesmo sintoma duas vezes no mesmo atendimento");
        }
    }
    
    public function Editar(AtendimentoSintoma $atendimentoSintoma) { 
        $query = "UPDATE atendimentosintoma SET SintomaId = :sintoma, Especificacao = :especificacao WHERE Id = :id";
        
        $stmt = $stmt = $this->conn->Conectar()->prepare($query);
        $stmt->bindValue(':id', $atendimentoSintoma->id);
        $stmt->bindValue(':sintoma', $atendimentoSintoma->sintoma);
        $stmt->bindValue(':especificacao', $atendimentoSintoma->especificacao);

        if (!$stmt->execute()) {
            throw new Exception("Não é possivel registrar o mesmo sintoma duas vezes no mesmo atendimento");
        }
    }
    
    public function Excluir($id) {
        $query = "DELETE FROM atendimentosintoma WHERE Id = :id";

        $stmt = $stmt = $this->conn->Conectar()->prepare($query);
        $stmt->bindValue(':id', $id);

        if (!$stmt->execute()) {
            throw new Exception("Não é possivel deletar esse sintoma");
        }
    }
    
    public function GetIds(int $atendimentoId) {
        $query = "SELECT Id FROM atendimentosintoma WHERE AtendimentoId = :atendimentoId";
        
        $stmt = $stmt = $this->conn->Conectar()->prepare($query);
        $stmt->bindValue(':atendimentoId', $atendimentoId);
        
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }  

    public function GetSintomas(int $atendimentoId) {
        $query = "SELECT Id, SintomaId, Especificacao FROM atendimentosintoma WHERE AtendimentoId = :atendimentoId";
        
        $stmt = $stmt = $this->conn->Conectar()->prepare($query);
        $stmt->bindValue(':atendimentoId', $atendimentoId);
        
        $stmt->execute();

        $resultado = $stmt->fetchAll(PDO::FETCH_OBJ);

        if (empty($resultado)) {
            throw new Exception("Nenhum sintoma encontrado");
        }

        return $resultado;
    }
}
