<?php

require_once 'Connection.php';
require_once '../Models/FichaMedica.php';
require_once '../Models/Paciente.php';

class FichaMedicaService {

    public static function CadastrarEndereco(FichaMedica $fichaMedica) {
        $conn = Connection();

        $id = $fichaMedica->getId();
        $planoSaude = $fichaMedica->getPlanoSaude();
        $problemaSaude = $fichaMedica->getProblemaSaude();
        $medicamento = $fichaMedica->getMedicamento();
        $alergia = $fichaMedica->getAlergia();
        $cirurgia = $fichaMedica->getCirurgia();
        $pacienteId = $fichaMedica->getPaciente()->getId();


        $sql = "INSERT INTO fichamedica VALUES (:id, :planoSaude, :problemaSaude, :medicamento, :alergia, :cirurgia, :pacienteId )";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':planoSaude', $planoSaude);
        $stmt->bindParam(':problemaSaude', $problemaSaude);
        $stmt->bindParam(':medicamento', $medicamento);
        $stmt->bindParam(':alergia', $alergia);
        $stmt->bindParam(':cirurgia', $cirurgia);
        $stmt->bindParam(':pacienteId', $pacienteId);

        try {
            $stmt->execute();
        } catch (Exception $e) {
            throw new Exception("Erro ao tentar cadastrar a ficha medica");
        }
    }

}
