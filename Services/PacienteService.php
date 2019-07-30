<?php

if (!defined('__ROOT__')) {
    define('__ROOT__', dirname(__FILE__, 2));
}

require_once(__ROOT__ . '/Models/Paciente.php');
require_once(__ROOT__ . '/Models/Usuario.php');

require_once(__ROOT__ . '/Services/Connection.php');

class PacienteService {

    public static function CadastrarPaciente(Paciente $paciente) {
        $conn = Connection();

        $id = $paciente->getId();
        $nome = $paciente->getNome();
        $ra = $paciente->getRa();
        $dataNascimento = $paciente->getDataNascimento();
        $email = $paciente->getEmail();
        $telefone = $paciente->getTelefone();
        $usuarioId = $paciente->getUsuario()->getId();

        PacienteService::VerificarRaExiste($ra);

        $sql = "INSERT INTO paciente VALUES (:id, :nome, :ra, :dataNascimento, :email, :telefone, :usuarioId)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':ra', $ra);
        $stmt->bindParam(':dataNascimento', $dataNascimento);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telefone', $telefone);
        $stmt->bindParam(':usuarioId', $usuarioId);

        try {
            $stmt->execute();
        } catch (Exception $e) {
            throw new Exception("Erro ao tentar cadastrar o paciente");
        }
    }

    public static function EditarPaciente(Paciente $paciente) {
        $conn = Connection();

        $id = $paciente->getId();
        $nome = $paciente->getNome();
        $ra = $paciente->getRa();
        $dataNascimento = $paciente->getDataNascimento();
        $email = $paciente->getEmail();
        $telefone = $paciente->getTelefone();

        $sql = "UPDATE paciente SET Nome = :nome, Ra = :ra, DataNascimento = :dataNascimento, Email = :email, Telefone = :telefone WHERE Id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':ra', $ra);
        $stmt->bindParam(':dataNascimento', $dataNascimento);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telefone', $telefone);

        try {
            $stmt->execute();
        } catch (Exception $e) {
            throw new Exception("Erro ao tentar editar o paciente");
        }
    }

    public static function Excluir($id) {
        $conn = Connection();

        $sql = "DELETE FROM paciente WHERE Id = :id";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);

        try {
            $stmt->execute();
            if ($stmt->rowCount() == 0) {
                throw new Exception("Não é possivel excluir um paciente com atendimentos registrados");
            }
        } catch (Exception $e) {
            throw new Exception("Não é possivel excluir um paciente com atendimentos registrados");
        }
    }

    public static function ListarPacientes() {
        $conn = Connection();

        $sql = "SELECT e.Id, f.Id, e.PacienteId, p.UsuarioId, p.Nome, p.Ra, e.Regime FROM paciente p "
                . "INNER JOIN endereco e ON e.PacienteId = p.Id "
                . "INNER JOIN fichamedica f ON f.PacienteId = p.Id";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $resultado = $stmt->fetchAll();

        return $resultado;
    }

    public static function ListarPacientesOrdenado($coluna, $ordem) {
        $conn = Connection();

        $sql = "SELECT e.Id, f.Id, e.PacienteId, p.UsuarioId, p.Nome, p.Ra, e.Regime FROM paciente p "
                . "INNER JOIN endereco e ON e.PacienteId = p.Id "
                . "INNER JOIN fichamedica f ON f.PacienteId = p.Id ORDER BY " . $coluna . " " . $ordem;

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $resultado = $stmt->fetchAll();

        return $resultado;
    }

    public static function Filtrar($valor) {
        $conn = Connection();

        $sql = "SELECT e.Id, f.Id, e.PacienteId, p.UsuarioId, p.Nome, p.Ra, e.Regime FROM paciente p "
                . "INNER JOIN endereco e ON e.PacienteId = p.Id "
                . "INNER JOIN fichamedica f ON f.PacienteId = p.Id WHERE ";

        if (count($valor) >= 2) {
            for ($i = 0; $i < count($valor); $i++) {
                $sql .= $valor[$i][0];

                if ($valor[$i][0] == "e.Regime") {
                    $sql .= " = " . $valor[$i][1];
                } else {
                    $sql .= " LIKE '%" . $valor[$i][1] . "%'";
                }

                if ($i !== count($valor) - 1) {
                    $sql .= ' AND ';
                }
            }
        } else {
            $sql .= $valor[0][0];

            if ($valor[0][0] == "e.Regime") {
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

    private static function VerificarRaExiste(string $ra) {
        $conn = Connection();

        $sql = "SELECT Ra FROM paciente WHERE Ra = :ra";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':ra', $ra);
        $stmt->execute();

        $resultado = $stmt->fetch();

        if (!empty($resultado)) {
            throw new Exception("O Ra {$ra} já está cadastrado no sistema");
        }
    }

    public static function RetornarPaciente(string $ra) {
        $conn = Connection();

        $sql = "SELECT * FROM paciente WHERE Ra = :ra";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':ra', $ra);
        $stmt->execute();

        $resultado = $stmt->fetch();

        if (empty($resultado)) {
            throw new Exception("Um erro inesperado aconteceu");
        }

        return new Paciente($resultado['Id'], $resultado['Nome'],
                $resultado['Ra'], $resultado['DataNascimento'], $resultado['Email'], $resultado['Telefone']);
    }

    public static function RetornarPacienteCompleto(int $id) {
        $conn = Connection();

        $sql = "SELECT * FROM paciente WHERE Id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $resultado = $stmt->fetch();

        if (empty($resultado)) {
            throw new Exception("Paciente não encontrado");
        }

        return new Paciente($resultado['Id'], $resultado['Nome'], $resultado['Ra'], $resultado['DataNascimento'], $resultado['Email'], $resultado['Telefone']);
    }

    public static function RetornarNomeRa(int $id) {
        $conn = Connection();

        $sql = "SELECT Nome, Ra FROM paciente WHERE Id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $resultado = $stmt->fetch();

        if (empty($resultado)) {
            throw new Exception("Paciente não encontrado");
        }

        return $resultado;
    }

    public static function RetornarId(int $usuarioId, bool $cadastro) {
        $conn = Connection();

        if ($cadastro) {
            $sql = "SELECT p.Id, e.Id, f.Id "
                    . "FROM paciente p "
                    . "INNER JOIN endereco e ON e.PacienteId = p.Id "
                    . "INNER JOIN fichamedica f ON f.PacienteId = p.Id "
                    . "WHERE p.UsuarioId = :usuarioId";
        } else {
            $sql = "SELECT Id FROM paciente WHERE UsuarioId = :usuarioId";
        }

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':usuarioId', $usuarioId);
        $stmt->execute();

        $resultado = $stmt->fetch();

        if (empty($resultado)) {
            throw new Exception("Paciente não encontrado");
        }

        return $resultado;
    }

}
