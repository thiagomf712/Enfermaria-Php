<?php

if (!defined('__ROOT__')) {
    define('__ROOT__', dirname(__FILE__, 2));
}

require_once(__ROOT__ . '/Models/Endereco.php');

require_once(__ROOT__ . '/Services/Connection.php');

class EnderecoService {
    
    private $conn;

    public function __construct() {
        $this->conn = new Connection();
    }

    public function Cadastrar(Endereco $endereco) {
        $query = "INSERT INTO endereco VALUES (:id, :regime, :logradouro, :numero, :complemento, :bairro, :cidade, :estado, :cep, :pacienteId )";
        
        $stmt = $this->conn->Conectar()->prepare($query);
        $stmt->bindValue(':id', $endereco->id);
        $stmt->bindValue(':regime', $endereco->regime);
        $stmt->bindValue(':logradouro', $endereco->logradouro);
        $stmt->bindValue(':numero', $endereco->numero);
        $stmt->bindValue(':complemento', $endereco->complemento);
        $stmt->bindValue(':bairro', $endereco->bairro);
        $stmt->bindValue(':cidade', $endereco->cidade);
        $stmt->bindValue(':estado', $endereco->estado);
        $stmt->bindValue(':cep', $endereco->cep);
        $stmt->bindValue(':pacienteId', $endereco->paciente->id);

        if (!$stmt->execute()) {
            throw new Exception("Erro ao tentar cadastrar o endereço");
        }
    }

    public static function EditarEndereco(Endereco $endereco) {
        $conn = Connection();

        $id = $endereco->getId();
        $regime = $endereco->getRegime();
        $logradouro = $endereco->getLogradouro();
        $numero = $endereco->getNumero();
        $complemento = $endereco->getComplemento();
        $bairro = $endereco->getBairro();
        $cidade = $endereco->getCidade();
        $estado = $endereco->getEstado();
        $cep = $endereco->getCep();

        $sql = "UPDATE endereco SET Regime = :regime, Logradouro = :logradouro, Numero = :numero, Complemento = :complemento,"
                . " Bairro = :bairro, Cidade = :cidade, Estado = :estado, Cep = :cep WHERE Id = :id";
        
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':regime', $regime);
        $stmt->bindParam(':logradouro', $logradouro);
        $stmt->bindParam(':numero', $numero);
        $stmt->bindParam(':complemento', $complemento);
        $stmt->bindParam(':bairro', $bairro);
        $stmt->bindParam(':cidade', $cidade);
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':cep', $cep);

        try {
            $stmt->execute();
        } catch (Exception $e) {
            throw new Exception("Erro ao tentar editar o endereço");
        }
    }
    
    public static function RetornarEndereco(int $id) {
        $conn = Connection();

        $sql = "SELECT * FROM endereco WHERE Id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $resultado = $stmt->fetch();

        if (empty($resultado)) {
            throw new Exception("Endereço não encontrado");
        }

        return new Endereco($resultado['Id'], $resultado['Regime'], $resultado['Logradouro'], $resultado['Numero'], $resultado['Complemento'], $resultado['Bairro'], $resultado['Cidade'], $resultado['Estado'], $resultado['Cep']);
    }

}
