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

        $resultado = $stmt->fetchAll();

        if (empty($resultado)) {
            throw new Exception("Esse usuario não existe");
        } else {
            if ($resultado[0]['Senha'] != $senha) {
                throw new Exception("Senha incorreta");
            } else {
                return new Usuario($resultado[0]['Id'], $resultado[0]['Login'],
                        $resultado[0]['Senha'], $resultado[0]['NivelAcesso']);
            }
        }
    }

}
