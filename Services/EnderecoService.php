<?php

require_once 'Connection.php';
require_once '../Models/Endereco.php';
require_once '../Models/Paciente.php';

class EnderecoService {

    public static function CadastrarEndereco(Endereco $endereco) {
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
        $pacienteId = $endereco->getPaciente()->getId();


        $sql = "INSERT INTO endereco VALUES (:id, :regime, :logradouro, :numero, :complemento, :bairro, :cidade, :estado, :cep, :pacienteId )";
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
        $stmt->bindParam(':pacienteId', $pacienteId);

        try {
            $stmt->execute();
        } catch (Exception $e) {
            throw new Exception("Erro ao tentar cadastrar o endereco");
        }
    }

}
