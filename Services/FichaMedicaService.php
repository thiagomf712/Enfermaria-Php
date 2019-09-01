<?php
if (!defined('__ROOT__')) {
    define('__ROOT__', dirname(__FILE__, 2));
}

require_once(__ROOT__ . '/Models/FichaMedica.php');

require_once(__ROOT__ . '/Services/Connection.php');

class FichaMedicaService {
    
    private $conn;

    public function __construct() {
        $this->conn = new Connection();
    }

    public function Cadastrar(FichaMedica $fichaMedica) {
        $query = "INSERT INTO fichamedica VALUES (:id, :planoSaude, :problemaSaude, :medicamento, :alergia, :cirurgia, :pacienteId )";
        
        $stmt = $this->conn->Conectar()->prepare($query);
        $stmt->bindValue(':id', $fichaMedica->id);
        $stmt->bindValue(':planoSaude', $fichaMedica->planoSaude);
        $stmt->bindValue(':problemaSaude', $fichaMedica->problemaSaude);
        $stmt->bindValue(':medicamento', $fichaMedica->medicamento);
        $stmt->bindValue(':alergia', $fichaMedica->alergia);
        $stmt->bindValue(':cirurgia', $fichaMedica->cirurgia);
        $stmt->bindValue(':pacienteId', $fichaMedica->paciente->id);

        if (!$stmt->execute()) {
            throw new Exception("Erro ao tentar cadastrar a ficha médica");
        }
    }
    
    public static function EditarFichaMedica(FichaMedica $fichaMedica) {
        $conn = Connection();
        
        $id = $fichaMedica->getId();
        $planoSaude = $fichaMedica->getPlanoSaude();
        $problemaSaude = $fichaMedica->getProblemaSaude();
        $medicamento = $fichaMedica->getMedicamento();
        $alergia = $fichaMedica->getAlergia();
        $cirurgia = $fichaMedica->getCirurgia();

        $sql = "UPDATE fichamedica SET PlanoSaude = :planoSaude, ProblemasSaude = :problemaSaude, Medicamentos = :medicamento, Alergias = :alergia, Cirurgias = :cirurgia WHERE Id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':planoSaude', $planoSaude);
        $stmt->bindParam(':problemaSaude', $problemaSaude);
        $stmt->bindParam(':medicamento', $medicamento);
        $stmt->bindParam(':alergia', $alergia);
        $stmt->bindParam(':cirurgia', $cirurgia);
        
        try {
            $stmt->execute();
        } catch (Exception $e) {
            throw new Exception("Erro ao tentar editar a ficha medica");
        }
    }
    
    public static function RetornarFichaMedica(int $id) {
        $conn = Connection();

        $sql = "SELECT * FROM fichamedica WHERE Id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $resultado = $stmt->fetch();
        
        if (empty($resultado)) {
            throw new Exception("Ficha Medica não encontrada");
        } 
          
        return new FichaMedica($resultado['Id'], $resultado['PlanoSaude'], $resultado['ProblemasSaude'], $resultado['Medicamentos'], $resultado['Alergias'], $resultado['Cirurgias']);
    }

}
