<?php

if (!defined('__ROOT__')) {
    define('__ROOT__', dirname(__FILE__, 2));
}

require_once(__ROOT__ . '/Models/AtendimentoSintoma.php');

require_once(__ROOT__ . '/Services/Connection.php');

class AtendimentoSintomaService {   

    public static function CadastrarAtendimentoSintoma(AtendimentoSintoma $atendimentoSintoma) {
        $conn = Connection();

        $id = $atendimentoSintoma->getId();        
        $atendimentoId = $atendimentoSintoma->getAtendimento();
        $sintomaId = $atendimentoSintoma->getSintoma();
        $especificacao = $atendimentoSintoma->getEspecificacao();

        $sql = "INSERT INTO atendimentosintoma VALUES (:id, :atendimentoId, :sintomaId, :especificacao)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':atendimentoId', $atendimentoId);
        $stmt->bindParam(':sintomaId', $sintomaId);
        $stmt->bindParam(':especificacao', $especificacao);

        try {
            $stmt->execute();
            
            if($stmt->rowCount() == 0){
                throw new Exception("Não é possivel cadastrar o mesmo sintoma duas vezes");
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
    
    public static function EditarAtendimentoSintoma(AtendimentoSintoma $atendimentoSintoma) {
        $conn = Connection();
        
        $id = $atendimentoSintoma->getId();        
        $sintomaId = $atendimentoSintoma->getSintoma();
        $especificacao = $atendimentoSintoma->getEspecificacao();

        $sql = "UPDATE atendimentosintoma SET SintomaId = :sintomaId, Especificacao = :especificacao WHERE Id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':sintomaId', $sintomaId);
        $stmt->bindParam(':especificacao', $especificacao);

        try {
            $stmt->execute();
        } catch (Exception $e) {
            throw new Exception("Erro ao tentar editar os sintomas");
        }
    }
    
    public static function Excluir($id) {
        $conn = Connection();

        $sql = "DELETE FROM atendimentosintoma WHERE Id = :id";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);

        try {
            $stmt->execute();
            if($stmt->rowCount() == 0){
                throw new Exception("Não foi possivel deletar esse sintoma");
            }
        } catch (Exception $e) {
            throw new Exception("Não foi possivel deletar esse sintoma");
        }
    }
    
    public static function RetornarSintomas(int $atendimentoId) {
        $conn = Connection();

        $sql = "SELECT Id, SintomaId, Especificacao FROM atendimentosintoma WHERE AtendimentoId = :atendimentoId";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':atendimentoId', $atendimentoId);
        $stmt->execute();

        $resultado = $stmt->fetchAll();

        if (empty($resultado)) {
            throw new Exception("erro inexperado");
        }

        return $resultado;
    }
}
