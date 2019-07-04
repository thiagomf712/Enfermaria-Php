<?php

class FichaMedica {
    private $id;
    private $planoSaude;
    private $problemasSaude;
    private $medicamentos;
    private $alergias;
    private $cirurgias;
    
    //relacionamentos
    private $paciente;
    
    public function getId() {
        return $this->id;
    }

    public function getPlanoSaude() {
        return $this->planoSaude;
    }

    public function getProblemasSaude() {
        return $this->problemasSaude;
    }

    public function getMedicamentos() {
        return $this->medicamentos;
    }

    public function getAlergias() {
        return $this->alergias;
    }

    public function getCirurgias() {
        return $this->cirurgias;
    }
    
    public function getPaciente() {
        return $this->paciente;
    }

    
    public function __construct(int $id, string $planoSaude, string $problemasSaude, 
            string $medicamentos, string $alergias, string $cirurgias, Paciente $paciente) {
        $this->id = $id;
        $this->planoSaude = $planoSaude;
        $this->problemasSaude = $problemasSaude;
        $this->medicamentos = $medicamentos;
        $this->alergias = $alergias;
        $this->cirurgias = $cirurgias;
        $this->paciente = $paciente;
    }

}
