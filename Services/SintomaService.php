<?php
if (!defined('__ROOT__')) {
    define('__ROOT__', dirname(__FILE__, 2));
}

require_once(__ROOT__ . '/Models/Sintoma.php');

require_once(__ROOT__ . '/Services/Connection.php');


class SintomaService {

    public static function CadastrarSintoma(Sintoma $sintoma) {
        $conn = Connection();

        $id = $sintoma->getId();
        $nome = $sintoma->getNome();
        $procedimento = $sintoma->getProcedimento();


        $sql = "INSERT INTO sintoma VALUES (:id, :nome, :procedimento)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':procedimento', $procedimento);

        try {
            $stmt->execute();
        } catch (Exception $e) {
            throw new Exception("Erro ao tentar cadastrar o sintoma");
        }
    }

    public static function ListarSintomas(){
        
    }
}
