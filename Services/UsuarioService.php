<?php

require_once 'Connection.php';
require_once '../Models/Usuario.php';

class UsuarioService {

    public static function ValidarLogin(string $login, string $senha) {
        $conn = Connection();

        $sql = "SELECT * FROM usuario WHERE Login = :login";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':login', $login);
        $stmt->execute();

        $resultado = $stmt->fetch();


        if (empty($resultado)) {
            throw new Exception("Esse usuario não existe");
        } else {
            if ($resultado['Senha'] != $senha) {
                throw new Exception("Senha incorreta");
            } else {
                return new Usuario($resultado['Id'], $resultado['Login'],
                        $resultado['Senha'], $resultado['NivelAcesso']);
            }
        }
    }

    public static function CadastrarUsuario(Usuario $usuario) {
        $conn = Connection();

        UsuarioService::VerificarLoginExiste($usuario->getLogin());
        
        $id = $usuario->getId();
        $login = $usuario->getLogin();
        $senha = $usuario->getSenha();
        $nivelAcesso = $usuario->getNivelAcesso();
        
        $sql = "INSERT INTO usuario VALUES (:id, :login, :senha, :nivelAcesso)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':login', $login);
        $stmt->bindParam(':senha', $senha);
        $stmt->bindParam(':nivelAcesso', $nivelAcesso);

        try {   
            $stmt->execute();
        } catch (Exception $e) {
            throw new Exception("Erro ao tentar cadastrar o usuario");
        }
    }

    private static function VerificarLoginExiste(string $login) {
        $conn = Connection();

        $sql = "SELECT Login FROM usuario WHERE Login = :login";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':login', $login);
        $stmt->execute();

        $resultado = $stmt->fetch();

        if (!empty($resultado)) {
            throw new Exception("O usuario {$login} já está cadastrado no sistema");
        }
    }

    //Função para passar o Id de um usuario para o Funcionario ou o Paciente
    public static function RetornarLogin(string $login) {
        $conn = Connection();

        $sql = "SELECT * FROM usuario WHERE Login = :login";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':login', $login);
        $stmt->execute();

        $resultado = $stmt->fetch();
        
        if (empty($resultado)) {
            throw new Exception("Um erro inesperado aconteceu");
        } else {
            return new Usuario($resultado['Id'], $resultado['Login'],
                    $resultado['Senha'], $resultado['NivelAcesso']);
        }
    }

}
