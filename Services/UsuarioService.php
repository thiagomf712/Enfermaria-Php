<?php

if (!defined('__ROOT__')) {
    define('__ROOT__', dirname(__FILE__, 2));
}

require_once(__ROOT__ . '/Models/Usuario.php');
require_once(__ROOT__ . '/Services/Connection.php');

class UsuarioService {

    private $conn;

    public function __construct() {
        $this->conn = new Connection();
    }

    public function ValidarLogin(string $login, string $senha) {
        $query = "SELECT Id, Login, Senha, NivelAcesso FROM usuario WHERE Login = :login";

        $stmt = $this->conn->Conectar()->prepare($query);
        $stmt->bindValue(':login', $login);

        $stmt->execute();

        $resultado = $stmt->fetch(PDO::FETCH_OBJ);

        if (empty($resultado)) {
            throw new Exception("Esse usuario não existe");
        }

        if ($resultado->Senha != $senha) {
            throw new Exception("Senha incorreta");
        }

        //O login e senha não são necessarios para a session
        return new Usuario($resultado->Id, null, null, $resultado->NivelAcesso);
    }

    public function CadastrarUsuario(Usuario $usuario) {
        $this->VerificarLoginExiste($usuario->login);

        $query = "INSERT INTO usuario VALUES (:id, :login, :senha, :nivelAcesso)";

        $stmt = $this->conn->Conectar()->prepare($query);
        $stmt->bindValue(':id', $usuario->id);
        $stmt->bindValue(':login', $usuario->login);
        $stmt->bindValue(':senha', $usuario->senha);
        $stmt->bindValue(':nivelAcesso', $usuario->nivelAcesso);

        if (!$stmt->execute()) {
            throw new Exception("Erro ao tentar cadastrar o usuario");
        }
    }

    public function Editar(Usuario $usuario) {
        $querry = "UPDATE usuario SET Login = :login, NivelAcesso = :nivelAcesso WHERE Id = :id";
        
        $stmt = $this->conn->Conectar()->prepare($querry);
        $stmt->bindValue(':id', $usuario->id);
        $stmt->bindValue(':login', $usuario->login);
        $stmt->bindValue(':nivelAcesso', $usuario->nivelAcesso);

        if (!$stmt->execute()) {
            throw new Exception("Erro ao tentar editar o usuario");
        }
    }

    public static function AlterarSenha(int $id, string $senha) {
        $conn = Connection();

        $sql = "UPDATE usuario SET Senha = :senha WHERE Id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':senha', $senha);

        try {
            $stmt->execute();
        } catch (Exception $e) {
            throw new Exception("Erro ao tentar alterar a senha");
        }
    }

    public function Excluir($id) {
        $query = "DELETE FROM usuario WHERE Id = :id";

        $stmt = $this->conn->Conectar()->prepare($query);
        $stmt->bindValue(':id', $id);

        if (!$stmt->execute()) {
            throw new Exception("Não foi possivel excluir o usuario");
        }
    }

    public static function ListarUsuarios() {
        $conn = Connection();

        $sql = "SELECT Id, Login, NivelAcesso FROM usuario";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $resultado = $stmt->fetchAll();

        return $resultado;
    }

    public static function ListarUsuariosOrdenado($coluna, $ordem) {
        $conn = Connection();

        $sql = "SELECT Id, Login, NivelAcesso FROM usuario ORDER BY " . $coluna . " " . $ordem;

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $resultado = $stmt->fetchAll();

        return $resultado;
    }

    public static function Filtrar($valor) {
        $conn = Connection();

        if (count($valor) >= 2) {
            $sql = "SELECT Id, Login, NivelAcesso FROM usuario WHERE ";

            for ($i = 0; $i < count($valor); $i++) {
                $sql .= $valor[$i][0];

                if ($valor[$i][0] == "NivelAcesso") {
                    $sql .= " = " . $valor[$i][1];
                } else {
                    $sql .= " LIKE '%" . $valor[$i][1] . "%'";
                }

                if ($i !== count($valor) - 1) {
                    $sql .= ' AND ';
                }
            }
        } else {
            $sql = "SELECT Id, Login, NivelAcesso FROM usuario WHERE " . $valor[0][0];

            if ($valor[0][0] == "NivelAcesso") {
                $sql .= " = " . $valor[0][1];
            } else {
                $sql .= " LIKE '%" . $valor[0][1] . "%'";
            }
        }

        $_SESSION['valorFiltrado'] = $sql;

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $resultado = $stmt->fetchAll();

        return $resultado;
    }

    public static function FiltrarOrdenado($coluna, $ordem) {
        $conn = Connection();

        $sql = $_SESSION['valorFiltrado'] . " ORDER BY " . $coluna . " " . $ordem;

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $resultado = $stmt->fetchAll();

        return $resultado;
    }

    //Verifica se um login já está cadastrado no sistema
    private function VerificarLoginExiste(string $login) {
        $query = "SELECT Login FROM usuario WHERE Login = :login";

        $stmt = $this->conn->Conectar()->prepare($query);
        $stmt->bindValue(':login', $login);

        $stmt->execute();

        $resultado = $stmt->fetch(PDO::FETCH_OBJ);

        if (!empty($resultado)) {
            throw new Exception("O usuario $login já está cadastrado no sistema");
        }
    }

    //Metodo que retona o id de um usuario
    public function GetId(string $login) {
        $query = "SELECT Id FROM usuario WHERE Login = :login";

        $stmt = $this->conn->Conectar()->prepare($query);
        $stmt->bindValue(':login', $login);

        $stmt->execute();

        $resultado = $stmt->fetch(PDO::FETCH_OBJ);

        if (empty($resultado)) {
            throw new Exception("Login não localizado no banco de dados");
        } else {
            return new Usuario($resultado->Id, null, null, null);
        }
    }

    //Retorna o usuario a partir do id passado
    public function GetUsuario(int $id) {
        $query = "SELECT Id, Login, NivelAcesso FROM usuario WHERE Id = :id";

        $stmt = $this->conn->Conectar()->prepare($query);
        $stmt->bindValue(':id', $id);

        $stmt->execute();

        $resultado = $stmt->fetch(PDO::FETCH_OBJ);

        if (empty($resultado)) {
            throw new Exception("Usuario não encontrado");
        }

        return new Usuario($resultado->Id, $resultado->Login, null, $resultado->NivelAcesso);
    }

}
