<?php
if (!defined('__ROOT__')) {
    define('__ROOT__', dirname(__FILE__, 2));
}

require_once(__ROOT__ . '/Models/Funcionario.php');
require_once(__ROOT__ . '/Models/Usuario.php');

require_once(__ROOT__ . '/Services/Connection.php');


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

}
