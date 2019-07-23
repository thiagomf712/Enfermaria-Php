<?php

class FichaMedica {
    private $id;
    private $planoSaude;
    private $problemaSaude;
    private $medicamento;
    private $alergia;
    private $cirurgia;
    
    //relacionamentos
    private $paciente;
    
    public function getId() {
        return $this->id;
    }

    public function getPlanoSaude() {
        return $this->planoSaude;
    }

    public function getProblemaSaude() {
        return $this->problemaSaude;
    }

    public function getMedicamento() {
        return $this->medicamento;
    }

    public function getAlergia() {
        return $this->alergia;
    }

    public function getCirurgia() {
        return $this->cirurgia;
    }
    
    public function getPaciente() {
        return $this->paciente;
    }

        
    public function __construct(int $id, string $planoSaude, string $problemaSaude, 
            string $medicamento, string $alergia, string $cirurgia, $paciente = null) {
        $this->id = $id;
        $this->planoSaude = $planoSaude;
        $this->problemaSaude = $problemaSaude;
        $this->medicamento = $medicamento;
        $this->alergia = $alergia;
        $this->cirurgia = $cirurgia;
        $this->paciente = $paciente;
    }

}
