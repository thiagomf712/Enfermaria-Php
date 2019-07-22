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


        $sql = "INSERT INTO sintoma VALUES (:id, :nome)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nome', $nome);

        try {
            $stmt->execute();
        } catch (Exception $e) {
            throw new Exception("Erro ao tentar cadastrar o sintoma");
        }
    }

    public static function ListarSintomas(){
        $conn = Connection();

        $sql = "SELECT * FROM sintoma";
        
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        
        $resultado = $stmt->fetchAll();
        
        return $resultado;
    }
    
    public static function ListarSintomasOrdenado($coluna, $ordem){
        $conn = Connection();

        $sql = "SELECT * FROM sintoma ORDER BY " . $coluna . " " . $ordem;
        
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        
        $resultado = $stmt->fetchAll();
        
        return $resultado;
    }
}
