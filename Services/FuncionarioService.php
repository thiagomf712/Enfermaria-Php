<?php

require_once 'Connection.php';
require_once '../Models/Funcionario.php';
require_once '../Models/Usuario.php';

class FuncionarioService {

    public static function CadastrarFuncionario(Funcionario $funcionario) {
        $conn = Connection();

        $id = $funcionario->getId();
        $nome = $funcionario->getNome();
        $usuarioId = $funcionario->getUsuario()->getId(); 
        
        
        $sql = "INSERT INTO funcionario VALUES (:id, :nome, :usuarioId)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':usuarioId', $usuarioId);

        try {
            $stmt->execute();
        } catch (Exception $e) {
            throw new Exception("Erro ao tentar cadastrar o funcionario");
        }
    }

}
