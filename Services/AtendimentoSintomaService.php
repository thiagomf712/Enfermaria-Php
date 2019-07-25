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
                throw new Exception("Erro ao tentar registrar os sintomas apresentados");
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
