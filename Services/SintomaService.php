<?php

if (!defined('__ROOT__')) {
    define('__ROOT__', dirname(__FILE__, 2));
}

if (session_id() == '') {
    session_start();
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

    public static function EditarSintoma(Sintoma $sintoma) {
        $conn = Connection();

        $id = $sintoma->getId();
        $nome = $sintoma->getNome();

        $sql = "UPDATE sintoma SET Nome = :nome WHERE Id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nome', $nome);

        try {
            $stmt->execute();
        } catch (Exception $e) {
            throw new Exception("Erro ao tentar editar o sintoma");
        }
    }

    public static function Excluir($id) {
        $conn = Connection();

        $sql = "DELETE FROM sintoma WHERE Id = :id";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);

        try {
            $stmt->execute();

            if ($stmt->rowCount() == 0) {
                throw new Exception("Não é possivel deletar sintomas registrados em algum atendimento");
            }
        } catch (Exception $e) {
            throw new Exception("Não é possivel deletar sintomas registrados em algum atendimento");
        }
    }

    public static function ListarSintomas() {
        $conn = Connection();

        $sql = "SELECT * FROM sintoma";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $resultado = $stmt->fetchAll();

        return $resultado;
    }

    public static function ListarSintomasOrdenado($coluna, $ordem) {
        $conn = Connection();

        $sql = "SELECT * FROM sintoma ORDER BY " . $coluna . " " . $ordem;

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $resultado = $stmt->fetchAll();

        return $resultado;
    }

    public static function Filtrar($valor) {
        $conn = Connection();

        $sql = "SELECT * FROM sintoma WHERE Nome LIKE '%" . $valor . "%'";

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

    public static function ListarSintomasEst() {
        $conn = Connection();

        $sql = "SELECT s.Id, s.Nome, COUNT(ats.Id) as Total "
                . "FROM sintoma s "
                . "LEFT JOIN atendimentosintoma ats ON s.Id = ats.SintomaId "
                . "WHERE s.Id = ats.SintomaId "
                . "GROUP BY s.Nome";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $resultado = $stmt->fetchAll();

        return $resultado;
    }

    public static function ListarSintomasOrdenadoEst($coluna, $ordem) {
        $conn = Connection();

        $sql = "SELECT s.Id, s.Nome, COUNT(ats.Id) as Total "
                . "FROM sintoma s "
                . "LEFT JOIN atendimentosintoma ats ON s.Id = ats.SintomaId "
                . "WHERE s.Id = ats.SintomaId "
                . "GROUP BY s.Nome ";

        $sql .= "ORDER BY " . $coluna . " " . $ordem;

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $resultado = $stmt->fetchAll();

        return $resultado;
    }

    public static function FiltrarEst($valor) {
        $conn = Connection();

        $sql = "SELECT s.Id, s.Nome, COUNT(ats.Id) as Total "
                . "FROM sintoma s "
                . "LEFT JOIN atendimentosintoma ats ON s.Id = ats.SintomaId "
                . "INNER JOIN atendimento a ON ats.AtendimentoId = a.Id "
                . "WHERE s.Id = ats.SintomaId AND ";

        if (count($valor) >= 2) {
            for ($i = 0; $i < count($valor); $i++) {
                $sql .= $valor[$i][0];

                if ($valor[$i][0] == "a.Data") {
                    $sql .= SintomaService::DefinirFiltroData($valor[$i]);
                } else {
                    $sql .= " LIKE '%" . $valor[$i][1] . "%'";
                }

                if ($i !== count($valor) - 1) {
                    $sql .= ' AND ';
                }
            }
        } else {
            $sql .= $valor[0][0];

            if ($valor[0][0] == "a.Data") {
                $sql .= SintomaService::DefinirFiltroData($valor[0]);
            } else {
                $sql .= " LIKE '%" . $valor[0][1] . "%'";
            }
        }

        $sql .= "GROUP BY s.Nome ";

        $_SESSION['valorFiltrado'] = $sql;

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $resultado = $stmt->fetchAll();

        return $resultado;
    }

    private static function DefinirFiltroData($valor) {
        if ($valor['ope'] == 'entre') {
            $sql = " BETWEEN '" . $valor[1] . "' AND '" . $valor[2] . "'";
        } else if ($valor['ope'] == 'maior') {
            $sql = " >= '" . $valor[1] . "'";
        } else {
            $sql = " <= '" . $valor[1] . "'";
        }

        return $sql;
    }

    public static function ListarOcorrencias($sintomaId, $data = null) {
        $conn = Connection();

        $sql = "SELECT a.Id, a.Data, a.Hora, p.Nome as pNome, f.Nome as fNome "
                . "FROM atendimento a "
                . "INNER JOIN atendimentosintoma ats ON ats.AtendimentoId = a.Id "
                . "INNER JOIN sintoma s ON s.Id = ats.SintomaId "
                . "INNER JOIN paciente p ON a.PacienteId = p.Id "
                . "INNER JOIN funcionario f ON a.FuncionarioId = f.Id "
                . "WHERE :sintomaId = s.Id ";

        if ($data != null) {
                   
            $sql .= "AND " . $data[0];
                    
            $sql .= SintomaService::DefinirFiltroData($data);
        }

        $sql .= "ORDER BY a.data ";
        
        $stmt = $conn->prepare($sql);
        $stmt->bindParam("sintomaId", $sintomaId);
        $stmt->execute();

        $resultado = $stmt->fetchAll();

        return $resultado;
    }
    
    public static function RetornarSintoma(int $id) {
        $conn = Connection();

        $sql = "SELECT * FROM sintoma WHERE Id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $resultado = $stmt->fetch();

        if (empty($resultado)) {
            throw new Exception("Sintoma não encontrado");
        }

        return new Sintoma($resultado['Id'], $resultado['Nome']);
    }

    public static function RetornarNomesSintomas() {
        $conn = Connection();

        $sql = "SELECT Id, Nome FROM sintoma ORDER BY Nome";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $resultado = $stmt->fetchAll();

        return $resultado;
    }

}
